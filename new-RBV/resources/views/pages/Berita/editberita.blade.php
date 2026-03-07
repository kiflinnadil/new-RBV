@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-16">
    <div class="max-w-4xl mx-auto px-6">
        
        <h1 class="text-5xl font-extrabold text-[#272E84] text-center mb-10 [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)]">
            Edit Berita
        </h1>

        <div class="bg-white rounded-[30px] shadow-xl p-10 md:p-14 border border-gray-100">
            <form action="{{ route('berita.update', $berita->id) }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-gray-400 text-sm mb-2 ml-1">Judul Berita</label>
                        <input type="text" name="judul" 
                               class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                               placeholder="Masukkan judul berita">
                    </div>

                    <div class="relative"> 
                        <label class="block text-gray-400 text-sm mb-2 ml-1">Kategori</label>
                        
                        <div class="relative"> 
                            <select name="kategori" 
                                class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-[#2B3A8C] outline-none appearance-none cursor-pointer">
                                <option value="" disabled selected>Pilih kategori</option>
                                <option value="Kesehatan">Kesehatan</option>
                                <option value="Kegiatan">Kegiatan</option>
                                <option value="Inovasi">Inovasi</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-gray-400 text-sm mb-2 ml-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="4"
                                  class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                                  placeholder="Masukkan deskripsi berita"></textarea>
                    </div>

                    <div>
                        <label class="block text-gray-400 text-sm mb-2 ml-1">Link Berita</label>
                        <input type="url" name="link" 
                               class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                               placeholder="https://youtube.com/embed/...">
                    </div>
                </div>

                <div class="flex justify-center mt-10">
                    <button type="submit" 
                            class="bg-[#2B3A8C] text-white font-bold py-3 px-12 rounded-lg hover:bg-blue-800 transition shadow-md">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection