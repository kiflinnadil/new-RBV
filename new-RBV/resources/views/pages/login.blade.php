@extends('layouts.app')

@section('content')

<div class="relative min-h-screen flex items-center justify-center overflow-hidden">

    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/image0.jpg') }}"
            alt="background"
            class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/30"></div>
    </div>

    <div class="relative z-10 w-full max-w-sm mx-4">
        <div class="backdrop-blur-md bg-white/20 border border-white/30 rounded-2xl shadow-2xl px-10 py-10">

            <h1 class="font-montserrat text-3xl font-bold text-white text-center mb-1 tracking-wide">
                Login
            </h1>
            <p class="font-montserrat text-white/80 text-sm text-center mb-3">
                Gunakan akun anda untuk masuk.
            </p>

            <div class="mb-6" style="height:20px; overflow:hidden; position:relative;">
                <p id="quoteText"
                    class="font-montserrat text-white/60 text-[10px] text-center italic
                           absolute inset-0 flex items-center justify-center px-2">
                </p>
            </div>

            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf

                @if(session('error'))
                    <div class="bg-red-500/20 border border-red-500/50 text-white text-xs p-3 rounded-lg text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <div>
                    <label class="block font-montserrat text-white text-sm font-medium mb-1">NIK</label>
                    <input
                        type="text"
                        name="nik"
                        value="{{ old('nik') }}"
                        required
                        class="w-full px-4 py-2.5 rounded-lg bg-white/90 font-montserrat text-gray-800 placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-white/60 transition">
                </div>

                <div>
                    <label class="block font-montserrat text-white text-sm font-medium mb-1">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="passwordInput"
                            required
                            class="w-full px-4 py-2.5 rounded-lg bg-white/90 font-montserrat text-gray-800 placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-white/60 transition pr-10">
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                        class="w-full py-2.5 bg-[#1E3A8A] hover:bg-[#1e40af] font-poppins text-white font-semibold rounded-lg transition duration-200 tracking-wide shadow-lg">
                        Login
                    </button>
                </div>
            </form>



        </div>
    </div>
</div>

@endsection