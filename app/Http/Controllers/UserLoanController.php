<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserLoanController extends Controller
{
    private function isUserBlocked()
    {
        $userId = Auth::id();

        $now = Carbon::now('Asia/Jakarta')->toDateString();

        $hasLateReturn = Loan::where('id_users', $userId)
            ->where('status', 'borrowed')
            ->where('tgl_kembali_rencana', '<', $now)
            ->exists();

        return $hasLateReturn;
    }

    public function index(Request $request)
    {
       
        if ($this->isUserBlocked()) {

            $now = Carbon::now('Asia/Jakarta')->toDateString();
            $lateBooks = Loan::with('book')
                ->where('id_users', Auth::id())
                ->where('status', 'borrowed')
                ->where('tgl_kembali_rencana', '<', $now)
                ->get();

            return view('loans-blocked', compact('lateBooks'));
        }

        $search = $request->input('search');
        $categoryId = $request->input('category_id');


        $query = Book::with('category');

        $query = Book::with('category')->where('stock', '>', 0);

        $borrowedBookIds = Loan::where('id_users', Auth::id())
            ->whereIn('status', ['pending', 'borrowed'])
            ->pluck('id_books')
            ->toArray();

        $query->whereNotIn('id', $borrowedBookIds);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $books = $query->paginate(12);
        $categories = Category::all();

        return view('loans', compact('books', 'categories'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu!');
        }

        if ($this->isUserBlocked()) {
            return redirect()->route('loans')
                ->with('error', 'Anda tidak bisa meminjam karena ada buku yang belum dikembalikan dan sudah melewati batas waktu pengembalian!');
        }

        $request->validate([
            'id_books' => 'required|exists:books,id',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali_rencana' => 'required|date|after:tgl_pinjam',
        ]);

        $tglPinjam = Carbon::parse($request->tgl_pinjam);
        $tglKembali = Carbon::parse($request->tgl_kembali_rencana);

        $durasi = $tglPinjam->diffInDays($tglKembali);

        if ($durasi > 7) {
            return back()
                ->with('error', 'Maksimal durasi peminjaman adalah 7 hari!')
                ->withInput();
        }

        $book = Book::find($request->id_books);
        if (!$book || $book->stock < 1) {
            return back()->with('error', 'Stok buku tidak tersedia!')->withInput();
        }

        $exists = Loan::where('id_books', $request->id_books)
            ->whereNotIn('status', ['returned', 'cancelled'])
            ->where(function ($q) use ($request) {
                $q->where('tgl_pinjam', '<=', $request->tgl_kembali_rencana)
                    ->where('tgl_kembali_rencana', '>=', $request->tgl_pinjam);
            })
            ->exists();

        if ($exists) {
            return back()
                ->with('error', 'Buku sudah dipinjam di tanggal tersebut!')
                ->withInput();
        }

        Loan::create([
            'id_users' => Auth::id(),
            'id_books' => $request->id_books,
            'tgl_pinjam' => $request->tgl_pinjam,
            'tgl_kembali_rencana' => $request->tgl_kembali_rencana,
            'status' => 'pending'
        ]);

        return redirect()->route('loans.history')
            ->with('success', 'Peminjaman buku berhasil diajukan!');
    }

    public function show($id)
    {
        $loan = Loan::with('book')
            ->where('id_users', Auth::id())
            ->findOrFail($id);

        return view('loans-show', compact('loan'));
    }

    public function history(Request $request)
    {
        $userId = Auth::id();
        $perPage = $request->input('per_page', 5);
        $status = $request->input('status', 'all');

        $query = Loan::with('book')
            ->where('id_users', $userId);

        if ($status != 'all') {
            $query->where('status', $status);
        } else {

            $query->whereNotIn('status', ['approved']);
        }

        $loans = $query->orderBy('created_at', 'desc')->paginate($perPage);

        $stats = [
            'total' => Loan::where('id_users', $userId)->whereNotIn('status', ['approved'])->count(),
            'pending' => Loan::where('id_users', $userId)->where('status', 'pending')->count(),
            'borrowed' => Loan::where('id_users', $userId)->where('status', 'borrowed')->count(),
            'returned' => Loan::where('id_users', $userId)->where('status', 'returned')->count(),
            'cancelled' => Loan::where('id_users', $userId)->where('status', 'cancelled')->count(),
        ];

        return view('loans-history', compact('loans', 'stats'));
    }
}