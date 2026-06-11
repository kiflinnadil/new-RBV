@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-16">
    <div class="max-w-4xl mx-auto px-6">
        
        <h1 class="font-poppins text-5xl font-extrabold text-[#272E84] text-center mb-10 [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)]">
            Edit Artikel
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

            <form id="formEdit" action="{{ route('artikel.update', $artikel->id_artikel) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            Judul Artikel <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" id="judul"
                            value="{{ old('judul', $artikel->judul) }}"
                            class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                            placeholder="Masukkan judul artikel">
                        <p id="errJudul" class="hidden text-xs text-red-500 mt-1 ml-1">Judul artikel wajib diisi.</p>
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            Deskripsi
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="4"
                            class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                            placeholder="Masukkan deskripsi artikel">{{ old('deskripsi', $artikel->deskripsi) }}</textarea>
                        {{-- <p id="errDeskripsi" class="hidden text-xs text-red-500 mt-1 ml-1">Deskripsi wajib diisi.</p> --}}
                    </div>
                    
                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            File Artikel 
                        </label>
                        <label class="flex items-center justify-between w-full bg-gray-100 rounded-xl py-3 px-5 cursor-pointer hover:bg-gray-200">
                            <span id="pdfName" class="font-montserrat text-gray-500 text-sm italic">
                                {{ $artikel->file_pdf ? basename($artikel->file_pdf) : 'Pilih file PDF · Maks. 20MB' }}
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12"/>
                            </svg>
                            <input type="file" name="file_pdf" id="file_pdf" accept=".pdf" class="hidden">
                            <p id="errPdf" class="hidden text-xs text-red-500 mt-1 ml-1">File PDF wajib diupload.</p>
                        </label>
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            Cover Artikel
                        </label>
                        <label class="flex items-center justify-between w-full bg-gray-100 rounded-xl py-3 px-5 cursor-pointer hover:bg-gray-200">
                            <span id="coverName" class="font-montserrat text-gray-500 text-sm italic">
                                {{ $artikel->cover ? basename($artikel->cover) : 'Pilih gambar cover · Maks. 20MB' }}
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12"/>
                            </svg>
                            <input type="file" name="cover" id="cover" accept=".jpg,.jpeg,.png" class="hidden">
                            <p id="errCover" class="hidden text-xs text-red-500 mt-1 ml-1">File cover wajib diupload.</p>
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
        document.getElementById('pdfName').textContent = fileName;
        document.getElementById('pdfName').classList.remove('text-gray-400');
        document.getElementById('pdfName').classList.add('text-gray-700');
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

    // const deskripsi = document.getElementById('deskripsi').value.trim();
    // if (!deskripsi) { showErr('errDeskripsi'); valid = false; } else { hideErr('errDeskripsi'); }

    if (valid) document.getElementById('formEdit').submit();
}
</script>

@endsection