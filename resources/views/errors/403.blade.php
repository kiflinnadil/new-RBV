@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F0F4FF] flex items-center justify-center px-4">
    <div class="text-center max-w-md mx-auto">

        <div class="mb-8">
            <div class="w-32 h-32 mx-auto bg-blue-50 rounded-full flex items-center justify-center mb-6">
                <div class="w-32 h-32 mx-auto mb-6 flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Citra Husada" class="w-full h-full object-contain drop-shadow-md">
                </div>
            </div>

            <h1 class="font-poppins text-8xl font-extrabold text-[#2B3A8C] mb-2">403</h1>
            <h2 class="font-poppins text-2xl font-bold text-gray-700 mb-3">Akses Ditolak</h2>
            <p class="text-gray-500 text-sm leading-relaxed">
                Kamu tidak memiliki izin untuk mengakses halaman ini.
                Halaman ini hanya dapat diakses oleh pengguna dengan role tertentu.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ url('/') }}"
                class="px-6 py-3 bg-[#2B3A8C] text-white font-bold text-sm rounded-2xl
                       hover:bg-blue-900 hover:shadow-lg transition">
                Kembali ke Beranda
            </a>
            <a href="javascript:history.back()"
                class="px-6 py-3 bg-white text-gray-600 font-bold text-sm rounded-2xl
                       border border-gray-200 hover:bg-gray-50 transition">
                Halaman Sebelumnya
            </a>
        </div>

    </div>
</div>
@endsection