<!DOCTYPE html>
<html lang="id">

<head>
    <title>@yield('title', '')</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet" />
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'body': '#f9fafb',
                        'lime': {
                            500: '#280905',
                            600: '#280905',
                        },
                        'teal': {
                            900: '#280905',
                        }
                    },
                    fontFamily: {
                        'body': ['Figtree', 'sans-serif'],
                        'heading': ['Figtree', 'sans-serif'],
                    },
                    borderRadius: {
                        'xl': '1rem',
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <style>
        .password-wrapper .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background: transparent;
            border: none;
            padding: 0;
            margin: 0;
            width: auto;
            height: auto;
            z-index: 2;
            transition: color 0.2s ease;
        }
    </style>
</head>

<body class="antialiased bg-gray-50 font-body text-gray-800">

    <div>
        <section class="py-12 lg:py-24 relative overflow-hidden bg-gradient-to-br from-lime-50 via-white to-teal-50">
             <div class="absolute inset-0 opacity-30 pointer-events-none">
                <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="wavePattern" x="0" y="0" width="120" height="120"
                            patternUnits="userSpaceOnUse">
                            <path d="M0 60 Q30 30 60 60 T120 60" stroke="#A27B5C" fill="none" stroke-width="0.8"
                                opacity="0.5" />
                            <path d="M0 90 Q30 60 60 90 T120 90" stroke="#280905" fill="none" stroke-width="0.6"
                                opacity="0.3" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#wavePattern)" />
                </svg>
            </div>


            <div class="container mx-auto px-4 relative">
                @yield('content')
            </div>
        </section>
    </div>
</body>

</html>
