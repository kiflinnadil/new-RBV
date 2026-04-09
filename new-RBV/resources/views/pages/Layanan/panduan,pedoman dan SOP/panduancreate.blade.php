@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-8 sm:py-12 lg:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="/layanan"
            class="inline-flex items-center justify-center w-10 h-10 rounded-full
                    text-gray-400 hover:text-[#2B3A8C] hover:bg-blue-50 transition-all duration-200 -ml-20">
                <img src="{{ asset('images/kembali.svg') }}" class="w-6 h-6" fill=none  viewBox="0 0 24 24" stroke="currentColor">
            </a>
        </div>

        <h1 class="font-poppins font-extrabold text-[#272E84] text-center mb-6 sm:mb-8 lg:mb-10
                    text-[55px] sm:text-4xl lg:text-5xl
                    [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)]">
            Upload Panduan, Pedoman dan SOP
        </h1>

        <div class="bg-white rounded-[20px] sm:rounded-[30px] shadow-xl border border-gray-100
                    p-6 sm:p-10 lg:p-14">

            <form action="{{ route('panduan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-4 sm:space-y-6">

                    <div>
                        <label class="block font-montserrat text-gray-400 text-xs sm:text-sm mb-1.5 sm:mb-2 ml-1">
                            Judul
                        </label>
                        <input
                            type="text"
                            name="judul"
                            value="{{ old('judul') }}"
                            class="w-full bg-gray-100 border-none rounded-xl py-2.5 sm:py-3 px-4 sm:px-5
                                    font-montserrat text-sm sm:text-base
                                    focus:ring-2 focus:ring-[#2B3A8C] outline-none
                                    @error('judul') ring-2 ring-red-400 @enderror"
                            placeholder="Masukkan judul dokumen">
                        @error('judul')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-xs sm:text-sm mb-1.5 sm:mb-2 ml-1">
                            File
                        </label>
                        <label class="flex items-center gap-3 w-full bg-gray-100 rounded-xl
                                        py-2.5 sm:py-3 px-4 sm:px-5
                                        font-montserrat cursor-pointer hover:bg-gray-200 transition">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            <span id="fileTextPanduanCreate" class="text-gray-400 text-xs sm:text-sm italic truncate">
                                File Maksimal 20 MB
                            </span>
                            <input type="file" name="file" id="filePanduanCreate" class="hidden" accept=".pdf">
                        </label>
                        @error('file')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="flex justify-center mt-8 sm:mt-10">
                    <button type="submit"
                        class="bg-[#2B3A8C] text-white font-bold font-poppins rounded-lg
                                hover:bg-blue-800 transition shadow-md
                                py-2.5 sm:py-3 px-10 sm:px-12
                                text-sm sm:text-base w-full sm:w-auto">
                        Upload
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('filePanduanCreate').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
        document.getElementById('fileTextPanduanCreate').innerText = file.name;
    }
});
</script>

@endsection