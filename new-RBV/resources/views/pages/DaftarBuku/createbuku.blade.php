@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 min-h-screen py-16">
        <div class="max-w-4xl mx-auto px-6">
            
            <h1 class="font-poppins text-5xl font-extrabold text-[#272E84] text-center mb-10 [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)]">
                Upload Buku
            </h1>

            <div class="bg-white rounded-[30px] shadow-xl p-10 md:p-14 border border-gray-100">
                <form action="{{ route('books.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">Judul Buku</label>
                            <input type="text" name="judul" 
                                class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                                placeholder="Masukkan judul buku">
                        </div>
                        
                        <div>
                            <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">Pengarang</label>
                            <input type="text" name="pengarang" 
                                class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                                placeholder="Masukkan nama pengarang">
                        </div>

                        <div>
                            <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">kategori</label>
                            <input type="text" name="kategori" 
                                class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                                placeholder="Masukkan kategori">
                        </div>

                        <div>
                            <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">Tahun Terbit</label>
                            <input type="text" name="tahun_terbit" 
                                class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                                placeholder="Masukkan tahun terbit">
                        </div>

                        <div>
                            <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">Deskripsi</label>
                            <textarea name="deskripsi" rows="4"
                            class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                            placeholder="Masukkan deskripsi buku"></textarea>
                        </div>
                        
                        <div>
                            <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                                File Buku
                            </label>

                            <label class="flex items-center w-full bg-gray-100 rounded-xl py-3 px-5 font-montserrat cursor-pointer hover:bg-gray-200">
                                <span class="block text-gray-400 text-sm ml-1 italic">
                                    File maksimal 20 MB
                                </span>
                                <input type="file" class="hidden">
                            </label>
                        </div>

                        <div>
                            <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                                Cover Photo
                            </label>

                            <label class="flex items-center w-full bg-gray-100 rounded-xl py-3 px-5 font-montserrat cursor-pointer hover:bg-gray-200">
                                <span class="block text-gray-400 text-sm ml-1 italic">
                                    File maksimal 20 MB
                                </span>
                                <input type="file" class="hidden">
                            </label>
                        </div>

                    </div>

                    <div class="flex justify-center mt-10">
                        <button type="submit" 
                                class="bg-[#2B3A8C] text-white font-bold py-3 px-12 font-poppins rounded-lg hover:bg-blue-800 transition shadow-md">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection