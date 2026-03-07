@extends('layouts.app')

@section('content')
    {{-- <div class="relative w-full h-[681px] overflow-hidden"> --}}
    <div class="relative w-full h-screen overflow-hidden">

        <div id="slider" class="relative z-0 flex transition-transform duration-700 ease-in-out h-full">
            <img src="{{ asset('images/image0.jpg') }}" class="w-full h-full object-cover flex-shrink-0">
            <img src="{{ asset('images/beranda.jpg') }}" class="w-full h-full object-cover flex-shrink-0">
            <img src="{{ asset('images/image2.jpg') }}" class="w-full h-full object-cover flex-shrink-0">
        </div>

        <div class="blue-overlay"></div>

        <div class="absolute inset-0 flex items-center z-20">
            <div class="max-w-10xl mx-auto w-full px-10">
                <div class="max-w-xl text-white">
                    <h1 class="text-5xl font-base leading-tight mb-0">
                        Selamat Datang di,
                        <br>
                    </h1>
                    <h1 class="text-6xl font-extrabold leading-tight mb-4">
                        <span class="italic">Ruang Baca <br>Virtual</span>
                    </h1>

                    <p class="text-2xl text-gray-200 mb-6">
                        Discover knowledge without limit.
                    </p>
                </div>
            </div>
        </div>

    </div>


    <div class="h-16 bg-blue-900"></div>
     <div class="relative overflow-hidden py-16">
        <div 
            class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('{{ asset('images/Beranda2.png') }}');"
        ></div>

        <div class="absolute inset-0 bg-gradient-to-r from-indigo-300/80 via-white/70 to-white/90"></div>

        <div class="relative z-10 px-16">

            <div class="max-w-7xl mx-auto px-6 relative z-10">

                
                <div class="flex justify-center items-center mb-12">
                    <h1 class="text-5xl font-extrabold text-[#272E84] 
                    [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)] tracking-tight">
                        Rekomendasi Buku
                    </h1>
                </div>
    
                <div class="swiper mySwiper relative">
                    <div class="swiper-wrapper">
                        @foreach ($books as $buku)
                            <div class="swiper-slide flex justify-center pb-10">
                                <a href="{{ route('books.show', $buku->id_buku) }}" class="block group">
                                    <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] 
                                    p-5 border border-gray-50 w-64 transform transition duration-300 
                                    group-hover:-translate-y-2 group-hover:shadow-xl">
                                        
                                        <div class="overflow-hidden rounded-xl mb-4">
                                            <img src="{{ asset('images/'. $buku->cover) }}" 
                                            class="w-full h-56 object-cover shadow-sm 
                                            group-hover:scale-105 transition duration-300">
                                        </div>
    
                                        <h3 class="font-bold text-lg text-blue-950 leading-tight mb-1 
                                        line-clamp-2 min-h-[3.5rem]">
                                            {{ $buku->judul }}
                                        </h3>
    
                                        <p class="text-xs font-semibold text-gray-400 mb-4 uppercase 
                                        tracking-wider line-clamp-1">
                                            {{ $buku->penulis ?? 'Author Name' }}
                                        </p>
                                        
                                        <button class="w-full py-2 bg-[#00A14C] text-white 
                                        text-sm font-bold rounded-lg hover:bg-emerald-600 transition">
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


        </div>

    </div>



    <div id="fasilitasSection" class="bg-white py-16">
        
        <div class="max-w-6xl mx-auto px-8 text-center mb-12">
            <h2 class="text-5xl font-extrabold text-[#272E84] [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)] tracking-tight mb-4">
                Fasilitas Yang Tersedia
            </h2>
            <p class="text-gray-500 max-w-2xl mx-auto">
                Kami menyediakan berbagai Fasilitas Unggulan untuk kenyamanan dan keamanan pasien.
            </p>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 overflow-hidden">
            <div class="swiper swiper-fasilitas">
                <div class="swiper-wrapper">

                    @foreach ([
                        ['img' => 'lab.png', 'title' => 'Layanan Laboratorium'],
                        ['img' => 'lab.png', 'title' => 'Layanan Radiologi'],
                        ['img' => 'lab.png', 'title' => 'Layanan Farmasi'],
                        ['img' => 'lab.png', 'title' => 'Instalasi Gawat Darurat'],
                        ] as $item)

                    <div class="swiper-slide flex justify-center item-center">
                        <div class="card-fasilitas rounded-3xl shadow-xl p-8 text-center mx-auto max-w-[340px]"
                            style="background: linear-gradient(
                                to bottom,
                                #E0EDFF 0%,
                                #FFFFFF 100%
                            );">
                            <div class="flex justify-center mb-4">
                                <img src="{{ asset('images/' . $item['img']) }}"
                                class="w-30 h-30 object-contain">
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
    



    <div class="relative overflow-hidden py-16">
        <div 
            class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('{{ asset('images/Beranda1.png') }}');"
        ></div>

        <div class="absolute inset-0 bg-gradient-to-r from-indigo-300/80 via-white/70 to-white/90"></div>

        <div class="relative z-10 px-16">

            <div class="max-w-6xl mx-auto px-8 text-center mb-12">
                <h2 class="text-5xl font-extrabold text-[#272E84] tracking-tight mb-4 [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)]">
                    Statistik Pengunjung 
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
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
   
</div>

<script>
    window.kunjunganData = @json($dataKunjungan);
    window.labels = @json($labels);
    </script>

@endsection