@extends('layouts-admin.admin')

@section('title', 'Bookings Management')

@section('content')

<!-- HEADER BOX -->
<div class="bg-white rounded-xl shadow p-5 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div
                class="w-12 h-12 flex items-center justify-center rounded-xl
                    bg-blue-100 text-blue-600">
                <i class="fa-solid fa-calendar-check text-lg"></i>
            </div>
            <div>
                <p class="text-sm text-stone-500">Total Bookings</p>
                <h2 class="text-2xl font-bold text-[#280905]">
                    {{ $bookings->total() }}
                </h2>
            </div>
        </div>

        {{-- <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
            <!-- Button Tambah -->
            <a href="{{ route('admin.bookings.create') }}"
                class="flex items-center justify-center gap-2 bg-[#280905] hover:bg-[#A27B5C]
                text-white px-4 sm:px-5 py-2.5 rounded-xl shadow transition
                w-full sm:w-auto order-2 sm:order-2">
                <i class="fa-solid fa-plus"></i>
                <span class="text-sm sm:text-base">Eksport</span>
            </a>
        </div> --}}
    </div>
</div>

<!-- SEARCH & FILTER -->
<div class="bg-white rounded-xl shadow p-4 mb-6">
    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
        <!-- SEARCH BOX -->
        <div class="w-full md:w-auto">
            <form id="searchForm" method="GET" action="{{ route('admin.bookings.index') }}"
                class="relative w-full md:w-72">
                <div class="relative">
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                        placeholder="Cari nama peminjam atau ruangan..."
                        class="w-full pl-10 pr-4 py-2.5 border border-stone-300 rounded-lg 
                              focus:outline-none focus:ring-2 focus:ring-[#A27B5C] focus:border-[#A27B5C]">
                    <i class="fa-solid fa-search absolute left-3 top-3.5 text-stone-400"></i>
                </div>

                @if (request('per_page'))
                    <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                @endif
            </form>
        </div>

        <!-- ROWS PER PAGE -->
        <div class="flex items-center gap-3">
            <span class="text-sm text-stone-600">Tampilkan:</span>
            <div class="flex bg-stone-100 rounded-lg p-1">
                @foreach ([5, 10, 15, 20] as $perPage)
                    <a href="{{ route('admin.bookings.index', array_merge(request()->except('page'), ['per_page' => $perPage])) }}"
                        class="px-3 py-1 rounded-md text-sm font-medium transition
                      {{ request('per_page', 5) == $perPage ? 'bg-[#A27B5C] text-white shadow' : 'text-stone-600 hover:text-[#A27B5C]' }}">
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
                    <th class="px-6 py-4">Ruangan</th>
                    <th class="px-6 py-4">Tanggal Pinjam</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($bookings as $item)
                    <tr class="hover:bg-stone-50 transition" id="row-{{ $item->id }}">
                        <td class="px-6 py-4 font-medium">
                            {{ ($bookings->currentPage() - 1) * $bookings->perPage() + $loop->iteration }}
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

                        <td class="px-6 py-4">
                            <p class="text-stone-700">{{ $item->room->room_name ?? '-' }}</p>
                            <p class="text-xs text-stone-400">{{ $item->room->location ?? '-' }}</p>
                        </td>

                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'approved' => 'bg-blue-100 text-blue-700',
                                    'borrowed' => 'bg-purple-100 text-purple-700',
                                    'returned' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700'
                                ];
                                $statusText = [
                                    'pending' => 'Pending',
                                    'approved' => 'Disetujui',
                                    'borrowed' => 'Dipinjam',
                                    'returned' => 'Dikembalikan',
                                    'cancelled' => 'Dibatalkan'
                                ];
                                $color = $statusColors[$item->status] ?? 'bg-gray-100 text-gray-700';
                                $text = $statusText[$item->status] ?? $item->status;
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $color }}">
                                {{ $text }}
                            </span>
                            @if($item->teguran)
                                <div class="mt-1" title="{{ $item->teguran }}">
                                    <i class="fa-solid fa-circle-exclamation text-red-500 text-xs"></i>
                                </div>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                <!-- View Button -->
                                <a href="{{ route('admin.bookings.show', $item->id) }}"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg 
                                        bg-[#A27B5C]/10 text-[#A27B5C] hover:bg-[#A27B5C]/20 transition-all duration-200"
                                    title="Lihat Detail">
                                    <i class="fa fa-eye text-sm"></i>
                                </a>

                                <!-- Approve Button (only for pending) -->
                                @if($item->status == 'pending')
                                    <form action="{{ route('admin.bookings.approve', $item->id) }}" 
                                          method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg 
                                                bg-green-100 text-green-600 hover:bg-green-200 transition-all duration-200"
                                            title="Setujui">
                                            <i class="fa-solid fa-check text-sm"></i>
                                        </button>
                                    </form>
                                @endif

                                <!-- Borrow Button (only for approved) -->
                                @if($item->status == 'approved')
                                    <form action="{{ route('admin.bookings.borrow', $item->id) }}" 
                                          method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg 
                                                bg-purple-100 text-purple-600 hover:bg-purple-200 transition-all duration-200"
                                            title="Tandai Dipinjam">
                                            <i class="fa-solid fa-hand-peace text-sm"></i>
                                        </button>
                                    </form>
                                @endif

                                <!-- Return Button (only for borrowed) -->
                                @if($item->status == 'borrowed')
                                    <form action="{{ route('admin.bookings.return', $item->id) }}" 
                                          method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg 
                                                bg-blue-100 text-blue-600 hover:bg-blue-200 transition-all duration-200"
                                            title="Tandai Dikembalikan">
                                            <i class="fa-solid fa-rotate-left text-sm"></i>
                                        </button>
                                    </form>
                                @endif

                                <!-- Delete Button -->
                                <form action="{{ route('admin.bookings.destroy', $item->id) }}" 
                                      method="POST" 
                                      class="delete-form inline-block"
                                      data-id="{{ $item->id }}"
                                      data-name="{{ $item->user->name ?? 'Booking' }} - {{ $item->room->room_name ?? '' }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="delete-btn w-8 h-8 flex items-center justify-center rounded-lg 
                                            bg-red-100 text-red-600 hover:bg-red-200 transition-all duration-200"
                                        title="Hapus">
                                        <i class="fa fa-trash text-sm"></i>
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
                                <p class="text-stone-500">Tidak ada data booking</p>
                                @if (request()->has('search'))
                                    <p class="text-sm text-stone-400 mt-1">
                                        Hasil pencarian "<span class="font-medium">{{ request('search') }}</span>"
                                        tidak ditemukan
                                    </p>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    @if ($bookings->hasPages())
        <div class="px-6 py-4 border-t border-stone-100">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-sm text-stone-500">
                    Menampilkan
                    <span class="font-medium">{{ $bookings->firstItem() ?? 0 }}</span>
                    -
                    <span class="font-medium">{{ $bookings->lastItem() ?? 0 }}</span>
                    dari
                    <span class="font-medium">{{ $bookings->total() }}</span>
                    data
                </div>

                <div class="flex items-center gap-2">
                    <!-- Previous Button -->
                    @if ($bookings->onFirstPage())
                        <span class="px-3 py-1.5 rounded-lg bg-stone-100 text-stone-400 cursor-not-allowed">
                            <i class="fa-solid fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $bookings->previousPageUrl() . (request('search') ? '&search=' . request('search') : '') . (request('per_page') ? '&per_page=' . request('per_page') : '') }}"
                            class="px-3 py-1.5 rounded-lg bg-[#A27B5C]/10 text-[#A27B5C] hover:bg-[#A27B5C]/20 transition">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                    @endif

                    <!-- Page Numbers -->
                    @php
                        $current = $bookings->currentPage();
                        $last = $bookings->lastPage();
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
                        <a href="{{ $bookings->url($i) . (request('search') ? '&search=' . request('search') : '') . (request('per_page') ? '&per_page=' . request('per_page') : '') }}"
                            class="px-3 py-1.5 min-w-[40px] text-center rounded-lg transition 
                              {{ $i == $current ? 'bg-[#280905] text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    <!-- Next Button -->
                    @if ($bookings->hasMorePages())
                        <a href="{{ $bookings->nextPageUrl() . (request('search') ? '&search=' . request('search') : '') . (request('per_page') ? '&per_page=' . request('per_page') : '') }}"
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
    // SweetAlert untuk konfirmasi delete
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const form = this.closest('.delete-form');
                const bookingName = form.getAttribute('data-name');
                
                Swal.fire({
                    title: "Are you sure?",
                    text: `Booking "${bookingName}" akan dihapus.`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        
                        Swal.fire({
                            title: "Deleted!",
                            text: `Booking has been deleted.`,
                            icon: "success",
                            confirmButtonColor: "#3085d6"
                        });
                    }
                });
            });
        });
    });
</script>

<!-- Show success message from server -->
@if(session('success'))
<script>
    Swal.fire({
        title: "Success!",
        text: "{{ session('success') }}",
        icon: "success",
        confirmButtonColor: "#3085d6"
    });
</script>
@endif

<!-- Show error message from server -->
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