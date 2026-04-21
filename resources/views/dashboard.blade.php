@extends('layouts-user.user')

@section('title', 'DASHBOARD')

@section('content')

<!-- STATISTIK CARD - HANYA 3 CARD -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
    <!-- Card 1: Total Peminjaman Bulan Terbaru -->
    <div class="group bg-white rounded-xl p-6 shadow hover:shadow-xl transition">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-slate-400 text-sm">Peminjaman Bulan Ini</p>
                <h2 class="text-3xl font-bold text-slate-800 mt-1"></h2>
                <p class="text-xs text-slate-500 mt-1">Total: </p>
            </div>
            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-blue-100 text-blue-600 group-hover:scale-110 transition">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
        </div>
    </div>

    <!-- Card 2: Menunggu Persetujuan -->
    <div class="group bg-white rounded-xl p-6 shadow hover:shadow-xl transition">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-slate-400 text-sm">Menunggu Persetujuan</p>
                <h2 class="text-3xl font-bold text-slate-800 mt-1"></h2>
            </div>
            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-yellow-100 text-yellow-600 group-hover:scale-110 transition">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
        </div>
        <div class="flex items-center mt-4">
            <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-medium">
                Perlu persetujuan
            </span>
        </div>
    </div>

    <!-- Card 3: Sedang Dipinjam -->
    <div class="group bg-white rounded-xl p-6 shadow hover:shadow-xl transition">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-slate-400 text-sm">Sedang Dipinjam</p>
                <h2 class="text-3xl font-bold text-slate-800 mt-1">}</h2>
            </div>
            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-green-100 text-green-600 group-hover:scale-110 transition">
                <i class="fa-solid fa-play"></i>
            </div>
        </div>
        <div class="flex items-center justify-between mt-4">
            <span class="px-2 py-1 bg-red-100 text-red-600 rounded-full text-xs font-medium">
                 Terlambat
            </span>
        </div>
    </div>
</div>

<!-- DIAGRAM BULANAN (BAR CHART) dengan Pilihan Tahun -->
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
            <form method="GET" action="{{ url()->current() }}" id="formTahun" class="flex items-center gap-2">
                <label class="text-sm text-slate-600 font-medium">Tahun:</label>
                <select name="tahun" onchange="this.form.submit()" 
                        class="px-3 pr-8 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white cursor-pointer">
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
    
    <!-- Canvas untuk Bar Chart Bulanan -->
    <canvas id="chartBulanan" height="120"></canvas>
    
    <!-- Tabel ringkasan data per bulan -->
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
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                    <td class="py-2 px-3 font-medium text-slate-700"></td>
                    <td class="text-right py-2 px-3 text-blue-600 font-semibold"></td>
                    <td class="text-right py-2 px-3 text-green-600 font-semibold"></td>
                        
                     </td>
                 </tr>
            </tbody>
            <tfoot class="bg-slate-100 font-semibold">
                <tr>
                    <td class="py-2 px-3 text-slate-700">TOTAL</td>
                    <td class="text-right py-2 px-3 text-blue-700"></td>
                    <td class="text-right py-2 px-3 text-green-700"></td>
                    <td class="text-right py-2 px-3 text-orange-700"></td>
                 </tr>
            </tfoot>
         </table>
    </div>
    
    <!-- Keterangan -->
    <div class="mt-4 text-xs text-slate-400 border-t border-slate-100 pt-3 text-center">
        <i class="fa-regular fa-chart-bar mr-1"></i
    </div>
</div>
@endsection