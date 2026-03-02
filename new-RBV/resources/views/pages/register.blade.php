@extends('layouts.app')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="flex flex-col justify-center items-start">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">
                Daftar di Ruang Baca Virtual
            </h1>
            <p class="text-lg text-gray-600 mb-6">
                Buat akun baru untuk mengakses koleksi buku, video, dan artikel kami.
            </p>
            <a href="{{ route('login') }}"
                class="inline-block bg-blue-700 text-white px-6 py-3 rounded-lg hover:bg-blue-800 transition">
                Masuk ke Akun Anda
            </a>
        </div>
        <div>
            <img src="{{ asset('images/reading.jpg') }}" alt="Ruang Baca Virtual" class="w-full rounded-lg shadow-md">
        </div>

    </div>

@endsection