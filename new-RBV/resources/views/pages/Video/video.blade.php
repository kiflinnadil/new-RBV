@extends('layouts.app')

@section('content')
<div class="bg-[#F5F7FB] min-h-screen">

    <div class="max-w-7xl mx-auto px-16 pt-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <h1 class="font-poppins text-4xl font-extrabold text-[#2B3A8C] [text-shadow:_0px_4px_5px_rgb(0_0_0_/_20%)]">
                Video
            </h1>
            @auth
                @if(auth()->user()->role == 'super_admin')
                    <a href="{{ route('video.create') }}" 
                    class="flex items-center justify-center w-10 h-10 rounded-md border border-gray-300 bg-white text-gray-800 transition hover:scale-110 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                        </svg>
                    </a>
                @endif
            @endauth
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-16 py-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

            @foreach ($videos as $video)

                @php
                    preg_match('/(youtube\.com\/embed\/|youtube\.com\/watch\?v=|youtu\.be\/)([^\&\?\/]+)/', $video->file_url, $matches);
                    $youtubeId = $matches[2] ?? null;
                @endphp

                <div class="relative aspect-square bg-[#EFF4FF] rounded-[2rem] shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden border border-white flex flex-col">
                    
                    <div class="relative h-[180px] w-full overflow-hidden">

                        @if($youtubeId)
                            <img 
                                src="https://img.youtube.com/vi/{{ $youtubeId }}/hqdefault.jpg"
                                class="w-full h-full object-cover"
                            >

                            <a href="{{ route('video.show', $video->id_video) }}"
                                class="absolute inset-0 flex items-center justify-center bg-black/30 hover:bg-black/40 transition">

                                <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6 4l10 6-10 6V4z"/>
                                </svg>

                            </a>
                        @endif

                        @auth
                            @if(auth()->user()->role == 'super_admin')
                                <div class="absolute top-3 right-3 z-20 flex flex-col gap-2">
                                    <a href="{{ route('video.edit', $video->id_video) }}" 
                                        class="p-1.5 bg-[#00A14C] text-white rounded-lg shadow hover:scale-110 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('video.destroy', $video->id_video) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Yakin Hapus?')" type="submit" 
                                                class="p-1.5 bg-red-500 text-white rounded-lg shadow hover:scale-110 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth

                    </div>

                    <div class="p-5 flex flex-col justify-between flex-grow">

                        <div>
                            <h2 class="font-poppins text-xl font-bold text-[#2B3A8C] leading-tight">
                                {{ $video->judul }}
                            </h2>
                            <p class="font-montserrat text-xs text-gray-400 mt-1">
                                {{ \Carbon\Carbon::parse($video->tanggal)->translatedFormat('d F Y') }}
                            </p>
                        </div>
                            <p class="font-montserrat text-sm text-gray-600 line-clamp-2 leading-relaxed my-2">
                                {{ $video->deskripsi }}
                            </p>

                        <div class="flex justify-center mt-4">
                            <a href="{{ route('video.show', $video->id_video) }}"
                                class="px-10 py-2 bg-[#00A14C] font-poppins text-white text-sm font-bold rounded-lg hover:bg-emerald-600 transition shadow-md">
                                Lihat
                            </a>
                        </div>

                    </div>

                </div>

            @endforeach

        </div>
    </div>
</div>
@endsection