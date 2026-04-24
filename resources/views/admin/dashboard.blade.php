@extends('layouts-admin.admin')

@section('title', 'DASHBOARD')

@section('content')


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">

        <div class="group bg-white rounded-xl p-6 shadow hover:shadow-xl transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-slate-400 text-sm">Peminjaman Bulan Ini</p>
                    <h2 class="text-3xl font-bold text-slate-800 mt-1">{{ $currentMonthLoans ?? 0 }}</h2>
                    <p class="text-xs text-slate-500 mt-1">Total: {{ $totalLoansAllTime ?? 0 }}</p>
                </div>
                <div
                    class="w-12 h-12 flex items-center justify-center rounded-xl bg-blue-100 text-blue-600 group-hover:scale-110 transition">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
            </div>
        </div>


        <div class="group bg-white rounded-xl p-6 shadow hover:shadow-xl transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-slate-400 text-sm">Menunggu Persetujuan</p>
                    <h2 class="text-3xl font-bold text-slate-800 mt-1">{{ $pendingLoans ?? 0 }}</h2>
                </div>
                <div
                    class="w-12 h-12 flex items-center justify-center rounded-xl bg-yellow-100 text-yellow-600 group-hover:scale-110 transition">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
            </div>
            <div class="flex items-center mt-4">
                <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-medium">
                    Perlu persetujuan
                </span>
            </div>
        </div>


        <div class="group bg-white rounded-xl p-6 shadow hover:shadow-xl transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-slate-400 text-sm">Sedang Dipinjam</p>
                    <h2 class="text-3xl font-bold text-slate-800 mt-1">{{ $activeLoans ?? 0 }}</h2>
                </div>
                <div
                    class="w-12 h-12 flex items-center justify-center rounded-xl bg-green-100 text-green-600 group-hover:scale-110 transition">
                    <i class="fa-solid fa-play"></i>
                </div>
            </div>
            <div class="flex items-center justify-between mt-4">
                <span class="px-2 py-1 bg-red-100 text-red-600 rounded-full text-xs font-medium">
                    {{ $overdueLoans ?? 0 }} Terlambat
                </span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow">
        <div class="flex flex-wrap justify-between items-center mb-6">
            <div>
                <h3 class="font-semibold text-slate-700 text-lg">
                    Statistik Peminjaman & Pengembalian Per Bulan
                </h3>
                <p class="text-xs text-slate-400 mt-1">Data peminjaman dan pengembalian per bulan</p>
            </div>
            <div class="flex items-center gap-4">
                <!-- Dropdown Pilih Tahun -->
                <form method="GET" action="{{ route('admin.dashboard') }}" id="formTahun" class="flex items-center gap-2">
                    <label class="text-sm text-slate-600 font-medium">Tahun:</label>
                    <select name="tahun" onchange="this.form.submit()"
                        class="px-3 pr-8 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white cursor-pointer">
                        @foreach ($availableYears ?? [date('Y')] as $year)
                            <option value="{{ $year }}"
                                {{ ($selectedYear ?? date('Y')) == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </form>
                <div class="flex items-center gap-3 text-xs">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-blue-500 rounded-full mr-1"></span>
                        <span class="text-slate-600">Peminjaman</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-1"></span>
                        <span class="text-slate-600">Pengembalian</span>
                    </div>
                </div>
            </div>
        </div>


        <canvas id="chartBulanan" height="120"></canvas>


        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50">
                        <th class="text-left py-2 px-3 text-slate-500 font-medium rounded-l-lg">Bulan</th>
                        <th class="text-right py-2 px-3 text-slate-500 font-medium">Peminjaman</th>
                        <th class="text-right py-2 px-3 text-slate-500 font-medium">Pengembalian</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPeminjaman = 0;
                        $totalPengembalian = 0;
                    @endphp
                    @forelse($monthlyData ?? [] as $data)
                        @php
                            $totalPeminjaman += $data['loans'];
                            $totalPengembalian += $data['returns'];
                        @endphp
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                            <td class="py-2 px-3 font-medium text-slate-700">{{ $data['month'] }}</td>
                            <td class="text-right py-2 px-3 text-blue-600 font-semibold">
                                {{ number_format($data['loans']) }}</td>
                            <td class="text-right py-2 px-3 text-green-600 font-semibold">
                                {{ number_format($data['returns']) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-slate-500">Belum ada data peminjaman</td>
                        </tr>
                    @endforelse
                </tbody>
                @if (!empty($monthlyData) && $totalPeminjaman > 0)
                    <tfoot class="bg-slate-100 font-semibold">
                        <tr>
                            <td class="py-2 px-3 text-slate-700">TOTAL</td>
                            <td class="text-right py-2 px-3 text-blue-700">{{ number_format($totalPeminjaman) }}</td>
                            <td class="text-right py-2 px-3 text-green-700">{{ number_format($totalPengembalian) }}</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>


        <div class="mt-4 text-xs text-slate-400 border-t border-slate-100 pt-3 text-center">
            <i class="fa-regular fa-chart-bar mr-1"></i> Menampilkan data peminjaman dan pengembalian berdasarkan tahun yang
            dipilih
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            const monthlyData = @json($monthlyData ?? []);

            if (monthlyData.length > 0) {
                
                const bulanLabels = monthlyData.map(item => item.month);
                const loanData = monthlyData.map(item => item.loans);
                const returnData = monthlyData.map(item => item.returns);

                
                const ctx = document.getElementById('chartBulanan').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: bulanLabels,
                        datasets: [{
                                label: 'Peminjaman',
                                data: loanData,
                                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                                borderColor: 'rgb(59, 130, 246)',
                                borderWidth: 1,
                                borderRadius: 6,
                                barPercentage: 0.7,
                                categoryPercentage: 0.8
                            },
                            {
                                label: 'Pengembalian',
                                data: returnData,
                                backgroundColor: 'rgba(34, 197, 94, 0.7)',
                                borderColor: 'rgb(34, 197, 94)',
                                borderWidth: 1,
                                borderRadius: 6,
                                barPercentage: 0.7,
                                categoryPercentage: 0.8
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        let value = context.parsed.y;
                                        return `${label}: ${value.toLocaleString('id-ID')} transaksi`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    callback: function(value) {
                                        return value.toLocaleString('id-ID');
                                    }
                                },
                                grid: {
                                    borderDash: [5, 5]
                                },
                                title: {
                                    display: true,
                                    text: 'Jumlah Transaksi',
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                title: {
                                    display: true,
                                    text: 'Bulan',
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
