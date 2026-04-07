@extends('layouts.app')

@section('content')

<div x-data="globalDelete()">

<div class="min-h-screen" style="background: linear-gradient(to bottom, #E0EDFF 0%, #FFFFFF 100%);">

    <div class="max-w-7xl mx-auto px-16 pt-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">

            <h1 class="font-poppins text-4xl font-extrabold text-[#2B3A8C]">
                Promkes
            </h1>

            <div class="flex items-center gap-8">

                <form method="GET" action="{{ route('promkes.index') }}" class="flex items-center gap-2">
                    <div class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari buku"
                            class="pl-4 sm:pl-5 pr-11 py-2.5 rounded-xl border border-gray-200 bg-white
                                    w-full sm:w-[240px] lg:w-[287px] h-[44px] sm:h-[49px]
                                    font-montserrat text-sm
                                    focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition-all">
                        <div class="absolute right-0 top-0 h-[44px] sm:h-[49px] w-[40px] sm:w-[43px]
                                    flex items-center justify-center
                                    bg-gray-100 rounded-r-xl text-gray-400
                                    group-focus-within:bg-[#2B3A8C] group-focus-within:text-white transition">
                            <img src="{{ asset('images/search-icon.jpg') }}" class="w-[20.505786895751953px] h-[20.5079345703125px]">
                        </div>
                    </div>
                </form>

                @auth
                    @if(in_array(auth()->user()->role, ['super_admin','admin']))
                        <a href="{{ route('promkes.create') }}"
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
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16 py-8 sm:py-10">

        @forelse ($promkes as $item)
        <div class="flex items-center gap-4 py-4 border-b border-gray-200">

            <div onclick="window.open('{{ $item->file ? asset('storage/' . $item->file) : '#' }}', '_blank')"
                class="flex items-center gap-4 flex-grow cursor-pointer group">

                <div class="flex-shrink-0 w-14 h-14">
                    <div class="w-14 h-14 bg-red-600 rounded flex flex-col items-center justify-center
                                transition duration-200 group-hover:scale-105 group-hover:shadow-md">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-6 h-6 text-white transition duration-200 group-hover:scale-110"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>

                        <span class="text-white text-[9px] font-bold mt-0.5
                                    transition duration-200 group-hover:scale-110">
                            PDF
                        </span>

                    </div>
                </div>

                <div class="flex-grow">
                    <p class="font-bold text-[18px] text-gray-800
                                transition duration-200 group-hover:text-blue-600">
                        {{ $item->judul }}
                    </p>
                    <p class="text-sm text-gray-400 mt-0.5">
                        Diunggah pada, {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('j F Y') }}
                    </p>
                </div>

            </div>

            <div class="flex items-center gap-8 flex-shrink-0">

                @if($item->file)
                <a href="{{ asset('storage/' . $item->file) }}"
                    download
                    class="p-2 bg-gray-300 text-white rounded-lg shadow hover:bg-gray-400 hover:scale-110 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </a>
                @endif

                @auth
                    @if(in_array(auth()->user()->role, ['super_admin','admin']))
                    <a href="{{ route('promkes.edit', $item->id_promkes) }}"
                        class="p-2 bg-[#00A14C] text-white rounded-lg shadow hover:scale-110 transition">
                        <img src="{{ asset('images/Edit.svg') }}" class="w-5 h-5">
                    </a>

                    <button @click="openDeleteModal({{ $item->id }})"
                        class="p-2 bg-red-500 text-white rounded-lg shadow hover:scale-110 transition">
                        <img src="{{ asset('images/Delete.svg') }}" class="w-5 h-5">
                    </button>
                    @endif
                @endauth

            </div>

        </div>
        @empty
        <div class="py-20 text-center">
            <p class="text-gray-500 italic">Data tidak ada.</p>
        </div>
        @endforelse

        @if($promkes->hasPages())
        <div class="mt-8">
            {{ $promkes->links() }}
        </div>
        @endif

    </div>
</div>

<template x-if="openDelete">
    <div @click.self="closeModal()"
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">
        <div class="bg-white rounded-[30px] p-10 max-w-sm w-full shadow-2xl text-center">
            <h2 class="text-2xl font-bold mb-2">Hapus</h2>
            <p class="text-gray-500 mb-6">Yakin ingin menghapus data ini?</p>

            <div class="flex gap-4">
                <button @click="closeModal()" class="bg-gray-400 text-white py-2 w-full rounded">
                    Tidak
                </button>
                <form :action="'/promkes/' + selectedId" method="POST" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white py-2 w-full rounded">
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