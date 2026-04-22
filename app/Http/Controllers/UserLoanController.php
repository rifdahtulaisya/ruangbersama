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
    // Di UserLoanController.php, method index()
public function index(Request $request)
{
    $search = $request->input('search');
    $categoryId = $request->input('category_id');

    $query = Book::with('category');
    
    // Ambil semua buku yang sedang dipinjam (status pending atau borrowed) oleh user yang sedang login
    $borrowedBookIds = Loan::where('id_users', Auth::id())
        ->whereIn('status', ['pending', 'borrowed'])
        ->pluck('id_books')
        ->toArray();

    // Hanya tampilkan buku yang tidak sedang dipinjam oleh user
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

        $request->validate([
            'id_books' => 'required|exists:books,id',
            'tgl_pinjam' => 'required|date|after_or_equal:today',
            'tgl_kembali_rencana' => 'required|date|after:tgl_pinjam',
        ]);

        // Cek ketersediaan buku
        $book = Book::find($request->id_books);
        if ($book->stock < 1) {
            return back()->with('error', 'Stok buku tidak tersedia!')->withInput();
        }

        // Cek apakah buku sudah dipinjam di tanggal tersebut
        $exists = Loan::where('id_books', $request->id_books)
            ->whereNotIn('status', ['returned', 'cancelled'])
            ->where(function ($q) use ($request) {
                $q->whereBetween('tgl_pinjam', [$request->tgl_pinjam, $request->tgl_kembali_rencana])
                    ->orWhereBetween('tgl_kembali_rencana', [$request->tgl_pinjam, $request->tgl_kembali_rencana])
                    ->orWhere(function ($q2) use ($request) {
                        $q2->where('tgl_pinjam', '<=', $request->tgl_pinjam)
                            ->where('tgl_kembali_rencana', '>=', $request->tgl_kembali_rencana);
                    });
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

        // Redirect ke halaman history dengan notifikasi sukses
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

        // Filter berdasarkan status (tanpa 'approved')
        if ($status != 'all') {
            $query->where('status', $status);
        } else {
            // Untuk 'all', tampilkan semua kecuali 'approved'
            $query->whereNotIn('status', ['approved']);
        }

        $loans = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Statistik (tanpa 'approved')
        $stats = [
            'total' => Loan::where('id_users', $userId)->whereNotIn('status', ['approved'])->count(),
            'pending' => Loan::where('id_users', $userId)->where('status', 'pending')->count(),
            'borrowed' => Loan::where('id_users', $userId)->where('status', 'borrowed')->count(),
            'returned' => Loan::where('id_users', $userId)->where('status', 'returned')->count(),
            'cancelled' => Loan::where('id_users', $userId)->where('status', 'cancelled')->count(),
        ];

        return view('loans-history', compact('loans', 'stats'));
    }

    // METHOD BARU: Menghapus data peminjaman (bukan hanya ubah status)
    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu!');
        }

        $loan = Loan::where('id_users', Auth::id())
            ->where('status', 'pending') // Hanya bisa hapus yang status pending
            ->findOrFail($id);

        // Hapus data peminjaman
        $loan->delete();

        return back()->with('success', 'Peminjaman berhasil dibatalkan!');
    }

    // Method untuk mengembalikan buku
    public function returnBook($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu!');
        }

        $loan = Loan::where('id_users', Auth::id())
            ->where('status', 'borrowed')
            ->findOrFail($id);

        // Gunakan waktu Indonesia (WIB)
        $now = Carbon::now('Asia/Jakarta');
        
        // Cek apakah sudah terlambat (gunakan tanggal dari waktu Indonesia)
        $telat = false;
        if ($loan->tgl_kembali_rencana < $now->toDateString()) {
            $telat = true;
        }

        $loan->update([
            'status' => 'returned',
            'tgl_kembali_realisasi' => $now,  // simpan dengan waktu Indonesia
            'teguran' => $telat ? 'Terlambat mengembalikan buku' : null
        ]);

        // Update stok buku
        if ($loan->book) {
            $loan->book->increment('stock');
        }

        return back()->with('success', $telat ? 
            'Buku berhasil dikembalikan (TERLAMBAT)!' : 
            'Buku berhasil dikembalikan! Terima kasih.');
    }
}