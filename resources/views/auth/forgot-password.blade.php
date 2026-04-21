@extends('layouts.app')

@section('title', 'Forget Password | RuangBersama')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="text-center mb-10">
        <h1 class="font-heading text-5xl sm:text-6xl md:text-7xl tracking-sm mb-6 font-bold text-teal-900">Forget Password</h1>
        <p class="text-gray-600">Masukkan email Anda untuk mengatur ulang password</p>
    </div>
    <div class="p-6 md:p-8 bg-white rounded-2xl shadow-xl border border-gray-100">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <label class="block pl-4 mb-1 text-sm font-medium text-gray-700" for="email"
                :value="__('Email')">Email</label>
            <input id="email" name="email" :value="old('email')" required autofocus
                class="w-full px-4 py-3 mb-5 outline-none ring-1 ring-gray-200 focus:ring-2 focus:ring-lime-500 shadow-sm rounded-full transition"
                type="email" placeholder="Masukan Email" />
            <button type="submit"
                class="flex w-full py-3 px-5 items-center justify-center font-semibold text-white hover:text-teal-900 border border-teal-900 hover:border-lime-500 bg-teal-900 hover:bg-lime-500 rounded-full transition duration-200 mb-6 group">
                <span class="mr-2">Login</span>
                <svg width="21" height="20" viewbox="0 0 21 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.25 10H15.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                    <path d="M10.5 4.75L15.75 10L10.5 15.25" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </button>

            <p class="text-center text-sm font-medium text-gray-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-teal-800 hover:text-lime-600 font-bold transition">Daftar
                    sekarang</a>
            </p>
        </form>
    </div>
@endsection