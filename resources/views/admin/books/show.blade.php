@extends('layouts-admin.admin')

@section('title', 'BOOK')

@section('content')
    <div class="bg-white rounded-xl shadow p-5 mb-6">
        <div class="flex items-center gap-4">
            <!-- BACK BUTTON -->
            <a href="{{ route('admin.books.index') }}"
                class="w-10 h-10 flex items-center justify-center rounded-lg
                  bg-sky-50 text-sky-600 hover:bg-sky-100 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-xl font-semibold text-slate-900">Detail Buku</h1>
                <p class="text-sm text-stone-500">Informasi lengkap buku yang dipilih</p>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-check-circle text-green-500"></i>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.parentElement.remove()"
                    class="text-green-500 hover:text-green-700">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-hidden">
        @if ($book->image)
            <div class="relative h-64 bg-stone-100">
                <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <h2 class="text-2xl font-bold text-white mb-1">{{ $book->title }}</h2>
                    <p class="text-white/90 flex items-center gap-2">
                        <i class="fa-solid fa-user-pen"></i> {{ $book->author }}
                    </p>
                </div>
            </div>
        @else
            <div class="h-48 bg-sky-300 flex items-center justify-center">
                <div class="text-center">
                    <i class="fa-solid fa-book text-5xl text-white mb-2"></i>
                    <p class="text-white">Tidak ada gambar</p>
                </div>
            </div>
        @endif

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="border-b border-stone-100 pb-3">
                        <label class="block text-xs font-medium text-stone-500 uppercase mb-1">
                            <i class="fa-solid fa-tag mr-1"></i> Kategori
                        </label>
                        <p class="text-stone-800 font-medium">
                            {{ $book->category->category_name ?? 'Tidak ada kategori' }}
                        </p>
                    </div>

                    <div class="border-b border-stone-100 pb-3">
                        <label class="block text-xs font-medium text-stone-500 uppercase mb-1">
                            <i class="fa-solid fa-book mr-1"></i> Judul Buku
                        </label>
                        <p class="text-stone-800 font-medium">{{ $book->title }}</p>
                    </div>

                    <div class="border-b border-stone-100 pb-3">
                        <label class="block text-xs font-medium text-stone-500 uppercase mb-1">
                            <i class="fa-solid fa-user-pen mr-1"></i> Penulis
                        </label>
                        <p class="text-stone-800 font-medium">{{ $book->author }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="border-b border-stone-100 pb-3">
                        <label class="block text-xs font-medium text-stone-500 uppercase mb-1">
                            <i class="fa-solid fa-boxes-stacked mr-1"></i> Stok Buku
                        </label>
                        <p class="text-stone-800 font-medium">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium 
                                {{ $book->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $book->stock }}
                                {{ $book->stock > 0 ? ($book->stock > 1 ? 'buku tersedia' : 'buku tersedia') : 'buku habis' }}
                            </span>
                        </p>
                    </div>

                    <div class="border-b border-stone-100 pb-3">
                        <label class="block text-xs font-medium text-stone-500 uppercase mb-1">
                            <i class="fa-regular fa-calendar-plus mr-1"></i> Dibuat Pada
                        </label>
                        <p class="text-stone-800">
                            {{ $book->created_at ? $book->created_at->format('d F Y') : '-' }}
                        </p>
                    </div>

                    <div class="border-b border-stone-100 pb-3">
                        <label class="block text-xs font-medium text-stone-500 uppercase mb-1">
                            <i class="fa-regular fa-calendar-check mr-1"></i> Terakhir Diupdate
                        </label>
                        <p class="text-stone-800">
                            {{ $book->updated_at ? $book->updated_at->format('d F Y') : '-' }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        console.log('Book detail page loaded');
    </script>
@endpush
