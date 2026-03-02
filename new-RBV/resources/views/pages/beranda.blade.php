@extends('layouts.app')

@section('content')
    <div class="relative w-full h-[520px] overflow-hidden">

        <div id="slider" class="flex transition-transform duration-700 ease-in-out h-full">
            <img src="{{ asset('images/image0.jpg') }}" class="w-full h-full object-cover flex-shrink-0">
            <img src="{{ asset('images/beranda.jpg') }}" class="w-full h-full object-cover flex-shrink-0">
            <img src="{{ asset('images/image2.jpg') }}" class="w-full h-full object-cover flex-shrink-0">
        </div>

        <div class="absolute inset-0 flex items-center">
            <div class="max-w-10xl mx-auto w-full px-10">
                <div class="max-w-xl text-white">
                    <h1 class="text-5xl font-semibold leading-tight mb-4">
                        Selamat Datang di,
                        <br>
                    </h1>
                    <h1 class="text-5xl font-extrabold leading-tight mb-4">
                        <span class="italic">Ruang Baca <br>Virtual</span>
                    </h1>

                    <p class="text-lg text-gray-200 mb-6">
                        Discover knowledge without limit.
                    </p>
                </div>
            </div>
        </div>

    </div>

    <div class="h-16 bg-blue-900"></div>

        <div class="px-16 py-30 bg-white bg-gradient-to-br from-blue-200 via-white to-pink-200 relative overflow-hidden">
        
            <div class="flex justify-center items-center mb-12 relative z-10">
                <h1 class="text-5xl font-extrabold text-blue-900 [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)] tracking-tight">
                    Rekomendasi Buku
                </h1>
            </div>

            <div class="swiper mySwiper px-10 relative z-10">
                <div class="swiper-wrapper">
                    @foreach ($books as $buku)
                        <div class="swiper-slide flex justify-center pb-10"> 
                            <a href="{{ route('books.show', $buku->id_buku) }}" class="block group">
                                <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] p-5 border border-gray-50 w-64 transform transition duration-300 group-hover:-translate-y-2 group-hover:shadow-xl">
                                    
                                    <div class="overflow-hidden rounded-xl mb-4">
                                        <img src="{{ asset('images/'. $buku->cover) }}" 
                                            class="w-full h-56 object-cover shadow-sm group-hover:scale-105 transition duration-300">
                                    </div>

                                    <h3 class="font-bold text-lg text-blue-950 leading-tight mb-1 line-clamp-2 min-h-[3.5rem]">
                                        {{ $buku->judul }}
                                    </h3>

                                    <p class="text-xs font-semibold text-gray-400 mb-4 uppercase tracking-wider line-clamp-1">
                                        {{ $buku->penulis ?? 'Author Name' }}
                                    </p>
                                    
                                    <button class="w-full py-2 bg-emerald-500 text-white text-sm font-bold rounded-lg hover:bg-emerald-600 transition">
                                        Baca Sekarang
                                    </button>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
    
            
            <div class="swiper-pagination !-bottom-2"></div>
        </div>
    </div>


    
    <div id="fasilitasSection" class="py-16"style="background: linear-gradient(180deg, #E8EAFF 0%, #D6D9F7 100%);">
        
        <div class="max-w-6xl mx-auto px-8 text-center mb-12">
            <h2 class="text-4xl font-extrabold text-[#2B3A8C] [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)] tracking-tight mb-4">
                Fasilitas Yang Tersedia
            </h2>
            <p class="text-gray-500 max-w-2xl mx-auto">
                Kami menyediakan berbagai Fasilitas Unggulan untuk kenyamanan dan keamanan pasien.
            </p>
        </div>
        
        <div class="max-w-6xl mx-auto px-4">
            <div class="swiper swiper-fasilitas">
                <div class="swiper-wrapper">

                    @foreach ([
                        ['img' => 'lab.png', 'title' => 'Layanan Laboratorium'],
                        ['img' => 'radiologi.png', 'title' => 'Layanan Radiologi'],
                        ['img' => 'farmasi.png', 'title' => 'Layanan Farmasi'],
                        ['img' => 'igd.png', 'title' => 'Instalasi Gawat Darurat'],
                        ] as $item)

                    <div class="swiper-slide flex justify-center">
                        <div class="card-fasilitas bg-white rounded-3xl shadow-md p-6 text-center">
                            <div class="flex justify-center mb-4">
                                <img src="{{ asset('images/' . $item['img']) }}"
                                class="w-28 h-28 object-contain">
                            </div>
                            <h3 class="font-bold text-base text-gray-800 mb-2">
                                {{ $item['title'] }}
                            </h3>
                            <p class="text-sm text-gray-500">
                                Dilengkapi peralatan pemeriksaan terbaru
                            </p>
                        </div>
                    </div>
                    
                    @endforeach
                    
                </div>
                
                <div class="swiper-pagination mt-10"></div>
            </div>
        </div>
    </div>
    
    <div class="px-16 py-30 bg-white bg-gradient-to-br from-blue-200 via-white to-pink-200 relative overflow-hidden">
    
        <div class="max-w-6xl mx-auto px-8 text-center mb-12">
            <h2 class="text-4xl font-extrabold text-[#2B3A8C] [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)] tracking-tight mb-4">
                Statistik Pengunjung 
            </h2>
            <p class="text-gray-500 max-w-2xl mx-auto">
                Pantau Statistik Pengunjung Ruang Baca Virtual 
            </p>
        </div>
    
        <div class="px-10 mt-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    
                <div class="bg-gray-100 rounded-xl shadow-md p-4 h-64">
                    <h5 class="font-bold text-blue-900 mb-2">
                        Statistik Pengunjung
                    </h5>
                    <div class="relative h-48">
                        <canvas id="chartKunjungan"></canvas>
                    </div>
                </div>
    
                <div class="bg-gray-100 rounded-xl shadow-md p-4 h-64">
                        <h5 class="font-bold text-blue-900 mb-2">
                            Trend Buku
                        </h5>
                        <div class="relative h-48">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.kunjunganData = @json($dataKunjungan);
    window.labels = @json($labels);
    </script>

@endsection