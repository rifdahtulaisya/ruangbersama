@extends('layouts-user.user')

@section('title', 'RIWAYAT PEMINJAMAN')

@section('content')
    <div class="bg-white rounded-xl shadow p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="w-full md:w-auto">
                <form id="filterForm" method="GET" action="{{ route('loans.history') }}" class="relative w-full md:w-72">
                    <div class="relative">
                        <select name="status" id="statusFilter"
                            class="w-full pl-10 pr-4 py-2.5 border border-stone-300 rounded-lg 
                               focus:outline-none focus:ring-2 focus:ring-[#A27B5C] focus:border-[#A27B5C]
                               appearance-none bg-white cursor-pointer">
                            <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>
                                Semua ({{ $stats['total'] ?? 0 }})
                            </option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                Pending ({{ $stats['pending'] ?? 0 }})
                            </option>
                            <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>
                                Dipinjam ({{ $stats['borrowed'] ?? 0 }})
                            </option>
                            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>
                                Dikembalikan ({{ $stats['returned'] ?? 0 }})
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                Dibatalkan ({{ $stats['cancelled'] ?? 0 }})
                            </option>
                        </select>
                        <i class="fa-solid fa-filter absolute left-3 top-3.5 text-stone-400"></i>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-3.5 text-stone-400 pointer-events-none"></i>
                    </div>
                </form>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-sm text-stone-600">Tampilkan:</span>
                <div class="flex bg-stone-100 rounded-lg p-1">
                    @foreach ([5, 10, 15, 20] as $perPage)
                        <a href="{{ route('loans.history', array_merge(request()->except('page', 'per_page'), ['per_page' => $perPage])) }}"
                            class="px-3 py-1 rounded-md text-sm font-medium transition
                          {{ request('per_page', 5) == $perPage ? 'bg-[#A27B5C] text-white shadow' : 'text-stone-600 hover:text-[#A27B5C]' }}">
                            {{ $perPage }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-stone-600">
                <thead class="bg-stone-50 text-xs uppercase text-stone-500">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Buku</th>
                        <th class="px-6 py-4">Tanggal Pinjam</th>
                        <th class="px-6 py-4">Rencana Kembali</th>
                        <th class="px-6 py-4">Tanggal Kembali</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($loans as $item)
                        <tr class="hover:bg-stone-50 transition">
                            <td class="px-6 py-4 font-medium">
                                {{ ($loans->currentPage() - 1) * $loans->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($item->book && $item->book->image)
                                        <div class="relative">
                                            <div
                                                class="absolute -bottom-1 left-0.5 right-0.5 h-2 bg-black/20 blur-sm rounded-full">
                                            </div>
                                            <div
                                                class="w-12 h-16 md:w-14 md:h-20 rounded-md overflow-hidden shadow-md border border-stone-200">
                                                <img src="{{ asset('storage/' . $item->book->image) }}"
                                                    alt="{{ $item->book->title }}"
                                                    class="w-full h-full object-cover hover:scale-105 transition duration-300">
                                            </div>
                                        </div>
                                    @else
                                        <div
                                            class="w-12 h-16 md:w-14 md:h-20 rounded-md bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center text-[#A27B5C] shadow-md">
                                            <i class="fa-solid fa-book text-xl"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-[#280905] line-clamp-1">
                                            {{ $item->book->title ?? 'Buku tidak tersedia' }}
                                        </p>
                                        <p class="text-xs text-stone-400">{{ $item->book->author ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="text-stone-600 font-medium">{{ $item->tgl_pinjam->format('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="text-stone-600 font-medium">{{ $item->tgl_kembali_rencana->format('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($item->tgl_kembali_realisasi)
                                    <span
                                        class="text-stone-600 font-medium">{{ Carbon\Carbon::parse($item->tgl_kembali_realisasi)->format('d M Y') }}</span>
                                @else
                                    <span class="text-stone-400">-</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'borrowed' => 'bg-blue-100 text-blue-700',
                                        'returned' => 'bg-green-100 text-green-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                    ];
                                    $statusTexts = [
                                        'pending' => 'Pending',
                                        'borrowed' => 'Dipinjam',
                                        'returned' => 'Dikembalikan',
                                        'cancelled' => 'Dibatalkan',
                                    ];
                                    $colorClass = $statusColors[$item->status] ?? 'bg-stone-100 text-stone-700';
                                    $statusText = $statusTexts[$item->status] ?? ucfirst($item->status);
                                @endphp
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $colorClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fa-solid fa-calendar-xmark text-4xl mb-3 text-stone-300"></i>
                                    <p class="text-stone-500 font-medium">Tidak ada riwayat peminjaman</p>
                                    <p class="text-sm text-stone-400 mt-1">Silakan ajukan peminjaman buku pada menu daftar
                                        buku.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($loans->hasPages())
            <div class="px-6 py-4 border-t border-stone-100">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-stone-500">
                        Menampilkan
                        <span class="font-medium">{{ $loans->firstItem() ?? 0 }}</span>
                        -
                        <span class="font-medium">{{ $loans->lastItem() ?? 0 }}</span>
                        dari
                        <span class="font-medium">{{ $loans->total() }}</span>
                        data
                    </div>
                    <div>
                        {{ $loans->appends(request()->except('page'))->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            const statusFilter = document.getElementById('statusFilter');
            const filterForm = document.getElementById('filterForm');

            if (statusFilter) {
                statusFilter.addEventListener('change', function() {
                    filterForm.submit();
                });
            }
        });
    </script>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false,
                position: 'top-end',
                toast: true,
                background: '#10b981',
                color: '#fff',
                iconColor: '#fff'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false,
                position: 'top-end',
                toast: true
            });
        @endif
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                title: "Berhasil!",
                text: "{{ session('success') }}",
                icon: "success",
                timer: 2000,
                showConfirmButton: true
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: "Gagal!",
                text: "{{ session('error') }}",
                icon: "error",
                confirmButtonColor: "#3085d6"
            });
        </script>
    @endif
@endsection