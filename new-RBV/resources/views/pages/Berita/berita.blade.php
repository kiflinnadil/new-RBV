@extends('layouts.app')

@section('content')
<div class="bg-[#F5F7FB] min-h-screen">

    <div class="max-w-7xl mx-auto px-16 pt-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <h1 class="text-5xl font-extrabold text-[#2B3A8C] [text-shadow:_0px_4px_5px_rgb(0_0_0_/_20%)]">
                {{ $kategori ?? 'Berita Terkini' }}
            </h1>

            <div class="flex items-center gap-4">
                <form method="GET" action="{{ URL::current() }}">
                    <select name="kategori" onchange="this.form.submit()"
                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-gray-600 shadow-sm outline-none">
                        <option value="">Kategori</option>
                        @foreach($kategoris as $item)
                            <option value="{{ $item }}" {{ (isset($kategori) && $kategori == $item) ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                    </select>
                </form>
                <a href="{{ route('berita.create') }}" class="flex items-center justify-center w-10 h-10 rounded-md border border-gray-300 bg-white text-gray-800 transition hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-16 py-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

            @forelse ($videoberita as $video)

            <div class="relative aspect-square bg-[#EFF4FF] rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden border border-white flex flex-col">
    
                <div class="relative h-2/5 w-full">
                    <img src="{{ asset('images/' . $video->cover) }}" 
                        class="w-full h-full object-cover" 
                        alt="Cover {{ $video->judul }}"
                        onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'">
                    
                    <div class="absolute top-3 right-3 z-20 flex flex-col gap-2">
                        <a href="{{ route('berita.edit', $video->id) }}" class="p-1.5 bg-[#00A14C] text-white rounded-lg shadow hover:scale-110 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                            </svg>
                        </a>
                        <form action="{{ route('berita.destroy', $video->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus?')" type="submit" class="p-1.5 bg-red-500 text-white rounded-lg shadow hover:scale-110 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="p-5 flex flex-col justify-between flex-grow">
                    <div>
                        <p class="text-[10px] text-[#00A14C] font-bold uppercase mb-1">
                            {{ $video->kategori }}
                        </p>
                        <h2 class="text-xl font-extrabold text-[#2B3A8C] leading-tight line-clamp-2">
                            {{ $video->judul }}
                        </h2>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ \Carbon\Carbon::parse($video->tanggal)->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed my-2">
                        {{ $video->deskripsi }} 
                    </p>

                    <div class="flex justify-center mt-auto">
                        <a href="{{ $video->link }}" target="_blank"
                        class="px-6 py-1.5 bg-[#00A14C] text-white text-[11px] font-bold rounded-lg hover:bg-emerald-600 transition shadow-md">
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
@endsection