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
            <p class="font-montserrat text-white/80 text-sm text-center mb-8">
                Gunakan akun anda untuk masuk.
            </p>

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
                    <input 
                        type="password" 
                        name="password"
                        required
                        class="w-full px-4 py-2.5 rounded-lg bg-white/90 font-montserrat text-gray-800 placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-white/60 transition">
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