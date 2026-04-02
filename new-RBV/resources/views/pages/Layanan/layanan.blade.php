@extends('layouts.app')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(to bottom, #E0EDFF 0%, #FFFFFF 100%);">

    <div class="max-w-5xl mx-auto px-4 sm:px-8 pt-8 sm:pt-10">
        <div class="flex items-center justify-center gap-4 pb-8">
            <h1 class="font-poppins text-4xl font-extrabold text-[#2B3A8C]">
                Layanan
            </h1>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-8 py-8 sm:py-10">
        <div class="grid grid-cols-1 gap-6 lg:gap-8">

            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 group cursor-pointer">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                    <div class="flex-shrink-0 w-20 h-20 bg-orange-50 rounded-3xl flex items-center justify-center group-hover:bg-orange-500 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-orange-500 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <h3 class="font-poppins text-2xl font-bold text-gray-800 mb-2">Panduan,Pedoman & SOP</h3>
                        <p class="text-gray-500 text-base leading-relaxed mb-4">
                            Kumpulan standar operasional prosedur untuk menunjang konsistensi pelayanan di setiap unit.
                        </p>
                        <a href="#" class="inline-flex items-center font-bold text-sm text-[#2B3A8C] group-hover:gap-3 transition-all">
                            Learn More 
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 group cursor-pointer">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                    <div class="flex-shrink-0 w-20 h-20 bg-blue-50 rounded-3xl flex items-center justify-center group-hover:bg-[#2B3A8C] transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-[#2B3A8C] group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <h3 class="font-poppins text-2xl font-bold text-gray-800 mb-2">Repositori</h3>
                        <p class="text-gray-500 text-base leading-relaxed mb-4">
                            Akses database publikasi ilmiah, jurnal kesehatan, dan hasil karya penelitian karyawan.
                        </p>
                        <a href="#" class="inline-flex items-center font-bold text-sm text-[#2B3A8C] group-hover:gap-3 transition-all">
                            Learn More 
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 group cursor-pointer">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                    <div class="flex-shrink-0 w-20 h-20 bg-red-50 rounded-3xl flex items-center justify-center group-hover:bg-red-600 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <h3 class="font-poppins text-2xl font-bold text-gray-800 mb-2">Promkes</h3>
                        <p class="text-gray-500 text-base leading-relaxed mb-4">
                            Media edukasi dan informasi mengenai kesehatan resmi dari Kementerian Kesehatan RI.
                        </p>
                        <a href="#" class="inline-flex items-center font-bold text-sm text-[#2B3A8C] group-hover:gap-3 transition-all">
                            Learn More 
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            

        </div>
    </div>
</div>
@endsection