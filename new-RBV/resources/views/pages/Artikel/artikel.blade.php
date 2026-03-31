@extends('layouts.app')

@section('content')

<div x-data="globalDelete()">

<div class="min-h-screen" style="background: linear-gradient(to bottom, #E0EDFF 0%, #FFFFFF 100%);">

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16 pt-8 sm:pt-10">
        <div class="flex items-center justify-between gap-4">

            <h1 class="font-poppins font-extrabold text-[#2B3A8C]
                       text-2xl sm:text-3xl lg:text-4xl">
                Artikel
            </h1>

            @auth
                @if(auth()->user()->role == 'super_admin')
                    <a href="{{ route('artikel.create') }}"
                        class="flex items-center justify-center flex-shrink-0
                               w-[44px] h-[44px] sm:w-[47px] sm:h-[49px]
                               rounded-md border border-gray-300 bg-white text-[#606060]
                               transition hover:scale-110 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="3" d="M12 4v16m8-8H4"/>
                        </svg>
                    </a>
                @endif
            @endauth
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16 py-8 sm:py-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 lg:gap-10">

            @foreach ($artikels as $artikel)

            <div class="bg-[#EFF4FF] rounded-2xl shadow-lg overflow-hidden flex flex-col">

                <div class="relative w-full aspect-[16/9] sm:aspect-[4/3]">
                    <img src="{{ asset('storage/'.$artikel->cover) }}"
                        class="w-full h-full object-cover"
                        onerror="this.src='https://via.placeholder.com/400x300'">

                    @auth
                        @if(auth()->user()->role == 'super_admin')
                        <div class="absolute top-2 right-2 sm:top-3 sm:right-3 z-20 flex flex-col gap-1.5 sm:gap-2">
                            <a href="{{ route('artikel.edit', $artikel->id_artikel) }}"
                                class="p-1.5 bg-[#00A14C] text-white rounded-lg shadow hover:scale-110 transition">
                                <img src="{{ asset('images/edit.png') }}" class="w-4 h-4 sm:w-5 sm:h-5 object-contain">
                            </a>
                            <button @click="openDeleteModal({{ $artikel->id_artikel }})"
                                class="p-1.5 bg-red-500 text-white rounded-lg shadow hover:scale-110 transition">
                                <img src="{{ asset('images/delete.png') }}" class="w-4 h-4 sm:w-5 sm:h-5 object-contain">
                            </button>
                        </div>
                        @endif
                    @endauth
                </div>

                <div class="p-4 sm:p-5 flex flex-col flex-grow">
                    <h2 class="font-poppins font-bold text-[#2B3A8C] mb-1 line-clamp-2
                               text-base sm:text-lg lg:text-xl">
                        {{ $artikel->judul }}
                    </h2>

                    <p class="text-xs text-gray-400 mb-2">
                        {{ \Carbon\Carbon::parse($artikel->tanggal)->translatedFormat('d F Y') }}
                    </p>

                    <p class="text-xs sm:text-sm text-gray-600 mb-3 line-clamp-2">
                        {{ $artikel->deskripsi }}
                    </p>

                    <div class="mt-auto text-center pt-1">
                        <a href="{{ route('artikel.read', $artikel->id_artikel) }}" target="_blank"
                            class="inline-block px-4 sm:px-5 py-2 bg-[#00A14C] text-white font-poppins font-semibold rounded-lg hover:bg-[#008a41] transition text-xs sm:text-sm">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>

            </div>

            @endforeach

        </div>

        @if($artikels->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 sm:py-32 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 sm:h-20 sm:w-20 text-gray-300 mb-4 sm:mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="font-montserrat font-bold text-gray-400 text-lg sm:text-2xl mb-2">Belum ada artikel</p>
            <p class="text-gray-400 text-xs sm:text-sm">Artikel akan muncul di sini setelah ditambahkan.</p>
        </div>
        @endif

    </div>
</div>

<template x-if="openDelete">
    <div @click.self="closeModal()"
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">
        <div class="bg-white rounded-[24px] sm:rounded-[30px] p-7 sm:p-10 max-w-xs sm:max-w-sm w-full shadow-2xl text-center">
            <h2 class="font-extrabold text-gray-900 mb-2 text-2xl sm:text-3xl">Hapus</h2>
            <p class="text-gray-500 text-sm sm:text-base mb-6 sm:mb-8">Apa anda yakin ingin hapus?</p>
            <div class="flex gap-3 sm:gap-4">
                <button @click="closeModal()"
                    class="bg-gray-400 text-white font-bold py-2.5 sm:py-3 rounded-xl w-full text-sm sm:text-base">
                    Tidak
                </button>
                <form :action="'/artikel/' + selectedId" method="POST" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 text-white font-bold py-2.5 sm:py-3 rounded-xl w-full text-sm sm:text-base">
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
            this.selectedId = id;
            this.openDelete = true;
        },
        closeModal() {
            this.openDelete = false;
            this.selectedId = null;
        }
    }
}
</script>

@endsection