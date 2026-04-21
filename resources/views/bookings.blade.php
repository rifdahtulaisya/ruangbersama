{{-- bookings.blade.php --}}
@extends('layouts-user.user')

@section('title', 'DAFTAR RUANGAN')

@section('content')
    <div class="space-y-8 animate-slide-in">

        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Cari Ruangan</label>
                    <div class="relative">
                        <input type="text" id="searchInput" value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-600 focus:border-amber-600 transition"
                            placeholder="Nama ruangan, lokasi...">
                        <i class="fas fa-search absolute left-3 top-3 text-slate-400"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
                    <select id="kategoriFilter"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-600 focus:border-amber-600 transition">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $kat)
                            <option value="{{ $kat->id }}" {{ request('category_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button onclick="resetFilters()"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl hover:bg-slate-50 transition flex items-center justify-center gap-2 text-amber-800">
                        <i class="fas fa-redo"></i> Reset Filter
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
            @forelse($rooms as $room)
                <div onclick="openBooking('{{ $room->id }}', '{{ $room->room_name }}', '{{ $room->location }}', '{{ $room->category->category_name ?? 'Tanpa Kategori' }}')"
                    class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border border-slate-200 relative group cursor-pointer hover:border-amber-500">

                    <div class="h-40 md:h-48 overflow-hidden bg-slate-100">
                        @if ($room->image)
                            <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->room_name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div
                                class="w-full h-full flex items-center justify-center bg-gradient-to-br from-amber-50 to-orange-50">
                                <i class="fas fa-door-open text-3xl md:text-4xl text-amber-300"></i>
                            </div>
                        @endif
                    </div>

                    <div class="p-4 md:p-6">
                        <div class="mb-2 md:mb-3">
                            <span
                                class="px-2 py-1 md:px-3 md:py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-medium">
                                {{ $room->category->category_name ?? 'Tanpa Kategori' }}
                            </span>
                        </div>

                        <h3
                            class="text-base md:text-lg font-bold text-slate-800 mb-2 line-clamp-1 group-hover:text-amber-700 transition">
                            {{ $room->room_name }}</h3>

                        <div class="flex items-center gap-1 md:gap-2 text-slate-600">
                            <i class="fas fa-map-marker-alt text-amber-600 text-sm md:text-base"></i>
                            <span
                                class="text-xs md:text-sm truncate">{{ $room->location ?? 'Lokasi tidak tersedia' }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-2 md:col-span-full bg-white rounded-2xl shadow-lg p-8 md:p-12 text-center">
                    <div class="text-slate-400 mb-4">
                        <i class="fas fa-search text-4xl md:text-6xl"></i>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-slate-700 mb-2">Ruangan Tidak Ditemukan</h3>
                    <button onclick="resetFilters()"
                        class="inline-flex items-center gap-2 bg-amber-700 hover:bg-amber-800 text-white px-4 py-2 md:px-6 md:py-3 rounded-lg font-medium transition text-sm md:text-base">
                        <i class="fas fa-redo"></i> Reset Pencarian
                    </button>
                </div>
            @endforelse
        </div>

        @if ($rooms->hasPages())
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="text-slate-600">
                        Menampilkan {{ $rooms->firstItem() }} - {{ $rooms->lastItem() }} dari {{ $rooms->total() }}
                        ruangan
                    </div>
                    <div>
                        {{ $rooms->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div id="pinjamModal" class="fixed inset-0 bg-black/50 z-[60] hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl animate-slide-up">
            <div class="p-6 border-b border-slate-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-slate-800">Formulir Peminjaman Ruangan</h3>
                    <button onclick="closePinjamModal()" class="text-slate-400 hover:text-slate-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <form id="pinjamForm" action="{{ route('bookings.store') }}" method="POST">
                @csrf
                <div class="p-6">
                    <input type="hidden" name="id_rooms" id="selectedRoomId" value="">

                    <div class="mb-6">
                        <h4 class="font-medium text-slate-700 mb-3 text-amber-800">Ruangan yang dipilih:</h4>
                        <div id="modalRoomDetail" class="bg-amber-50 p-4 rounded-xl border border-amber-100">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                <i class="fas fa-calendar-alt mr-2 text-amber-600"></i>Tanggal Peminjaman
                            </label>
                            <input type="date" name="tgl_pinjam" required min="{{ date('Y-m-d') }}"
                                value="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-600 focus:border-amber-600 outline-none bg-slate-50">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                <i class="fas fa-calendar-check mr-2 text-amber-600"></i>Tanggal Pengembalian
                            </label>
                            <input type="date" name="tgl_kembali_rencana" required
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="" {{-- Dibuat kosong --}}
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-600 focus:border-amber-600 outline-none">
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-slate-200 flex gap-3">
                    <button type="button" onclick="closePinjamModal()"
                        class="flex-1 px-4 py-3 border border-slate-300 rounded-xl hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-3 bg-amber-700 text-white rounded-xl hover:bg-amber-800 transition flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Ajukan Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openBooking(id, nama, lokasi, kategori) {
            const modal = document.getElementById('pinjamModal');
            const modalRoomDetail = document.getElementById('modalRoomDetail');
            const selectedRoomId = document.getElementById('selectedRoomId');

            // Set Detail Ruangan
            modalRoomDetail.innerHTML = `
                <div class="space-y-1.5 p-1">
                    <div class="grid grid-cols-[80px_1fr] items-baseline">
                        <span class="text-slate-500 text-sm">Nama:</span>
                        <span class="font-bold text-amber-900 text-lg">${nama}</span>
                    </div>
                    <div class="grid grid-cols-[80px_1fr] items-baseline">
                        <span class="text-slate-500 text-sm">Lokasi:</span>
                        <span class="text-slate-700 text-sm font-medium">${lokasi}</span>
                    </div>
                    <div class="grid grid-cols-[80px_1fr] items-baseline">
                        <span class="text-slate-500 text-sm">Kategori:</span>
                        <span class="text-slate-700 text-sm font-medium">${kategori}</span>
                    </div>
                </div>
            `;

            selectedRoomId.value = id;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closePinjamModal() {
            document.getElementById('pinjamModal').classList.add('hidden');
            document.getElementById('pinjamModal').classList.remove('flex');
        }

        function applyFilters() {
            const search = document.getElementById('searchInput').value;
            const kategori = document.getElementById('kategoriFilter').value;
            let url = new URL(window.location.href);
            let params = new URLSearchParams(url.search);

            if (search) params.set('search', search);
            else params.delete('search');
            if (kategori) params.set('category_id', kategori);
            else params.delete('category_id');
            params.delete('page');
            window.location.href = `${url.pathname}?${params.toString()}`;
        }

        function resetFilters() {
            window.location.href = "{{ route('bookings') }}";
        }

        document.getElementById('kategoriFilter').addEventListener('change', applyFilters);
        document.getElementById('searchInput').addEventListener('keypress', e => {
            if (e.key === 'Enter') applyFilters();
        });

        // ESC to close
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closePinjamModal();
        });
    </script>

    <style>
        .animate-slide-up {
            animation: slideUp 0.3s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
