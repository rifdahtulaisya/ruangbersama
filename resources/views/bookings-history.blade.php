@extends('layouts-user.user')

@section('title', 'Riwayat Peminjaman')

@section('content')

<!-- MOBILE: DROPDOWN -->
<div class="block md:hidden mb-6">
    <div class="bg-white rounded-xl shadow p-4">
        <label class="text-sm text-stone-500 font-semibold mb-2 block">Statistik</label>
        <select id="statsDropdown"
            class="w-full border border-stone-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#A27B5C] focus:border-[#A27B5C]">
            <option value="pending">Pending ({{ $stats['pending'] ?? 0 }})</option>
            <option value="approved">Approved ({{ $stats['approved'] ?? 0 }})</option>
            <option value="borrowed">Borrowed ({{ $stats['borrowed'] ?? 0 }})</option>
            <option value="returned">Returned ({{ $stats['returned'] ?? 0 }})</option>
        </select>

        <div id="statsContent" class="mt-4 text-center">
            <p class="text-xs text-stone-500 uppercase font-semibold">Pending</p>
            <h2 class="text-2xl font-bold text-[#280905]">{{ $stats['pending'] ?? 0 }}</h2>
        </div>
    </div>
</div>

<!-- DESKTOP: CARD -->
<div class="hidden md:grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow p-5">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div>
                <p class="text-xs text-stone-500 uppercase font-semibold">Pending</p>
                <h2 class="text-xl font-bold text-[#280905]">{{ $stats['pending'] ?? 0 }}</h2>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div>
                <p class="text-xs text-stone-500 uppercase font-semibold">Approved</p>
                <h2 class="text-xl font-bold text-[#280905]">{{ $stats['approved'] ?? 0 }}</h2>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                <i class="fa-solid fa-key"></i>
            </div>
            <div>
                <p class="text-xs text-stone-500 uppercase font-semibold">Borrowed</p>
                <h2 class="text-xl font-bold text-[#280905]">{{ $stats['borrowed'] ?? 0 }}</h2>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-stone-100 text-stone-600">
                <i class="fa-solid fa-box-archive"></i>
            </div>
            <div>
                <p class="text-xs text-stone-500 uppercase font-semibold">Returned</p>
                <h2 class="text-xl font-bold text-[#280905]">{{ $stats['returned'] ?? 0 }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-4 mb-6">
    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="w-full md:w-auto">
            <form id="searchForm" method="GET" action="{{ route('bookings.history') }}"
                class="relative w-full md:w-72">
                <div class="relative">
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                        placeholder="Cari ruangan..."
                        class="w-full pl-10 pr-4 py-2.5 border border-stone-300 rounded-lg 
                            focus:outline-none focus:ring-2 focus:ring-[#A27B5C] focus:border-[#A27B5C]">
                    <i class="fa-solid fa-search absolute left-3 top-3.5 text-stone-400"></i>
                </div>
            </form>
        </div>

        <div class="flex items-center gap-3">
            <span class="text-sm text-stone-600">Tampilkan:</span>
            <div class="flex bg-stone-100 rounded-lg p-1">
                @foreach ([5, 10, 15, 20] as $perPage)
                    <a href="{{ route('bookings.history', array_merge(request()->except('page'), ['per_page' => $perPage])) }}"
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
                    <th class="px-6 py-4">Ruangan</th>
                    <th class="px-6 py-4">Tanggal Pinjam</th>
                    <th class="px-6 py-4">Rencana Kembali</th>
                    <th class="px-6 py-4 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($bookings as $item)
                    <tr class="hover:bg-stone-50 transition">
                        <td class="px-6 py-4 font-medium">
                            {{ ($bookings->currentPage() - 1) * $bookings->perPage() + $loop->iteration }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($item->room->image)
                                    <img src="{{ asset('storage/' . $item->room->image) }}" 
                                         class="w-10 h-10 rounded-lg object-cover border border-stone-200">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-stone-100 flex items-center justify-center text-[#A27B5C]">
                                        <i class="fa-solid fa-door-open"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-[#280905] line-clamp-1">{{ $item->room->room_name }}</p>
                                    <p class="text-xs text-stone-400">{{ $item->room->category->category_name ?? '-' }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <span class="text-stone-600 font-medium">{{ $item->tgl_pinjam->format('d M Y') }}</span>
                        </td>

                        <td class="px-6 py-4">
                            <span class="text-stone-600 font-medium">{{ $item->tgl_kembali_rencana->format('d M Y') }}</span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            @php
                                $statusColors = [
                                    'pending'   => 'bg-amber-100 text-amber-700',
                                    'approved'  => 'bg-emerald-100 text-emerald-700',
                                    'cancelled' => 'bg-stone-100 text-stone-500',
                                    'returned'  => 'bg-blue-100 text-blue-700',
                                    'rejected'  => 'bg-red-100 text-red-700',
                                ];
                                $colorClass = $statusColors[$item->status] ?? 'bg-stone-100 text-stone-700';
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $colorClass }}">
                                {{ $item->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fa-solid fa-calendar-xmark text-4xl mb-3 text-stone-300"></i>
                                <p class="text-stone-500 font-medium">Belum ada riwayat peminjaman</p>
                                <p class="text-sm text-stone-400 mt-1">Silakan ajukan peminjaman ruangan pada menu daftar ruangan.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($bookings->hasPages())
        <div class="px-6 py-4 border-t border-stone-100">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-sm text-stone-500">
                    Menampilkan
                    <span class="font-medium">{{ $bookings->firstItem() ?? 0 }}</span>
                    -
                    <span class="font-medium">{{ $bookings->lastItem() ?? 0 }}</span>
                    dari
                    <span class="font-medium">{{ $bookings->total() }}</span>
                    data
                </div>
                <div>
                    {{ $bookings->appends(request()->except('page'))->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
    // Auto submit pencarian saat user mengetik
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        let timeout = null;

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    searchForm.submit();
                }, 800);
            });
        }
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const dropdown = document.getElementById('statsDropdown');
    const content = document.getElementById('statsContent');

    const stats = {
        pending: {{ $stats['pending'] ?? 0 }},
        approved: {{ $stats['approved'] ?? 0 }},
        borrowed: {{ $stats['borrowed'] ?? 0 }},
        returned: {{ $stats['returned'] ?? 0 }},
    };

    dropdown.addEventListener('change', function () {
        const value = this.value;

        content.innerHTML = `
            <p class="text-xs text-stone-500 uppercase font-semibold">${value}</p>
            <h2 class="text-2xl font-bold text-[#280905]">${stats[value]}</h2>
        `;
    });
});
</script>
@endsection