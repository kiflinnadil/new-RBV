@extends('layouts.app')

@section('content')

<div x-data="globalDelete()">

<div class="min-h-screen" style="background: linear-gradient(to bottom, #E0EDFF 0%, #FFFFFF 100%);">

    <div class="max-w-7xl mx-auto px-16 pt-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <h1 class="font-poppins text-4xl font-extrabold text-[#2B3A8C]">
                Video
            </h1>

            @auth
                @if(auth()->user()->role == 'super_admin')
                    <a href="{{ route('video.create') }}"
                        class="flex items-center justify-center w-10 h-10 rounded-md border border-gray-300 bg-white text-[#606060] transition hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="3" d="M12 4v16m8-8H4"/>
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
                $youtubeId = null;
                $tiktokId = null;
                $isInstagram = false;

                if (preg_match('/(youtube\.com\/watch\?v=|youtu\.be\/)([^\&\?\/]+)/', $video->file_url, $yt)) {
                    $youtubeId = $yt[2];
                }

                if (preg_match('/video\/(\d+)/', $video->file_url, $tt)) {
                    $tiktokId = $tt[1];
                }

                if (str_contains($video->file_url, 'instagram.com')) {
                    $isInstagram = true;
                }
            @endphp

            <div class="relative aspect-square bg-[#EFF4FF] rounded-[2rem] shadow-lg overflow-hidden flex flex-col">
                
                <div class="relative h-[180px] w-full overflow-hidden">

                    <a href="{{ $video->file_url }}" target="_blank" class="block w-full h-full">

                        @if($youtubeId)
                            <img src="https://img.youtube.com/vi/{{ $youtubeId }}/hqdefault.jpg"
                                class="w-full h-full object-cover">

                        @elseif(str_contains($video->file_url, 'tiktok.com'))

                            <div class="w-full h-full bg-black flex items-center justify-center relative">

                                <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="w-16 h-16 text-white opacity-80"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 3v12.5a2.5 2.5 0 11-2.5-2.5h1V10H6.5A5.5 5.5 0 1012 15.5V7.9a6.5 6.5 0 003.5 1V6a3.5 3.5 0 01-3.5-3H9z"/>
                                </svg>

                                <div class="absolute bottom-2 text-xs text-white bg-black/60 px-2 py-1 rounded">
                                    TikTok
                                </div>

                            </div>

                        @elseif($isInstagram)
                            <div class="w-full h-full bg-gradient-to-br from-pink-500 via-red-500 to-yellow-500 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="w-16 h-16 text-white"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M7.75 2C4.574 2 2 4.574 2 7.75v8.5C2 19.426 4.574 22 7.75 22h8.5C19.426 22 22 19.426 22 16.25v-8.5C22 4.574 19.426 2 16.25 2h-8.5z"/>
                                </svg>
                            </div>

                        @else
                            <img src="https://via.placeholder.com/400x300?text=No+Preview"
                                class="w-full h-full object-cover">
                        @endif

                        <div class="absolute inset-0 flex items-center justify-center bg-black/30 hover:bg-black/40 transition pointer-events-none">
                            <svg class="w-14 h-14 text-white drop-shadow-lg transform hover:scale-110 pointer-events-none"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6 4l10 6-10 6V4z"/>
                            </svg>
                        </div>

                    </a>

                    @auth
                    @if(auth()->user()->role == 'super_admin')
                    <div class="absolute top-3 right-3 z-20 flex flex-col gap-2">

                        <a href="{{ route('video.edit', $video->id_video) }}" 
                            class="p-1.5 bg-[#00A14C] text-white rounded-lg shadow hover:scale-110 transition">
                            <img src="{{ asset('images/edit.png') }}" class="w-5 h-5 object-contain">
                        </a>

                        <button @click="openDeleteModal({{ $video->id_video }})"
                            class="p-1.5 bg-red-500 text-white rounded-lg shadow hover:scale-110 transition">
                            <img src="{{ asset('images/delete.png') }}" class="w-5 h-5 object-contain">
                        </button>

                    </div>
                    @endif
                    @endauth

                </div>

                <div class="p-5 flex flex-col justify-between flex-grow">

                    <div>
                        <h2 class="font-poppins text-xl font-bold text-[#2B3A8C]">
                            {{ $video->judul }}
                        </h2>

                        <p class="text-xs text-gray-400">
                            {{ \Carbon\Carbon::parse($video->tanggal)->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <p class="text-sm text-gray-600 my-2 line-clamp-2">
                        {{ $video->deskripsi }}
                    </p>

                    <div class="flex justify-center mt-4">
                        <a href="{{ $video->file_url }}" target="_blank"
                            class="px-10 py-2 bg-[#00A14C] text-white text-sm font-bold rounded-lg hover:bg-emerald-600 transition shadow-md">
                            Lihat
                        </a>
                    </div>

                </div>

            </div>

            @endforeach

        </div>
    </div>
</div>

<template x-if="openDelete">
    <div @click.self="closeModal()"
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm">

        <div class="bg-white rounded-[30px] p-10 max-w-sm w-full shadow-2xl text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Hapus</h2>
            <p class="text-gray-500 mb-8">Apa anda yakin ingin hapus?</p>

            <div class="flex gap-4">
                <button @click="closeModal()"
                    class="bg-gray-400 text-white font-bold py-3 rounded-xl w-full">
                    Tidak
                </button>

                <form :action="'/video/' + selectedId" method="POST" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-600 text-white font-bold py-3 rounded-xl w-full">
                        Ya
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

</div>

<script>
function globalDelete() {
    return {
        openDelete: false,
        selectedId: null,

        openDeleteModal(id) {
            this.selectedId = id
            this.openDelete = true
        },

        closeModal() {
            this.openDelete = false
            this.selectedId = null
        }
    }
}
</script>

@endsection