@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F0F4FF]">

    <div class="max-w-4xl mx-auto px-4 sm:px-8 py-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('eoffice.surat-masuk.index') }}" class="text-gray-400 hover:text-[#2B3A8C] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="font-poppins text-xl sm:text-2xl font-extrabold text-[#2B3A8C]">Tambah Surat Masuk</h1>
                <p class="text-gray-400 text-xs">Input data surat masuk sesuai buku agenda</p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-8 pb-10">
        <form action="{{ route('eoffice.surat-masuk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-6">

                {{-- Baris 1: No. Agenda + Prioritas --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">No. Agenda</label>
                        <input type="text" name="nomor_agenda" value="{{ $nomorAgenda }}" readonly
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 font-mono font-bold text-[#2B3A8C] text-sm cursor-not-allowed">
                        <p class="text-[10px] text-gray-400 mt-1 ml-1">*Otomatis berdasarkan urutan tahun ini</p>
                    </div>
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">Prioritas Surat</label>
                        <select name="prioritas" required
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                            <option value="biasa">🟢 Biasa</option>
                            <option value="sedang">🟡 Sedang</option>
                            <option value="segera">🔴 Segera</option>
                        </select>
                    </div>
                </div>

                {{-- Baris 2: Nomor Surat + Asal Surat --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">Nomor Surat Asli</label>
                        <input type="text" name="nomor_surat" placeholder="Contoh: 123/RSCH/III/2026"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                    </div>
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">Asal Surat (Pengirim)</label>
                        <input type="text" name="asal_surat" required placeholder="Contoh: Dinas Kesehatan"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                    </div>
                </div>

                {{-- Baris 3: Tanggal Surat + Tanggal Diterima + Jenis --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">Tanggal Surat</label>
                        <input type="date" name="tanggal_surat" value="{{ date('Y-m-d') }}"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                    </div>
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">Tanggal Diterima</label>
                        <input type="date" name="tanggal_diterima" value="{{ date('Y-m-d') }}"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                    </div>
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">Jenis Surat</label>
                        <select name="jenis" required
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                            <option value="external">Eksternal (Luar RS)</option>
                            <option value="internal">Internal (Antar Unit)</option>
                        </select>
                    </div>
                </div>

                {{-- Perihal --}}
                <div>
                    <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">Perihal / Isi Ringkas</label>
                    <textarea name="perihal" rows="3" required placeholder="Tuliskan inti dari surat masuk..."
                        class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C] resize-none"></textarea>
                </div>

                {{-- Tag Unit --}}
                <div>
                    <label class="block text-gray-700 font-bold text-xs sm:text-sm mb-3 ml-1 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Tag Unit / Penerima Disposisi
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 bg-blue-50 p-4 rounded-2xl border border-blue-100">
                        @foreach($users as $user)
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="tag_users[]" value="{{ $user->id_user }}"
                                class="w-4 h-4 rounded border-gray-300 text-[#2B3A8C] focus:ring-[#2B3A8C]">
                            <span class="text-xs text-gray-600 group-hover:text-[#2B3A8C] transition">{{ $user->nama_lengkap }}</span>
                        </label>
                        @endforeach
                    </div>
                    <p class="text-[10px] text-gray-400 mt-2 ml-1">*Unit yang dicentang akan menerima notifikasi surat ini.</p>
                </div>

                {{-- File Scan --}}
                <div>
                    <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">File Scan Surat (PDF/JPG) <span class="text-gray-400">(Opsional)</span></label>
                    <div class="relative group">
                        <input type="file" name="file_scan" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="w-full bg-[#F3F4F6] border-2 border-dashed border-gray-200 rounded-xl py-6 flex flex-col items-center justify-center group-hover:border-[#2B3A8C] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400 group-hover:text-[#2B3A8C] mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
                            </svg>
                            <span class="text-xs text-gray-500 group-hover:text-[#2B3A8C]">Klik atau tarik file ke sini</span>
                        </div>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('eoffice.surat-masuk.index') }}"
                        class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:bg-gray-100 rounded-xl transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-2.5 bg-[#2B3A8C] text-white text-sm font-bold rounded-xl hover:shadow-lg hover:shadow-blue-200 transition">
                        Simpan & Teruskan
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection