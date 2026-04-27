@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F0F4FF]">

    <div class="max-w-4xl mx-auto px-4 sm:px-8 py-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('eoffice.surat-keluar.index') }}" class="text-gray-400 hover:text-[#2B3A8C] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="font-poppins text-xl sm:text-2xl font-extrabold text-[#2B3A8C]">Edit Surat Keluar</h1>
                <p class="text-gray-400 text-xs font-mono">{{ $surat->nomor_surat }}</p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-8 pb-10">
        <form action="{{ route('eoffice.surat-keluar.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-6">

                {{-- Nomor Surat + Tanggal --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">
                            Nomor Surat <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nomor_surat"
                            value="{{ old('nomor_surat', $surat->nomor_surat) }}"
                            required placeholder="001/RSCH/SK/IV/2026"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]
                                   @error('nomor_surat') ring-2 ring-red-400 @enderror">
                        @error('nomor_surat')
                        <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p>
                        @enderror
                        <p class="text-[10px] text-gray-400 mt-1 ml-1">Format: No/RSCH/SK/BulanRomawi/Tahun</p>
                    </div>
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">
                            Tanggal Keluar <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_keluar"
                            value="{{ old('tanggal_keluar', \Carbon\Carbon::parse($surat->tanggal_keluar)->format('Y-m-d')) }}"
                            required
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                    </div>
                </div>

                {{-- Tujuan --}}
                <div>
                    <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">
                        Tujuan Surat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="tujuan"
                        value="{{ old('tujuan', $surat->tujuan) }}"
                        required placeholder="Contoh: Dinas Kesehatan Jember"
                        class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                </div>

                {{-- Perihal --}}
                <div>
                    <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">
                        Perihal <span class="text-red-500">*</span>
                    </label>
                    <textarea name="perihal" rows="3" required
                        placeholder="Tuliskan perihal surat..."
                        class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C] resize-none">{{ old('perihal', $surat->perihal) }}</textarea>
                </div>

                {{-- File Surat (opsional, hanya kalau mau ganti) --}}
                <div>
                    <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">
                        File Surat <span class="text-gray-400">(Opsional — kosongkan jika tidak ingin mengganti)</span>
                    </label>

                    {{-- Tampilkan file lama kalau ada --}}
                    @if(isset($surat->file_surat) && $surat->file_surat)
                    <div class="flex items-center gap-3 p-3 bg-[#F8FAFF] rounded-xl mb-3 border border-gray-100">
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-600 font-semibold">File saat ini:</p>
                            <a href="{{ asset('storage/'.$surat->file_surat) }}" target="_blank"
                                class="text-xs text-[#2B3A8C] hover:underline">
                                {{ basename($surat->file_surat) }}
                            </a>
                        </div>
                    </div>
                    @endif

                    <div class="relative group">
                        <input type="file" name="file_surat" id="fileSurat" accept=".pdf,.jpg,.jpeg,.png"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="w-full bg-[#F3F4F6] border-2 border-dashed border-gray-200 rounded-xl py-6
                                    flex flex-col items-center justify-center group-hover:border-[#2B3A8C] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400 group-hover:text-[#2B3A8C] mb-2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12"/>
                            </svg>
                            <span id="fileLabel" class="text-xs text-gray-500 group-hover:text-[#2B3A8C]">
                                Klik atau tarik file untuk mengganti
                            </span>
                            <span class="text-[10px] text-gray-400 mt-1">PDF / JPG / PNG · Maks. 10MB</span>
                        </div>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('eoffice.surat-keluar.index') }}"
                        class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:bg-gray-100 rounded-xl transition">
                        Batal
                    </a>
                    <a href="{{ route('eoffice.surat-keluar.show', $surat->id) }}"
                        class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:bg-gray-100 rounded-xl transition">
                        Lihat Detail
                    </a>
                    <button type="submit"
                        class="px-8 py-2.5 bg-[#2B3A8C] text-white text-sm font-bold rounded-xl
                               hover:bg-blue-900 hover:shadow-lg hover:shadow-blue-200 transition">
                        Simpan Perubahan
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('fileSurat').addEventListener('change', function(e) {
    const f = e.target.files[0];
    if (f) document.getElementById('fileLabel').textContent = f.name;
});
</script>

@endsection