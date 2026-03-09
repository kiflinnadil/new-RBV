@extends('layouts.app')

@section('content')
    <div class="bg-[#F5F7FB] min-h-screen">

        <div class="max-full mx-auto px-2 py-0 pt-10 pr-16 pl-16">
            <div class="flex flex-col md:flex-row items-center justify-between mb-0 gap-4">
                <h1 class="text-5xl font-extrabold text-[#2B3A8C] [text-shadow:_0px_4px_5px_rgb(0_0_0_/_20%)]">
                    {{ $kategori ?? 'Berita Terkini' }}
                </h1>
    
                <div class="flex items-center gap-4">
                    <form method="GET" action="{{ URL::current() }}">
                        <select name="kategori"
                        onchange="this.form.submit()"
                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-gray-600 shadow-sm focus:ring-2 focus:ring-blue-600 outline-none">
                        
                        <option value="">Kategori</option>
                        @foreach($kategoris as $item)
                        <option value="{{ $item }}" {{ (isset($kategori) && $kategori == $item) ? 'selected' : '' }}>
                            {{ $item }}
                        </option>
                        @endforeach
                        </select>
                    </form>
                    
                    <a href="{{ route('berita.create') }}" 
                        class="flex items-center justify-center w-10 h-10 rounded-md border border-gray-300 bg-white text-gray-800 transition hover:scale-110"
                        title="Tambah Berita Baru"> 
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>        


        <div class="max-w-[1440px] mx-auto px-10 py-10"> <div class="grid grid-cols-1 md:grid-cols-3 gap-12 px-2"> @forelse ($videoberita as $video)
            <div class="bg-white rounded-[40px] shadow-[0_15px_40px_rgba(0,0,0,0.08)] overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_25px_60px_rgba(0,0,0,0.15)]">
                
                <div class="relative w-full aspect-square overflow-hidden bg-gray-100">
                    <div class="absolute top-5 right-5 z-10 flex flex-col gap-3">
                        <a href="#" class="p-2.5 bg-[#00A14C] text-white rounded-xl shadow-lg hover:scale-110 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </a>
                        <form action="{{ route('berita.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-[#E11D48] text-white rounded-lg shadow-md hover:scale-110 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </div>

                    <div class="aspect-[4/3] w-full bg-gray-200 overflow-hidden">
                        <img src="{{ asset('storage/' . $video->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $video->judul }}">
                    </div>

                        <div class="p-5 flex flex-col flex-grow">
                            <p class="text-sm text-[#00A14c] font-semibold mb-1">
                                {{ $video->kategori }}
                            </p>

                            <h2 class="text-lg font-extrabold text-blue-900 mb-2 line-clamp-2">
                                {{ $video->judul }}
                            </h2>

                            <p class="text-sm text-gray-500 mb-2">
                                {{ \Carbon\Carbon::parse($video->tanggal)->translatedFormat('d F Y') }}
                            </p>

                            <p class="text-sm text-gray-600 mb-6 line-clamp-3">
                                {{ $video->deskripsi }}
                            </p>

                            <div class="mt-auto">
                                <a href="{{ route('berita.show', $video->id) }}"
                                class="block w-full text-center py-2 bg-[#00A14C] text-white text-sm font-bold rounded-lg hover:bg-emerald-600 transition shadow-md">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <p class="text-gray-500 text-xl italic">Tidak ada berita pada kategori ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection