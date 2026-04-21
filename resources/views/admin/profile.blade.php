@extends('layouts-admin.admin')

@section('title', 'Profil Administrator')

@section('content')
    <div class="pc-content">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-circle-user text-slate-500"></i>
                        Informasi Akun
                    </h3>

                    <div class="flex flex-col items-center">
                        <div
                            class="w-32 h-32 rounded-full bg-slate-800 
                                 flex items-center justify-center text-white text-4xl font-bold mb-4
                                 shadow-lg border-4 border-slate-100">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>

                        <h4 class="text-xl font-bold text-slate-800">{{ Auth::user()->name }}</h4>
                        <p class="text-sm text-slate-500">{{ Auth::user()->username }}</p>
                        <p class="text-sm text-slate-500">{{ Auth::user()->email }}</p>

                        <div class="mt-4 w-full">
                            <div class="bg-slate-50 rounded-xl p-3 text-center border border-slate-100">
                                <span class="px-3 py-1.5 bg-slate-800 text-white rounded-full text-xs font-medium">
                                    <i class="fa-solid fa-shield-halved mr-1"></i> Administrator
                                </span>
                            </div>
                        </div>

                        <div class="mt-6 w-full border-t border-slate-200 pt-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500">Bergabung</span>
                                <span class="font-medium text-slate-800">
                                    {{ Auth::user()->created_at ? Auth::user()->created_at->format('d/m/Y') : '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-user-pen text-slate-500"></i>
                        Edit Profil
                    </h3>

                    @if (session('success'))
                        <div class="mb-6 p-4 bg-slate-800 text-white rounded-xl flex items-center gap-3">
                            <i class="fa-solid fa-circle-check"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Nama Lengkap
                                </label>
                                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl 
                                          focus:border-slate-800 focus:ring-1 focus:ring-slate-800
                                          transition">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Username
                                </label>
                                <input type="text" name="username" value="{{ old('username', Auth::user()->username) }}" required
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl 
                                          focus:border-slate-800 focus:ring-1 focus:ring-slate-800
                                          transition">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Email
                                </label>
                                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl 
                                          focus:border-slate-800 focus:ring-1 focus:ring-slate-800
                                          transition">
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit"
                                class="px-6 py-3 bg-slate-900 text-white rounded-xl hover:bg-slate-800 
                                       transition font-medium flex items-center gap-2 shadow-md">
                                <i class="fa-regular fa-floppy-disk"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-lock text-slate-500"></i>
                        Ganti Password
                    </h3>

                    <form action="{{ route('admin.profile.password') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Password Saat Ini</label>
                                <div class="relative">
                                    <input type="password" name="current_password" id="current_password" required
                                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:border-slate-800 transition pr-12">
                                    <button type="button" onclick="togglePassword('current_password', this)"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Password Baru</label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" required
                                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:border-slate-800 transition pr-12">
                                    <button type="button" onclick="togglePassword('password', this)"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation" required
                                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:border-slate-800 transition pr-12">
                                    <button type="button" onclick="togglePassword('password_confirmation', this)"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit"
                                class="px-6 py-3 bg-slate-900 text-white rounded-xl hover:bg-slate-800 
                                       transition font-medium flex items-center gap-2 shadow-md">
                                Ubah Password
                            </button>
                            <button type="reset"
                                class="px-6 py-3 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition font-medium">
                                Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
@endsection