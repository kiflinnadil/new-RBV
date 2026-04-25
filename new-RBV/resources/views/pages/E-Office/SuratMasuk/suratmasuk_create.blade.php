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
                @if(in_array(auth()->user()->role, ['sekretaris','super_admin','admin']))
                    <h1 class="font-poppins text-xl sm:text-2xl font-extrabold text-[#2B3A8C]">Tambah Surat Masuk</h1>
                    <p class="text-gray-400 text-xs">Input data surat masuk buku agenda</p>
                @else
                    <h1 class="font-poppins text-xl sm:text-2xl font-extrabold text-[#2B3A8C]">Kirim Surat Masuk</h1>
                    <p class="text-gray-400 text-xs">Surat akan diproses oleh sekretaris</p>
                @endif
            </div>
        </div>
    </div>

    @if(in_array(auth()->user()->role, ['unit','karyawan']))
    <div class="max-w-4xl mx-auto px-4 sm:px-8 mb-4">
        <div class="flex items-start gap-3 bg-blue-50 border border-blue-100 rounded-2xl p-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-xs text-blue-700">
                <span class="font-bold">Alur:</span>
                Kamu kirim → Sekretaris proses (set prioritas + teruskan) → Direktur → Kabag → Selesai
            </p>
        </div>
    </div>
    @endif

    <div class="max-w-4xl mx-auto px-4 sm:px-8 pb-10">
        <form action="{{ route('eoffice.surat-masuk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-6">

                <div class="grid grid-cols-1 {{ in_array(auth()->user()->role, ['sekretaris','super_admin','admin']) ? 'sm:grid-cols-2' : '' }} gap-5">
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">
                            No. Agenda <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nomor_agenda" value="{{ old('nomor_agenda') }}"
                            placeholder="Contoh: 001/2026" required
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]
                                   @error('nomor_agenda') ring-2 ring-red-400 @enderror">
                        @error('nomor_agenda')
                        <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @if(in_array(auth()->user()->role, ['sekretaris','super_admin','admin']))
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">Prioritas Surat</label>
                        <select name="prioritas"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                            <option value="biasa">🟢 Biasa</option>
                            <option value="sedang">🟡 Sedang</option>
                            <option value="segera">🔴 Segera</option>
                        </select>
                    </div>
                    @endif
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">Nomor Surat</label>
                        <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}"
                            placeholder="001/RSCH/SM/IV/2026"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                        <p class="text-[10px] text-gray-400 mt-1 ml-1">No/RSCH/Kode/BulanRomawi/Tahun</p>
                    </div>
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">Asal Surat <span class="text-red-500">*</span></label>
                        <input type="text" name="asal_surat" value="{{ old('asal_surat') }}"
                            required placeholder="Contoh: Dinas Kesehatan / Unit Keuangan"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">Tanggal Surat</label>
                        <input type="date" name="tanggal_surat" value="{{ date('Y-m-d') }}"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                    </div>
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">Tanggal Diterima</label>
                        <input type="date" name="tanggal_masuk" value="{{ date('Y-m-d') }}"
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

                <div>
                    <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">Perihal / Isi Ringkas <span class="text-red-500">*</span></label>
                    <textarea name="perihal" rows="3" required placeholder="Tuliskan inti dari surat..."
                        class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2B3A8C] resize-none"></textarea>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold text-xs sm:text-sm mb-3 ml-1">
                        @if(in_array(auth()->user()->role, ['unit','karyawan']))
                            Kirim ke Sekretaris
                        @else
                            Disposisi ke
                        @endif
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 bg-blue-50 p-4 rounded-2xl border border-blue-100">
                        @foreach($usersTag as $u)
                        <label class="flex items-center gap-3 cursor-pointer group p-2.5 rounded-xl hover:bg-blue-100 transition">
                            <input type="checkbox" name="tag_users[]" value="{{ $u->id_user }}"
                                class="w-4 h-4 rounded border-gray-300 text-[#2B3A8C] focus:ring-[#2B3A8C]">
                            <div>
                                <p class="text-xs font-semibold text-gray-700 group-hover:text-[#2B3A8C]">{{ $u->nama_lengkap }}</p>
                                <p class="text-[10px] text-gray-400">{{ $u->jabatan }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <p class="text-[10px] text-gray-400 mt-2 ml-1">
                        @if(in_array(auth()->user()->role, ['unit','karyawan']))
                            *Sekretaris yang dipilih akan menerima dan memproses surat ini
                        @else
                            *Yang dipilih akan menerima surat untuk ditindaklanjuti
                        @endif
                    </p>
                </div>

                <div>
                    <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">
                        File Scan Surat <span class="text-gray-400">(PDF/JPG · Opsional)</span>
                    </label>
                    <div class="relative group">
                        <input type="file" name="file_scan" id="fileScan" accept=".pdf,.jpg,.jpeg,.png"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="w-full bg-[#F3F4F6] border-2 border-dashed border-gray-200 rounded-xl py-6
                                    flex flex-col items-center justify-center group-hover:border-[#2B3A8C] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400 group-hover:text-[#2B3A8C] mb-2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12"/>
                            </svg>
                            <span id="fileLabel" class="text-xs text-gray-500 group-hover:text-[#2B3A8C]">Klik atau tarik file ke sini</span>
                            <span class="text-[10px] text-gray-400 mt-1">Maks. 10MB</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('eoffice.surat-masuk.index') }}"
                        class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:bg-gray-100 rounded-xl transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-2.5 bg-[#2B3A8C] text-white text-sm font-bold rounded-xl
                               hover:bg-blue-900 hover:shadow-lg hover:shadow-blue-200 transition">
                        @if(in_array(auth()->user()->role, ['unit','karyawan']))
                            Kirim ke Sekretaris
                        @else
                            Simpan & Teruskan
                        @endif
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('fileScan').addEventListener('change', function(e) {
    const f = e.target.files[0];
    if (f) document.getElementById('fileLabel').textContent = f.name; 
});
</script>

@endsection