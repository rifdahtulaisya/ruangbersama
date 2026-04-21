@extends('layouts-admin.admin')

@section('title', 'Admin | Detail Ruangan')

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
                <h1 class="text-xl font-semibold text-[#280905]">Detail Ruangan</h1>
                <p class="text-sm text-stone-500">Informasi lengkap ruangan yang dipilih</p>
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

    <!-- DETAIL CARD -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <!-- Header with Image -->
        @if($room->image)
        <div class="relative h-64 bg-stone-100">
            <img src="{{ asset('storage/' . $room->image) }}" 
                 alt="{{ $room->room_name }}" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6">
                <h2 class="text-2xl font-bold text-white mb-1">{{ $room->room_name }}</h2>
                <p class="text-white/90 flex items-center gap-2">
                    <i class="fa-solid fa-location-dot"></i> {{ $room->location }}
                </p>
            </div>
        </div>
        @else
        <div class="h-48 bg-gradient-to-r from-[#A27B5C]/20 to-[#280905]/10 flex items-center justify-center">
            <div class="text-center">
                <i class="fa-solid fa-door-open text-5xl text-[#A27B5C] mb-2"></i>
                <p class="text-stone-500">Tidak ada gambar</p>
            </div>
        </div>
        @endif

        <!-- Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <!-- Category -->
                    <div class="border-b border-stone-100 pb-3">
                        <label class="block text-xs font-medium text-stone-500 uppercase mb-1">
                            <i class="fa-solid fa-tag mr-1"></i> Kategori
                        </label>
                        <p class="text-stone-800 font-medium">
                            {{ $room->category->category_name ?? 'Tidak ada kategori' }}
                        </p>
                    </div>

                    <!-- Room Name -->
                    <div class="border-b border-stone-100 pb-3">
                        <label class="block text-xs font-medium text-stone-500 uppercase mb-1">
                            <i class="fa-solid fa-building mr-1"></i> Nama Ruangan
                        </label>
                        <p class="text-stone-800 font-medium">{{ $room->room_name }}</p>
                    </div>

                    <!-- Location -->
                    <div class="border-b border-stone-100 pb-3">
                        <label class="block text-xs font-medium text-stone-500 uppercase mb-1">
                            <i class="fa-solid fa-location-dot mr-1"></i> Lokasi
                        </label>
                        <p class="text-stone-800 font-medium">{{ $room->location }}</p>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4">
                    <!-- Created At -->
                    <div class="border-b border-stone-100 pb-3">
                        <label class="block text-xs font-medium text-stone-500 uppercase mb-1">
                            <i class="fa-regular fa-calendar-plus mr-1"></i> Dibuat Pada
                        </label>
                        <p class="text-stone-800">
                            {{ $room->created_at ? $room->created_at->format('d F Y, H:i') : '-' }}
                        </p>
                    </div>

                    <!-- Last Updated -->
                    <div class="border-b border-stone-100 pb-3">
                        <label class="block text-xs font-medium text-stone-500 uppercase mb-1">
                            <i class="fa-regular fa-calendar-check mr-1"></i> Terakhir Diupdate
                        </label>
                        <p class="text-stone-800">
                            {{ $room->updated_at ? $room->updated_at->format('d F Y, H:i') : '-' }}
                        </p>
                    </div>

                    <!-- Status -->
                    <div class="border-b border-stone-100 pb-3">
                        <label class="block text-xs font-medium text-stone-500 uppercase mb-1">
                            <i class="fa-solid fa-circle-info mr-1"></i> Status
                        </label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fa-solid fa-check-circle mr-1 text-xs"></i> Aktif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-stone-100">
                <a href="{{ route('admin.rooms.index') }}"
                    class="px-5 py-2.5 rounded-lg bg-stone-200 text-stone-700 hover:bg-stone-300
                      transition flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('admin.rooms.edit', $room->id) }}"
                    class="px-5 py-2.5 rounded-lg bg-[#280905] text-white hover:bg-[#A27B5C]
                       transition flex items-center gap-2">
                    <i class="fa-solid fa-pen"></i> Edit Ruangan
                </a>
            </div>
        </div>
    </div>

    <!-- Riwayat Peminjaman (Optional) -->
    <div class="mt-6 bg-white rounded-xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-stone-100">
            <h3 class="text-lg font-semibold text-[#280905] flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left"></i>
                Riwayat Peminjaman
            </h3>
            <p class="text-sm text-stone-500 mt-1">Belum ada data peminjaman untuk ruangan ini</p>
        </div>
        <div class="p-6 text-center text-stone-500">
            <i class="fa-solid fa-inbox text-4xl mb-2 opacity-50"></i>
            <p>Belum ada riwayat peminjaman</p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Optional: Tambahkan script jika diperlukan
        console.log('Room detail page loaded');
    </script>
@endpush