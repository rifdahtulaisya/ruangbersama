<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $currentMonthLoans = Loan::where('id_users', $user->id)
            ->whereYear('tgl_pinjam', date('Y'))
            ->whereMonth('tgl_pinjam', date('m'))
            ->count();

        $pendingLoans = Loan::where('id_users', $user->id)
            ->where('status', Loan::STATUS_PENDING)
            ->count();

        $borrowedLoans = Loan::where('id_users', $user->id)
            ->where('status', Loan::STATUS_BORROWED)
            ->count();

        $lateLoans = Loan::where('id_users', $user->id)
            ->where('status', Loan::STATUS_BORROWED)
            ->where('tgl_kembali_rencana', '<', now())
            ->count();

        $popularBooks = Book::with('category')
            ->withCount(['loans' => function ($query) {
                $query->where('status', '!=', Loan::STATUS_CANCELLED);
            }])
            ->having('loans_count', '>', 0)
            ->orderBy('loans_count', 'desc')
            ->limit(4)
            ->get();

        $monthlyStats = $this->getMonthlyStats($user->id);

        return view('dashboard', compact(
            'currentMonthLoans',
            'pendingLoans',
            'borrowedLoans',
            'lateLoans',
            'popularBooks',
            'monthlyStats'
        ));
    }

    private function getMonthlyStats($userId)
    {
        $months = [];
        $borrowedData = [];
        $returnedData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthName = $month->translatedFormat('M Y');
            $months[] = $monthName;

            $borrowed = Loan::where('id_users', $userId)
                ->whereYear('tgl_pinjam', $month->year)
                ->whereMonth('tgl_pinjam', $month->month)
                ->count();
            $borrowedData[] = $borrowed;

            $returned = Loan::where('id_users', $userId)
                ->whereYear('tgl_kembali_realisasi', $month->year)
                ->whereMonth('tgl_kembali_realisasi', $month->month)
                ->whereNotNull('tgl_kembali_realisasi')
                ->count();
            $returnedData[] = $returned;
        }

        return [
            'months' => $months,
            'borrowed' => $borrowedData,
            'returned' => $returnedData
        ];
    }
}
