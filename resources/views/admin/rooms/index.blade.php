@extends('layouts-admin.admin')

@section('title', 'Rooms Management')

@section('content')

<!-- HEADER BOX -->
<div class="bg-white rounded-xl shadow p-5 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div
                class="w-12 h-12 flex items-center justify-center rounded-xl
                    bg-[#A27B5C]/20 text-blue-600">
                <i class="fa-solid fa-toolbox text-lg"></i>
            </div>
            <div>
                <p class="text-sm text-stone-500">Total Rooms</p>
                <h2 class="text-2xl font-bold text-[#280905]">
                    {{ $rooms->total() }}
                </h2>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
            <!-- Button Tambah -->
            <a href="{{ route('admin.rooms.create') }}"
                class="flex items-center justify-center gap-2 bg-[#280905] hover:bg-[#A27B5C]
                text-white px-4 sm:px-5 py-2.5 rounded-xl shadow transition
                w-full sm:w-auto order-2 sm:order-2">
                <i class="fa-solid fa-plus"></i>
                <span class="text-sm sm:text-base">Tambah</span>
            </a>
        </div>
    </div>
</div>

<!-- SEARCH & FILTER -->
<div class="bg-white rounded-xl shadow p-4 mb-6">
    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
        <!-- SEARCH BOX -->
        <div class="w-full md:w-auto">
            <form id="searchForm" method="GET" action="{{ route('admin.rooms.index') }}"
                class="relative w-full md:w-72">
                <div class="relative">
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                        placeholder="Cari nama ruangan..."
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
                    <a href="{{ route('admin.rooms.index', array_merge(request()->except('page'), ['per_page' => $perPage])) }}"
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
                    <th class="px-6 py-4">Image</th>
                    <th class="px-6 py-4">Room Name</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4">Location</th>
                    <th class="px-6 py-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($rooms as $item)
                    <tr class="hover:bg-stone-50 transition" id="row-{{ $item->id }}">
                        <td class="px-6 py-4 font-medium">
                            {{ ($rooms->currentPage() - 1) * $rooms->perPage() + $loop->iteration }}
                        </td>

                        <td class="px-6 py-4">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" 
                                     alt="{{ $item->room_name }}" 
                                     class="w-12 h-12 rounded-lg object-cover border border-stone-200">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-stone-200 flex items-center justify-center">
                                    <i class="fa-solid fa-image text-stone-400 text-sm"></i>
                                </div>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div>
                                    <p class="font-semibold text-[#280905]">
                                        {{ $item->room_name }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            @if($item->category)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                    bg-[#A27B5C]/10 text-[#A27B5C]">
                                    {{ $item->category->category_name }}
                                </span>
                            @else
                                <span class="text-stone-400 text-sm">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 text-stone-600">
                                <i class="fa-solid fa-map-pin text-[#A27B5C] text-sm"></i>
                                <span class="text-sm">{{ $item->location ?? '-' }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                <!-- View Button -->
                                <a href="{{ route('admin.rooms.show', $item->id) }}"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg 
                                        bg-[#A27B5C]/10 text-[#A27B5C] hover:bg-[#A27B5C]/20 transition-all duration-200"
                                    title="Lihat Detail">
                                    <i class="fa fa-eye text-sm"></i>
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('admin.rooms.edit', $item->id) }}"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg 
                                        bg-[#A27B5C]/10 text-[#A27B5C] hover:bg-[#A27B5C]/20 transition-all duration-200"
                                    title="Edit">
                                    <i class="fa fa-edit text-sm"></i>
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.rooms.destroy', $item->id) }}" 
                                      method="POST" 
                                      class="delete-form inline-block"
                                      data-id="{{ $item->id }}"
                                      data-name="{{ $item->room_name }}">
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
                                <i class="fa-solid fa-box-open text-3xl mb-3 text-stone-300"></i>
                                <p class="text-stone-500">Tidak ada data ruangan</p>
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
    @if ($rooms->hasPages())
        <div class="px-6 py-4 border-t border-stone-100">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-sm text-stone-500">
                    Menampilkan
                    <span class="font-medium">{{ $rooms->firstItem() ?? 0 }}</span>
                    -
                    <span class="font-medium">{{ $rooms->lastItem() ?? 0 }}</span>
                    dari
                    <span class="font-medium">{{ $rooms->total() }}</span>
                    data
                </div>

                <div class="flex items-center gap-2">
                    <!-- Previous Button -->
                    @if ($rooms->onFirstPage())
                        <span class="px-3 py-1.5 rounded-lg bg-stone-100 text-stone-400 cursor-not-allowed">
                            <i class="fa-solid fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $rooms->previousPageUrl() . (request('search') ? '&search=' . request('search') : '') . (request('per_page') ? '&per_page=' . request('per_page') : '') }}"
                            class="px-3 py-1.5 rounded-lg bg-[#A27B5C]/10 text-[#A27B5C] hover:bg-[#A27B5C]/20 transition">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                    @endif

                    <!-- Page Numbers -->
                    @php
                        $current = $rooms->currentPage();
                        $last = $rooms->lastPage();
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
                        <a href="{{ $rooms->url($i) . (request('search') ? '&search=' . request('search') : '') . (request('per_page') ? '&per_page=' . request('per_page') : '') }}"
                            class="px-3 py-1.5 min-w-[40px] text-center rounded-lg transition 
                              {{ $i == $current ? 'bg-[#280905] text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    <!-- Next Button -->
                    @if ($rooms->hasMorePages())
                        <a href="{{ $rooms->nextPageUrl() . (request('search') ? '&search=' . request('search') : '') . (request('per_page') ? '&per_page=' . request('per_page') : '') }}"
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
        // Ambil semua tombol delete
        const deleteButtons = document.querySelectorAll('.delete-btn');
        
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Ambil form terdekat
                const form = this.closest('.delete-form');
                const roomName = form.getAttribute('data-name');
                const roomId = form.getAttribute('data-id');
                
                // Tampilkan SweetAlert sesuai permintaan
                Swal.fire({
                    title: "Are you sure?",
                    text: `You won't be able to revert this! Kategori "${roomName}" akan dihapus.`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form untuk menghapus data
                        form.submit();
                        
                        // Tampilkan notifikasi sukses
                        Swal.fire({
                            title: "Deleted!",
                            text: `Kategori "${roomName}" has been deleted.`,
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