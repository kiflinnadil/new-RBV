@extends('layouts.app')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(to bottom,#E0EDFF 0%,#FFFFFF 100%);">

    <div class="max-w-7xl mx-auto px-8 pt-12 pb-6">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">

            <h1 class="text-5xl font-extrabold text-[#2B3A8C] [text-shadow:_0px_4px_5px_rgb(0_0_0_/_20%)]">
                Buku Favorit
            </h1>

            
        </div>

    </div>
    
    <div class="max-w-7xl mx-auto px-8 py-10">
        
        @if(!empty($books))
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10 ">

            @foreach ($books as $buku)
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden flex flex-col border border-white p-5 group">

                <div class="relative aspect-[3/4] w-full rounded-2xl overflow-hidden shadow-inner bg-gray-50">
                    <img src="{{ asset('images/'.$buku->cover) }}" 
                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500" 
                        alt="{{ $buku->judul }}">
                        
                        <form action="{{ route('books.favorite', $buku->id_buku) }}" method="POST" class="absolute top-3 right-3 z-10">
                            @csrf
                            <button type="submit" class="bg-white/80 p-2 rounded-full shadow-sm hover:scale-110 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="h-6 w-6 text-yellow-400 fill-current" 
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                </svg>
                            </button>
                        </form>

                        <div class="aspect-[3/4] w-full overflow-hidden">
                            <img src="{{ asset('images/'.$buku->cover) }}" class="w-full h-full object-cover">
                        </div>

                </div>
                
                <div class="pt-6 pb-2 flex flex-col flex-grow text-center">

                    <h2 class="text-xl font-extrabold text-[#2B3A8C] leading-tight mb-1 line-clamp-2">
                        {{ $buku->judul }}
                    </h2>
                    <p class="text-sm font-bold text-black opacity-80 mb-6">
                        {{ $buku->penulis }}
                    </p>

                    <div class="mt-auto px-2">
                        <button onclick="document.getElementById('modal-{{ $buku->id_buku }}').showModal()" 
                                class="block w-full py-2.5 bg-[#00A14C] text-white text-[13px] font-bold rounded-xl hover:bg-[#008a41] transition shadow-md">
                            Detail Buku
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @else
        <div class="flex flex-col items-center justify-center py-32 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-300 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
            </svg>
            <p class="text-2xl font-bold text-gray-400 mb-2">Belum ada buku favorit</p>
            <p class="text-gray-400 text-sm mb-8">Tambahkan buku ke favorit dengan menekan ikon bintang</p>
            <a href="{{ route('books.index') }}" 
               class="px-6 py-3 bg-[#00A14C] text-white font-bold rounded-xl hover:bg-emerald-700 transition">
                Jelajahi Buku
            </a>
        </div>
        @endif

    </div>
</div>
@endsection