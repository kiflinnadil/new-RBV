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



    <div id="fasilitasSection" class="py-16"
        style="background: linear-gradient(180deg, #c8d8f8 0%, #dde8ff 30%, #e8d8f8 70%, #c8c8f0 100%);">

        <div class="max-w-3xl mx-auto px-8 text-center mb-10">
            <h2 class="font-poppins text-[55px] font-extrabold text-[#1a237e] mb-3"
                style="text-shadow: 0px 3px 6px rgba(0,0,0,0.2);">
                Fasilitas Yang Tersedia
            </h2>
            <p class="text-black text-base font-montserrat leading-relaxed">
                Kami menyediakan berbagai Fasilitas Unggulan untuk kenyamanan dan
                keamanan pasien serta pengunjung Rumah Sakit Citra Husada.
            </p>
        </div>

        <div class="relative">

            <button class="fasilitas-prev absolute left-4 top-1/2 -translate-y-1/2 z-10
                text-gray-400 hover:text-gray-700 transition-colors text-5xl font-thin
                leading-none bg-transparent border-none cursor-pointer select-none w-10 text-center">
                &#8249;
            </button>
            <button class="fasilitas-next absolute right-4 top-1/2 -translate-y-1/2 z-10
                text-gray-400 hover:text-gray-700 transition-colors text-5xl font-thin
                leading-none bg-transparent border-none cursor-pointer select-none w-10 text-center">
                &#8250;
            </button>

            <div class="swiper swiper-fasilitas px-16">
                <div class="swiper-wrapper">

                    @foreach ([
                        ['img' => 'layanangawatdarurat.png', 'title' => 'Layanan Gawat Darurat',   'desc' => 'Dilengkapi peralatan pemeriksaan terbaru'],
                        ['img' => 'lab.png',                 'title' => 'Layanan Laboratorium',    'desc' => 'Pemeriksaan laboratorium lengkap dan akurat'],
                        ['img' => 'lab.png',                 'title' => 'Layanan Radiologi',       'desc' => 'Teknologi pencitraan medis terkini'],
                        ['img' => 'lab.png',                 'title' => 'Layanan Farmasi',         'desc' => 'Obat-obatan lengkap dan terpercaya'],
                        ['img' => 'layanangawatdarurat.png', 'title' => 'Instalasi Gawat Darurat', 'desc' => 'Penanganan darurat 24 jam siap melayani'],
                        ['img' => 'layanangawatdarurat.png', 'title' => 'Layanan Rawat Inap',      'desc' => 'Kamar nyaman dengan fasilitas lengkap'],
                        ['img' => 'layanangawatdarurat.png', 'title' => 'Layanan Rehabilitasi',    'desc' => 'Program pemulihan fisik profesional'],
                        ['img' => 'layanangawatdarurat.png', 'title' => 'Layanan Konsultasi',      'desc' => 'Konsultasi dokter spesialis terpercaya'],
                        ['img' => 'layanangawatdarurat.png', 'title' => 'Layanan Operasi',         'desc' => 'Ruang operasi steril berteknologi tinggi'],
                    ] as $item)

                    <div class="swiper-slide">
                        <div class="rounded-3xl text-center py-10 px-8"
                            style="background: linear-gradient(160deg, #dbeafe 0%, #f0f6ff 50%, #ffffff 100%);
                                box-shadow: 0 4px 24px rgba(100,120,200,0.10);">
                            <div class="flex justify-center mb-6">
                                <img src="{{ asset('images/' . $item['img']) }}"
                                    class="object-contain"
                                    style="width: 180px; height: 160px;"
                                    alt="{{ $item['title'] }}">
                            </div>
                            <h3 class="font-bold text-lg text-gray-800 mb-2">
                                {{ $item['title'] }}
                            </h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                {{ $item['desc'] }}
                            </p>
                        </div>
                    </div>

                    @endforeach

                </div>
            </div>

        </div>

        <div class="fasilitas-pagination flex justify-center mt-8 gap-2"></div>

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

            <div class="px-16 py-10">


                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

                    <div class="bg-white rounded-2xl border border-gray-200 px-6 py-5 flex items-center gap-2 shadow-xl">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('images/kunjungan.png') }}" class="w-30 h-30 object-contain">
                        </div>
                        <div>
                            <p class="font-poppins text-blue-900 font-bold text-lg leading-tight">Kunjungan Hari ini</p>
                            <p class="font-poppins text-red-600 font-bold text-4xl mt-1">{{ $kunjunganHariIni ?? 100 }}</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-200 px-6 py-5 flex items-center gap-2 shadow-xl">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('images/layanan.png') }}" class="w-30 h-30 object-contain">
                        </div>
                        <div>
                            <p class="font-poppins text-blue-900 font-bold text-lg leading-tight">Akses Layanan</p>
                            <p class="font-poppins text-red-600 font-bold text-4xl mt-1">{{ $aksesLayanan ?? 100 }}</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-200 px-6 py-5 flex items-center gap-2 shadow-xl">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('images/trenbuku.png') }}" class="w-30 h-30 object-contain">
                        </div>
                        <div>
                            <p class="font-poppins text-blue-900 font-bold text-lg leading-tight">Trend Buku</p>
                            <p class="font-poppins text-red-600 font-bold text-4xl mt-1">{{ $trendBuku ?? 100 }}</p>
                        </div>
                    </div>

                </div>

                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <div class="relative" style="height: 380px;">
                        <canvas id="chartKunjungan"></canvas>
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