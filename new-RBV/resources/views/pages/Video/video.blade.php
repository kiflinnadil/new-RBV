@extends('layouts.app')

@section('content')
    <div class="bg-[#F5F7FB] min-h-screen">

        <div class="max-full mx-auto px-2 py-0 pt-10 pr-16 pl-16">

            <div class="flex flex-col md:flex-row items-center justify-between mb-0 gap-4">
                <h1 class="text-5xl font-extrabold text-[#2B3A8C] [text-shadow:_0px_4px_5px_rgb(0_0_0_/_20%)]">
                    Video
                </h1>
            </div>

        </div>   
        <div class="max-full mx-auto px-16 py-10">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-20">

            @foreach ($videos as $video)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden flex flex-col">
                    
                    <div class="aspect-video w-full">
                        <a href="{{ route('video.show', $video->id) }}"
                        class="inline-block bg-white text-gray-800 px-4 py-2 rounded-lg ">

                            <iframe src="{{ $video->link }}"
                                    class="w-full h-full"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                            </iframe>
                        
                            <h2 class="text-lg font-extrabold text-blue-900 mb-2 line-clamp-2">
                                {{ $video->judul }}
                            </h2>

                            <p class="text-sm text-gray-600 mb-6 line-clamp-3">
                                {{ $video->deskripsi }}
                            </p>

                            <div class="mt-auto">
                                <a href="{{ route('berita.show', $video->id) }}"
                                class="block w-full text-center py-2 bg-[#00A14C] text-white text-sm font-bold rounded-lg hover:bg-emerald-600 transition shadow-md">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </a>
                    </div>

                </div>
                
            @endforeach

        </div>

    </div>

@endsection