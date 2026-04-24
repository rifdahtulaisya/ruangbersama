<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);
        $statusFilter = $request->input('status');
        $tanggalFilter = $request->input('tanggal');

        $query = Loan::with(['user', 'book']);

        if ($statusFilter && $statusFilter != 'all' && in_array($statusFilter, ['pending', 'borrowed', 'returned', 'cancelled'])) {
            $query->where('status', $statusFilter);
        }

        if ($tanggalFilter) {
            $query->whereDate('tgl_pinjam', $tanggalFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($studentQuery) use ($search) {
                    $studentQuery->where('name', 'like', "%{$search}%");
                })->orWhereHas('book', function ($bookQuery) use ($search) {
                    $bookQuery->where('title', 'like', "%{$search}%");
                });
            });
        }

        $loans = $query->orderBy('created_at', 'desc')->paginate($perPage);

        $stats = [
            'total' => Loan::count(),
            'pending' => Loan::where('status', 'pending')->count(),
            'borrowed' => Loan::where('status', 'borrowed')->count(),
            'returned' => Loan::where('status', 'returned')->count(),
        ];

        return view('admin.loans.index', compact('loans', 'stats', 'statusFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'user')->get();

        $books = Book::where('stock', '>', 0)->get();

        return view('admin.loans.create', compact('users', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_users' => 'required|exists:users,id',
            'id_books' => 'required|exists:books,id',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali_rencana' => 'required|date|after_or_equal:tgl_pinjam',
            'status' => 'required|in:pending,borrowed,returned,cancelled'
        ]);

        if ($request->status == 'borrowed') {
            $book = Book::findOrFail($request->id_books);
            if ($book->stock < 1) {
                return redirect()->back()
                    ->with('error', 'Stok buku tidak mencukupi!')
                    ->withInput();
            }
            $book->decrementStock();
        }

        Loan::create($request->all());

        return redirect()->route('admin.loans.index')
            ->with('success', 'Pinjaman berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $loan = Loan::with(['user', 'book.category'])->findOrFail($id);

        session(['loans_page' => request()->input('page', 1)]);

        return view('admin.loans.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $loan = Loan::findOrFail($id);
        $users = User::all();
        $books = Book::all();
        return view('admin.loans.edit', compact('loan', 'users', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_users' => 'required|exists:users,id',
            'id_books' => 'required|exists:books,id',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali_rencana' => 'required|date|after_or_equal:tgl_pinjam',
            'tgl_kembali_realisasi' => 'nullable|date|after_or_equal:tgl_pinjam',
            'status' => 'required|in:pending,borrowed,returned,cancelled',
            'teguran' => 'nullable|string'
        ]);

        $loan = Loan::findOrFail($id);
        $oldStatus = $loan->status;
        $newStatus = $request->status;

        DB::beginTransaction();

        try {
            if ($oldStatus != $newStatus) {
                if ($newStatus == 'borrowed' && $oldStatus != 'borrowed') {
                    $book = Book::findOrFail($request->id_books);
                    if ($book->stock < 1) {
                        throw new \Exception('Stok buku tidak mencukupi!');
                    }
                    $book->decrementStock();
                }

                if ($newStatus == 'returned' && $oldStatus == 'borrowed') {
                    $book = Book::findOrFail($request->id_books);
                    $book->incrementStock();
                }

                if ($newStatus == 'cancelled' && $oldStatus == 'borrowed') {
                    $book = Book::findOrFail($request->id_books);
                    $book->incrementStock();
                }
            }

            $loan->update($request->all());

            DB::commit();

            return redirect()->route('admin.loans.index')
                ->with('success', 'Pinjaman berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $loan = Loan::findOrFail($id);

        DB::beginTransaction();

        try {
            if ($loan->status == 'borrowed') {
                $loan->book->incrementStock();
            }

            $loan->delete();

            DB::commit();

            return redirect()->route('admin.loans.index')
                ->with('success', 'Pinjaman berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus pinjaman: ' . $e->getMessage());
        }
    }

    /**
     * Approve loan
     */
    public function approve(string $id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->status != 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya pinjaman dengan status pending yang dapat disetujui');
        }

        DB::beginTransaction();

        try {
            if ($loan->book->stock < 1) {
                throw new \Exception('Stok buku tidak mencukupi!');
            }

            $loan->book->decrementStock();

            $loan->update([
                'status' => 'borrowed',
                'tgl_pinjam' => now()->toDateString()
            ]);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Pinjaman berhasil disetujui dan stok buku berkurang');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Return item
     */
    public function returnItem(string $id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->status != 'borrowed') {
            return redirect()->back()
                ->with('error', 'Hanya pinjaman dengan status borrowed yang dapat dikembalikan');
        }

        DB::beginTransaction();

        try {
            $telat = false;
            if ($loan->tgl_kembali_rencana < now()->toDateString()) {
                $telat = true;
            }

            $loan->book->incrementStock();

            $loan->update([
                'status' => 'returned',
                'tgl_kembali_realisasi' => now()->toDateString(),
                'teguran' => $telat ? 'Terlambat mengembalikan barang' : null
            ]);

            DB::commit();

            return redirect()->back()
                ->with('success', $telat ? 'Buku dikembalikan (TERLAMBAT) dan stok bertambah' : 'Buku dikembalikan dan stok bertambah');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal mengembalikan buku: ' . $e->getMessage());
        }
    }
}
