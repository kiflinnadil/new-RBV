@extends('layouts.app')

@section('content')

    <div class="relative w-full h-[55vh] sm:h-[70vh] lg:h-[calc(95vh-100px)] overflow-hidden">

        <div id="slider" class="relative z-0 flex transition-transform duration-700 ease-in-out h-full">
            <img src="{{ asset('images/image0.jpg') }}"  class="w-full h-full object-cover flex-shrink-0">
            <img src="{{ asset('images/beranda.jpg') }}" class="w-full h-full object-cover flex-shrink-0">
            <img src="{{ asset('images/image2.jpg') }}"  class="w-full h-full object-cover flex-shrink-0">
        </div>

        <div class="absolute bottom-6 sm:bottom-10 left-1/2 -translate-x-1/2 z-30 flex flex-col items-center gap-2 group">
            <span class="text-white font-poppins text-[9px] sm:text-[10px] uppercase tracking-[0.2em] opacity-70 group-hover:opacity-100 transition-opacity">
                Scroll
            </span>
            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 border-white/30 backdrop-blur-sm flex items-center justify-center animate-bounce shadow-lg">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </div>
        </div>

        <div class="blue-overlay"></div>

        <div class="absolute inset-0 flex items-center z-20">
            <div class="w-full px-6 sm:px-10 lg:px-16">
                <div class="max-w-xs sm:max-w-md lg:max-w-xl text-white">
                    <h1 class="font-montserrat font-normal text-2xl sm:text-3xl lg:text-[40px] leading-tight mb-0">
                        Selamat Datang di,
                    </h1>
                    <h1 class="font-montserrat font-extrabold text-3xl sm:text-5xl lg:text-[55px] leading-tight mb-3 sm:mb-4">
                        <span class="italic">Ruang Baca <br>Virtual</span>
                    </h1>
                    <p class="font-montserrat text-base sm:text-xl lg:text-[22px] text-gray-200">
                        Discover knowledge without limit.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="h-10 sm:h-12 lg:h-16 bg-blue-900"></div>


    <div class="relative overflow-hidden py-10 sm:py-14 lg:py-16">
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('{{ asset('images/Beranda2.png') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-300/80 via-white/70 to-white/90"></div>

        <div class="relative z-10 px-4 sm:px-8 lg:px-16">
            <div class="max-w-7xl mx-auto">

                <div class="flex justify-center items-center mb-8 sm:mb-10 lg:mb-12">
                    <h1 class="font-poppins font-extrabold text-[#272E84] tracking-tight text-center
                                text-3xl sm:text-4xl lg:text-[55px]
                                [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)]">
                        Rekomendasi Buku
                    </h1>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-10">

                    @foreach ($books as $buku)

                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden flex flex-col border border-white p-3 sm:p-4 lg:p-5 pt-0.5 group">

                        <div class="relative aspect-[3/4] w-full rounded-2xl overflow-hidden shadow-inner bg-gray-50 mt-2">
                            <img src="{{ asset('storage/'.$buku->cover) }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        </div>

                        <div class="pt-3 sm:pt-4 lg:pt-6 pb-2 flex flex-col flex-grow text-center">
                            <h2 class="font-poppins font-extrabold text-[#2B3A8C] leading-tight mb-1 line-clamp-2
                                        text-sm sm:text-base lg:text-xl">
                                {{ $buku->judul }}
                            </h2>
                            <p class="font-poppins font-bold text-black opacity-80 mb-3 sm:mb-5 lg:mb-6
                                        text-xs sm:text-sm">
                                {{ $buku->penulis }}
                            </p>
                            <div class="mt-auto px-0 sm:px-1 lg:px-2">
                                <button onclick="document.getElementById('modal-home-{{ $buku->id_buku }}').showModal()"
                                    class="block w-full py-2 sm:py-2.5 bg-[#00A14C] font-poppins text-white font-bold rounded-lg hover:bg-[#008a41] transition shadow-md
                                            text-[11px] sm:text-[12px] lg:text-[13px]">
                                    Detail Buku
                                </button>
                            </div>
                        </div>
                    </div>

                    <dialog id="modal-home-{{ $buku->id_buku }}"
                        class="rounded-[24px] sm:rounded-[32px] p-0 backdrop:bg-black/50 shadow-2xl
                                w-[95vw] sm:w-full max-w-lg sm:max-w-xl lg:max-w-2xl
                                overflow-hidden fixed inset-0 m-auto">
                        <div class="bg-white p-5 sm:p-8 lg:p-12 relative">
                            <button onclick="document.getElementById('modal-home-{{ $buku->id_buku }}').close()"
                                class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition text-2xl leading-none">&times;</button>

                            <div class="flex flex-col items-center">
                                <div class="w-36 sm:w-48 lg:w-64 aspect-[3/4] mb-5 sm:mb-8 shadow-2xl rounded-lg overflow-hidden">
                                    <img src="{{ asset('storage/'.$buku->cover) }}" class="w-full h-full object-cover">
                                </div>

                                <div class="w-full text-left">
                                    <h1 class="font-poppins font-bold text-black mb-1 text-lg sm:text-xl lg:text-2xl">{{ $buku->judul }}</h1>
                                    <p class="font-poppins font-bold text-black text-xs sm:text-sm">{{ $buku->penulis }}</p>
                                    <p class="font-poppins text-gray-400 mb-3 sm:mb-4 text-xs">{{ $buku->tahun }}</p>
                                    <p class="font-poppins text-gray-500 leading-relaxed mb-6 sm:mb-10 text-justify text-xs sm:text-[13px]">
                                        {{ $buku->deskripsi }}
                                    </p>
                                    <div class="flex justify-center">
                                        <a href="{{ route('books.read', $buku->id_buku) }}" target="_blank"
                                            class="px-8 sm:px-10 py-2.5 bg-[#00A14C] font-poppins text-white font-bold rounded-lg text-sm hover:bg-[#008a41] transition">
                                            Baca Buku
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </dialog>

                    @endforeach

                </div>
            </div>
        </div>
    </div>


    <div id="fasilitasSection" class="py-10 sm:py-14 lg:py-16"
        style="background: #F6F9FF">

        <div class="max-w-3xl mx-auto px-4 sm:px-8 text-center mb-8 sm:mb-10">
            <h2 class="font-poppins font-extrabold text-[#1a237e] mb-3
                        text-3xl sm:text-4xl lg:text-[55px]"
                style="text-shadow: 0px 3px 6px rgba(0,0,0,0.2);">
                Fasilitas Yang Tersedia
            </h2>
            <p class="text-black font-montserrat leading-relaxed text-sm sm:text-base">
                Kami menyediakan berbagai Fasilitas Unggulan untuk kenyamanan dan
                keamanan pasien serta pengunjung Rumah Sakit Citra Husada.
            </p>
        </div>

        <div class="relative px-8 sm:px-12 lg:px-16">
            <button class="fasilitas-prev absolute left-1 sm:left-2 top-1/2 -translate-y-1/2 z-10
                text-gray-400 hover:text-gray-700 transition-colors text-4xl sm:text-5xl font-thin
                leading-none bg-transparent border-none cursor-pointer select-none w-8 sm:w-10 text-center">
                &#8249;
            </button>
            <button class="fasilitas-next absolute right-1 sm:right-2 top-1/2 -translate-y-1/2 z-10
                text-gray-400 hover:text-gray-700 transition-colors text-4xl sm:text-5xl font-thin
                leading-none bg-transparent border-none cursor-pointer select-none w-8 sm:w-10 text-center">
                &#8250;
            </button>

            <div class="swiper swiper-fasilitas">
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
                        <div class="rounded-3xl text-center py-7 sm:py-10 px-5 sm:px-8 h-full"
                            style="background: linear-gradient(160deg, #dbeafe 0%, #E0EDFF 50%, #ffffff 100%);
                                    box-shadow: 0 4px 24px rgba(100,120,200,0.10);">
                            <div class="flex justify-center mb-4 sm:mb-6">
                                <img src="{{ asset('images/' . $item['img']) }}"
                                    class="object-contain w-28 h-24 sm:w-36 sm:h-32 lg:w-[180px] lg:h-[160px]"
                                    alt="{{ $item['title'] }}">
                            </div>
                            <h3 class="font-bold text-sm sm:text-base lg:text-lg text-gray-800 mb-2">
                                {{ $item['title'] }}
                            </h3>
                            <p class="text-gray-500 text-xs sm:text-sm leading-relaxed">
                                {{ $item['desc'] }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="fasilitas-pagination flex justify-center mt-6 sm:mt-8 gap-2"></div>
    </div>


    <div class="relative overflow-hidden py-10 sm:py-14 lg:py-16">
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('{{ asset('images/Beranda1.png') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-300/80 via-white/70 to-white/90"></div>

        <div class="relative z-10 px-4 sm:px-8 lg:px-16">

            <div class="max-w-6xl mx-auto text-center mb-8 sm:mb-10 lg:mb-12">
                <h2 class="font-poppins font-extrabold text-[#272E84] tracking-tight mb-3
                            text-3xl sm:text-4xl lg:text-[55px]
                            [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)]">
                    Statistik Pengunjung
                </h2>
                <p class="font-poppins text-black text-sm sm:text-lg lg:text-[22px] max-w-2xl mx-auto">
                    Pantau Statistik Pengunjung Ruang Baca Virtual
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5 mb-5 sm:mb-8 max-w-5xl mx-auto">

                <div class="bg-white rounded-2xl border border-gray-200 px-4 sm:px-6 py-4 sm:py-5 flex items-center gap-3 shadow-xl">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/kunjungan.png') }}" class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 object-contain">
                    </div>
                    <div>
                        <p class="font-poppins text-blue-900 font-bold text-sm sm:text-base lg:text-lg leading-tight">Kunjungan Hari ini</p>
                        <p class="font-poppins text-red-600 font-bold text-3xl sm:text-4xl mt-1">{{ $kunjunganHariIni ?? 100 }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 px-4 sm:px-6 py-4 sm:py-5 flex items-center gap-3 shadow-xl">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/layanan.png') }}" class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 object-contain">
                    </div>
                    <div>
                        <p class="font-poppins text-blue-900 font-bold text-sm sm:text-base lg:text-lg leading-tight">Akses Layanan</p>
                        <p class="font-poppins text-red-600 font-bold text-3xl sm:text-4xl mt-1">{{ $aksesLayanan ?? 100 }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 px-4 sm:px-6 py-4 sm:py-5 flex items-center gap-3 shadow-xl">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/trenbuku.png') }}" class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 object-contain">
                    </div>
                    <div>
                        <p class="font-poppins text-blue-900 font-bold text-sm sm:text-base lg:text-lg leading-tight">Trend Buku</p>
                        <p class="font-poppins text-red-600 font-bold text-3xl sm:text-4xl mt-1">{{ $trendBuku ?? 100 }}</p>
                    </div>
                </div>

            </div>

            {{-- Chart --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-6 max-w-5xl mx-auto">
                <div class="relative h-52 sm:h-64 lg:h-[380px]">
                    <canvas id="chartKunjungan"></canvas>
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
            if (!isInside) dialog.close();
        });
    });
    </script>

@endsection