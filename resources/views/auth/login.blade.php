@extends('layouts.app')

@section('title', 'Login | RuangBersama')

@section('content')
    <div class="max-w-lg mx-auto">
        <div class="text-center mb-10">
            <h1 class="font-heading text-5xl sm:text-6xl md:text-7xl tracking-sm mb-6 font-bold text-[#280905]">
                Login</h1>
            <p class="text-gray-600">Akses akun RuangBersama Anda</p>
        </div>
        <div class="p-6 md:p-8 bg-white rounded-2xl shadow-xl border border-gray-100">
            <form action="{{ route('login') }}" method="POST">
                @csrf <label class="block pl-4 mb-1 text-sm font-medium text-gray-700" for="email">Email</label>
                <input id="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-3 mb-5 outline-none ring-1 ring-gray-200 focus:ring-2 focus:ring-[#A27B5C] shadow-sm rounded-full transition"
                    type="email" placeholder="nama@email.com" />
                @error('email')
                    <p class="text-red-500 text-xs mt-1 mb-4 pl-4">{{ $message }}</p>
                @enderror
                <div class="mb-6" x-data="{ show: false }">

                    <div class="flex justify-between items-center mb-1 px-4">
                        <label class="text-sm font-medium text-gray-700" for="password">Password</label>
                        <a href="#" class="text-[#280905] hover:text-[#A27B5C] text-xs font-semibold transition">Lupa
                            Password?</a>
                    </div>

                    <div class="relative password-wrapper">
                        <input id="password" name="password" required x-bind:type="show ? 'text' : 'password'"
                            class="password-input w-full pl-4 py-3 outline-none ring-1 ring-gray-200 focus:ring-2 focus:ring-[#A27B5C] shadow-sm rounded-full border-none bg-white text-gray-800"
                            placeholder="••••••••" />

                        <button type="button" @click="show = !show"
                            class="password-toggle focus:outline-none text-gray-500 hover:text-[#280905] transition"
                            aria-label="Toggle password visibility">
                            <iconify-icon x-bind:icon="show ? 'heroicons:eye-slash' : 'heroicons:eye'" width="20"
                                height="20" class="pointer-events-none">
                            </iconify-icon>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1 pl-4">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="flex w-full py-3 px-5 items-center justify-center font-semibold text-white hover:text-white border border-[#280905] hover:border-[#A27B5C] bg-[#280905] hover:bg-[#A27B5C] rounded-full transition duration-200 mb-6 group">
                    <span class="mr-2">Login</span>
                    <span class="iconify" data-icon="mdi:arrow-right" data-width="20" data-height="20"></span>
                </button>

                <p class="text-center text-sm font-medium text-gray-500">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-[#280905] hover:text-[#A27B5C] font-bold transition">Daftar
                        sekarang</a>
                </p>
            </form>
        </div>
    </div>
@endsection
