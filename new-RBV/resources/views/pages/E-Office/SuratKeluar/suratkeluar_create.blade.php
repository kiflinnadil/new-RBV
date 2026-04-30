@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F0F4FF]">

    <div class="max-w-4xl mx-auto px-4 sm:px-8 py-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('eoffice.surat-keluar.index') }}" class="text-gray-400 hover:text-[#2B3A8C] transition">
                <img src="{{ asset('images/kembali.svg') }}" class="w-6 h-6" fill=none  viewBox="0 0 24 24" stroke="currentColor">
            </a>
            <div>
                <h1 class="font-poppins text-xl sm:text-2xl font-extrabold text-[#2B3A8C]">Tambah Surat Keluar</h1>
                <p class="text-gray-400 text-xs">Nomor surat otomatis terisi & urut</p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-8 py-6">

        <form action="{{ route('eoffice.surat-keluar.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-6">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">No. Surat</label>
                        <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}"
                            placeholder="Contoh: 001/RSCH/SK/IV/2026"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                    </div>
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">Tanggal Diterima</label>
                        <input type="date" name="tanggal_keluar" value="{{ now()->format('Y-m-d') }}" required
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C] border-none">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">Ditujukan Kepada</label>
                    <input type="text" name="tujuan" required placeholder="Nama instansi / orang yang dituju"
                        class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C] border-none">
                </div>

                <div>
                    <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">Perihal</label>
                    <input type="text" name="perihal" required placeholder="Perihal / subjek surat"
                        class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C] border-none">
                </div>
{{-- 
                <div>
                    <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">Isi Surat (Draft)</label>
                    <textarea name="isi" rows="6" placeholder="Tulis isi singkat atau draft surat di sini..."
                        class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C] resize-none leading-relaxed border-none"></textarea>
                </div> --}}

                <div>
                    <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">
                        Keterangan 
                        <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <input type="text" name="keterangan" placeholder="Contoh: Tagihan biaya perawatan pasien/keluarga BPJS Tenaga Kerja, dll."
                        class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C] border-none">
                </div>

                <div>
                    <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1 font-semibold text-[#2B3A8C]">File Scan Surat (PDF/JPG)</label>
                    <div class="relative group">
                        <input type="file" name="file_scan" accept=".pdf,.jpg,.jpeg,.png"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="w-full bg-[#F3F4F6] border-2 border-dashed border-gray-200 rounded-xl py-6 flex flex-col items-center justify-center group-hover:border-[#2B3A8C] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400 group-hover:text-[#2B3A8C] mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
                            </svg>
                            <span class="text-xs text-gray-500 group-hover:text-[#2B3A8C]">Klik untuk upload scan surat (PDF/JPG) (Opsional)</span>
                        </div>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-2 ml-1">*Penting untuk arsip digital jika surat sudah dicetak dan distempel manual.</p>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-50">
                    <a href="{{ route('eoffice.surat-keluar.index') }}"
                        class="px-6 py-2.5 border border-gray-300 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-2.5 bg-[#2B3A8C] text-white text-sm font-bold rounded-xl hover:bg-blue-800 transition shadow-md">
                        Simpan Surat
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection