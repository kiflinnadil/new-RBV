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



<form action="{{ route('books.favorite', $buku->id_buku) }}" method="POST" class="absolute top-3 right-3 z-10">
    @csrf
    <button type="submit" class="bg-white/80 p-2 rounded-full shadow-sm hover:scale-110 transition">
        <svg xmlns="http://www.w3.org/2000/svg" 
            class="h-6 w-6 {{ $buku->is_favorite ? 'text-yellow-400 fill-current' : 'text-gray-400' }}" 
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
        </svg>
    </button>
</form>