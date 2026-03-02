@extends('layouts.app')

@section('content')
    
    <div class="flex justify-between items-center mb-12">
        <div class="flex- items-center">
            <div class="w-1 h-8 bg-blue-700 mr-4"></div>
            <h1 class="text-xl font-extrabold text-gray-900">
                Video
            </h1>

        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

        @foreach ($videos as $video)
            <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden">
                <a href="{{ route('video.show', $video->id) }}"
                    class="inline-block bg-white text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition">

                    <iframe src="{{ $video->link }}" class="w-full h-56"></iframe>
        
                    <div class="p-5">
        
                        <h2 class="text-lg font-bold mb-2">
                            {{ $video->judul }}
                        </h2>
        
                        <p class="text-sm text-blue-600 font-semibold mb-1">
                            {{ $video->tanggal }}
                        </p>
        
                        <p class="text-sm text-gray-600 font-semibold mb-1">
                            {{ $video->deskripsi }}
                        </p>
                    </div>


                </a>


            </div>
        @endforeach

    </div>

@endsection