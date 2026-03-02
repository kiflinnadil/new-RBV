@extends('layouts.app')

@section('content')

<div class="px-16 py-16">

    <div class="flex justify-between items-center mb-12">
        <div class="flex items-center">
            <div class="w-1 h-8 bg-blue-700 mr-4"></div>
            <h1 class="text-3xl font-extrabold text-gray-900">
                Daftar Koleksi
            </h1>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

        @foreach ($books as $buku)
        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden">

            <img src="{{ asset('storage/'.$buku->cover) }}"
                 class="w-full h-56 object-cover">

            <div class="p-5">
                <p class="text-sm text-blue-600 font-semibold mb-1">
                    {{ $buku->kategori }}
                </p>

                <h2 class="text-lg font-bold mb-2">
                    {{ $buku->judul }}
                </h2>

                <p class="text-sm text-gray-500 mb-3">
                    {{ $buku->penulis }}
                </p>

                <p class="text-sm text-gray-600 mb-4">
                    {{ Str::limit($buku->deskripsi, 80) }}
                </p>

                <a href="{{ route('books.show', $buku->id_buku) }}"
                   class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Lihat Detail
                </a>
            </div>

        </div>
        @endforeach

    </div>

    <div class="mt-10">
        
    </div>

</div>

@endsection