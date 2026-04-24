<html lang="en">
<head>
    <title>RuangBuku</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&amp;display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/tailwind/tailwind.min.css') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer="defer"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
</head>
<body class="antialiased bg-body text-body font-body">
    <div>
        {{-- Header --}}
        <div>
            <section class="relative" style="background-color: #280905;"><img
                    class="absolute top-0 left-0 w-full h-full" src="{{ asset('user-assets/image/bg-landing.png') }}"
                    alt="" />
                <nav class="py-6">
                    <div class="container mx-auto px-4">
                        <div class="relative flex items-center justify-between">
                            <a class="inline-block" href="#!">
                                <img class="h-8" src="{{ asset('logo.svg') }}" alt="" />
                            </a>
                            <div class="flex items-center justify-end">
                                <div class="hidden md:block">
                                    @auth
                                        <a class="inline-flex group py-2.5 px-4 items-center justify-center text-sm font-medium text-white hover:text-teal-900 border border-white hover:bg-white rounded-full transition duration-200"
                                            href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}">
                                            <span class="mr-2">Dashboard</span>
                                            <span class="transform group-hover:translate-x-0.5 transition-transform duration-200">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4.75 10H15.25" stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M10 4.75L15.25 10L10 15.25" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    </path>
                                                </svg>
                                            </span>
                                        </a>
                                    @else
                                        <a class="inline-flex group py-2.5 px-4 items-center justify-center text-sm font-medium text-white hover:text-teal-900 border border-white hover:bg-white rounded-full transition duration-200"
                                            href="{{ route('login') }}">
                                            <span class="mr-2">Login</span>
                                            <span class="transform group-hover:translate-x-0.5 transition-transform duration-200">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4.75 10H15.25" stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M10 4.75L15.25 10L10 15.25" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    </path>
                                                </svg>
                                            </span>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
                <div class="relative pt-18 pb-24 sm:pb-32 lg:pt-36 lg:pb-62">
                    <div class="container mx-auto px-4 relative">
                        <div class="max-w-lg xl:max-w-xl mx-auto text-center">
                            <h1 class="font-heading text-5xl xs:text-7xl xl:text-8xl tracking-tight text-white mb-8">
                                RuangBuku
                            </h1>
                            <p class="max-w-md xl:max-w-none text-lg text-white opacity-80 mb-10">
                                Akses mudah koleksi pustaka untuk wawasan luas dan produktivitas tanpa batas. Pinjam buku pilihan Anda, di mana pun dan kapan pun.
                            </p>
                            <a class="inline-flex py-4 px-6 items-center justify-center text-lg font-medium bg-white text-[#280905] border border-white rounded-full transition duration-200"
                                href="{{ route('register') }}"
                                onmouseover="this.style.color='white'; this.style.backgroundColor='transparent'"
                                onmouseout="this.style.color='#280905'; this.style.backgroundColor='white'">
                                Mulai Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        {{-- Footer --}}
        <section class="relative py-12 lg:py-24 bg-white overflow-hidden">
            <div class="container px-4 mx-auto relative">
                <div class="flex flex-wrap -mb-3 justify-between">
                    <div class="flex items-center mb-3">
                        <a class="inline-block mr-4 text-black hover:text-[#280905] transition duration-200" href="#!">
                            <span class="iconify" data-icon="ri:facebook-fill" data-width="20" data-height="20"></span>
                        </a>
                        <a class="inline-block mr-4 text-black hover:text-[#280905] transition duration-200" href="#!">
                            <span class="iconify" data-icon="ri:instagram-line" data-width="24" data-height="24"></span>
                        </a>
                        <a class="inline-block text-black hover:text-[#280905] transition duration-200" href="#!">
                            <span class="iconify" data-icon="ri:linkedin-fill" data-width="24" data-height="24"></span>
                        </a>
                    </div>
                    <p class="text-sm text-gray-500 mb-3">© 2026 RuangBuku. All rights reserved.</p>
                </div>
            </div>
        </section>
    </div>
</body>
</html>