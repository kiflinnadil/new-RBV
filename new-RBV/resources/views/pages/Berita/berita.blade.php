@extends('layouts.app')

@section('content')

<div x-data="globalDelete()">

<div class="min-h-screen" style="background: linear-gradient(to bottom, #E0EDFF 0%, #FFFFFF 100%);">

    <div class="max-w-7xl mx-auto px-16 pt-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">

            <h1 class="font-poppins text-4xl font-extrabold text-[#2B3A8C]">
                {{ $kategori ?? 'Berita Terkini' }}
            </h1>

            <div class="flex items-center gap-4">
                <form method="GET" action="{{ URL::current() }}">
                    <select name="kategori" onchange="this.form.submit()"
                        class="rounded-md border border-gray-300 bg-white px-[14px] py-2 text-gray-600 shadow-sm outline-none">
                        <option value="">Kategori</option>
                        @foreach($kategoris as $item)
                            <option value="{{ $item }}" {{ (isset($kategori) && $kategori == $item) ? 'selected' : '' }}>
                                {{ $item }}
                            </option>
                        @endforeach
                    </select>
                </form>

                @auth
                    @if(auth()->user()->role == 'super_admin')
                        <a href="{{ route('berita.create') }}"
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
    </div>

    <div class="max-w-7xl mx-auto px-16 py-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

            @forelse ($berita as $berita)

            <div class="relative aspect-square bg-[#EFF4FF] rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden border border-white flex flex-col">
    
                <div class="relative h-[40%] w-full">
                    <img src="{{ asset('storage/' . $berita->cover) }}" 
                        class="w-full h-full object-cover"
                        onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'">

                    @auth
                    @if(auth()->user()->role == 'super_admin')

                    <div class="absolute top-3 right-3 z-20 flex flex-col gap-2">

                        <a href="{{ route('berita.edit', $berita->id_berita) }}"
                            class="p-1.5 bg-[#00A14C] text-white rounded-lg shadow hover:scale-110 transition">
                            <img src="{{ asset('images/edit.png') }}" class="w-5 h-5 object-contain">
                        </a>

                        <button @click="openDeleteModal({{ $berita->id_berita }})"
                            class="p-1.5 bg-red-500 text-white rounded-lg shadow hover:scale-110 transition">
                            <img src="{{ asset('images/delete.png') }}" class="w-5 h-5 object-contain">
                        </button>

                    </div>

                    @endif
                    @endauth

                </div>

                <div class="p-5 flex flex-col justify-between flex-grow">

                    <div>
                        <p class="font-montserrat text-[10px] text-[#00A14C] font-bold uppercase mb-1">
                            {{ $berita->kategori }}
                        </p>

                        <h2 class="font-poppins text-xl font-bold text-[#2B3A8C] leading-tight line-clamp-2">
                            {{ $berita->judul }}
                        </h2>

                        <p class="font-montserrat text-xs text-gray-400 mt-1">
                            {{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <p class="font-montserrat text-sm text-gray-600 line-clamp-2 leading-relaxed my-2">
                        {{ $berita->deskripsi }} 
                    </p>

                    <div class="flex justify-center mt-auto">
                        <a href="{{ $berita->file_url }}" target="_blank"
                            class="px-6 py-1.5 bg-[#00A14C] font-poppins text-white text-[14px] font-bold rounded-lg hover:bg-emerald-600 transition shadow-md">
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
    <div
        @click.self="closeModal()"
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">

        <div class="bg-white rounded-[30px] p-10 max-w-sm w-full shadow-2xl text-center">

            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Hapus</h2>
            <p class="text-gray-500 mb-8">Apa anda yakin ingin hapus?</p>

            <div class="flex gap-4">
                <button @click="closeModal()"
                    class="bg-gray-400 text-white font-bold py-3 rounded-xl w-full">
                    Tidak
                </button>

                <form :action="'/berita/' + selectedId" method="POST" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 text-white font-bold py-3 rounded-xl w-full">
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