@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#F0F4FF] py-8 sm:py-12">

    {{-- HEADER --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16 mb-10">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

            <div class="flex items-center gap-4">

                <a href="{{ route('eoffice.surat-keluar.index') }}"
                    class="text-gray-400 hover:text-[#2B3A8C] transition">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 19l-7-7 7-7"/>

                    </svg>

                </a>

                <div>

                    <h1 class="font-poppins text-4xl font-extrabold text-[#2B3A8C]">
                        Detail Surat Keluar
                    </h1>

                    {{-- <p class="font-mono text-sm text-gray-400">
                        {{ $surat->nomor_surat }}
                    </p> --}}

                </div>

            </div>

            @if($surat->file_scan)

            <a href="{{ asset('storage/' . $surat->file_scan) }}"
                target="_blank"
                class="flex items-center gap-2 px-6 py-3 bg-white text-red-600
                       font-bold text-sm rounded-2xl shadow-sm hover:shadow-xl
                       hover:-translate-y-1 transition-all duration-300 self-start">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707
                           l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14
                           a2 2 0 002 2z"/>

                </svg>

                PDF

            </a>

            @endif

        </div>

    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16 grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-4">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6">

                <h2 class="font-poppins font-bold text-gray-700 text-sm mb-4 pb-2 border-b border-gray-100">
                    Informasi Surat
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">

                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">
                            Nomor Surat
                        </p>

                        <p class="font-mono font-bold text-[#2B3A8C]">
                            {{ $surat->nomor_surat }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">
                            Tanggal Surat
                        </p>

                        <p class="font-semibold text-gray-700">
                            {{ \Carbon\Carbon::parse($surat->tanggal_keluar)->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">
                            Tujuan Surat
                        </p>

                        <p class="font-semibold text-gray-700">
                            {{ $surat->tujuan }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">
                            Dibuat
                        </p>

                        <p class="font-semibold text-gray-700">
                            {{ \Carbon\Carbon::parse($surat->created_at)->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    <div class="sm:col-span-2">

                        <p class="text-xs text-gray-400 mb-0.5">
                            Perihal
                        </p>

                        <p class="font-semibold text-gray-700">
                            {{ $surat->perihal }}
                        </p>

                    </div>

                </div>

                @if($surat->keterangan)

                <div class="mt-4 pt-4 border-t border-gray-100">

                    <p class="text-xs text-gray-400 mb-1">
                        Keterangan
                    </p>

                    <p class="text-sm text-gray-700 bg-[#F8FAFF] rounded-xl p-3">
                        {{ $surat->keterangan }}
                    </p>

                </div>

                @endif

            </div>

            @if($surat->file_scan)

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">

                <h2 class="font-poppins font-bold text-gray-700 text-sm mb-3">
                    File Surat
                </h2>

                <a href="{{ asset('storage/' . $surat->file_scan) }}"
                    target="_blank"
                    class="flex items-center gap-3 p-3 bg-[#F8FAFF]
                           rounded-xl hover:bg-blue-50 transition">

                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">

                        <svg class="w-4 h-4 text-red-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707
                                   l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14
                                   a2 2 0 002 2z"/>

                        </svg>

                    </div>

                    <span class="text-sm text-[#2B3A8C] font-semibold">
                        Lihat / Download File Surat
                    </span>

                </a>

            </div>

            @endif

        </div>

        <div class="space-y-4">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">

                <h2 class="font-poppins font-bold text-gray-700 text-sm mb-3">
                    Status Surat
                </h2>

                <div class="flex items-center gap-2 p-3 bg-green-100 rounded-xl">

                    <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>

                    <span class="text-sm font-semibold text-green-700">
                        Surat Keluar
                    </span>

                </div>

            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">

                <h2 class="font-poppins font-bold text-gray-700 text-sm mb-4">
                    Riwayat Aktivitas
                </h2>

                <div class="space-y-0">

                    <div class="flex gap-3 pb-4 relative">

                        <div class="absolute left-3.5 top-7 bottom-0 w-0.5 bg-gray-100"></div>

                        <div class="w-7 h-7 rounded-full flex-shrink-0 flex items-center justify-center z-10 bg-[#2B3A8C]">

                            <div class="w-2 h-2 rounded-full bg-white"></div>

                        </div>

                        <div class="pt-0.5">

                            <p class="text-xs font-bold text-gray-700">
                                Surat dibuat
                            </p>

                            <p class="text-[10px] text-gray-400">
                                {{ \Carbon\Carbon::parse($surat->created_at)->format('d/m/Y H:i') }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection