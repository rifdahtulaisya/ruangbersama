@extends('layouts.app')

@section('title', 'Register | RuangBuku')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="text-center mb-10">
        <h1 class="font-heading text-5xl sm:text-6xl md:text-7xl tracking-sm mb-6 font-bold text-[#280905]">
            Register</h1>
        <p class="text-gray-600">Buat akun RuangBuku Anda</p>
    </div>
    <div class="p-6 md:p-8 bg-white rounded-2xl shadow-xl border border-gray-100">
        <form action="{{ route('register') }}" method="POST" autocomplete="off">
            @csrf
            
            {{-- Input Nama Lengkap --}}
            <div class="mb-4">
                <label class="block pl-4 mb-1 text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-3 outline-none ring-1 ring-gray-200 focus:ring-2 focus:ring-[#A27B5C] shadow-sm rounded-full transition"
                    type="text" placeholder="Masukkan nama lengkap" />
                @error('name')
                    <p class="text-red-500 text-xs mt-1 pl-4">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Nomor Telepon --}}
<div class="mb-4">
    <label class="block pl-4 mb-1 text-sm font-medium text-gray-700">Nomor Telepon</label>
    <input name="number" value="{{ old('number') }}" required
        class="w-full px-4 py-3 outline-none ring-1 ring-gray-200 focus:ring-2 focus:ring-[#A27B5C] shadow-sm rounded-full transition"
        type="tel" placeholder="081234567890" />
    @error('number')
        <p class="text-red-500 text-xs mt-1 pl-4">{{ $message }}</p>
    @enderror
</div>

            {{-- Input Username - Menggunakan autocomplete="one-time-code" atau "off" --}}
            <div class="mb-4">
                <label class="block pl-4 mb-1 text-sm font-medium text-gray-700">Username</label>
                <input name="username" value="{{ old('username') }}" required 
                    autocomplete="none"
                    class="w-full px-4 py-3 outline-none ring-1 ring-gray-200 focus:ring-2 focus:ring-[#A27B5C] shadow-sm rounded-full transition"
                    type="text" placeholder="username_anda" />
                @error('username')
                    <p class="text-red-500 text-xs mt-1 pl-4">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Email --}}
            <div class="mb-4">
                <label class="block pl-4 mb-1 text-sm font-medium text-gray-700">Email</label>
                <input name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-3 outline-none ring-1 ring-gray-200 focus:ring-2 focus:ring-[#A27B5C] shadow-sm rounded-full transition"
                    type="email" placeholder="nama@email.com" />
                @error('email')
                    <p class="text-red-500 text-xs mt-1 pl-4">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Password - Menggunakan autocomplete="new-password" agar tidak terisi dari password manager --}}
            <div class="mb-4" x-data="{ show: false }">
                <label class="block pl-4 mb-1 text-sm font-medium text-gray-700">Password</label>
                <div class="relative password-wrapper">
                    <input name="password" required x-bind:type="show ? 'text' : 'password'"
                        autocomplete="new-password"
                        class="password-input w-full pl-4 py-3 outline-none ring-1 ring-gray-200 focus:ring-2 focus:ring-[#A27B5C] shadow-sm rounded-full border-none bg-white text-gray-800"
                        placeholder="••••••••" />
                    <button type="button" @click="show = !show"
                        class="password-toggle text-gray-500 hover:text-teal-900 transition">
                        <iconify-icon x-bind:icon="show ? 'heroicons:eye-slash' : 'heroicons:eye'"
                            width="20"></iconify-icon>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1 pl-4">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Konfirmasi Password --}}
            <div class="mb-8" x-data="{ show: false }">
                <label class="block pl-4 mb-1 text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <div class="relative password-wrapper">
                    <input name="password_confirmation" required x-bind:type="show ? 'text' : 'password'"
                        autocomplete="new-password"
                        class="password-input w-full pl-4 py-3 outline-none ring-1 ring-gray-200 focus:ring-2 focus:ring-[#A27B5C] shadow-sm rounded-full border-none bg-white text-gray-800"
                        placeholder="Ulangi password" />
                    <button type="button" @click="show = !show"
                        class="password-toggle text-gray-500 hover:text-teal-900 transition">
                        <iconify-icon x-bind:icon="show ? 'heroicons:eye-slash' : 'heroicons:eye'"
                            width="20"></iconify-icon>
                    </button>
                </div>
            </div>

            <button type="submit"
                class="flex w-full py-3 px-5 items-center justify-center font-semibold text-white bg-[#280905] hover:bg-[#A27B5C] rounded-full transition duration-200 mb-6">
                <span>Daftar Sekarang</span>
            </button>

            <p class="text-center text-sm font-medium text-gray-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-[#280905] hover:text-[#A27B5C] font-bold transition">Login di sini</a>
            </p>
        </form>
    </div>
</div>
@endsection