@extends('layouts-user.user')

@section('title', 'DASHBOARD')

@section('content')


<div class="bg-white rounded-xl p-8 shadow-sm border border-slate-100 mb-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-slate-800">
                    Selamat Datang, <span class="text-amber-700">{{ Auth::user()->name ?? 'User' }}</span>
                </h1>
                <p class="text-slate-500 mt-1 flex items-center gap-2">
                    <i class="fa-regular fa-calendar-alt text-sm"></i>
                    <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                </p>
            </div>
        </div>
        <div class="bg-amber-50 rounded-full px-4 py-2 text-amber-700 text-sm font-medium flex items-center gap-2">
            <i class="fa-solid fa-book-open"></i>
            <span>Selamat membaca dan belajar</span>
        </div>
    </div>

</div>


<div class="hidden sm:grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
    
    <div class="group bg-white rounded-xl p-6 shadow hover:shadow-xl transition">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-slate-400 text-sm">Peminjaman Bulan Ini</p>
                <h2 class="text-3xl font-bold text-slate-800 mt-1">{{ $currentMonthLoans }}</h2>
                <p class="text-xs text-slate-500 mt-1">Total peminjaman bulan {{ now()->translatedFormat('F Y') }}</p>
            </div>
            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-amber-100 text-amber-600 group-hover:scale-110 transition">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
        </div>
    </div>

    
    <div class="group bg-white rounded-xl p-6 shadow hover:shadow-xl transition">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-slate-400 text-sm">Menunggu Persetujuan</p>
                <h2 class="text-3xl font-bold text-slate-800 mt-1">{{ $pendingLoans }}</h2>
            </div>
            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-yellow-100 text-yellow-600 group-hover:scale-110 transition">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
        </div>
        <div class="flex items-center mt-4">
            <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-medium">
                {{ $pendingLoans }} menunggu persetujuan
            </span>
        </div>
    </div>

    
    <div class="group bg-white rounded-xl p-6 shadow hover:shadow-xl transition">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-slate-400 text-sm">Sedang Dipinjam</p>
                <h2 class="text-3xl font-bold text-slate-800 mt-1">{{ $borrowedLoans }}</h2>
            </div>
            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-green-100 text-green-600 group-hover:scale-110 transition">
                <i class="fa-solid fa-play"></i>
            </div>
        </div>
        <div class="flex items-center justify-between mt-4">
            <span class="px-2 py-1 bg-red-100 text-red-600 rounded-full text-xs font-medium">
                {{ $lateLoans }} Terlambat
            </span>
        </div>
    </div>
</div>


<div class="grid grid-cols-3 gap-3 mb-6 sm:hidden">
    <div class="bg-white rounded-xl p-3 shadow text-center">
        <div class="w-8 h-8 mx-auto flex items-center justify-center rounded-lg bg-amber-100 text-amber-600 mb-2">
            <i class="fa-solid fa-calendar-check text-sm"></i>
        </div>
        <p class="text-xs text-slate-500">Bulan Ini</p>
        <p class="text-xl font-bold text-slate-800">{{ $currentMonthLoans }}</p>
    </div>
    
    <div class="bg-white rounded-xl p-3 shadow text-center">
        <div class="w-8 h-8 mx-auto flex items-center justify-center rounded-lg bg-yellow-100 text-yellow-600 mb-2">
            <i class="fa-solid fa-hourglass-half text-sm"></i>
        </div>
        <p class="text-xs text-slate-500">Menunggu</p>
        <p class="text-xl font-bold text-slate-800">{{ $pendingLoans }}</p>
    </div>
    
    <div class="bg-white rounded-xl p-3 shadow text-center">
        <div class="w-8 h-8 mx-auto flex items-center justify-center rounded-lg bg-green-100 text-green-600 mb-2">
            <i class="fa-solid fa-play text-sm"></i>
        </div>
        <p class="text-xs text-slate-500">Dipinjam</p>
        <div>
            <p class="text-xl font-bold text-slate-800">{{ $borrowedLoans }}</p>
            @if($lateLoans > 0)
            <span class="text-xs text-red-600 font-medium">{{ $lateLoans }} terlambat</span>
            @endif
        </div>
    </div>
</div>


