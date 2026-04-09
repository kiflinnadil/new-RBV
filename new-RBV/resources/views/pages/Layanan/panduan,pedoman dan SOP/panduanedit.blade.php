@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-16">
    <div class="max-w-4xl mx-auto px-6">
        <div class="mb-6">
            <a href="/layanan"
            class="inline-flex items-center justify-center w-10 h-10 rounded-full
                    text-gray-400 hover:text-[#2B3A8C] hover:bg-blue-50 transition-all duration-200 -ml-20">
                <img src="{{ asset('images/kembali.svg') }}" class="w-6 h-6" fill=none  viewBox="0 0 24 24" stroke="currentColor">
            </a>
        </div>

        <h1 class="font-poppins text-5xl font-extrabold text-[#272E84] text-center mb-10
                [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)]">
            Edit Panduan, Pedoman dan SOP
        </h1>

        <div class="bg-white rounded-[30px] shadow-xl p-10 md:p-14 border border-gray-100">

            <form action="{{ route('panduan.update', $panduan->id_panduan) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            Judul
                        </label>
                        <input
                            type="text"
                            name="judul"
                            value="{{ old('judul', $panduan->judul) }}"
                            class="w-full bg-gray-100 border-none rounded-xl py-3 px-5
                                    font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none
                                    @error('judul') ring-2 ring-red-400 @enderror">
                        @error('judul')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            File
                        </label>
                        <label class="flex items-center gap-3 w-full bg-gray-100 rounded-xl
                                        py-3 px-5 font-montserrat cursor-pointer hover:bg-gray-200 transition">
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            <span id="fileTextPanduanEdit" class="text-gray-400 text-sm italic truncate">
                                {{ $panduan->file ? basename($panduan->file) : 'Biarkan kosong jika tidak diganti' }}
                            </span>
                            <input type="file" name="file" id="filePanduanEdit" class="hidden" accept=".pdf">
                        </label>
                        @error('file')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="flex justify-center mt-10">
                    <button type="submit"
                        class="bg-[#2B3A8C] text-white font-poppins font-bold py-3 px-12
                                rounded-lg hover:bg-blue-800 transition shadow-md">
                        Update Dokumen
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('filePanduanEdit').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
        document.getElementById('fileTextPanduanEdit').innerText = file.name;
    }
});
</script>

@endsection