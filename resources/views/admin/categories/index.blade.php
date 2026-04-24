@extends('layouts-admin.admin')

@section('title', 'KATEGORI')

@section('content')

    <div class="bg-white rounded-xl shadow p-5 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-sky-100 text-sky-600">
                    <i class="fa-solid fa-toolbox text-lg"></i>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Total Categories</p>
                    <h2 class="text-2xl font-bold text-slate-900">
                        {{ $categories->total() }}
                    </h2>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                <a href="{{ route('admin.categories.create') }}"
                    class="flex items-center justify-center gap-2 bg-sky-600 hover:bg-sky-700
                text-white px-4 sm:px-5 py-2.5 rounded-xl shadow transition w-full sm:w-auto order-2 sm:order-2">
                    <i class="fa-solid fa-plus"></i>
                    <span class="text-sm sm:text-base">Tambah</span>
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="w-full md:w-auto">
                <form id="searchForm" method="GET" action="{{ route('admin.categories.index') }}"
                    class="relative w-full md:w-72">
                    <div class="relative">
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                            placeholder="Cari nama kategori..."
                            class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-lg 
                               focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400">
                        <i class="fa-solid fa-search absolute left-3 top-3.5 text-slate-400"></i>
                    </div>

                    @if (request('per_page'))
                        <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                    @endif
                </form>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-sm text-slate-600">Tampilkan:</span>
                <div class="flex bg-slate-100 rounded-lg p-1">
                    @foreach ([5, 10, 15, 20] as $perPage)
                        <a href="{{ route('admin.categories.index', array_merge(request()->except('page'), ['per_page' => $perPage])) }}"
                            class="px-3 py-1 rounded-md text-sm font-medium transition
                      {{ request('per_page', 5) == $perPage ? 'bg-sky-600 text-white shadow' : 'text-slate-600 hover:text-sky-600' }}">
                            {{ $perPage }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden border-slate-700/50">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Category Name</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($categories as $item)
                        <tr class="hover:bg-sky-50/50 transition" id="row-{{ $item->id }}">
                            <td class="px-6 py-4 font-medium">
                                {{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <p class="font-semibold text-slate-900">
                                            {{ $item->category_name }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.categories.show', $item->id) }}"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg 
                                        bg-sky-100 text-sky-600  hover:bg-sky-600 hover:text-white transition-all duration-200"
                                        title="Lihat Detail">
                                        <i class="fa fa-eye text-sm"></i>
                                    </a>

                                    <a href="{{ route('admin.categories.edit', $item->id) }}"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg 
                                        bg-yellow-100 text-yellow-600 hover:bg-amber-500 hover:text-white transition-all duration-200"
                                        title="Edit">
                                        <i class="fa fa-edit text-sm"></i>
                                    </a>

                                    <form action="{{ route('admin.categories.destroy', $item->id) }}" method="POST"
                                        class="delete-form inline-block" data-id="{{ $item->id }}"
                                        data-name="{{ $item->category_name }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 text-red-600 hover:bg-rose-600 hover:text-white transition-all duration-200"
                                            title="Hapus">
                                            <i class="fa fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <i class="fa-solid fa-box-open text-3xl mb-3 text-slate-200"></i>
                                    <p>Tidak ada data kategori</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($categories->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-slate-500">
                        Menampilkan <span class="font-medium text-slate-900">{{ $categories->firstItem() }}</span> - <span
                            class="font-medium text-slate-900">{{ $categories->lastItem() }}</span> dari <span
                            class="font-medium text-slate-900">{{ $categories->total() }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        @if ($categories->onFirstPage())
                            <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed"><i
                                    class="fa-solid fa-chevron-left"></i></span>
                        @else
                            <a href="{{ $categories->previousPageUrl() }}"
                                class="px-3 py-1.5 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-100 transition"><i
                                    class="fa-solid fa-chevron-left"></i></a>
                        @endif

                        @for ($i = 1; $i <= $categories->lastPage(); $i++)
                            @if ($i >= $categories->currentPage() - 1 && $i <= $categories->currentPage() + 1)
                                <a href="{{ $categories->url($i) }}"
                                    class="px-3 py-1.5 min-w-[40px] text-center rounded-lg transition 
                                  {{ $i == $categories->currentPage() ? 'bg-sky-500 text-white shadow-md shadow-sky-200' : 'bg-sky-100 text-stone-600 hover:bg-sky-200' }}">
                                    {{ $i }}
                                </a>
                            @endif
                        @endfor

                        @if ($categories->hasMorePages())
                            <a href="{{ $categories->nextPageUrl() }}"
                                class="px-3 py-1.5 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-100 transition"><i
                                    class="fa-solid fa-chevron-right"></i></a>
                        @else
                            <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed"><i
                                    class="fa-solid fa-chevron-right"></i></span>
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
        // Auto submit search form on typing
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

                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        clearTimeout(searchTimeout);
                        searchForm.submit();
                    }
                });
            }

            // Delete confirmation with SweetAlert
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const categoryName = this.dataset.name || 'kategori ini';

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Data kategori <strong>${categoryName}</strong> akan dihapus permanen!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Tampilkan loading
                            Swal.fire({
                                title: 'Menghapus...',
                                text: 'Mohon tunggu sebentar',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // Submit form
                            this.submit();
                        }
                    });
                });
            });
        });

        // Tampilkan SweetAlert sukses jika ada session success dari delete
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true
            });
        @endif

        // Tampilkan SweetAlert error jika ada session error
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'OK'
            });
        @endif
    </script>

    <script>
        // Auto submit search form on typing
        document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            let searchTimeout;

            if (searchInput) {
                // Auto submit after typing stops
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);

                    // Show loading indicator (optional)
                    const searchIcon = this.parentElement.querySelector('.fa-search');
                    if (searchIcon) {
                        searchIcon.classList.remove('fa-search');
                        searchIcon.classList.add('fa-spinner', 'fa-spin');
                    }

                    searchTimeout = setTimeout(() => {
                        // Submit the form
                        searchForm.submit();
                    }, 800); // 800ms delay
                });

                // Clear search button
                const clearBtn = document.getElementById('clearSearch');
                if (clearBtn) {
                    clearBtn.addEventListener('click', function() {
                        searchInput.value = '';
                        searchForm.submit();
                    });
                }

                // Allow Enter key to submit immediately
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        clearTimeout(searchTimeout);
                        searchForm.submit();
                    }
                });
            }

            // Delete confirmation
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data kategori akan dihapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
        });
    </script>



    <style>
        /* Optional: Style for loading spinner */
        .fa-spinner {
            color: #4f46e5 !important;
        }
    </style>

@endsection
