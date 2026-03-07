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



        <div class="max-full mx-auto px-16 py-10">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-20">
                @forelse ($videoberita as $video)
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden flex flex-col">
                        
                        <div class="aspect-video w-full">
                            <iframe src="{{ $video->link }}"
                                    class="w-full h-full"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                            </iframe>
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