<div class="bg-white rounded-xl p-6 shadow">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h3 class="font-semibold text-slate-700 text-lg">
                <i class="fa-solid fa-book-open text-amber-600 mr-2"></i>
                Koleksi Buku Populer
            </h3>
            <p class="text-xs text-slate-400 mt-1">Rekomendasi buku yang sedang banyak dibaca</p>
        </div>
        <a href="{{ route('loans') }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium flex items-center gap-1">
            Lihat semua <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
    </div>
    
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($popularBooks as $book)
        <div class="border border-slate-100 rounded-lg p-3 hover:shadow-lg transition-all duration-300 group cursor-pointer">
            
            <div class="relative bg-gradient-to-br from-slate-100 to-slate-50 rounded-lg overflow-hidden aspect-[3/4] group-hover:shadow-md transition-all duration-300">
                @if($book->image && file_exists(storage_path('app/public/' . $book->image)))
                    <img src="{{ asset('storage/' . $book->image) }}" 
                         alt="{{ $book->title }}" 
                         class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                        <i class="fa-solid fa-book text-5xl mb-2"></i>
                        <i class="fa-solid fa-image text-2xl opacity-50"></i>
                    </div>
                @endif
                
                
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <h4 class="text-white text-xs font-medium truncate">{{ $book->title }}</h4>
                    <p class="text-white/80 text-xs truncate">{{ $book->author }}</p>
                </div>
            </div>
            
            
            <div class="mt-2 text-center">
                <h4 class="font-medium text-slate-700 text-sm truncate">{{ $book->title }}</h4>
                <p class="text-xs text-slate-400 truncate">{{ $book->author }}</p>
            </div>
        </div>
        @empty
        <div class="col-span-4 text-center py-8 text-slate-500">
            <i class="fa-solid fa-book-open text-4xl mb-2"></i>
            <p>Belum ada data buku</p>
        </div>
        @endforelse
    </div>
</div>


<div class="mt-6 bg-white rounded-xl p-6 shadow">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h3 class="font-semibold text-slate-700 text-lg">
                <i class="fa-solid fa-clock-rotate-left text-amber-600 mr-2"></i>
                Riwayat Peminjaman Terbaru
            </h3>
        </div>
        <a href="{{ route('loans.history') }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium flex items-center gap-1">
            Lihat semua <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
    </div>
    
    <div class="overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead>
            <tr class="border-b border-slate-200 bg-slate-50">
                <th class="text-left py-2 px-3 text-slate-500 font-medium rounded-l-lg">Buku</th>
                <th class="text-left py-2 px-3 text-slate-500 font-medium">Tanggal Pinjam</th>
                <th class="text-left py-2 px-3 text-slate-500 font-medium">Tgl Kembali Rencana</th>
                <th class="text-left py-2 px-3 text-slate-500 font-medium rounded-r-lg">Status</th>
             </tr>
        </thead>
        <tbody>
            @php
                $recentLoans = App\Models\Loan::where('id_users', Auth::id())
                    ->with('book')
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
            @endphp
            
            @forelse($recentLoans as $loan)
            <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                <td class="py-2 px-3 font-medium text-slate-700">{{ $loan->book->title ?? '-' }}</td>
                <td class="py-2 px-3 text-slate-600">{{ $loan->tgl_pinjam ? $loan->tgl_pinjam->format('d/m/Y') : '-' }}</td>
                <td class="py-2 px-3 text-slate-600">{{ $loan->tgl_kembali_rencana ? $loan->tgl_kembali_rencana->format('d/m/Y') : '-' }}</td>
                <td class="py-2 px-3">
                    @if($loan->status == 'pending')
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-medium">Menunggu</span>
                    @elseif($loan->status == 'borrowed')
                        <span class="px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">Dipinjam</span>
                    @elseif($loan->status == 'returned')
                        <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-medium">Dikembalikan</span>
                    @elseif($loan->status == 'cancelled')
                        <span class="px-2 py-1 bg-red-100 text-red-600 rounded-full text-xs font-medium">Dibatalkan</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-8 text-slate-500">
                    <i class="fa-solid fa-book text-4xl mb-2"></i>
                    <p>Belum ada riwayat peminjaman</p>
                    <a href="{{ route('loans') }}" class="text-amber-600 text-sm mt-2 inline-block">Mulai pinjam buku</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>

@endsection