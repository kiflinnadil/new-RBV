@extends('layouts.app')

@section('content')

<div x-data="globalDelete()">

<div class="min-h-screen" style="background: linear-gradient(to bottom, #E0EDFF 0%, #FFFFFF 100%);">

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16 pt-8 sm:pt-10">
        <div class="flex items-center justify-between gap-4">
            <h1 class="font-poppins text-4xl font-extrabold text-[#2B3A8C]">
                Artikel
            </h1>

            @auth
                @if(in_array(auth()->user()->role, ['super_admin','admin']))
                    <a href="{{ route('artikel.create') }}"
                        class="flex items-center justify-center w-[47px] h-[49px] rounded-md border border-gray-300 bg-white text-[#606060] transition hover:scale-110">
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

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16 py-8 sm:py-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 lg:gap-10">

            @foreach ($artikels as $artikel)

            <div class="relative aspect-square bg-[#EFF4FF] rounded-2xl shadow-lg overflow-hidden flex flex-col">

                <div class="relative h-[40%] w-full">
                    <img src="{{ asset('storage/'.$artikel->cover) }}"
                        class="w-full h-full object-cover"
                        onerror="this.src='https://via.placeholder.com/400x300'">

                    @auth
                    @if(in_array(auth()->user()->role, ['super_admin','admin']))
                    <div class="absolute top-3 right-3 z-20 flex flex-col gap-2">
                        <a href="{{ route('artikel.edit', $artikel->id_artikel) }}"
                            class="p-1.5 bg-[#00A14C] text-white rounded-lg shadow hover:scale-110 transition">
                            <img src="{{ asset('images/Edit.svg') }}" class="w-5 h-5 object-contain">
                        </a>
                        <button @click="openDeleteModal({{ $artikel->id_artikel }})"
                            class="p-1.5 bg-red-500 text-white rounded-lg shadow hover:scale-110 transition">
                            <img src="{{ asset('images/Delete.svg') }}" class="w-5 h-5 object-contain">
                        </button>
                    </div>
                    @endif
                    @endauth
                </div>

                <div class="p-5 flex flex-col flex-grow">
                    <h2 class="font-poppins text-xl font-bold text-[#2B3A8C]">
                        {{ $artikel->judul }}
                    </h2>
                    <p class="text-xs text-gray-400">
                        {{ \Carbon\Carbon::parse($artikel->tanggal)->translatedFormat('d F Y') }}
                    </p>
                    <p class="text-sm text-gray-600 my-2 line-clamp-2">
                        {{ $artikel->deskripsi }}
                    </p>
                    <div class="mt-auto text-center">
                        <a href="{{ route('artikel.read', $artikel->id_artikel) }}" target="_blank"
                            class="px-6 py-2 bg-[#00A14C] text-white font-bold rounded-lg hover:bg-emerald-600">
                            Baca Selengkapnya
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
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">
        <div class="bg-white rounded-[30px] p-10 max-w-sm w-full shadow-2xl text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Hapus</h2>
            <p class="text-gray-500 mb-8">Apa anda yakin ingin hapus?</p>
            <div class="flex gap-4">
                <button @click="closeModal()"
                    class="bg-gray-400 text-white font-bold py-3 rounded-xl w-full">
                    Tidak
                </button>
                <form :action="'/artikel/' + selectedId" method="POST" class="w-full">
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