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
                <h1 class="text-xl font-semibold text-slate-900">Edit Buku</h1>
                <p class="text-sm text-slate-500">Perbarui informasi buku yang sudah ada</p>
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

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
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
                <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required
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
                <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}" required
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
                <input type="number" name="stock" id="stock" value="{{ old('stock', $book->stock) }}" required
                    min="0"
                    class="w-full px-4 py-2.5 border border-stone-300 rounded-lg
                           focus:ring-2 focus:ring-sky-300 focus:border-sky-400
                           placeholder:text-stone-400"
                    placeholder="Masukkan jumlah stok buku">
                @error('stock')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Gambar Buku
                </label>

                <div id="imagePreviewContainer" class="mb-4">
                    @if ($book->image)
                        <div id="currentImageWrapper">
                            <div class="flex items-start gap-4 p-3 bg-stone-50 rounded-lg border border-stone-200">
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                        id="currentImage" class="w-32 h-32 object-cover rounded-lg border border-stone-200">
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-stone-600">Gambar saat ini</p>
                                    <button type="button" id="removeCurrentImageBtn"
                                        class="mt-2 text-xs text-red-600 hover:text-red-700 flex items-center gap-1">
                                        <i class="fa-solid fa-trash"></i> Hapus gambar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div id="newImagePreview" style="display: none;">
                        <div class="flex items-start gap-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="relative">
                                <img src="" alt="Preview" id="previewImage"
                                    class="w-32 h-32 object-cover rounded-lg border border-blue-200">
                                <button type="button" id="cancelNewImageBtn"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-blue-600">Gambar baru akan menggantikan gambar lama</p>
                                <p id="newImageName" class="text-xs text-stone-500 mt-1"></p>
                            </div>
                        </div>
                    </div>
                </div>

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
                <input type="hidden" name="remove_image" id="remove_image" value="0">
                @error('image')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-stone-100">
                <button type="submit"
                    class="px-5 py-2.5 rounded-lg bg-sky-600 hover:bg-sky-700 text-white
                       transition flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Update
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        const imageInput = document.getElementById('image');
        const newImagePreview = document.getElementById('newImagePreview');
        const previewImage = document.getElementById('previewImage');
        const newImageName = document.getElementById('newImageName');
        const currentImageWrapper = document.getElementById('currentImageWrapper');
        const removeImageInput = document.getElementById('remove_image');
        const removeCurrentImageBtn = document.getElementById('removeCurrentImageBtn');
        const cancelNewImageBtn = document.getElementById('cancelNewImageBtn');

        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];

                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar! Maksimal 2MB.');
                    this.value = '';
                    return;
                }

                const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/svg+xml'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format file tidak didukung! Gunakan PNG, JPG, GIF, atau SVG.');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    newImageName.textContent = 'File: ' + file.name;
                    newImagePreview.style.display = 'block';

                    if (currentImageWrapper) {
                        currentImageWrapper.style.display = 'none';
                    }

                    removeImageInput.value = '0';
                };
                reader.readAsDataURL(file);
            }
        });

        if (removeCurrentImageBtn) {
            removeCurrentImageBtn.addEventListener('click', function() {
                if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                    removeImageInput.value = '1';
                    currentImageWrapper.style.display = 'none';

                    imageInput.value = '';
                    newImagePreview.style.display = 'none';
                }
            });
        }

        if (cancelNewImageBtn) {
            cancelNewImageBtn.addEventListener('click', function() {

                imageInput.value = '';

                newImagePreview.style.display = 'none';

                if (currentImageWrapper && removeImageInput.value !== '1') {
                    currentImageWrapper.style.display = 'block';
                }

                previewImage.src = '';
                newImageName.textContent = '';
            });
        }

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
                dropZone.classList.add('bg-stone-100', 'border-stone-400');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('bg-stone-100', 'border-stone-400');
            }, false);
        });

        dropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            imageInput.files = files;

            const changeEvent = new Event('change');
            imageInput.dispatchEvent(changeEvent);
        }, false);
    </script>
@endpush
