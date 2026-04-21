@extends('layouts-admin.admin')

@section('title', 'Admin | Tambah Ruangan')

@section('content')
    <!-- HEADER BOX -->
    <div class="bg-white rounded-xl shadow p-5 mb-6">
        <div class="flex items-center gap-4">
            <!-- BACK BUTTON -->
            <a href="{{ route('admin.rooms.index') }}"
                class="w-10 h-10 flex items-center justify-center rounded-lg
                  bg-stone-100 text-stone-600 hover:bg-stone-200 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-xl font-semibold text-[#280905]">Tambah Ruangan</h1>
                <p class="text-sm text-stone-500">Buat ruangan baru untuk kategori Anda</p>
            </div>
        </div>
    </div>

    <!-- ALERT MESSAGE -->
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

    <!-- FORM CARD -->
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- FORM SECTION -->
        <div class="bg-white rounded-xl shadow p-6 flex-1">
            <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Error global --}}
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- CATEGORY FIELD -->
                <div class="mb-5">
                    <label for="category_id" class="block text-sm font-medium text-[#280905] mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-4 py-2.5 border border-stone-300 rounded-lg
                               focus:ring-2 focus:ring-[#A27B5C] focus:border-[#A27B5C]
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

                <!-- ROOM NAME FIELD -->
                <div class="mb-5">
                    <label for="room_name" class="block text-sm font-medium text-[#280905] mb-2">
                        Nama Ruangan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="room_name" id="room_name" value="{{ old('room_name') }}" required
                        class="w-full px-4 py-2.5 border border-stone-300 rounded-lg
                               focus:ring-2 focus:ring-[#A27B5C] focus:border-[#A27B5C]
                               placeholder:text-stone-400"
                        placeholder="Masukkan nama ruangan">
                    @error('room_name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- LOCATION FIELD -->
                <div class="mb-5">
                    <label for="location" class="block text-sm font-medium text-[#280905] mb-2">
                        Lokasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" required
                        class="w-full px-4 py-2.5 border border-stone-300 rounded-lg
                               focus:ring-2 focus:ring-[#A27B5C] focus:border-[#A27B5C]
                               placeholder:text-stone-400"
                        placeholder="Masukkan lokasi ruangan">
                    @error('location')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- IMAGE FIELD -->
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-[#280905] mb-2">
                        Gambar (Opsional)
                    </label>
                    <div class="flex items-center justify-center w-full">
                        <label for="image"
                            class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-stone-300 rounded-lg cursor-pointer
                                   bg-stone-50 hover:bg-stone-100 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl text-[#A27B5C] mb-2"></i>
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

                <!-- BUTTON SUBMIT -->
                <div class="flex justify-end gap-3 pt-6 border-t border-stone-100">
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-[#280905] text-white hover:bg-[#A27B5C]
                           transition flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                    </button>
                </div>
            </form>
        </div>

        <!-- INFO SECTION -->
        <div class="hidden lg:flex w-full lg:w-1/3 xl:w-1/4 flex-col items-center justify-center">
            <div class="bg-white rounded-xl shadow p-8 w-full h-full flex flex-col items-center justify-center">
                <!-- Illustration -->
                <div class="mb-6">
                    <div
                        class="w-48 h-48 mx-auto bg-gradient-to-br from-[#A27B5C]/20 to-[#280905]/10 
                        rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-door-open text-6xl text-[#A27B5C]"></i>
                    </div>
                </div>

                <!-- Informasi -->
                <div class="text-center">
                    <h3 class="text-lg font-semibold text-[#280905] mb-2">Buat Ruangan Baru</h3>

                    <!-- Tips Box -->
                    <div class="mt-6 p-4 bg-[#A27B5C]/10 rounded-lg border border-[#A27B5C]/20">
                        <h4 class="text-sm font-medium text-[#280905] mb-2 flex items-center gap-2">
                            <i class="fa-solid fa-lightbulb"></i> Tips Ruangan
                        </h4>
                        <ul class="text-xs text-stone-600 space-y-1 text-left">
                            <li>• Pilih kategori yang sesuai dengan jenis ruangan</li>
                            <li>• Gunakan nama ruangan yang deskriptif</li>
                            <li>• Cantumkan lokasi yang jelas dan mudah ditemukan</li>
                            <li>• Tambahkan gambar untuk visual yang lebih baik</li>
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