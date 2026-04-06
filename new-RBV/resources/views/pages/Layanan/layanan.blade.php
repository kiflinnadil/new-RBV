@extends('layouts.app')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(to bottom, #E0EDFF 0%, #FFFFFF 100%);">

    <div class="max-w-5xl mx-auto px-4 sm:px-8 pt-8 sm:pt-10">
        <div class="flex items-center justify-center pb-20">
            <h1 class="font-poppins text-4xl font-extrabold text-[#2B3A8C]">
                Layanan
            </h1>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-8 pb-16">
        <div class="grid grid-cols-1 gap-10">

            <a href="/panduan" class="block group">
                <div class="bg-white rounded-[15px] border border-gray-100 p-6 sm:p-8
                            flex flex-col sm:flex-row items-center sm:items-center gap-6
                            transition-all duration-300 hover:-translate-y-1
                            hover:border-[#2B3A8C]/30"
                     style="box-shadow: 0px 4px 16.8px 0px rgba(0,55,136,0.46);">

                    <div class="flex-shrink-0 w-24 h-24 flex items-center justify-center">
                        <img src="{{ asset('images/panduan-icon.jpg') }}" alt="Panduan Icon" class="w-full h-full object-contain">
                    </div>

                    <div class="flex-grow text-center sm:text-left">
                        <h3 class="font-poppins text-xl sm:text-2xl font-bold text-[#2B3A8C] mb-2">
                            Panduan, pedoman dan SOP
                        </h3>
                        <p class="text-gray-400 text-sm sm:text-base leading-relaxed">
                            Dokumen Panduan, Pedoman, SOP serta informasi penggunaan layanan di Rumah Sakit Citra Husada.
                        </p>
                    </div>
                </div>
            </a>

            <a href="/repositori" class="block group">
                <div class="bg-white rounded-[15px] border border-gray-100 p-6 sm:p-8
                            flex flex-col sm:flex-row items-center sm:items-center gap-6
                            transition-all duration-300 hover:-translate-y-1
                            hover:border-[#2B3A8C]/30"
                     style="box-shadow: 0px 4px 16.8px 0px rgba(0,55,136,0.46);">

                    <div class="flex-shrink-0 w-24 h-24 flex items-center justify-center">
                        <img src="{{ asset('images/repositori-icon.jpg') }}" alt="Repositori Icon" class="w-full h-full object-contain">
                    </div>

                    <div class="flex-grow text-center sm:text-left">
                        <h3 class="font-poppins text-xl sm:text-2xl font-bold text-[#2B3A8C] mb-2">
                            Repositori
                        </h3>
                        <p class="text-gray-400 text-sm sm:text-base leading-relaxed">
                            Kumpulan dokumen kesehatan, jurnal, dan informasi penting lainnya yang ada di Rumah Sakit Citra Husada.
                        </p>
                    </div>
                </div>
            </a>

            <a href="/promkes" class="block group">
                <div class="bg-white rounded-[15px] border border-gray-100 p-6 sm:p-8
                            flex flex-col sm:flex-row items-center sm:items-center gap-6
                            transition-all duration-300 hover:-translate-y-1
                            hover:border-[#2B3A8C]/30"
                     style="box-shadow: 0px 4px 16.8px 0px rgba(0,55,136,0.46);">

                    <div class="flex-shrink-0 w-24 h-24 flex items-center justify-center">
                        <img src="{{ asset('images/promkes-icon.jpg') }}" alt="Promkes Icon" class="w-full h-full object-contain">
                    </div>

                    <div class="flex-grow text-center sm:text-left">
                        <h3 class="font-poppins text-xl sm:text-2xl font-bold text-[#2B3A8C] mb-2">
                            Promkes
                        </h3>
                        <p class="text-gray-400 text-sm sm:text-base leading-relaxed">
                            Program promosi kesehatan serta edukasi untuk masyarakat demi mendukung hidup sehat.
                        </p>
                    </div>
                </div>
            </a>

        </div>
    </div>
</div>
@endsection