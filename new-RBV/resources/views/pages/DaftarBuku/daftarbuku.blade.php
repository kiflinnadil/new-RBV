@extends('layouts.app')

@section('content')
    <div class="min-h-screen" style="background: linear-gradient(to bottom, #E0EDFF 0%, #FFFFFF 100%);">
        
        <div class="max-w-7xl mx-auto px-16 pt-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">

                <h1 class="font-poppins text-4xl font-extrabold text-[#2B3A8C] [text-shadow:_0px_4px_5px_rgb(0_0_0_/_20%)]">
                    Daftar Buku
                </h1>
    
                <div class="flex items-center gap-4">
                    <div class="relative group">
                        <input type="text" placeholder="Cari buku" 
                               class="pl-5 pr-12 py-2.5 rounded-xl border border-gray-200 bg-white w-72 font-montserrat focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition-all">
                        <div class="absolute right-0 top-0 h-full w-12 flex items-center justify-center bg-gray-100 rounded-r-xl text-gray-400 group-focus-within:bg-[#2B3A8C] group-focus-within:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>

                    <a href="{{ route('books.create') }}" 
                        class="flex items-center justify-center w-11 h-11 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition shadow-sm"
                        title="Tambah Data"> 
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-16 py-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
                
                @forelse ($books as $buku)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden flex flex-col border border-white p-5 pt-0.5 group">   
                    
                    <div class="relative aspect-[3/4] w-full rounded-2xl overflow-hidden shadow-inner bg-gray-50">
                        <img src="{{ asset('images/'.$buku->cover) }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500" 
                             alt="{{ $buku->judul }}">
                    </div>

                    <div class="pt-6 pb-2 flex flex-col flex-grow text-center">

                        <h2 class="font-poppins text-xl font-extrabold text-[#2B3A8C] leading-tight mb-1 line-clamp-2">
                            {{ $buku->judul }}
                        </h2>
                        <p class="font-poppins text-sm font-bold text-black opacity-80 mb-6">
                            {{ $buku->penulis }}
                        </p>

                        <div class="mt-auto px-2">
                            <button onclick="document.getElementById('modal-{{ $buku->id_buku }}').showModal()" 
                                    class="block w-full py-2.5 bg-[#00A14C] font-poppins text-white text-[13px] font-bold rounded-lg hover:bg-[#008a41] transition shadow-md">
                                Detail Buku
                            </button>
                        </div>
                    </div>

                    <dialog id="modal-{{ $buku->id_buku }}" 
                        class="rounded-[32px] p-0 backdrop:bg-black/50 shadow-2xl w-full max-w-2xl overflow-hidden
                        fixed inset-0 m-auto">
                        <div class="bg-white p-8 md:p-12 relative">
                            <button onclick="this.closest('dialog').close()" class="absolute top-5 right-5 text-gray-400 hover:text-black">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <div class="flex flex-col items-center">
                                <div class="w-48 md:w-64 aspect-[3/4] mb-8 shadow-2xl rounded-lg overflow-hidden">
                                    <img src="{{ asset('images/'.$buku->cover) }}" class="w-full h-full object-cover">
                                </div>

                                <div class="w-full text-left">
                                    <div class="flex justify-between items-start mb-1">
                                        <h1 class="font-poppins text-2xl font-bold text-black">{{ $buku->judul }}</h1>
                                        
                                        <div class="flex gap-2">
                                            <a href="{{ route('books.edit', $buku->id_buku) }}" class="p-2 bg-[#00A14C] text-white rounded-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                            </a>
                                            
                                            <form action="{{ route('books.delete', $buku->id_buku) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 bg-red-500 text-white rounded-md">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </form>

                                            <form action="{{ route('books.favorite', $buku->id_buku) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-white/80 p-2 rounded-full shadow-sm hover:scale-110 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                                        class="h-6 w-6 {{ $buku->is_favorite ? 'text-yellow-400 fill-current' : 'text-gray-400' }}" 
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <p class="font-poppins text-sm font-bold text-black">{{ $buku->penulis }}</p>
                                    <p class="font-poppins text-xs text-gray-400 mb-4">{{ $buku->tahun }}</p>

                                    <p class="font-poppins text-[13px] text-gray-500 leading-relaxed mb-10 text-justify">
                                        {{ $buku->deskripsi }}
                                    </p>

                                    <div class="flex justify-center">
                                        <a href="{{ route('books.read', $buku->id_buku) }}" class="px-10 py-2.5 bg-[#00A14C] font-poppins text-white font-bold rounded-lg text-sm">
                                            Baca Buku
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </dialog>
                </div>
                @empty
                    <div class="col-span-full text-center py-20 bg-white/50 rounded-[3rem] border-2 border-dashed border-blue-100">
                        <p class="text-gray-400 text-xl font-medium">Koleksi buku belum tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection