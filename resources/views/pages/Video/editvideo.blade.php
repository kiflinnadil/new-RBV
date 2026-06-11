@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-16">
    <div class="max-w-4xl mx-auto px-6">
        
        <h1 class="font-poppins text-5xl font-extrabold text-[#272E84] text-center mb-10 [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)]">
            Edit Video
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

            <form id="formEdit" action="{{ route('video.update', $video->id_video) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            Judul Video <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" id="judul"
                            value="{{ old('judul', $video->judul) }}"
                            class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                            placeholder="Masukkan judul video">
                        <p id="errJudul" class="hidden text-xs text-red-500 mt-1 ml-1">Judul video wajib diisi.</p>
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            Deskripsi <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <textarea name="deskripsi" rows="4"
                            class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                            placeholder="Masukkan deskripsi video">{{ old('deskripsi', $video->deskripsi) }}</textarea>
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            Link Video <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="link" id="link"
                            value="{{ old('link', $video->file_url) }}"
                            class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                            placeholder="https://youtube.com/embed/...">
                        <p id="errLink" class="hidden text-xs text-red-500 mt-1 ml-1">Link video wajib diisi.</p>
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
function showErr(id) { document.getElementById(id).classList.remove('hidden'); }
function hideErr(id) { document.getElementById(id).classList.add('hidden'); }

function validasiForm() {
    let valid = true;

    const judul = document.getElementById('judul').value.trim();
    if (!judul) { showErr('errJudul'); valid = false; } else { hideErr('errJudul'); }

    const link = document.getElementById('link').value.trim();
    if (!link) { showErr('errLink'); valid = false; } else { hideErr('errLink'); }

    if (valid) document.getElementById('formEdit').submit();
}
</script>

@endsection