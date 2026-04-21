<aside id="sidebar"
    class="fixed left-0 top-0 w-[300px] h-screen
          bg-[#280905] 
          border-r border-[#A27B5C]/30
          shadow-xl z-40 flex flex-col
          transform -translate-x-full
          md:translate-x-0
          transition-transform duration-300">

    <div class="px-8 py-8">
        <div class="flex items-center gap-3">
            <div class="w-14 h-14">
                <img 
                    src="{{ asset('logo.svg') }}" 
                    alt="RuangBersama Logo"
                    class="w-full h-full object-contain"
                />
            </div>
            <div class="flex flex-col">
                <span class="text-xl font-bold text-amber-100 tracking-wide">
                    RuangBersama
                </span>
                <span class="text-xs text-amber-100/60 font-medium">
                    Pengguna
                </span>
            </div>
        </div>
        <div class="mt-6 border-b border-[#A27B5C]/20"></div>
    </div>

    <nav class="px-6 text-sm space-y-2 flex-1 overflow-y-auto">
        <a href="{{ route('dashboard') }}"
        class="block -mx-6 transition
        {{ Route::is('dashboard') 
            ? 'bg-[#A27B5C]/20 border-r-4 border-[#A27B5C]' 
            : 'border-r-4 border-transparent hover:bg-[#A27B5C]/10' }}">

            <div class="flex items-center gap-4 px-6 py-3
            {{ Route::is('dashboard') 
                ? 'text-amber-100 font-semibold' 
                : 'text-amber-100/70 hover:text-amber-100' }}">
                
                <i class="fa-solid fa-chart-line"></i>
                Dashboard
            </div>
        </a>

        <a href="{{ route('bookings') }}"
        class="block -mx-6 transition
        {{ Route::is('bookings') 
            ? 'bg-[#A27B5C]/20 border-r-4 border-[#A27B5C]' 
            : 'border-r-4 border-transparent hover:bg-[#A27B5C]/10' }}">

            <div class="flex items-center gap-4 px-6 py-3
            {{ Route::is('bookings') 
                ? 'text-amber-100 font-semibold' 
                : 'text-amber-100/70 hover:text-amber-100' }}">
                
                <i class="fa-solid fa-screwdriver-wrench"></i>
                Daftar Ruangan
            </div>
        </a>

        <a href="{{ route('bookings.history') }}"
        class="block -mx-6 transition
        {{ Route::is('bookings.history') 
            ? 'bg-[#A27B5C]/20 border-r-4 border-[#A27B5C]' 
            : 'border-r-4 border-transparent hover:bg-[#A27B5C]/10' }}">

            <div class="flex items-center gap-4 px-6 py-3
            {{ Route::is('bookings.history') 
                ? 'text-amber-100 font-semibold' 
                : 'text-amber-100/70 hover:text-amber-100' }}">
                
                <i class="fa-solid fa-screwdriver-wrench"></i>
                Riwayat Sewa
            </div>
        </a>
    </nav>

    <div class="px-6 pb-6 space-y-3">
        
         <a href=""

           class="block bg-[#A27B5C]/5 backdrop-blur-sm rounded-xl p-4 border border-[#A27B5C]/20 shadow-sm

                  hover:bg-[#A27B5C]/10 hover:border-[#A27B5C]/40 hover:shadow-md

                  transition-all duration-200 group">

            <div class="flex items-center gap-3">

                <div class="relative">

                    <img src="{{ asset('profile.svg') }}"

                         class="w-12 h-12 rounded-full object-cover border-2 border-[#A27B5C]/50 group-hover:border-[#A27B5C] transition-all"

                         alt="User Avatar">

                    <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-[#A27B5C] border-2 border-[#280905] rounded-full"></span>

                </div>

               

                <div class="flex-1 min-w-0">

                    <div class="flex items-center justify-between">

                        <p class="text-sm font-semibold text-[#A27B5C] truncate">

                            {{ Auth::user()->name ?? 'Peminjam' }}

                        </p>

                        <i class="fa-solid fa-chevron-right text-[#A27B5C]/40 text-xs opacity-0 group-hover:opacity-100 transition-opacity"></i>

                    </div>

                    <p class="text-[10px] text-[#A27B5C]/60 truncate flex items-center gap-1">

                        {{ Auth::user()->email ?? 'peminjam@example.com' }}

                    </p>

                    <div class="flex items-center gap-1 mt-1">

                        <span class="px-2 py-0.5 bg-[#A27B5C]/20 text-[#A27B5C] rounded-full text-[10px] font-medium">

                            <i class="fa-solid fa-shield-alt mr-1"></i>Peminjam

                        </span>

                    </div>

                </div>

            </div>

        </a>

        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-4 px-5 py-3 rounded-xl
                       bg-red-500/10 text-red-400
                       hover:bg-red-600 hover:text-white
                       transition-all duration-200 font-medium group">
                <i class="fa-solid fa-right-from-bracket group-hover:translate-x-1 transition-transform"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>