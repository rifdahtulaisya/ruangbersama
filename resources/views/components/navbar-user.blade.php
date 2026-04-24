
<header
    class="fixed top-0 left-0 md:left-[300px] right-0 h-20
           bg-gradient-to-r from-[#280905] to-[#1a0603] shadow-lg
           flex items-center justify-between
           px-4 md:px-8 z-30">

    
    <div class="flex items-center gap-3">
        
        <button id="burgerBtn"
            class="md:hidden w-10 h-10 rounded-full
                   bg-[#A27B5C]/10 hover:bg-[#A27B5C]/20
                   flex items-center justify-center transition">
            <i class="fa-solid fa-bars text-amber-300"></i>
        </button>

       
        <div>
            <h1 class="text-xl font-bold text-amber-100">
                @yield('title', '')
            </h1>
            <p class="text-xs text-amber-300/80 mt-0.5 hidden sm:block">
                @yield('subtitle', '')
            </p>
        </div>
    </div>

    
    <div class="flex items-center gap-4">
        
        <button
            class="relative w-10 h-10 rounded-full
                   bg-amber-800/30 hover:bg-amber-800/50
                   flex items-center justify-center transition">
            <i class="fa-regular fa-bell text-amber-300"></i>
            <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
        </button>
    </div>
</header>