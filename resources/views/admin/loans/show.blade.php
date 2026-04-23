@extends('layouts-admin.admin')

@section('title', 'TRANSAKSI')

@section('content')

<div class="bg-white rounded-xl shadow p-5 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.loans.index') }}"
                class="w-10 h-10 flex items-center justify-center rounded-lg
                  bg-sky-50 text-sky-600 hover:bg-sky-100 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-xl font-semibold text-slate-900">
                    Show Category
                </h2>
                <p class="text-sm text-slate-500">Detail informasi data kategori</p>
            </div>
        </div>
    </div>
</div>

<!-- Borrower & Book Information -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Borrower Information Card -->
    <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
        <div class="border-b border-stone-100 px-6 py-4 bg-gradient-to-r from-stone-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-purple-100 text-purple-600">
                    <i class="fa-solid fa-user text-xl"></i>
                </div>
                <h2 class="text-lg font-semibold text-[#280905]">Informasi Peminjam</h2>
            </div>
        </div>
        <div class="p-6">
            <div class="flex items-start gap-4">
                <!-- Avatar -->
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center text-purple-600 shadow-md">
                    <i class="fa-solid fa-user text-2xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-[#280905]">{{ $loan->user->name ?? '-' }}</h3>
                    <p class="text-sm text-stone-500 mt-1">
                        <i class="fa-solid fa-envelope mr-2"></i>
                        {{ $loan->user->email ?? '-' }}
                    </p>
                    @if($loan->user && $loan->user->no_hp)
                        <p class="text-sm text-stone-500 mt-1">
                            <i class="fa-solid fa-phone mr-2"></i>
                            {{ $loan->user->no_hp }}
                        </p>
                    @endif
                    @if($loan->user && $loan->user->address)
                        <p class="text-sm text-stone-500 mt-1">
                            <i class="fa-solid fa-location-dot mr-2"></i>
                            {{ $loan->user->address }}
                        </p>
                    @endif
                    <!-- Info pinjam tambahan -->
                    <div class="mt-3 pt-3 border-t border-stone-100">
                        <div class="flex items-center gap-4 text-xs text-stone-500">
                            <span>
                                <i class="fa-regular fa-calendar mr-1"></i>
                                Member sejak: {{ \Carbon\Carbon::parse($loan->user->created_at ?? now())->format('M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Book Information Card with Realistic Cover -->
    <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
        <div class="border-b border-stone-100 px-6 py-4 bg-gradient-to-r from-stone-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                    <i class="fa-solid fa-book text-xl"></i>
                </div>
                <h2 class="text-lg font-semibold text-[#280905]">Informasi Buku</h2>
            </div>
        </div>
        <div class="p-6">
            <div class="flex gap-5">
                <!-- Book Cover - Realistic Style -->
                <div class="flex-shrink-0 relative">
                    @if ($loan->book && $loan->book->image)
                        <div class="relative group">
                            <!-- Shadow efek seperti buku asli -->
                            <div class="absolute -right-1 bottom-1 w-full h-full bg-black/20 rounded-r-md blur-sm"></div>
                            <div class="absolute -bottom-1 left-1 right-1 h-2 bg-black/20 blur-md rounded-full"></div>
                            
                            <!-- Cover buku dengan efek 3D -->
                            <div class="relative w-28 md:w-36 rounded-r-md overflow-hidden shadow-xl border-l-4 border-amber-700/30">
                                <img src="{{ asset('storage/' . $loan->book->image) }}"
                                    alt="{{ $loan->book->title }}"
                                    class="w-full h-auto object-cover group-hover:scale-105 transition duration-300">
                                <!-- Efek lipatan cover -->
                                <div class="absolute inset-0 bg-gradient-to-tr from-black/10 via-transparent to-white/20 pointer-events-none"></div>
                            </div>
                            
                            <!-- Spine effect -->
                            <div class="absolute left-0 top-0 bottom-0 w-2 bg-gradient-to-r from-amber-800/40 to-amber-600/20 rounded-l-sm"></div>
                        </div>
                    @else
                        <div class="relative group">
                            <div class="absolute -right-1 bottom-1 w-full h-full bg-black/20 rounded-r-md blur-sm"></div>
                            <div class="relative w-28 md:w-36 rounded-r-md bg-gradient-to-br from-amber-100 to-orange-100 flex flex-col items-center justify-center p-3 shadow-xl border-l-4 border-amber-700/30">
                                <i class="fa-solid fa-book-open text-4xl text-[#A27B5C] mb-2"></i>
                                <p class="text-xs text-center text-stone-600 font-medium">Cover Buku</p>
                                <p class="text-[10px] text-stone-400 text-center">Tidak tersedia</p>
                            </div>
                            <div class="absolute left-0 top-0 bottom-0 w-2 bg-gradient-to-r from-amber-800/40 to-amber-600/20 rounded-l-sm"></div>
                        </div>
                    @endif
                </div>
                
                <!-- Book Details -->
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-[#280905] line-clamp-2">{{ $loan->book->title ?? 'Buku tidak tersedia' }}</h3>
                    @if($loan->book)
                        <p class="text-sm text-stone-600 mt-1">
                            <i class="fa-solid fa-user-pen mr-2"></i>
                            {{ $loan->book->author ?? '-' }}
                        </p>
                        @if($loan->book->publisher)
                            <p class="text-sm text-stone-500 mt-1">
                                <i class="fa-solid fa-building mr-2"></i>
                                {{ $loan->book->publisher }}
                            </p>
                        @endif
                        @if($loan->book->isbn)
                            <p class="text-sm text-stone-500 mt-1">
                                <i class="fa-solid fa-barcode mr-2"></i>
                                ISBN: {{ $loan->book->isbn }}
                            </p>
                        @endif
                        @if($loan->book->tahun_terbit)
                            <p class="text-sm text-stone-500 mt-1">
                                <i class="fa-solid fa-calendar mr-2"></i>
                                Tahun Terbit: {{ $loan->book->tahun_terbit }}
                            </p>
                        @endif
                        
                        <!-- Book Stats Badges -->
                        <div class="mt-3 flex flex-wrap items-center gap-2">
                            <span class="text-xs px-2 py-1 rounded-full bg-stone-100 text-stone-600">
                                <i class="fa-solid fa-layer-group mr-1"></i>
                                {{ $loan->book->category->category_name ?? 'Tidak ada kategori' }}
                            </span>
                            <span class="text-xs px-2 py-1 rounded-full bg-stone-100 text-stone-600">
                                <i class="fa-solid fa-copy mr-1"></i>
                                Stok: {{ $loan->book->stock ?? 0 }}
                            </span>
                            @if(($loan->book->stock ?? 0) == 0)
                                <span class="text-xs px-2 py-1 rounded-full bg-red-100 text-red-600">
                                    <i class="fa-solid fa-ban mr-1"></i>
                                    Habis
                                </span>
                            @endif
                        </div>
                        
                        <!-- Loan Period Info -->
                        <div class="mt-4 p-3 bg-amber-50 rounded-lg border border-amber-100">
                            <div class="flex items-center gap-3 text-sm">
                                <i class="fa-solid fa-calendar-week text-amber-600"></i>
                                <div>
                                    <p class="text-xs text-stone-500">Periode Peminjaman</p>
                                    <p class="text-sm font-medium text-[#280905]">
                                        {{ \Carbon\Carbon::parse($loan->tgl_pinjam)->format('d/m/Y') }} 
                                        <i class="fa-solid fa-arrow-right mx-1 text-stone-400"></i> 
                                        {{ \Carbon\Carbon::parse($loan->tgl_kembali)->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Info Card (Tanggal Pinjam & Status) -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                    <i class="fa-solid fa-calendar-day text-xl"></i>
                </div>
                <div>
                    <p class="text-xs text-stone-500 uppercase font-semibold">Tanggal Pinjam</p>
                    <p class="text-lg font-bold text-[#280905]">
                        {{ \Carbon\Carbon::parse($loan->tgl_pinjam)->translatedFormat('d F Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-100 text-green-600">
                    <i class="fa-solid fa-flag-checkered text-xl"></i>
                </div>
                <div>
                    <p class="text-xs text-stone-500 uppercase font-semibold">Status</p>
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'borrowed' => 'bg-blue-100 text-blue-700',
                            'returned' => 'bg-green-100 text-green-700',
                            'cancelled' => 'bg-red-100 text-red-700'
                        ];
                        $statusText = [
                            'pending' => 'Pending',
                            'borrowed' => 'Dipinjam',
                            'returned' => 'Dikembalikan',
                            'cancelled' => 'Dibatalkan'
                        ];
                        $statusIcons = [
                            'pending' => 'fa-clock-rotate-left',
                            'borrowed' => 'fa-key',
                            'returned' => 'fa-box-archive',
                            'cancelled' => 'fa-times-circle'
                        ];
                        $color = $statusColors[$loan->status] ?? 'bg-gray-100 text-gray-700';
                        $text = $statusText[$loan->status] ?? $loan->status;
                        $icon = $statusIcons[$loan->status] ?? 'fa-circle-info';
                    @endphp
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-medium {{ $color }}">
                        <i class="fa-solid {{ $icon }}"></i>
                        {{ $text }}
                    </span>
                    @if($loan->tgl_kembali && \Carbon\Carbon::parse($loan->tgl_kembali)->isPast() && $loan->status != 'returned')
                        <p class="text-xs text-red-500 mt-2">
                            <i class="fa-solid fa-circle-exclamation"></i> Melewati batas pengembalian
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Jika ada keterangan atau teguran -->
@if($loan->keterangan || $loan->teguran)
<div class="grid grid-cols-1 gap-6 mt-6">
    @if($loan->keterangan)
    <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
        <div class="p-6">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-stone-100 text-stone-600">
                    <i class="fa-solid fa-pen text-xl"></i>
                </div>
                <div>
                    <p class="text-xs text-stone-500 uppercase font-semibold">Keterangan</p>
                    <p class="text-sm text-stone-700 mt-1">{{ $loan->keterangan }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($loan->teguran)
    <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden border-l-4 border-red-500">
        <div class="p-6">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-red-100 text-red-600">
                    <i class="fa-solid fa-circle-exclamation text-xl"></i>
                </div>
                <div>
                    <p class="text-xs text-red-500 uppercase font-semibold">Teguran</p>
                    <p class="text-sm text-red-700 mt-1">{{ $loan->teguran }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endif

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Success/Error Messages -->
@if(session('success'))
<script>
    Swal.fire({
        title: "Berhasil!",
        text: "{{ session('success') }}",
        icon: "success",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true
    }).then(() => {
        window.location.href = "{{ route('admin.loans.index') }}";
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        title: "Error!",
        text: "{{ session('error') }}",
        icon: "error",
        confirmButtonColor: "#3085d6"
    });
</script>
@endif

@endsection