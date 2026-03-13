@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-16">
    <div class="max-w-4xl mx-auto px-6">
        
        <h1 class="font-poppins text-5xl font-extrabold text-[#272E84] text-center mb-10 [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)]">
            Edit Video
        </h1>

        <div class="bg-white rounded-[30px] shadow-xl p-10 md:p-14 border border-gray-100">

            <form action="{{ route('video.update', $video->id_video) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">Judul Video</label>
                        <input type="text" name="judul" 
                                value="{{ old('judul', $video->judul) }}"
                                class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                                placeholder="Masukkan judul video">
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="4"
                                    class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                                    placeholder="Masukkan deskripsi video">{{ old('deskripsi', $video->deskripsi) }}</textarea>
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">Link Video</label>
                        <input type="url" name="link" 
                                value="{{ old('link', $video->file_url) }}"
                                class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-[#2B3A8C] outline-none"
                                placeholder="https://youtube.com/embed/...">
                        </div>
                </div>

                <div class="flex justify-center gap-4 mt-10">

                    {{-- <a href="{{ route('video.index') }}" 
                        class="bg-gray-400 text-white font-bold py-3 px-12 rounded-lg hover:bg-gray-500 transition shadow-md">
                        Batal
                    </a> --}}
                    
                    <button type="submit" 
                            class="bg-[#2B3A8C] font-poppins text-white font-bold py-3 px-12 rounded-lg hover:bg-blue-800 transition shadow-md">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection