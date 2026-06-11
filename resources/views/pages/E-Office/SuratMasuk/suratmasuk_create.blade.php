@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F0F4FF]">

    <div class="max-w-4xl mx-auto px-4 sm:px-8 py-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('eoffice.surat-masuk.index') }}"
               class="text-gray-400 hover:text-[#2B3A8C] transition">
                <img src="{{ asset('images/kembali.svg') }}"
                     class="w-6 h-6">
            </a>

            <div>
                @if(in_array(auth()->user()->role, ['sekretaris','super_admin','admin']))
                    <h1 class="font-poppins text-xl sm:text-2xl font-extrabold text-[#2B3A8C]">
                        Tambah Surat Masuk
                    </h1>
                    <p class="text-gray-400 text-xs">
                        Input data surat masuk buku agenda
                    </p>
                @else
                    <h1 class="font-poppins text-xl sm:text-2xl font-extrabold text-[#2B3A8C]">
                        Kirim Surat Masuk
                    </h1>
                    <p class="text-gray-400 text-xs">
                        Surat akan diproses oleh sekretaris
                    </p>
                @endif
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-8 pb-10">

        <form action="{{ route('eoffice.surat-masuk.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-6">

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                        <ul class="text-sm text-red-600 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 {{ in_array(auth()->user()->role, ['sekretaris','super_admin','admin']) ? 'sm:grid-cols-2' : '' }} gap-5">
                @if(in_array(auth()->user()->role, ['sekretaris','super_admin','admin']))
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">
                            No. Agenda
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text"
                            name="nomor_agenda"
                            value="{{ old('nomor_agenda') }}"
                            placeholder="Contoh: 001/2026"
                            required
                            oninvalid="this.setCustomValidity('Nomor agenda wajib diisi.')"
                            oninput="this.setCustomValidity('')"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                    </div>
                @endif

                    @if(in_array(auth()->user()->role, ['sekretaris','super_admin','admin']))
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">
                            Prioritas Surat
                        </label>

                        <select name="prioritas"
                                class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm
                                       focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">

                            <option value="biasa">🟢 Biasa</option>
                            <option value="sedang">🟡 Sedang</option>
                            <option value="segera">🔴 Segera</option>

                        </select>
                    </div>
                    @endif

                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">
                            Nomor Surat <span class="text-red-500">*</span>
                        </label>

                        <input type="text"
                            name="nomor_surat"
                            value="{{ old('nomor_surat') }}"
                            required
                            placeholder="001/RSCH/SM/IV/2026"
                            oninvalid="this.setCustomValidity('Nomor surat wajib diisi.')"
                            oninput="this.setCustomValidity('')"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]
                                    @error('nomor_surat') ring-2 ring-red-400 @enderror">

                        @error('nomor_surat')
                            <p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p>
                        @else
                            <p class="text-[10px] text-gray-400 mt-1 ml-1">
                                No/RSCH/Kode/BulanRomawi/Tahun
                            </p>
                        @enderror
                    </div>

                    @if(
                        in_array(auth()->user()->role, ['unit'])
                        || auth()->user()->id_jabatan == 3
                    )

                        <input type="hidden"
                               name="asal_surat"
                               value="{{ auth()->user()->unit_kerja }}">

                        <div>
                            <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">
                                Asal Surat
                            </label>

                        <div class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5">

                            <div class="text-gray-700 text-sm">

                                {{ auth()->user()->unit_kerja }}

                            </div>

                            <div class="text-[10px] text-gray-400">

                                {{ auth()->user()->unitKerjaRelation->kabid ?? '' }}

                            </div>

                        </div>
                        </div>

                    @else

                        <div>
                            <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">
                                Asal Surat
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text"
                                   name="asal_surat"
                                   value="{{ old('asal_surat') }}"
                                   required
                                   placeholder="Contoh: Dinas Kesehatan / Unit Keuangan"
                                   oninvalid="this.setCustomValidity('Asal surat wajib diisi.')"
                                   oninput="this.setCustomValidity('')"
                                   class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                        </div>

                    @endif

                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">
                            Tanggal Surat
                        </label>

                        <input type="date"
                               name="tanggal_surat"
                               value="{{ date('Y-m-d') }}"
                               class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                    </div>

                    @if(in_array(auth()->user()->role, ['sekretaris','super_admin','admin']))
                    <div>
                        <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">
                            Tanggal Diterima
                        </label>

                        <input type="date"
                            name="tanggal_masuk"
                            value="{{ date('Y-m-d') }}"
                            class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">
                    </div>
                    @else
                        <input type="hidden" name="tanggal_masuk" value="{{ date('Y-m-d') }}">
                    @endif

                    @if(
                        in_array(auth()->user()->role, ['unit'])
                        || auth()->user()->id_jabatan == 3
                    )

                        <input type="hidden"
                               name="jenis"
                               value="internal">

                        <div>
                            <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">
                                Jenis Surat
                            </label>
                            <div class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-gray-500 text-sm">
                                Internal
                            </div>
                        </div>

                    @else

                        <div>
                            <label class="block text-gray-500 text-sm mb-1 ml-1">
                                Jenis Surat
                            </label>

                            <select name="jenis"
                                    required
                                    class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm
                                           focus:outline-none focus:ring-2 focus:ring-[#2B3A8C]">

                                <option value="internal">Internal</option>
                                <option value="external">Eksternal</option>

                            </select>
                        </div>

                    @endif

                </div>

                <div>
                    <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">
                        Perihal / Isi Ringkas
                        <span class="text-red-500">*</span>
                    </label>

                    <textarea name="perihal"
                              rows="3"
                              placeholder="Tuliskan inti dari surat..."
                              class="w-full bg-[#F3F4F6] rounded-xl py-3 px-5 text-sm
                                     focus:outline-none focus:ring-2 focus:ring-[#2B3A8C] resize-none">{{ old('perihal') }}</textarea>
                </div>

                @if(
                    auth()->user()->id_jabatan == 4
                )
                <div>

                    <label class="block text-gray-700 font-bold text-xs sm:text-sm mb-3 ml-1">
                        Disposisi ke
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 bg-blue-50 p-4 rounded-2xl border
                        {{ $errors->has('tag_users') ? 'border-red-300 bg-red-50' : 'border-blue-100' }}">

                        @foreach($usersTag as $u)

                        <label class="flex items-center gap-3 cursor-pointer group p-2.5 rounded-xl hover:bg-blue-100 transition">

                            <input type="checkbox"
                                   name="tag_users[]"
                                   value="{{ $u->id_user }}"
                                   class="w-4 h-4 rounded border-gray-300 text-[#2B3A8C] focus:ring-[#2B3A8C]">

                            <div>
                                <p class="text-xs font-semibold text-gray-700 group-hover:text-[#2B3A8C]">
                                    {{ $u->nama_lengkap }}
                                </p>

                                <p class="text-[10px] text-gray-400">
                                    {{ $u->jabatan }}
                                </p>
                            </div>

                        </label>

                        @endforeach
                        @error('tag_users')
                            <p class="text-xs text-red-500 mt-1.5 ml-1 font-semibold">{{ $message }}</p>
                        @enderror
                        <div id="errorDisposisi" class="hidden mt-1.5 ml-1 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xs text-red-500 font-semibold">Disposisi wajib dipilih.</p>
                        </div>

                    </div>

                    <p class="text-[10px] text-gray-400 mt-2 ml-1">
                        *Yang dipilih akan menerima surat untuk ditindaklanjuti
                    </p>

                </div>
                @endif

                <div>

                    <label class="block text-gray-500 text-xs sm:text-sm mb-1.5 ml-1">
                        File Scan Surat
                        <span class="text-gray-400">(PDF/JPG · Opsional)</span>
                    </label>

                    <div class="relative group">

                        <input type="file"
                               name="file_scan"
                               id="fileScan"
                               accept=".pdf,.jpg,.jpeg,.png"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                        <div class="w-full bg-[#F3F4F6] border-2 border-dashed border-gray-200 rounded-xl py-6
                                    flex flex-col items-center justify-center group-hover:border-[#2B3A8C] transition">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-8 h-8 text-gray-400 group-hover:text-[#2B3A8C] mb-2"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12"/>

                            </svg>

                            <span id="fileLabel"
                                  class="text-xs text-gray-500 group-hover:text-[#2B3A8C]">
                                Klik atau tarik file ke sini
                            </span>

                            <span class="text-[10px] text-gray-400 mt-1">
                                Maks. 10MB
                            </span>

                        </div>

                    </div>

                </div>

<div class="flex justify-end gap-3 pt-2">

    <a href="{{ route('eoffice.surat-masuk.index') }}"
       onclick="event.preventDefault(); bukaModalBatal()"
       class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:bg-gray-100 rounded-xl transition">

        Batal

    </a>

    <button type="button"
            onclick="bukaModalSimpan()"
            class="px-8 py-2.5 bg-[#2B3A8C] text-white text-sm font-bold rounded-xl
                   hover:bg-blue-900 hover:shadow-lg hover:shadow-blue-200 transition">

        @if(
            in_array(auth()->user()->role, ['unit'])
            || auth()->user()->id_jabatan == 3
        )

            Kirim ke Sekretaris

        @else

            Simpan & Teruskan

        @endif

    </button>

</div>

<div id="modalSimpan"
     class="hidden fixed inset-0 z-50 flex items-center justify-center">

    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
         onclick="tutupModalSimpan()"></div>

    <div class="relative bg-white rounded-2xl shadow-2xl p-7 max-w-sm w-full mx-4 z-10">

        <div class="flex flex-col items-center text-center gap-4">

            <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-7 h-7 text-[#2B3A8C]"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2.5"
                          d="M13 7l5 5m0 0l-5 5m5-5H6"/>

                </svg>

            </div>

            <div>

                <h3 class="font-poppins font-bold text-gray-800 text-lg">

                    Konfirmasi Surat

                </h3>

                <p class="text-gray-500 text-sm mt-1">

                    Apakah Anda yakin ingin menyimpan dan meneruskan surat ini?

                </p>

            </div>

            <div class="flex gap-3 w-full mt-2">

                <button type="button"
                        onclick="tutupModalSimpan()"
                        class="flex-1 py-2.5 bg-gray-100 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-200 transition">

                    Batal

                </button>

                <button type="submit"
                        class="flex-1 py-2.5 bg-[#2B3A8C] text-white text-sm font-bold rounded-xl hover:bg-blue-900 transition">

                    Ya, Lanjutkan

                </button>

            </div>

        </div>

    </div>

</div>

<div id="modalBatal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center">

    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
         onclick="tutupModalBatal()"></div>

    <div class="relative bg-white rounded-2xl shadow-2xl p-7 max-w-sm w-full mx-4 z-10">

        <div class="flex flex-col items-center text-center gap-4">

            <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-7 h-7 text-red-600"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2.5"
                          d="M6 18L18 6M6 6l12 12"/>

                </svg>

            </div>

            <div>

                <h3 class="font-poppins font-bold text-gray-800 text-lg"> 

                    Batalkan Proses

                </h3>

                <p class="text-gray-500 text-sm mt-1">

                    Data yang belum disimpan akan hilang.

                </p>

            </div>

            <div class="flex gap-3 w-full mt-2">

                <button type="button"
                        onclick="tutupModalBatal()"
                        class="flex-1 py-2.5 bg-gray-100 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-200 transition">

                    Kembali

                </button>

                <a href="{{ route('eoffice.surat-masuk.index') }}"
                   class="flex-1 py-2.5 bg-red-600 text-white text-sm font-bold rounded-xl hover:bg-red-700 transition text-center">

                    Ya, Batal

                </a>

            </div>

        </div>

    </div>

</div>

<script>
function bukaModalSimpan() {
    const form = document.querySelector('form');

    const inputs = form.querySelectorAll('[required]');
    let valid = true;

    for (let input of inputs) {
        if (!input.checkValidity()) {
            input.reportValidity();
            valid = false;
            break;
        }
    }

    if (!valid) return;

    const checkboxes = form.querySelectorAll('input[name="tag_users[]"]');
    if (checkboxes.length > 0) {
        const adaYangDiceklis = Array.from(checkboxes).some(cb => cb.checked);
        if (!adaYangDiceklis) {
            const errorDiv = document.getElementById('errorDisposisi');
            if (errorDiv) {
                errorDiv.classList.remove('hidden');
                errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        } else {
            const errorDiv = document.getElementById('errorDisposisi');
            if (errorDiv) errorDiv.classList.add('hidden');
        }
    }

    document.getElementById('modalSimpan').classList.remove('hidden');
}

function tutupModalSimpan() {
    document.getElementById('modalSimpan').classList.add('hidden');
}

function bukaModalBatal() {
    document.getElementById('modalBatal').classList.remove('hidden');
}

function tutupModalBatal() {
    document.getElementById('modalBatal').classList.add('hidden');
}
</script>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('fileScan').addEventListener('change', function(e) {

    const f = e.target.files[0];

    if (f) {
        document.getElementById('fileLabel').textContent = f.name;
    }

});
document.querySelectorAll('input[name="tag_users[]"]').forEach(cb => {
    cb.addEventListener('change', function() {
        const adaDiceklis = Array.from(
            document.querySelectorAll('input[name="tag_users[]"]')
        ).some(c => c.checked);

        const errorDiv = document.getElementById('errorDisposisi');
        if (errorDiv) {
            errorDiv.classList.toggle('hidden', adaDiceklis);
        }
    });
});
</script>

@endsection