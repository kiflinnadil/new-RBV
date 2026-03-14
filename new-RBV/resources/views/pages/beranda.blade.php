@extends('layouts.app')

@section('content')

    <div class="relative w-full h-[calc(95vh-100px)] overflow-hidden">
        
        <div id="slider" class="relative z-0 flex transition-transform duration-700 ease-in-out h-full">
            <img src="{{ asset('images/image0.jpg') }}" class="w-full h-full object-cover flex-shrink-0">
            <img src="{{ asset('images/beranda.jpg') }}" class="w-full h-full object-cover flex-shrink-0">
            <img src="{{ asset('images/image2.jpg') }}" class="w-full h-full object-cover flex-shrink-0">
        </div>

        <div class="blue-overlay"></div>

        <div class="absolute inset-0 flex items-center z-20">
            <div class="max-w-10xl mx-auto w-full px-10">
                <div class="max-w-xl text-white">
                    <h1 class="text-5xl font-montserrat text-[40px] font-base leading-tight mb-0">
                        Selamat Datang di,
                        <br>
                    </h1>
                    <h1 class="text-6xl font-montserrat text-[55px] font-extrabold leading-tight mb-4">
                        <span class="italic">Ruang Baca <br>Virtual</span>
                    </h1>

                    <p class="text-2xl font-montserrat text-[22px] text-gray-200 mb-6">
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

            <div class="max-w-7xl mx-auto px-16">

                
                <div class="flex justify-center items-center mb-12">
                    <h1 class="font-poppins text-[55px] font-extrabold text-[#272E84] 
                    [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)] tracking-tight">
                        Rekomendasi Buku
                    </h1>
                </div>
    
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">

                    @foreach ($books as $buku)

                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden flex flex-col border border-white p-5 pt-0.5 group">   
                        
                        <div class="relative aspect-[3/4] w-full rounded-2xl overflow-hidden shadow-inner bg-gray-50">
                            <img src="{{ asset('storage/'.$buku->cover) }}" 
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        </div>

                        <div class="pt-6 pb-2 flex flex-col flex-grow text-center">

                            <h2 class="font-poppins text-xl font-extrabold text-[#2B3A8C] leading-tight mb-1 line-clamp-2">
                                {{ $buku->judul }}
                            </h2>

                            <p class="font-poppins text-sm font-bold text-black opacity-80 mb-6">
                                {{ $buku->penulis }}
                            </p>

                            <div class="mt-auto px-2">
                                <button onclick="document.getElementById('modal-home-{{ $buku->id_buku }}').showModal()" 
                                    class="block w-full py-2.5 bg-[#00A14C] font-poppins text-white text-[13px] font-bold rounded-lg hover:bg-[#008a41] transition shadow-md">
                                    Detail Buku
                                </button>
                            </div>
                        </div>

                    </div>

                    <dialog id="modal-home-{{ $buku->id_buku }}" 
                    class="rounded-[32px] p-0 backdrop:bg-black/50 shadow-2xl w-full max-w-2xl overflow-hidden fixed inset-0 m-auto">
                        <div class="bg-white p-8 md:p-12 relative">

                            <div class="flex flex-col items-center">
                                <div class="w-48 md:w-64 aspect-[3/4] mb-8 shadow-2xl rounded-lg overflow-hidden">
                                    <img src="{{ asset('storage/'.$buku->cover) }}" class="w-full h-full object-cover">
                                </div>

                                <div class="w-full text-left">
                                    <h1 class="font-poppins text-2xl font-bold text-black mb-1">{{ $buku->judul }}</h1>
                                    <p class="font-poppins text-sm font-bold text-black">{{ $buku->penulis }}</p>
                                    <p class="font-poppins text-xs text-gray-400 mb-4">{{ $buku->tahun }}</p>

                                    <p class="font-poppins text-[13px] text-gray-500 leading-relaxed mb-10 text-justify">
                                        {{ $buku->deskripsi }}
                                    </p>

                                    <div class="flex justify-center">
                                        <a href="{{ route('books.read', $buku->id_buku) }}" target="_blank"
                                            class="px-10 py-2.5 bg-[#00A14C] font-poppins text-white font-bold rounded-lg text-sm">
                                            Baca Buku
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </dialog>
                @endforeach
                </div>   
                    <div class="swiper-pagination !-bottom-2"></div>
                </div>
            </div>
        </div>
    </div>



    <div id="fasilitasSection" class="bg-white py-16">
        
        <div class="max-w-6xl mx-auto px-8 text-center mb-12">
            <h2 class="font-poppins text-[55px] font-extrabold text-[#272E84] [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)] tracking-tight mb-2">
                Fasilitas Yang Tersedia
            </h2>
            <p class="font-montserrat text-22px text-black max-w-2xl mx-auto">
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
                                class="w-30 h-30 font-poppins object-contain">
                            </div>
                            <h3 class="font-bold text-base text-gray-800 mb-2">
                                {{ $item['title'] }}
                            </h3>
                            <p class="font-montserrat text-sm text-gray-500">
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
                <h2 class="font-poppins text-[55px] font-extrabold text-[#272E84] tracking-tight mb-4 [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)]">
                    Statistik Pengunjung 
                </h2>
                <p class="font-poppins text-[22px] text-black max-w-2xl mx-auto">
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
    document.querySelectorAll("dialog").forEach(dialog => {
    dialog.addEventListener("click", function (e) {
            const rect = dialog.getBoundingClientRect();

            const isInside =
                e.clientX >= rect.left &&
                e.clientX <= rect.right &&
                e.clientY >= rect.top &&
                e.clientY <= rect.bottom;

            if (!isInside) {
                dialog.close();
            }
        });
    });
    </script>

@endsection