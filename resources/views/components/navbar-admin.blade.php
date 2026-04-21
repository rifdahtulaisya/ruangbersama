<header
    class="fixed top-0 left-0 md:left-[300px] right-0 h-20
           bg-white border-b border-slate-200
           shadow-sm flex items-center justify-between
           px-4 md:px-8 z-30">

    <div class="flex items-center gap-3">
        <button id="burgerBtn"
            class="md:hidden w-10 h-10 rounded-lg
                   bg-slate-100 hover:bg-slate-200
                   flex items-center justify-center transition">
            <i class="fa-solid fa-bars text-slate-600"></i>
        </button>

        <div class="flex flex-col">
            <h1 class="text-xl font-bold text-slate-800">
                @yield('title', 'Dashboard')
            </h1>
            @hasSection('subtitle')
                <p class="text-sm text-slate-500 mt-0.5">
                    @yield('subtitle')
                </p>
            @endif
        </div>
    </div>

    <div class="flex items-center gap-3 md:gap-6">
        <button
            class="relative w-10 h-10 rounded-full
                   bg-slate-100 hover:bg-slate-200
                   flex items-center justify-center transition">
            <i class="fa-regular fa-bell text-slate-600"></i>
            <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-blue-500 rounded-full border-2 border-white"></span>
        </button>

        <a href="{{ route('admin.profile') }}" 
           class="flex items-center gap-3 bg-slate-50 px-3 py-1.5 rounded-full border border-slate-200 hover:bg-slate-100 transition">
            <img src="{{ asset('profile.svg') }}"
                 class="w-8 h-8 rounded-full object-cover border border-slate-300"
                 alt="Profile">
            <div class="leading-tight hidden sm:block">
                <p class="text-sm font-bold text-slate-700">
                    Admin
                </p>
                <p class="text-[10px] text-slate-500 uppercase tracking-tighter">
                    Administrator
                </p>
            </div>
        </a>
    </div>
</header>