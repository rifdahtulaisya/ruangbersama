@extends('layouts-user.user')

@section('title', 'PEMINJAMAN BUKU')

@section('content')
{{-- Cek jika user diblokir, redirect ke halaman block --}}
    @php
        use Carbon\Carbon;
        $now = Carbon::now('Asia/Jakarta')->toDateString();
        $hasLateReturn = App\Models\Loan::where('id_users', Auth::id())
            ->where('status', 'borrowed')
            ->where('tgl_kembali_rencana', '<', $now)
            ->exists();
    @endphp

    @if($hasLateReturn)
        <div class="bg-red-50 border-l-4 border-red-500 rounded-xl p-4 mb-6">
            <div class="flex items-center gap-3">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                <div>
                    <p class="text-red-700 font-medium">Anda tidak bisa melakukan peminjaman!</p>
                    <p class="text-red-600 text-sm">Ada buku yang belum dikembalikan dan melewati batas waktu. Silakan kembalikan buku terlebih dahulu.</p>
                </div>
            </div>
        </div>
    @endif
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

        {{-- Card --}}
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
            @forelse($books as $book)
                <div onclick="openLoan('{{ $book->id }}', '{{ $book->title }}', '{{ $book->author }}', '{{ $book->category->category_name ?? 'Tanpa Kategori' }}')"
                    class="group bg-white rounded-xl shadow-md hover:shadow-xl overflow-hidden transition-all duration-300 cursor-pointer flex flex-col h-full border border-slate-100 hover:border-amber-200">

                    {{-- Book Cover Container with realistic shadow and spine effect --}}
                    <div class="relative mx-4 mt-4 mb-2">
                        {{-- Shadow under book --}}
                        <div
                            class="absolute -bottom-2 left-2 right-2 h-4 bg-black/20 blur-md rounded-full opacity-60 group-hover:opacity-100 transition">
                        </div>

                        {{-- Book Cover with 3D effect --}}
                        <div class="relative transform group-hover:-translate-y-1 transition duration-300">
                            {{-- Spine shadow effect on left side --}}
                            <div
                                class="absolute left-0 top-0 bottom-0 w-3 bg-gradient-to-r from-black/30 to-transparent rounded-l-md z-10">
                            </div>

                            {{-- Cover image --}}
                            <div class="aspect-[3/4] rounded-lg overflow-hidden shadow-lg">
                                @if ($book->image)
                                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500 ease-out">
                                @else
                                    <div
                                        class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-amber-100 to-orange-100">
                                        <i class="fas fa-book text-5xl md:text-6xl text-amber-300 mb-2"></i>
                                        <span class="text-xs text-amber-500 font-medium">No Cover</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Page edge effect on right side --}}
                            <div
                                class="absolute right-0 top-1 bottom-1 w-1.5 bg-gradient-to-l from-slate-200 to-transparent rounded-r">
                            </div>
                        </div>
                    </div>

                    {{-- Content Container --}}
                    <div class="p-4 md:p-5 flex flex-col flex-grow">
                        {{-- Title --}}
                        <h3
                            class="text-base md:text-lg font-bold text-slate-800 line-clamp-2 group-hover:text-amber-700 transition mb-1.5">
                            {{ $book->title }}
                        </h3>

                        {{-- Author --}}
                        <div class="flex items-center gap-1.5 text-slate-500 mb-3">
                            <i class="fas fa-user-edit text-amber-500 text-xs"></i>
                            <span
                                class="text-xs md:text-sm truncate">{{ $book->author ?? 'Penulis tidak tersedia' }}</span>
                        </div>

                        {{-- Spacer to push category to bottom --}}
                        <div class="flex-grow"></div>

                        {{-- Category at the bottom --}}
                        <div class="mt-3 pt-2 border-t border-slate-100">
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 rounded-full text-xs font-medium">
                                <i class="fas fa-tag text-[10px]"></i>
                                {{ $book->category->category_name ?? 'Tanpa Kategori' }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-xl shadow-md p-8 md:p-12 text-center border border-slate-100">
                        <div class="text-slate-400 mb-4">
                            <i class="fas fa-search text-5xl md:text-6xl"></i>
                        </div>
                        <h3 class="text-xl md:text-2xl font-bold text-slate-700 mb-2">Buku Tidak Ditemukan</h3>
                        <p class="text-slate-500 mb-6">Coba gunakan kata kunci lain atau reset filter pencarian</p>
                        <button onclick="resetFilters()"
                            class="inline-flex items-center gap-2 bg-amber-600 hover:bg-amber-700 text-white px-5 py-2.5 rounded-lg font-medium transition shadow-md hover:shadow-lg">
                            <i class="fas fa-redo-alt"></i> Reset Pencarian
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($books->hasPages())
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="text-slate-600">
                        Menampilkan {{ $books->firstItem() }} - {{ $books->lastItem() }} dari {{ $books->total() }}
                        buku
                    </div>
                    <div>
                        {{ $books->links('vendor.pagination.tailwind') }}
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

            <form id="pinjamForm" action="{{ route('loans.store') }}" method="POST">
                @csrf
                <div class="p-6">
                    <input type="hidden" name="id_books" id="selectedBookId" value="">

                    <div class="mb-6">
                        <h4 class="font-medium text-slate-700 mb-3 text-amber-800">Buku yang dipilih:</h4>
                        <div id="modalBookDetail" class="bg-amber-50 p-4 rounded-xl border border-amber-100">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                <i class="fas fa-calendar-alt mr-2 text-amber-600"></i>Tanggal Peminjaman
                            </label>
                            <input type="date" name="tgl_pinjam" id="tgl_pinjam_input" required
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-600 focus:border-amber-600 outline-none bg-slate-50"
                                readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                <i class="fas fa-calendar-check mr-2 text-amber-600"></i>Tanggal Pengembalian
                            </label>
                            <input type="date" name="tgl_kembali_rencana" id="tgl_kembali_input" required
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
        function openLoan(id, title, author, categoryName) {
            const modal = document.getElementById('pinjamModal');
            const modalBookDetail = document.getElementById('modalBookDetail');
            const selectedBookId = document.getElementById('selectedBookId');

            // Ambil waktu saat ini berdasarkan perangkat (Waktu Indonesia)
            const now = new Date();

            // Format YYYY-MM-DD menggunakan standar lokal (en-CA menghasilkan format yang pas untuk input date)
            const today = now.toLocaleDateString('en-CA');

            // Hitung tanggal maksimal (hari ini + 6 hari untuk total 7 hari)
            const maxReturnDate = new Date(now);
            maxReturnDate.setDate(now.getDate() + 6);
            const maxReturnDateStr = maxReturnDate.toLocaleDateString('en-CA');

            // Hitung tanggal besok untuk minimal pengembalian
            const tomorrow = new Date(now);
            tomorrow.setDate(now.getDate() + 1);
            const tomorrowStr = tomorrow.toLocaleDateString('en-CA');

            const tglPinjamInput = document.getElementById('tgl_pinjam_input');
            const tglKembaliInput = document.getElementById('tgl_kembali_input');

            if (tglPinjamInput) {
                // Set tanggal peminjaman dengan hari ini
                tglPinjamInput.value = today;
                tglPinjamInput.readOnly = true; // Hanya readonly, bukan disabled
                tglPinjamInput.style.backgroundColor = '#f3f4f6'; // Warna abu-abu untuk indikasi readonly
                tglPinjamInput.style.cursor = 'not-allowed';
            }

            if (tglKembaliInput) {
                tglKembaliInput.value = '';
                tglKembaliInput.min = tomorrowStr;
                tglKembaliInput.max = maxReturnDateStr; // Batas maksimal 7 hari (hari ini + 6)
                tglKembaliInput.removeAttribute('readonly');
                tglKembaliInput.removeAttribute('disabled');
            }

            // Update Detail Buku
            modalBookDetail.innerHTML = `
                <div class="space-y-2">
                    <div class="grid grid-cols-[100px_1fr] items-baseline">
                        <span class="text-slate-500 text-sm">Judul Buku:</span>
                        <span class="font-bold text-amber-900">${title}</span>
                    </div>
                    <div class="grid grid-cols-[100px_1fr] items-baseline">
                        <span class="text-slate-500 text-sm">Pengarang:</span>
                        <span class="text-slate-700">${author}</span>
                    </div>
                    <div class="grid grid-cols-[100px_1fr] items-baseline">
                        <span class="text-slate-500 text-sm">Kategori:</span>
                        <span class="text-slate-700">${categoryName}</span>
                    </div>
                </div>
            `;

            selectedBookId.value = id;
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
            window.location.href = "{{ route('loans') }}";
        }

        document.getElementById('kategoriFilter').addEventListener('change', applyFilters);
        document.getElementById('searchInput').addEventListener('keypress', e => {
            if (e.key === 'Enter') applyFilters();
        });

        // ESC to close
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closePinjamModal();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const inputPinjam = document.querySelector('input[name="tgl_pinjam"]');
            const inputKembali = document.querySelector('input[name="tgl_kembali_rencana"]');

            function updateDateLimits() {
                if (inputPinjam.value) {
                    let startDate = new Date(inputPinjam.value);

                    // Hitung Tanggal Minimal (H+1 setelah pinjam)
                    let minDate = new Date(startDate);
                    minDate.setDate(startDate.getDate() + 1);

                    // Hitung Tanggal Maksimal (H+6 setelah pinjam, total 7 hari termasuk hari pinjam)
                    let maxDate = new Date(startDate);
                    maxDate.setDate(startDate.getDate() + 6);

                    // Format ke YYYY-MM-DD untuk atribut input date
                    const minStr = minDate.toISOString().split('T')[0];
                    const maxStr = maxDate.toISOString().split('T')[0];

                    inputKembali.min = minStr;
                    inputKembali.max = maxStr;

                    // Jika tanggal yang sudah terpilih sebelumnya melebihi batas baru, kosongkan
                    if (inputKembali.value && (inputKembali.value > maxStr || inputKembali.value < minStr)) {
                        inputKembali.value = '';
                    }
                }
            }

            // Jalankan saat pertama kali halaman dimuat (untuk handle nilai default tgl hari ini)
            updateDateLimits();

            // Jalankan setiap kali input tanggal pinjam diubah
            if (inputPinjam) {
                inputPinjam.addEventListener('change', updateDateLimits);
            }
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
