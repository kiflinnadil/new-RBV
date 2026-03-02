@extends('layouts.app')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-4 gap-8">

    @foreach ($videoberita as $video)
        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden">
            <iframe src="{{ $video->link }}" class="w-full h-56"></iframe>
            <a href="{{ route('berita.show', $video->id) }}" class="block group">

                <div class="p-5">
                    <p class="text-sm text-emerald-500 font-semibold mb-1">
                        {{ $video->kategori }}
                    </p>

                    <h2 class="text-lg font-extrabold text-blue-900 mb-2">
                        {{ Str::limit($video->judul, 25) }}
                    </h2>

                    <p class="text-sm text-gray-500 mb-3">
                        {{ $video->tanggal }}
                    </p>

                    <p class="text-sm text-gray-600 mb-4">
                        {{ Str::limit($video->deskripsi, 80) }}
                    </p>

                    <button class="w-full py-2 bg-emerald-500 text-white text-sm font-bold rounded-lg hover:bg-emerald-600 transition">
                        Baca Selengkapnya
                    </button>
                </div>
            </a>

        </div>
    @endforeach

</div>

@endsection