@extends('layouts-user.user')

@section('title', 'PEMINJAMAN BUKU')

@section('content')
    <div class="space-y-8 animate-slide-in">

        
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center gap-3 mb-6 pb-3 border-b border-slate-200">
                <div class="bg-red-100 rounded-full p-2">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <h2 class="text-xl font-bold text-slate-800">Akses Terblokir</h2>
            </div>

            @if ($lateBooks->count() > 0)
                
                <div class="mb-6 p-4 bg-amber-50 rounded-lg border border-amber-200">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-info-circle text-amber-600 text-xl mt-0.5"></i>
                        <div>
                            <p class="text-amber-800 font-medium">Perhatian:</p>
                            <p class="text-amber-700 text-sm">
                                Silakan kembalikan buku yang terlambat terlebih dahulu untuk dapat meminjam kembali.
                            </p>
                        </div>
                    </div>
                </div>

                
                <div class="space-y-4">
                    @foreach ($lateBooks as $loan)
                        <div class="bg-red-50 rounded-xl p-5 border border-red-200 hover:shadow-md transition">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <i class="fas fa-book text-red-600"></i>
                                        <h3 class="font-bold text-lg text-slate-800">
                                            {{ $loan->book->title ?? 'Buku tidak ditemukan' }}</h3>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm mt-2">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-calendar-alt text-red-500 w-4"></i>
                                            <span class="text-slate-600">Tanggal Pinjam:</span>
                                            <span
                                                class="font-medium">{{ \Carbon\Carbon::parse($loan->tgl_pinjam)->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-calendar-check text-red-500 w-4"></i>
                                            <span class="text-slate-600">Batas Kembali:</span>
                                            <span
                                                class="font-medium text-red-700">{{ \Carbon\Carbon::parse($loan->tgl_kembali_rencana)->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 bg-red-200 text-red-800 rounded-full text-xs font-semibold">
                                            <i class="fas fa-clock"></i> TERLAMBAT
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-check-circle text-green-500 text-5xl mb-3"></i>
                    <p class="text-slate-600">Tidak ada buku yang terlambat.</p>
                </div>
            @endif
        </div>

        
        <div class="flex justify-center">
            <a href="{{ route('loans.history') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white rounded-xl font-medium transition shadow-md">
                <i class="fas fa-history"></i> Lihat History Peminjaman
            </a>
        </div>
    </div>

    <style>
        .animate-slide-in {
            animation: slideIn 0.4s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection