<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin | RuangBuku</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css" rel="stylesheet">

    <!-- DataTables Responsive -->
    <link href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.min.css" rel="stylesheet">

</head>

<body class="min-h-screen flex flex-col overflow-x-hidden bg-blue-100 text-slate-900">
    <!-- Sidebar -->
    <x-sidebar-admin />

    <!-- Navbar -->
    <x-navbar-admin />
    <div id="overlay" class="fixed inset-0 bg-black/30 z-30 hidden md:hidden">
    </div>

    <main
        class="pt-8 pb-6 px-4 md:px-6 relative top-[90px] mb-24 md:ml-[320px] md:mr-3 md:rounded-3xl transition-all duration-300 flex flex-col max-w-full">
        @yield('content')
    </main>

    <footer
        class="mt-10 px-6 py-4 text-sm text-slate-500 flex justify-between items-center
               md:ml-[320px] md:mr-3 transition-all duration-300">

        <div>
            © {{ date('Y') }} RuangBuku reserved.
        </div>

    </footer>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('fotoInput');

            // Check if the element exists before using it
            if (input) {
                input.addEventListener('change', function() {
                    const file = this.files[0];
                    if (!file) return;

                    const previewContainer = document.getElementById('previewContainer');

                    if (!previewContainer) return;

                    // RESET TOTAL
                    previewContainer.innerHTML = '';

                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.className = 'w-full h-full object-cover';

                    previewContainer.appendChild(img);

                    const uploadBtnText = document.getElementById('uploadBtnText');
                    if (uploadBtnText) uploadBtnText.textContent = 'Ganti Foto';

                    const hapusFoto = document.getElementById('hapus_foto');
                    if (hapusFoto) hapusFoto.checked = false;
                });
            }
        });
    </script>
    


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmLogout() {

            Swal.fire({
                title: 'Logout?',
                text: "Anda akan keluar dari sistem",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6366f1',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {

                if (result.isConfirmed) {

                    document.getElementById('logout-form').submit();

                }

            });

        }
    </script>

    <script>
        const burger = document.getElementById('burgerBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        burger.addEventListener('click', () => {

            sidebar.classList.toggle('-translate-x-full');

            overlay.classList.toggle('hidden');

        });

        overlay.addEventListener('click', () => {

            sidebar.classList.add('-translate-x-full');

            overlay.classList.add('hidden');

        });
    </script>




    @stack('scripts')
    @yield('scripts')
</body>

</html>
