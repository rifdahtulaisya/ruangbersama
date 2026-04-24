<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->get('tahun', date('Y'));

        $availableYears = Loan::select(DB::raw('YEAR(tgl_pinjam) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        if (empty($availableYears)) {
            $availableYears = [date('Y')];
        }

        $currentMonthLoans = Loan::whereYear('tgl_pinjam', date('Y'))
            ->whereMonth('tgl_pinjam', date('m'))
            ->count();

        $totalLoansAllTime = Loan::count();

        $pendingLoans = Loan::where('status', Loan::STATUS_PENDING)->count();

        $activeLoans = Loan::where('status', Loan::STATUS_BORROWED)->count();

        $overdueLoans = Loan::where('status', Loan::STATUS_BORROWED)
            ->where('tgl_kembali_rencana', '<', now())
            ->count();

        $monthlyData = $this->getMonthlyData($selectedYear);

        return view('admin.dashboard', compact(
            'currentMonthLoans',
            'totalLoansAllTime',
            'pendingLoans',
            'activeLoans',
            'overdueLoans',
            'monthlyData',
            'availableYears',
            'selectedYear'
        ));
    }

    private function getMonthlyData($year)
    {
        $data = [];

        $monthNames = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        for ($month = 1; $month <= 12; $month++) {
            $loans = Loan::whereYear('tgl_pinjam', $year)
                ->whereMonth('tgl_pinjam', $month)
                ->count();

            $returns = Loan::whereYear('tgl_kembali_realisasi', $year)
                ->whereMonth('tgl_kembali_realisasi', $month)
                ->where('status', Loan::STATUS_RETURNED)
                ->count();

            $data[] = [
                'month' => $monthNames[$month],
                'month_num' => $month,
                'loans' => $loans,
                'returns' => $returns
            ];
        }

        return $data;
    }
}
