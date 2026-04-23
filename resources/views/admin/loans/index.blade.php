@extends('layouts-admin.admin')

@section('title', 'TRANSAKSI')

@section('content')

    <!-- CARDS - Desktop View -->
    <div class="hidden lg:grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <!-- Card Total Data -->
        <a href="{{ route('admin.loans.index', array_merge(request()->except(['status', 'page']), ['status' => 'all'])) }}"
            class="block group">
            <div
                class="bg-white rounded-xl shadow p-4 hover:shadow-lg transition-all duration-300 cursor-pointer {{ !request('status') || request('status') == 'all' ? 'ring-2 ring-purple-500 shadow-lg' : '' }}">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 flex items-center justify-center rounded-lg bg-purple-100 text-purple-600 group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-database text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs text-stone-500 uppercase font-semibold">Total Data</p>
                            <h2 class="text-2xl font-bold text-[#280905]">{{ $stats['total'] ?? 0 }}</h2>
                        </div>
                    </div>
                    @if (!request('status') || request('status') == 'all')
                        <div class="text-purple-500">
                            <i class="fa-solid fa-check-circle"></i>
                        </div>
                    @endif
                </div>
            </div>
        </a>

        <!-- Card Pending -->
        <a href="{{ route('admin.loans.index', array_merge(request()->except(['status', 'page']), ['status' => 'pending'])) }}"
            class="block group">
            <div
                class="bg-white rounded-xl shadow p-4 hover:shadow-lg transition-all duration-300 cursor-pointer {{ request('status') == 'pending' ? 'ring-2 ring-amber-500 shadow-lg' : '' }}">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 flex items-center justify-center rounded-lg bg-amber-100 text-amber-600 group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-clock-rotate-left text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs text-stone-500 uppercase font-semibold">Pending</p>
                            <h2 class="text-2xl font-bold text-[#280905]">{{ $stats['pending'] ?? 0 }}</h2>
                        </div>
                    </div>
                    @if (request('status') == 'pending')
                        <div class="text-amber-500">
                            <i class="fa-solid fa-check-circle"></i>
                        </div>
                    @endif
                </div>
            </div>
        </a>

        <!-- Card Borrowed -->
        <a href="{{ route('admin.loans.index', array_merge(request()->except(['status', 'page']), ['status' => 'borrowed'])) }}"
            class="block group">
            <div
                class="bg-white rounded-xl shadow p-4 hover:shadow-lg transition-all duration-300 cursor-pointer {{ request('status') == 'borrowed' ? 'ring-2 ring-blue-500 shadow-lg' : '' }}">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600 group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-key text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs text-stone-500 uppercase font-semibold">Borrowed</p>
                            <h2 class="text-2xl font-bold text-[#280905]">{{ $stats['borrowed'] ?? 0 }}</h2>
                        </div>
                    </div>
                    @if (request('status') == 'borrowed')
                        <div class="text-blue-500">
                            <i class="fa-solid fa-check-circle"></i>
                        </div>
                    @endif
                </div>
            </div>
        </a>

        <!-- Card Returned -->
        <a href="{{ route('admin.loans.index', array_merge(request()->except(['status', 'page']), ['status' => 'returned'])) }}"
            class="block group">
            <div
                class="bg-white rounded-xl shadow p-4 hover:shadow-lg transition-all duration-300 cursor-pointer {{ request('status') == 'returned' ? 'ring-2 ring-green-500 shadow-lg' : '' }}">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-100 text-green-600 group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-box-archive text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs text-stone-500 uppercase font-semibold">Returned</p>
                            <h2 class="text-2xl font-bold text-[#280905]">{{ $stats['returned'] ?? 0 }}</h2>
                        </div>
                    </div>
                    @if (request('status') == 'returned')
                        <div class="text-green-500">
                            <i class="fa-solid fa-check-circle"></i>
                        </div>
                    @endif
                </div>
            </div>
        </a>

        <a href="{{ route('admin.loans.create') }}" class="block group h-full">
            <div
                class="bg-sky-600 hover:bg-sky-700
                text-white rounded-xl shadow p-4 hover:shadow-lg transition-all duration-300 cursor-pointer h-full">
                <div class="flex items-center justify-between h-full">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 flex items-center justify-center rounded-lg bg-white/20 text-white group-hover:scale-110 transition-transform duration-300 shrink-0">
                            <i class="fa-solid fa-plus text-lg"></i>
                        </div>

                        <div class="flex flex-col justify-center h-10">
                            <h2 class="text-xl font-bold text-white leading-none">Create</h2>
                        </div>
                    </div>

                    <div class="text-white/50 group-hover:text-white/80 transition shrink-0">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- MOBILE: Only Create Button -->
    <div class="lg:hidden mb-6">
        <a href="{{ route('admin.loans.create') }}" class="block group">
            <div
                class="bg-sky-600 hover:bg-sky-700 rounded-xl shadow p-4 hover:shadow-lg transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-12 h-12 flex items-center justify-center rounded-lg bg-white/20 text-white group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-plus text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-white/80 uppercase font-semibold">Tambah Baru</p>
                            <h2 class="text-xl font-bold text-white">Tambah Peminjaman</h2>
                        </div>
                    </div>
                    <div class="text-white/50 group-hover:text-white/80 transition">
                        <i class="fa-solid fa-arrow-right text-xl"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Filter Info & Reset Button -->
    @if (request('status') || request('tanggal'))
        <div class="mb-4 flex items-center justify-between bg-stone-50 rounded-lg p-3">
            <div class="flex items-center gap-2 flex-wrap">
                <i class="fa-solid fa-filter text-stone-500"></i>
                <span class="text-sm text-stone-600">Filter aktif:</span>

                @if (request('status') && request('status') != 'all')
                    <span class="text-sm font-semibold text-[#280905] bg-white px-2 py-1 rounded">
                        Status:
                        @if (request('status') == 'pending')
                            Pending
                        @elseif(request('status') == 'borrowed')
                            Dipinjam
                        @elseif(request('status') == 'returned')
                            Dikembalikan
                        @endif
                    </span>
                @endif

                @if (request('tanggal'))
                    <span class="text-sm font-semibold text-[#280905] bg-white px-2 py-1 rounded">
                        Tanggal: {{ \Carbon\Carbon::parse(request('tanggal'))->format('d/m/Y') }}
                    </span>
                @endif
            </div>
            <a href="{{ route('admin.loans.index', array_merge(request()->except(['status', 'page', 'tanggal']))) }}"
                class="text-sm text-[#A27B5C] hover:text-[#280905] transition flex items-center gap-1">
                <i class="fa-solid fa-times-circle"></i>
                Hapus Semua Filter
            </a>
        </div>
    @endif

    <!-- SEARCH & FILTER -->
    <div class="bg-white rounded-xl shadow p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <!-- FILTER TANGGAL & SEARCH BOX -->
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <!-- Filter Tanggal -->
                <form id="dateFilterForm" method="GET" action="{{ route('admin.loans.index') }}" class="relative">
                    <div class="relative">
                        <input type="date" name="tanggal" id="tanggalFilter" value="{{ request('tanggal') }}"
                            class="w-full sm:w-48 pl-10 pr-4 py-2.5 border border-stone-300 rounded-lg 
                        focus:outline-none focus:ring-2 focus:ring-[#A27B5C] focus:border-[#A27B5C] text-sm">
                        <i class="fa-solid fa-calendar-days absolute left-3 top-3.5 text-stone-400"></i>
                    </div>

                    @if (request('per_page'))
                        <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                    @endif
                    @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    @if (request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                </form>

                <!-- Search Box -->
                <form id="searchForm" method="GET" action="{{ route('admin.loans.index') }}"
                    class="relative w-full sm:w-80">
                    <div class="relative">
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                            placeholder="Cari Transaksi..."
                            class="w-full pl-10 pr-4 py-2.5 border border-stone-300 rounded-lg 
                        focus:outline-none focus:ring-2 focus:ring-[#A27B5C] focus:border-[#A27B5C]">
                        <i class="fa-solid fa-search absolute left-3 top-3.5 text-stone-400"></i>
                    </div>

                    @if (request('per_page'))
                        <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                    @endif
                    @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    @if (request('tanggal'))
                        <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                    @endif
                </form>
            </div>

            <!-- ROWS PER PAGE -->
            <div class="flex items-center gap-3">
                <span class="text-sm text-stone-600">Tampilkan:</span>
                <div class="flex bg-stone-100 rounded-lg p-1">
                    @foreach ([5, 10, 15, 20] as $perPage)
                        <a href="{{ route('admin.loans.index', array_merge(request()->except('page'), ['per_page' => $perPage])) }}"
                            class="px-3 py-1 rounded-md text-sm font-medium transition
                        {{ request('per_page', 5) == $perPage ? 'bg-sky-600 text-white shadow' : 'text-slate-600 hover:text-sky-600' }}">
                            {{ $perPage }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- TABLE CARD -->
    <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-stone-600">
                <thead class="bg-stone-50 text-xs uppercase text-stone-500">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Peminjam</th>
                        <th class="px-6 py-4">Buku</th>
                        <th class="px-6 py-4">Tanggal Pinjam</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($loans as $item)
                        <tr class="hover:bg-stone-50 transition" id="row-{{ $item->id }}">
                            <td class="px-6 py-4 font-medium">
                                {{ ($loans->currentPage() - 1) * $loans->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <p class="font-semibold text-[#280905]">
                                            {{ $item->user->name ?? '-' }}
                                        </p>
                                        <p class="text-xs text-stone-400">
                                            {{ $item->user->email ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <!-- BUKU COLUMN -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($item->book && $item->book->image)
                                        <div class="relative">
                                            {{-- Shadow effect --}}
                                            <div
                                                class="absolute -bottom-1 left-0.5 right-0.5 h-2 bg-black/20 blur-sm rounded-full">
                                            </div>

                                            {{-- Book cover --}}
                                            <div
                                                class="w-10 h-14 md:w-12 md:h-16 rounded-md overflow-hidden shadow-md border border-stone-200">
                                                <img src="{{ asset('storage/' . $item->book->image) }}"
                                                    alt="{{ $item->book->title }}"
                                                    class="w-full h-full object-cover hover:scale-105 transition duration-300">
                                            </div>
                                        </div>
                                    @else
                                        <div
                                            class="w-10 h-14 md:w-12 md:h-16 rounded-md bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center text-black shadow-md">
                                            <i class="fa-solid fa-book text-lg"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-[#280905] line-clamp-1">
                                            {{ $item->book->title ?? 'Buku tidak tersedia' }}
                                        </p>
                                        <p class="text-xs text-stone-400">{{ $item->book->author ?? '-' }}</p>
                                        @if ($item->book && $item->book->isbn)
                                            <p class="text-xs text-stone-400 mt-0.5">ISBN: {{ $item->book->isbn }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'borrowed' => 'bg-blue-100 text-blue-700',
                                        'returned' => 'bg-green-100 text-green-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                    ];
                                    $statusText = [
                                        'pending' => 'Pending',
                                        'borrowed' => 'Dipinjam',
                                        'returned' => 'Dikembalikan',
                                        'cancelled' => 'Dibatalkan',
                                    ];
                                    $color = $statusColors[$item->status] ?? 'bg-gray-100 text-gray-700';
                                    $text = $statusText[$item->status] ?? $item->status;
                                @endphp
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $color }}">
                                    {{ $text }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">

                                    <!-- View Button -->
                                    <a href="{{ route('admin.loans.show', $item->id) }}"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg 
                                        bg-[#A27B5C]/10 text-[#A27B5C] hover:bg-[#A27B5C]/20 transition-all duration-200"
                                        title="Lihat Detail">
                                        <i class="fa fa-eye text-sm"></i>
                                    </a>

                                    <!-- Approve Button (only for pending) -->
                                    @if ($item->status == 'pending')
                                        <form action="{{ route('admin.loans.approve', $item->id) }}" method="POST"
                                            class="inline-block approve-form"
                                            data-name="{{ $item->user->name ?? 'Loan' }} - {{ $item->book->title ?? '' }}">
                                            @csrf
                                            <button type="button"
                                                class="approve-btn w-8 h-8 flex items-center justify-center rounded-lg 
                                                bg-green-100 text-green-600 hover:bg-green-200 transition-all duration-200"
                                                title="Setujui">
                                                <i class="fa-solid fa-check text-sm"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Return Button (only for borrowed) -->
                                    @if ($item->status == 'borrowed')
                                        <form action="{{ route('admin.loans.return', $item->id) }}" method="POST"
                                            class="inline-block return-form"
                                            data-name="{{ $item->user->name ?? 'Loan' }} - {{ $item->book->title ?? '' }}">
                                            @csrf
                                            <button type="button"
                                                class="return-btn w-8 h-8 flex items-center justify-center rounded-lg 
                                                bg-blue-100 text-blue-600 hover:bg-blue-200 transition-all duration-200"
                                                title="Tandai Dikembalikan">
                                                <i class="fa-solid fa-rotate-left text-sm"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.loans.destroy', $item->id) }}" method="POST"
                                        class="delete-form inline-block" data-id="{{ $item->id }}"
                                        data-name="{{ $item->user->name ?? 'Loan' }} - {{ $item->book->title ?? '' }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="delete-btn w-8 h-8 flex items-center justify-center rounded-lg 
                                            bg-red-100 text-red-600 hover:bg-red-200 transition-all duration-200"
                                            title="Hapus">
                                            <i class="fa-solid fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-stone-500">
                                <div class="flex flex-col items-center">
                                    <i class="fa-solid fa-calendar-xmark text-3xl mb-3 text-stone-300"></i>
                                    <p class="text-stone-500">Tidak ada data Peminjaman Buku</p>
                                    @if (request()->has('search'))
                                        <p class="text-sm text-stone-400 mt-1">
                                            Hasil pencarian "<span class="font-medium">{{ request('search') }}</span>"
                                            tidak ditemukan
                                        </p>
                                    @endif
                                    @if (request('status') && request('status') != 'all')
                                        <p class="text-sm text-stone-400 mt-1">
                                            dengan status
                                            <span class="font-medium">
                                                @if (request('status') == 'pending')
                                                    Pending
                                                @elseif(request('status') == 'borrowed')
                                                    Dipinjam
                                                @elseif(request('status') == 'returned')
                                                    Dikembalikan
                                                @endif
                                            </span>
                                        </p>
                                    @endif
                                    @if (request('tanggal'))
                                        <p class="text-sm text-stone-400 mt-1">
                                            pada tanggal <span
                                                class="font-medium">{{ \Carbon\Carbon::parse(request('tanggal'))->format('d/m/Y') }}</span>
                                        </p>
                                    @endif
                                    <!-- Mobile create button in empty state -->
                                    <a href="{{ route('admin.loans.create') }}"
                                        class="mt-4 px-4 py-2 bg-[#A27B5C] text-white rounded-lg hover:bg-[#8B6348] transition flex items-center gap-2 lg:hidden">
                                        <i class="fa-solid fa-plus"></i>
                                        Tambah Peminjaman
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        @if ($loans->hasPages())
            <div class="px-6 py-4 border-t border-stone-100">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-stone-500">
                        Menampilkan
                        <span class="font-medium">{{ $loans->firstItem() ?? 0 }}</span>
                        -
                        <span class="font-medium">{{ $loans->lastItem() ?? 0 }}</span>
                        dari
                        <span class="font-medium">{{ $loans->total() }}</span>
                        data
                    </div>

                    <div class="flex items-center gap-2">
                        <!-- Previous Button -->
                        @if ($loans->onFirstPage())
                            <span class="px-3 py-1.5 rounded-lg bg-stone-100 text-stone-400 cursor-not-allowed">
                                <i class="fa-solid fa-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $loans->previousPageUrl() . (request('search') ? '&search=' . request('search') : '') . (request('per_page') ? '&per_page=' . request('per_page') : '') . (request('status') ? '&status=' . request('status') : '') . (request('tanggal') ? '&tanggal=' . request('tanggal') : '') }}"
                                class="px-3 py-1.5 rounded-lg bg-[#A27B5C]/10 text-[#A27B5C] hover:bg-[#A27B5C]/20 transition">
                                <i class="fa-solid fa-chevron-left"></i>
                            </a>
                        @endif

                        <!-- Page Numbers -->
                        @php
                            $current = $loans->currentPage();
                            $last = $loans->lastPage();
                            $start = max(1, $current - 1);
                            $end = min($last, $current + 1);

                            if ($last <= 5) {
                                $start = 1;
                                $end = $last;
                            } else {
                                if ($current <= 3) {
                                    $start = 1;
                                    $end = 5;
                                } elseif ($current >= $last - 2) {
                                    $start = $last - 4;
                                    $end = $last;
                                }
                            }
                        @endphp

                        @for ($i = $start; $i <= $end; $i++)
                            <a href="{{ $loans->url($i) . (request('search') ? '&search=' . request('search') : '') . (request('per_page') ? '&per_page=' . request('per_page') : '') . (request('status') ? '&status=' . request('status') : '') . (request('tanggal') ? '&tanggal=' . request('tanggal') : '') }}"
                                class="px-3 py-1.5 min-w-[40px] text-center rounded-lg transition 
                              {{ $i == $current ? 'bg-[#280905] text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                                {{ $i }}
                            </a>
                        @endfor

                        <!-- Next Button -->
                        @if ($loans->hasMorePages())
                            <a href="{{ $loans->nextPageUrl() . (request('search') ? '&search=' . request('search') : '') . (request('per_page') ? '&per_page=' . request('per_page') : '') . (request('status') ? '&status=' . request('status') : '') . (request('tanggal') ? '&tanggal=' . request('tanggal') : '') }}"
                                class="px-3 py-1.5 rounded-lg bg-[#A27B5C]/10 text-[#A27B5C] hover:bg-[#A27B5C]/20 transition">
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="px-3 py-1.5 rounded-lg bg-stone-100 text-stone-400 cursor-not-allowed">
                                <i class="fa-solid fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Search form auto submit
        document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            let searchTimeout;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        searchForm.submit();
                    }, 800);
                });
            }
        });
    </script>

    <script>
        // Date filter auto submit
        document.addEventListener('DOMContentLoaded', function() {
            const dateFilterForm = document.getElementById('dateFilterForm');
            const tanggalFilter = document.getElementById('tanggalFilter');

            if (tanggalFilter) {
                tanggalFilter.addEventListener('change', function() {
                    dateFilterForm.submit();
                });
            }
        });
    </script>

    <script>
        // SweetAlert untuk konfirmasi delete
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const form = this.closest('.delete-form');
                    const loanName = form.getAttribute('data-name');

                    Swal.fire({
                        title: "Apakah Anda yakin?",
                        text: `Data peminjaman "${loanName}" akan dihapus secara permanen.`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

    <script>
        // SweetAlert untuk konfirmasi approve
        document.addEventListener('DOMContentLoaded', function() {
            const approveButtons = document.querySelectorAll('.approve-btn');

            approveButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const form = this.closest('.approve-form');
                    const loanName = form.getAttribute('data-name');

                    Swal.fire({
                        title: "Setujui Peminjaman?",
                        text: `Peminjaman "${loanName}" akan disetujui dan stok buku akan berkurang.`,
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#10b981",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Ya, setujui!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

    <script>
        // SweetAlert untuk konfirmasi return
        document.addEventListener('DOMContentLoaded', function() {
            const returnButtons = document.querySelectorAll('.return-btn');

            returnButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const form = this.closest('.return-form');
                    const loanName = form.getAttribute('data-name');

                    Swal.fire({
                        title: "Yakin Dikonfirmasi?",
                        text: `Buku "${loanName}" yang dipinjam.`,
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#3b82f6",
                        cancelButtonColor: "#ef4444",
                        confirmButtonText: "Ya, kembalikan!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

    <!-- Show success message from server -->
    @if (session('success'))
        <script>
            Swal.fire({
                title: "Success!",
                text: "{{ session('success') }}",
                icon: "success",
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true
            });
        </script>
    @endif

    <!-- Show error message from server -->
    @if (session('error'))
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
