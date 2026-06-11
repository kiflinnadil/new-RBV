@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-16">
    <div class="max-w-4xl mx-auto px-6">
        
        <h1 class="font-poppins text-5xl font-extrabold text-[#272E84] text-center mb-10 [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)]">
            Edit Buku
        </h1>

        <div class="bg-white rounded-[30px] shadow-xl p-10 md:p-14 border border-gray-100">

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-2xl px-5 py-4 mb-6">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm font-bold text-red-600">Gagal menyimpan, periksa kembali:</p>
                </div>
                <ul class="text-sm text-red-500 space-y-1 ml-6 list-disc">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-2xl px-5 py-4 mb-6 flex items-center gap-2">
                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <p class="text-sm font-bold text-green-600">{{ session('success') }}</p>
            </div>
            @endif

            <form id="formEdit" action="{{ route('books.update', $book->id_buku) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            Judul Buku <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" id="judul"
                            value="{{ old('judul', $book->judul) }}"
                            class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                            placeholder="Masukkan judul buku">
                        <p id="errJudul" class="hidden text-xs text-red-500 mt-1 ml-1">Judul buku wajib diisi.</p>
                    </div>
                    
                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            Pengarang <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="pengarang" id="pengarang"
                            value="{{ old('pengarang', $book->penulis) }}"
                            class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                            placeholder="Masukkan nama pengarang">
                        <p id="errPengarang" class="hidden text-xs text-red-500 mt-1 ml-1">Pengarang wajib diisi.</p>
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="kategori" id="kategori"
                            class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none">
                            <option value="">Pilih Kategori</option>
                            <option value="Kesehatan" {{ old('kategori', $book->kategori) == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                            <option value="Non Kesehatan" {{ old('kategori', $book->kategori) == 'Non Kesehatan' ? 'selected' : '' }}>Non Kesehatan</option>
                        </select>
                        <p id="errKategori" class="hidden text-xs text-red-500 mt-1 ml-1">Kategori wajib dipilih.</p>
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            Tahun Terbit <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="tahun_terbit" id="tahunInput"
                            value="{{ old('tahun_terbit', $book->tahun) }}"
                            maxlength="4"
                            class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                            placeholder="Contoh: {{ date('Y') }}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <p id="errTahun" class="hidden text-xs text-red-500 mt-1 ml-1">Tahun terbit wajib diisi dengan angka (1900 - {{ date('Y') }}).</p>
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            Deskripsi 
                            {{-- <span class="text-red-500">*</span> --}}
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="4"
                            class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                            placeholder="Masukkan deskripsi buku">{{ old('deskripsi', $book->deskripsi) }}</textarea>
                        {{-- <p id="errDeskripsi" class="hidden text-xs text-red-500 mt-1 ml-1">Deskripsi wajib diisi.</p> --}}
                    </div>
                    
                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            File Buku 
                        </label>
                        <label class="flex items-center justify-between w-full bg-gray-100 rounded-xl py-3 px-5 font-montserrat cursor-pointer hover:bg-gray-200">
                            <span id="filePdfName" class="text-gray-500 text-sm italic">
                                {{ $book->file_pdf ? basename($book->file_pdf) : 'Pilih file PDF · Maks. 20MB' }}
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12"/>
                            </svg>
                            <input type="file" name="file_pdf" id="file_pdf" accept=".pdf" class="hidden">
                        </label>
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            Cover Photo 
                        </label>
                        <label class="flex items-center justify-between w-full bg-gray-100 rounded-xl py-3 px-5 font-montserrat cursor-pointer hover:bg-gray-200">
                            <span id="coverName" class="text-gray-500 text-sm italic">
                                {{ $book->cover ? basename($book->cover) : 'Pilih gambar cover · Maks. 20MB' }}
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12"/>
                            </svg>
                            <input type="file" name="cover" id="cover" accept=".jpg,.jpeg,.png" class="hidden">
                        </label>
                    </div>

                </div>

                <div class="flex justify-center mt-10">
                    <button type="button"
                        onclick="validasiForm()"
                        class="bg-[#2B3A8C] font-poppins text-white font-bold py-3 px-12 rounded-lg hover:bg-blue-800 transition shadow-md">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('file_pdf').addEventListener('change', function(e){
    const fileName = e.target.files[0]?.name;
    if(fileName){
        document.getElementById('filePdfName').textContent = fileName;
        document.getElementById('filePdfName').classList.remove('text-gray-400');
        document.getElementById('filePdfName').classList.add('text-gray-700');
    }
});

document.getElementById('cover').addEventListener('change', function(e){
    const fileName = e.target.files[0]?.name;
    if(fileName){
        document.getElementById('coverName').textContent = fileName;
        document.getElementById('coverName').classList.remove('text-gray-400');
        document.getElementById('coverName').classList.add('text-gray-700');
    }
});

function showErr(id) { document.getElementById(id).classList.remove('hidden'); }
function hideErr(id) { document.getElementById(id).classList.add('hidden'); }

function validasiForm() {
    let valid = true;

    const judul = document.getElementById('judul').value.trim();
    if (!judul) { showErr('errJudul'); valid = false; } else { hideErr('errJudul'); }

    const pengarang = document.getElementById('pengarang').value.trim();
    if (!pengarang) { showErr('errPengarang'); valid = false; } else { hideErr('errPengarang'); }

    const kategori = document.getElementById('kategori').value;
    if (!kategori) { showErr('errKategori'); valid = false; } else { hideErr('errKategori'); }

    const tahun = document.getElementById('tahunInput').value.trim();
    const tahunInt = parseInt(tahun);
    const tahunSekarang = {{ date('Y') }};
    if (!tahun || isNaN(tahunInt) || tahunInt < 1900 || tahunInt > tahunSekarang) {
        showErr('errTahun'); valid = false;
    } else { hideErr('errTahun'); }

    // const deskripsi = document.getElementById('deskripsi').value.trim();
    // if (!deskripsi) { showErr('errDeskripsi'); valid = false; } else { hideErr('errDeskripsi'); }

    if (valid) {
        document.getElementById('formEdit').submit();
    }
}
</script>

@endsection