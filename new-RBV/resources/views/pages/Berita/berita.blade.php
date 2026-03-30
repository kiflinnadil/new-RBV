@extends('layouts.app')

@section('content')

<div x-data="globalDelete()">

<div class="min-h-screen" style="background: linear-gradient(to bottom, #E0EDFF 0%, #FFFFFF 100%);">

    <div class="max-w-7xl mx-auto px-16 pt-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">

            <h1 class="font-poppins text-4xl font-extrabold text-[#2B3A8C]">
                {{ $kategori ?? 'Berita Terkini' }}
            </h1>

            <div class="flex items-center gap-8">
                
                <form method="GET" action="{{ URL::current() }}">
                    
                    <div x-data="{ open: false, selected: '{{ $kategori ?? 'Kategori' }}' }" class="relative w-[180px]">

                        <button type="button"
                            @click="open = !open"
                            class="w-[197px] h-[49px] bg-[#F5F5F5] bg-white border border-gray-400 rounded-[5px] px-3 py-2
                                text-gray-600 text-sm font-serial font-montserrat text-[20px]
                                flex justify-between items-center shadow-sm">

                            <span x-text="selected"></span>

                            <img src="{{ asset('images/Vector.svg') }}"
                                class="w-[12px] h-[6px] transition-transform duration-300"
                                :class="open ? 'rotate-180' : ''">
                        </button>

                        <div x-show="open"
                            @click.outside="open = false"
                            x-transition
                            class="absolute w-[197px] mt-2 bg-white border border-gray-300 rounded-[5px] shadow-lg z-50 overflow-hidden font-montserrat">

                            <div 
                                @click="selected='Kategori'; open=false; $refs.input.value=''; $el.closest('form').submit()"
                                class="px-3 py-2 hover:bg-gray-200 cursor-pointer text-[20px] text-gray-600">
                                Semua
                            </div>

                            @foreach($kategoris as $item)
                                <div 
                                    @click="selected='{{ $item }}'; open=false; $refs.input.value='{{ $item }}'; $el.closest('form').submit()"
                                    class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-[20px] text-gray-600">
                                    {{ $item }}
                                </div>
                            @endforeach

                        </div>

                        <input type="hidden" name="kategori" x-ref="input" value="{{ $kategori }}">

                    </div>

                </form>

                @auth
                    @if(auth()->user()->role == 'super_admin')
                        <a href="{{ route('berita.create') }}"
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

    <div class="max-w-7xl mx-auto px-16 py-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

            @forelse ($berita as $berita)

            <div class="relative aspect-square bg-[#EFF4FF] rounded-2xl shadow-lg hover:shadow-2xl transition overflow-hidden flex flex-col">
    
                <div class="relative h-[40%] w-full">
                    <img src="{{ asset('storage/' . $berita->cover) }}" 
                        class="w-full h-full object-cover"
                        onerror="this.src='https://via.placeholder.com/400x300'">

                    @auth
                    @if(auth()->user()->role == 'super_admin')
                    <div class="absolute top-3 right-3 z-20 flex flex-col gap-2">

                        <a href="{{ route('berita.edit', $berita->id_berita) }}"
                            class="p-1.5 bg-[#00A14C] text-white rounded-lg shadow hover:scale-110 transition">
                            <img src="{{ asset('images/edit.png') }}" class="w-5 h-5">
                        </a>

                        <button @click="openDeleteModal({{ $berita->id_berita }})"
                            class="p-1.5 bg-red-500 text-white rounded-lg shadow hover:scale-110 transition">
                            <img src="{{ asset('images/delete.png') }}" class="w-5 h-5">
                        </button>

                    </div>
                    @endif
                    @endauth
                </div>

                <div class="p-5 flex flex-col flex-grow">

                    <div>
                        <p class="text-[10px] text-[#00A14C] font-bold uppercase">
                            {{ $berita->kategori }}
                        </p>

                        <h2 class="text-xl font-bold text-[#2B3A8C] line-clamp-2">
                            {{ $berita->judul }}
                        </h2>

                        <p class="text-xs text-gray-400">
                            {{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <p class="text-sm text-gray-600 line-clamp-2 my-2">
                        {{ $berita->deskripsi }}
                    </p>

                    <div class="mt-auto text-center">
                        <a href="{{ $berita->file_url }}" target="_blank"
                            class="px-6 py-2 bg-[#00A14C] text-white font-bold rounded-lg hover:bg-emerald-600">
                            Baca Selengkapnya
                        </a>
                    </div>

                </div>
            </div>

            @empty
            <div class="col-span-full text-center py-20">
                <p class="text-gray-500 italic">Data tidak ada.</p>
            </div>
            @endforelse

        </div>
    </div>
</div>

<template x-if="openDelete">
    <div @click.self="closeModal()"
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50">

        <div class="bg-white rounded-3xl p-10 w-full max-w-sm text-center">

            <h2 class="text-2xl font-bold mb-2">Hapus</h2>
            <p class="text-gray-500 mb-6">Yakin hapus?</p>

            <div class="flex gap-4">
                <button @click="closeModal()" class="bg-gray-400 text-white py-2 w-full rounded">
                    Tidak
                </button>

                <form :action="'/berita/' + selectedId" method="POST" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-600 text-white py-2 w-full rounded">
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