<?php
// database/seeders/LoanSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loan;
use App\Models\User;
use App\Models\Book;
use Carbon\Carbon;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada data user, book, dan category terlebih dahulu
        // Ambil beberapa user (misal yang memiliki role member/siswa)
        $users = User::where('role', 'member')->orWhere('role', 'student')->get();
        
        // Jika tidak ada user dengan role tersebut, ambil semua user
        if ($users->isEmpty()) {
            $users = User::take(5)->get();
        }
        
        // Ambil semua books
        $books = Book::all();
        
        if ($users->isEmpty() || $books->isEmpty()) {
            $this->command->error('Tidak ada data user atau book. Jalankan seeder user dan book terlebih dahulu!');
            return;
        }

        // Data peminjaman untuk Januari - April 2026
        $loans = [
            // JANUARI 2026
            [
                'user_index' => 0,
                'book_index' => 0,
                'tgl_pinjam' => '2026-01-05',
                'hari_pinjam' => 7,
                'status' => Loan::STATUS_RETURNED,
                'tgl_kembali_realisasi' => '2026-01-12',
            ],
            [
                'user_index' => 1,
                'book_index' => 1,
                'tgl_pinjam' => '2026-01-10',
                'hari_pinjam' => 7,
                'status' => Loan::STATUS_RETURNED,
                'tgl_kembali_realisasi' => '2026-01-17',
            ],
            [
                'user_index' => 2,
                'book_index' => 2,
                'tgl_pinjam' => '2026-01-15',
                'hari_pinjam' => 7,
                'status' => Loan::STATUS_BORROWED,
                'tgl_kembali_realisasi' => null,
            ],
            [
                'user_index' => 0,
                'book_index' => 3,
                'tgl_pinjam' => '2026-01-20',
                'hari_pinjam' => 14,
                'status' => Loan::STATUS_RETURNED,
                'tgl_kembali_realisasi' => '2026-02-03',
            ],
            [
                'user_index' => 3,
                'book_index' => 4,
                'tgl_pinjam' => '2026-01-25',
                'hari_pinjam' => 7,
                'status' => Loan::STATUS_RETURNED,
                'tgl_kembali_realisasi' => '2026-02-01',
            ],
            
            // FEBRUARI 2026
            [
                'user_index' => 1,
                'book_index' => 0,
                'tgl_pinjam' => '2026-02-01',
                'hari_pinjam' => 7,
                'status' => Loan::STATUS_RETURNED,
                'tgl_kembali_realisasi' => '2026-02-08',
            ],
            [
                'user_index' => 4,
                'book_index' => 5,
                'tgl_pinjam' => '2026-02-05',
                'hari_pinjam' => 14,
                'status' => Loan::STATUS_BORROWED,
                'tgl_kembali_realisasi' => null,
            ],
            [
                'user_index' => 2,
                'book_index' => 1,
                'tgl_pinjam' => '2026-02-10',
                'hari_pinjam' => 7,
                'status' => Loan::STATUS_RETURNED,
                'tgl_kembali_realisasi' => '2026-02-17',
            ],
            [
                'user_index' => 0,
                'book_index' => 6,
                'tgl_pinjam' => '2026-02-15',
                'hari_pinjam' => 7,
                'status' => Loan::STATUS_CANCELLED,
                'tgl_kembali_realisasi' => null,
            ],
            [
                'user_index' => 3,
                'book_index' => 2,
                'tgl_pinjam' => '2026-02-20',
                'hari_pinjam' => 7,
                'status' => Loan::STATUS_BORROWED,
                'tgl_kembali_realisasi' => null,
            ],
            
            // MARET 2026
            [
                'user_index' => 1,
                'book_index' => 3,
                'tgl_pinjam' => '2026-03-01',
                'hari_pinjam' => 7,
                'status' => Loan::STATUS_RETURNED,
                'tgl_kembali_realisasi' => '2026-03-08',
            ],
            [
                'user_index' => 4,
                'book_index' => 0,
                'tgl_pinjam' => '2026-03-05',
                'hari_pinjam' => 14,
                'status' => Loan::STATUS_RETURNED,
                'tgl_kembali_realisasi' => '2026-03-19',
            ],
            [
                'user_index' => 2,
                'book_index' => 4,
                'tgl_pinjam' => '2026-03-10',
                'hari_pinjam' => 7,
                'status' => Loan::STATUS_BORROWED,
                'tgl_kembali_realisasi' => null,
            ],
            [
                'user_index' => 0,
                'book_index' => 1,
                'tgl_pinjam' => '2026-03-15',
                'hari_pinjam' => 7,
                'status' => Loan::STATUS_RETURNED,
                'tgl_kembali_realisasi' => '2026-03-22',
            ],
            [
                'user_index' => 3,
                'book_index' => 5,
                'tgl_pinjam' => '2026-03-20',
                'hari_pinjam' => 14,
                'status' => Loan::STATUS_PENDING,
                'tgl_kembali_realisasi' => null,
            ],
            [
                'user_index' => 1,
                'book_index' => 7,
                'tgl_pinjam' => '2026-03-25',
                'hari_pinjam' => 7,
                'status' => Loan::STATUS_BORROWED,
                'tgl_kembali_realisasi' => null,
            ],
            
            // APRIL 2026
            [
                'user_index' => 2,
                'book_index' => 6,
                'tgl_pinjam' => '2026-04-01',
                'hari_pinjam' => 7,
                'status' => Loan::STATUS_RETURNED,
                'tgl_kembali_realisasi' => '2026-04-08',
            ],
            [
                'user_index' => 4,
                'book_index' => 1,
                'tgl_pinjam' => '2026-04-05',
                'hari_pinjam' => 14,
                'status' => Loan::STATUS_BORROWED,
                'tgl_kembali_realisasi' => null,
            ],
            [
                'user_index' => 0,
                'book_index' => 2,
                'tgl_pinjam' => '2026-04-10',
                'hari_pinjam' => 7,
                'status' => Loan::STATUS_RETURNED,
                'tgl_kembali_realisasi' => '2026-04-17',
            ],
            [
                'user_index' => 3,
                'book_index' => 8,
                'tgl_pinjam' => '2026-04-15',
                'hari_pinjam' => 7,
                'status' => Loan::STATUS_PENDING,
                'tgl_kembali_realisasi' => null,
            ],
            [
                'user_index' => 1,
                'book_index' => 4,
                'tgl_pinjam' => '2026-04-20',
                'hari_pinjam' => 14,
                'status' => Loan::STATUS_BORROWED,
                'tgl_kembali_realisasi' => null,
            ],
            [
                'user_index' => 2,
                'book_index' => 0,
                'tgl_pinjam' => '2026-04-25',
                'hari_pinjam' => 7,
                'status' => Loan::STATUS_CANCELLED,
                'tgl_kembali_realisasi' => null,
            ],
        ];

        foreach ($loans as $loanData) {
            $user = $users[$loanData['user_index'] % $users->count()];
            $book = $books[$loanData['book_index'] % $books->count()];
            
            $tgl_pinjam = Carbon::parse($loanData['tgl_pinjam']);
            $tgl_kembali_rencana = $tgl_pinjam->copy()->addDays($loanData['hari_pinjam']);
            
            $loan = Loan::create([
                'id_users' => $user->id,
                'id_books' => $book->id,
                'tgl_pinjam' => $loanData['tgl_pinjam'],
                'tgl_kembali_rencana' => $tgl_kembali_rencana,
                'tgl_kembali_realisasi' => $loanData['tgl_kembali_realisasi'],
                'status' => $loanData['status'],
                'returned_at' => $loanData['tgl_kembali_realisasi'],
            ]);
            
            // Update status otomatis berdasarkan tanggal kembali realisasi
            if ($loanData['tgl_kembali_realisasi']) {
                $loan->status = Loan::STATUS_RETURNED;
                $loan->save();
            }
            
            // Kurangi stok buku jika status borrowed
            if ($loanData['status'] === Loan::STATUS_BORROWED && !$loanData['tgl_kembali_realisasi']) {
                $book->decrementStock();
            }
            
            // Kembalikan stok jika sudah dikembalikan
            if ($loanData['tgl_kembali_realisasi']) {
                $book->incrementStock();
            }
        }
        
        $this->command->info('Seeder peminjaman bulan Januari - April 2026 berhasil dijalankan!');
        $this->command->info('Total peminjaman: ' . count($loans));
    }
}