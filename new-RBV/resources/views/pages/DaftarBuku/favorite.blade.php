@extends('layouts.app')

@section('content')
<div class="bg-[#F5F7FB] min-h-screen">
    <div class="max-full mx-auto px-8 py-12">

        <div class="flex flex-col md:flex-row items-center justify-between mb-10 gap-4">
            <h1 class="text-5xl font-extrabold text-[#2B3A8C] [text-shadow:_0px_4px_5px_rgb(0_0_0_/_20%)]">
                Buku Favorit
            </h1>
        </div>

        @if(!empty($books))
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($books as $buku)
            <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden flex flex-col border border-gray-100 relative">

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

                <div class="p-5 flex flex-col flex-grow text-center">
                    <h2 class="text-lg font-extrabold text-[#2B3A8C] mb-1 line-clamp-1">
                        {{ $buku->judul }}
                    </h2>
                    <p class="text-xs text-gray-500 mb-4">{{ $buku->penulis }}</p>

                    <div class="mt-auto">
                        <a href="{{ route('books.show', $buku->id_buku) }}"
                        class="block w-full py-2 bg-[#00A14C] text-white text-xs font-bold rounded-lg hover:bg-emerald-700 transition">
                            Detail Buku
                        </a>
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