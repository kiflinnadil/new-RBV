@extends('layouts.app')

@section('content')

<div class="px-16 py-16">

    <div class="bg-white rounded-2xl shadow-lg p-10 grid md:grid-cols-2 gap-12">

        <div>
            <img src="{{ asset('storage/'.$book->cover) }}"
                 class="rounded-xl shadow-md w-full object-cover">
        </div>

        <div>

            <h1 class="text-4xl font-bold mb-6">
                {{ $book->judul }}
            </h1>

            <div class="space-y-4 text-gray-700">

                <div>
                    <span class="font-semibold text-gray-900">Penulis:</span>
                    {{ $book->penulis }}
                </div>

                <div>
                    <span class="font-semibold text-gray-900">Tahun:</span>
                    {{ $book->tahun }}
                </div>

                <div>
                    <span class="font-semibold text-gray-900">Kategori:</span>
                    {{ $book->kategori }}
                </div>

                <div>
                    <span class="font-semibold text-gray-900">Deskripsi:</span>
                    <p class="mt-2 leading-relaxed">
                        {{ $book->deskripsi }}
                    </p>
                </div>

                <a href="{{ $book->file_pdf }}"
                    target="_blank"
                    class="inline-block mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        📖 Baca Buku
                </a>

            </div>

            <a href="/"
               class="inline-block mt-8 bg-gray-800 text-white px-6 py-2 rounded-lg hover:bg-gray-900 transition">
                ← Kembali
            </a>

        </div>

    </div>

</div>

@endsection