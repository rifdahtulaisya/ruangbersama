<aside id="sidebar"
    class="fixed left-0 top-0 w-[300px] h-screen
           bg-slate-900
           border-r border-slate-700/50
           shadow-xl z-40 flex flex-col
           transform -translate-x-full
           md:translate-x-0
           transition-transform duration-300">

    <div class="px-8 py-8">
        <div class="flex items-center gap-3">
            <div class="w-14 h-14">
                <img src="{{ asset('logo.svg') }}" alt="Logo"
                    class="w-full h-full object-contain filter grayscale brightness-200" />
            </div>
            <div class="flex flex-col">
                <span class="text-xl font-bold text-white tracking-wide">
                    RuangBuku
                </span>
                <span class="text-xs text-slate-400 font-medium">
                    Administrator
                </span>
            </div>
        </div>
        <div class="mt-6 border-b border-slate-700/50"></div>
    </div>

    <nav class="px-6 text-sm space-y-2">
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-4 px-5 py-3 rounded-xl transition
                  {{ Route::is('admin.dashboard')
                      ? 'bg-slate-800 text-white font-semibold shadow-sm border border-slate-700'
                      : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
            <i class="fa-solid fa-chart-line w-5 text-center"></i>
            Dashboard
        </a>

        <div class="pt-4">
            <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                Monitoring
            </p>

            <a href="{{ route('admin.loans.index') }}"
                class="flex items-center gap-4 px-5 py-3 rounded-xl transition
              {{ Route::is('admin.loans.*')
                  ? 'bg-slate-800 text-white font-semibold shadow-sm border border-slate-700'
                  : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <i class="fa-solid fa-calendar-check w-5 text-center"></i>
                <div class="flex flex-col">
                    <span>Transaksi</span>
                    <span class="text-xs opacity-75">peminjaman & pengembalian</span>
                </div>
            </a>
        </div>

        <div class="pt-4">
            <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                Master Data
            </p>

            <a href="{{ route('admin.categories.index') }}"
                class="flex items-center gap-4 px-5 py-3 rounded-xl transition
                      {{ Route::is('admin.categories.*')
                          ? 'bg-slate-800 text-white font-semibold shadow-sm border border-slate-700'
                          : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <i class="fa-solid fa-layer-group w-5 text-center"></i>
                Data Kategori
            </a>

            <a href="{{ route('admin.books.index') }}"
                class="flex items-center gap-4 px-5 py-3 rounded-xl transition mt-1
                      {{ Route::is('admin.books.*')
                          ? 'bg-slate-800 text-white font-semibold shadow-sm border border-slate-700'
                          : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <i class="fa-solid fa-toolbox w-5 text-center"></i>
                Data Buku
            </a>
        </div>

        <div class="pt-4">
            <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                Data Pengguna
            </p>

            <a href="{{ route('admin.members.index') }}"
                class="flex items-center gap-4 px-5 py-3 rounded-xl transition mt-1
                      {{ Route::is('admin.members.*')
                          ? 'bg-slate-800 text-white font-semibold shadow-sm border border-slate-700'
                          : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <i class="fa-solid fa-user-friends w-5 text-center"></i>
                Data Anggota
            </a>
        </div>
    </nav>

    <div class="mt-auto px-6 pb-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-4 px-5 py-3 rounded-xl
                       border bg-red-500/10 border-red-500/50 hover:bg-red-600 hover:text-white
                       text-red-600 transition-all duration-200 font-medium">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
