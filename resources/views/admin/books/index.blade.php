@extends('layouts-admin.admin')

@section('title', 'BUKU')

@section('content')

    <div class="bg-white rounded-xl shadow p-5 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-sky-100 text-sky-600">
                    <i class="fa-solid fa-book text-lg"></i>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Total Books</p>
                    <h2 class="text-2xl font-bold text-slate-900">
                        {{ $books->total() }}
                    </h2>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                <a href="{{ route('admin.books.create') }}"
                    class="flex items-center justify-center gap-2 bg-sky-600 hover:bg-sky-700
                text-white px-4 sm:px-5 py-2.5 rounded-xl shadow-sm transition
                w-full sm:w-auto order-2 sm:order-2">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span class="text-sm sm:text-base font-semibold">Tambah</span>
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="w-full md:w-auto">
                <form id="searchForm" method="GET" action="{{ route('admin.books.index') }}"
                    class="relative w-full md:w-80">
                    <div class="relative">
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                            placeholder="Cari judul atau penulis..."
                            class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-lg 
                              focus:outline-none focus:ring-2 focus:ring-sky-100 focus:border-sky-500 transition-all">
                        <i class="fa-solid fa-search absolute left-3 top-3.5 text-slate-400"></i>
                    </div>

                    @if (request('per_page'))
                        <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                    @endif
                </form>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-sm text-slate-600 font-medium">Tampilkan:</span>
                <div class="flex bg-slate-100 rounded-lg p-1">
                    @foreach ([5, 10, 15, 20] as $perPage)
                        <a href="{{ route('admin.books.index', array_merge(request()->except('page'), ['per_page' => $perPage])) }}"
                            class="px-3 py-1 rounded-md text-sm font-semibold transition
                      {{ request('per_page', 5) == $perPage ? 'bg-sky-600 text-white shadow' : 'text-slate-600 hover:text-sky-600' }}">
                            {{ $perPage }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow hover:shadow-md transition overflow-hidden border border-slate-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="bg-slate-50 text-xs uppercase text-slate-500 font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Cover</th>
                        <th class="px-6 py-4">Informasi Buku</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4 text-center">Stok</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($books as $item)
                        <tr class="hover:bg-sky-50/50 transition" id="row-{{ $item->id }}">
                            <td class="px-6 py-4 font-medium text-slate-400">
                                {{ ($books->currentPage() - 1) * $books->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                                        class="w-12 h-16 rounded-md object-cover border border-slate-200 shadow-sm">
                                @else
                                    <div
                                        class="w-12 h-16 rounded-md bg-slate-100 flex items-center justify-center border border-dashed border-slate-300">
                                        <i class="fa-solid fa-book-open text-slate-300 text-xs"></i>
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-bold text-slate-900 mb-0.5">{{ $item->title }}</p>
                                    <p class="text-xs text-sky-600 font-medium">
                                        <i class="fa-solid fa-user-pen mr-1"></i>{{ $item->author }}
                                    </p>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                @if ($item->category)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-sky-100 text-sky-700">
                                        {{ $item->category->category_name }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-xs">Tanpa Kategori</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-bold {{ $item->stock > 0 ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }}">
                                    {{ $item->stock }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.books.show', $item->id) }}"
                                        class="w-9 h-9 flex items-center justify-center rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-600 hover:text-white transition-all duration-200 shadow-sm"
                                        title="Lihat Detail">
                                        <i class="fa fa-eye text-sm"></i>
                                    </a>

                                    <a href="{{ route('admin.books.edit', $item->id) }}"
                                        class="w-9 h-9 flex items-center justify-center rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition-all duration-200 shadow-sm"
                                        title="Edit">
                                        <i class="fa fa-edit text-sm"></i>
                                    </a>

                                    <form action="{{ route('admin.books.destroy', $item->id) }}" method="POST"
                                        class="delete-form inline-block" data-id="{{ $item->id }}"
                                        data-name="{{ $item->title }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="delete-btn w-9 h-9 flex items-center justify-center rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all duration-200 shadow-sm"
                                            title="Hapus">
                                            <i class="fa fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12">
                                <div class="flex flex-col items-center justify-center text-center text-slate-500">
                                    <i class="fa-solid fa-box-open text-3xl mb-3 text-slate-200"></i>
                                    <p>Tidak ada data kategori</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($books->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-slate-500">
                        Menadfsdf <span class="font-bold text-slate-700">{{ $books->firstItem() }}</span> - <span
                            class="font-bold text-slate-700">{{ $books->lastItem() }}</span> dari <span
                            class="font-bold text-slate-700">{{ $books->total() }}</span> data
                    </div>

                    <div class="flex items-center gap-2">
                        @if ($books->onFirstPage())
                            <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed"><i
                                    class="fa-solid fa-chevron-left"></i></span>
                        @else
                            <a href="{{ $books->previousPageUrl() }}"
                                class="px-3 py-1.5 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-100 transition"><i
                                    class="fa-solid fa-chevron-left"></i></a>
                        @endif

                        @for ($i = 1; $i <= $books->lastPage(); $i++)
                            @if ($i >= $books->currentPage() - 1 && $i <= $books->currentPage() + 1)
                                <a href="{{ $books->url($i) }}"
                                    class="px-3 py-1.5 min-w-[40px] text-center rounded-lg transition 
                                  {{ $i == $books->currentPage() ? 'bg-sky-500 text-white shadow-md shadow-sky-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                    {{ $i }}
                                </a>
                            @endif
                        @endfor

                        @if ($books->hasMorePages())
                            <a href="{{ $books->nextPageUrl() }}"
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // SweetAlert untuk session success
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
        document.addEventListener('DOMContentLoaded', function() {
            // Fix Delete Button logic
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('.delete-form');
                    const bookName = form.getAttribute('data-name');

                    Swal.fire({
                        title: "Hapus Buku?",
                        text: `Buku "${bookName}" akan dihapus secara permanen!`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#dc2626",
                        cancelButtonColor: "#6b7280",
                        confirmButtonText: "Ya, Hapus!",
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
@endsection