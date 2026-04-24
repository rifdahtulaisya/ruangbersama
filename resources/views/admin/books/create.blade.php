@extends('layouts-admin.admin')

@section('title', 'BOOK')

@section('content')

    <div class="bg-white rounded-xl shadow p-5 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.books.index') }}"
                class="w-10 h-10 flex items-center justify-center rounded-lg
                  bg-sky-50 text-sky-600 hover:bg-sky-100 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-xl font-semibold text-slate-900">Tambah Buku</h1>
                <p class="text-sm text-slate-500">Tambahkan data buku baru</p>
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

    <div class="flex flex-col lg:flex-row gap-6">
        <div class="bg-white rounded-xl shadow p-6 flex-1">
            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-5">
                    <label for="category_id" class="block text-sm font-medium text-slate-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-4 py-2.5 border border-stone-300 rounded-lg
                               focus:ring-2 focus:ring-sky-300 focus:border-sky-400
                               bg-white">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-2">
                        Judul Buku <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-2.5 border border-stone-300 rounded-lg
                               focus:ring-2 focus:ring-sky-300 focus:border-sky-400
                               placeholder:text-stone-400"
                        placeholder="Masukkan judul buku">
                    @error('title')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="author" class="block text-sm font-medium text-slate-700 mb-2">
                        Penulis <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="author" id="author" value="{{ old('author') }}" required
                        class="w-full px-4 py-2.5 border border-stone-300 rounded-lg
                               focus:ring-2 focus:ring-sky-300 focus:border-sky-400
                               placeholder:text-stone-400"
                        placeholder="Masukkan nama penulis">
                    @error('author')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="stock" class="block text-sm font-medium text-slate-700 mb-2">
                        Stok Buku <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock') }}" required min="0"
                        class="w-full px-4 py-2.5 border border-stone-300 rounded-lg
                               focus:ring-2 focus:ring-sky-300 focus:border-sky-400
                               placeholder:text-stone-400"
                        placeholder="Masukkan jumlah stok">
                    @error('stock')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-slate-700 mb-2">
                        Gambar (Opsional)
                    </label>
                    <div class="flex items-center justify-center w-full">
                        <label for="image"
                            class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-stone-300 rounded-lg cursor-pointer
                                   bg-stone-50 hover:bg-stone-100 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl text-sky-600 mb-2"></i>
                                <p class="text-sm text-stone-600">
                                    <span class="font-semibold">Klik untuk upload</span> atau drag & drop
                                </p>
                                <p class="text-xs text-stone-500">PNG, JPG, GIF, SVG (Maksimal 2MB)</p>
                            </div>
                            <input type="file" name="image" id="image" class="hidden" accept="image/*">
                        </label>
                    </div>
                    <p id="image-name" class="text-sm text-stone-600 mt-2"></p>
                    @error('image')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t border-stone-100">
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-sky-600 hover:bg-sky-700 text-white
                           transition flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                    </button>
                </div>
            </form>
        </div>

        <div class="hidden lg:flex w-full lg:w-1/3 xl:w-1/4 flex-col items-center justify-center">
            <div class="bg-white rounded-xl shadow p-8 w-full h-full flex flex-col items-center justify-center">

                <div class="mb-6">
                    <div
                        class="w-40 h-40 mx-auto bg-gradient-to-br from-sky-100 to-sky-50 
                rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-book text-5xl text-sky-600"></i>
                    </div>
                </div>

                <div class="text-center">
                    <h3 class="text-lg font-semibold text-sky-700 mb-2">Tambah Buku</h3>

                    <p class="text-sm text-stone-500">
                        Isi data buku dengan lengkap agar mudah dikelola dan ditemukan.
                    </p>

                    <div class="mt-5 p-3 bg-[#A27B5C]/10 rounded-lg border border-[#A27B5C]/20">
                        <ul class="text-xs text-stone-600 space-y-1 text-left">
                            <li>• Pilih kategori yang sesuai</li>
                            <li>• Gunakan judul yang jelas</li>
                            <li>• Isi penulis dengan benar</li>
                            <li>• Tambahkan gambar (opsional)</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const imageInput = document.getElementById('image');
        const imageName = document.getElementById('image-name');

        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                imageName.textContent = '✓ ' + this.files[0].name;
            }
        });

        // Drag and drop functionality
        const dropZone = document.querySelector('label[for="image"]');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('bg-[#A27B5C]/10', 'border-[#A27B5C]');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('bg-[#A27B5C]/10', 'border-[#A27B5C]');
            }, false);
        });

        dropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            imageInput.files = files;

            if (files && files[0]) {
                imageName.textContent = '✓ ' + files[0].name;
            }
        }, false);
    </script>
@endpush
