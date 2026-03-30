@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-16">
    <div class="max-w-4xl mx-auto px-6">
        
        <h1 class="font-poppins text-5xl font-extrabold text-[#272E84] text-center mb-10">
            Upload Video
        </h1>

        <div class="bg-white rounded-[30px] shadow-xl p-10 md:p-14 border border-gray-100">
            <form action="{{ route('video.store') }}" method="POST">
                @csrf
                
                <div class="space-y-6">

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2">Judul Video</label>
                        <input type="text" name="judul" 
                            class="w-full bg-gray-100 rounded-xl py-3 px-5 font-montserrat"
                            placeholder="Masukkan judul video">
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2">Deskripsi</label>
                        <textarea name="deskripsi" rows="4"
                                class="w-full bg-gray-100 rounded-xl py-3 px-5 font-montserrat"
                                placeholder="Masukkan deskripsi"></textarea>
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2">Link Video</label>
                        <input type="text" name="link"
                            class="w-full bg-gray-100 rounded-xl py-3 px-5 font-montserrat"
                            placeholder="https://youtube.com / tiktok / instagram">
                    </div>

                    <div class="flex justify-center mt-10">
                        <button type="submit" 
                            class="bg-[#2B3A8C] text-white font-bold py-3 px-12 rounded-lg">
                            Upload
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection