@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-16">
    <div class="max-w-4xl mx-auto px-6">
        
        <h1 class="font-poppins text-5xl font-extrabold text-[#272E84] text-center mb-10 [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)]">
            Upload Video
        </h1>

        <div class="bg-white rounded-[30px] shadow-xl p-10 md:p-14 border border-gray-100">
            <form action="{{ route('berita.store') }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">Judul Video</label>
                        <input type="text" name="judul" 
                               class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                               placeholder="Masukkan judul video">
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="4"
                                  class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                                  placeholder="Masukkan deskripsi video"></textarea>
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">Link Berita</label>
                        <input type="url" name="link" 
                               class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                               placeholder="https://youtube.com/embed/...">
                    </div>

                <div class="flex justify-center mt-10">
                    <button type="submit" 
                            class="bg-[#2B3A8C] font-poppins text-white font-bold py-3 px-12 rounded-lg hover:bg-blue-800 transition shadow-md">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection