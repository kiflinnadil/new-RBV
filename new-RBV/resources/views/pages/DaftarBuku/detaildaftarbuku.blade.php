@extends('layouts.app')

@section('content')

<div class="px-16 py-16" >

    <div class="bg-white rounded-2xl shadow-lg p-10 grid md:grid-cols-2 gap-12">

        <div>
            <img src="{{ asset('storage/'.$book->cover) }}"
                class="rounded-xl shadow-md w-full object-cover">
        </div>

        <div class="flex flex-col justify-between">

            <div>
                <h1 class="text-4xl font-bold text-[#2B3A8C] mb-1">
                    {{ $book->judul }}
                </h1>

                <p class="text-gray-500 text-sm mb-4">
                    ✍️ {{ $book->penulis }} &nbsp;·&nbsp; {{ $book->tahun }}
                </p>

                <span class="inline-block bg-emerald-100 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full mb-6">
                    {{ $book->kategori }}
                </span>

                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Deskripsi</h2>
                    <p class="text-gray-600 leading-relaxed text-sm">
                        {{ $book->deskripsi }}
                    </p>
                </div>
            </div>

            <div class="flex flex-col gap-3">

                <form action="{{ route('books.update', $book->id_buku) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <div class="space-y-6">
                        <div>
                            <label class="block text-gray-400 text-sm mb-2 ml-1">Judul Buku</label>
                            <input type="text" name="judul" value="{{ $book->judul }}"
                                class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-[#2B3A8C] outline-none">
                        </div>
                        
                        <div>
                            <label class="block text-gray-400 text-sm mb-2 ml-1">Pengarang</label>
                            <input type="text" name="pengarang" value="{{ $book->penulis }}"
                                class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-[#2B3A8C] outline-none">
                        </div>

                        <div>
                            <label class="block text-gray-400 text-sm mb-2 ml-1">Tahun Terbit</label>
                            <input type="text" name="tahun_terbit" value="{{ $book->tahun }}"
                                class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-[#2B3A8C] outline-none">
                        </div>

                        <div>
                            <label class="block text-gray-400 text-sm mb-2 ml-1">Deskripsi</label>
                            <textarea name="deskripsi" rows="4"
                                class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-[#2B3A8C] outline-none">{{ $book->deskripsi }}</textarea>
                        </div>
                        
                        <div>
                            <label class="block text-gray-400 text-sm mb-2 ml-1">File Buku (Biarkan kosong jika tidak ingin ganti)</label>
                            <label class="flex items-center w-full bg-gray-100 rounded-xl py-3 px-5 cursor-pointer hover:bg-gray-200">
                                <input type="file" name="file_buku" class="w-full text-sm text-gray-400 italic">
                            </label>
                        </div>

                        <div>
                            <label class="block text-gray-400 text-sm mb-2 ml-1">Cover Photo (Biarkan kosong jika tidak ingin ganti)</label>
                            <label class="flex items-center w-full bg-gray-100 rounded-xl py-3 px-5 cursor-pointer hover:bg-gray-200">
                                <input type="file" name="cover" class="w-full text-sm text-gray-400 italic">
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-center mt-10">
                        <button type="submit" class="bg-[#2B3A8C] text-white font-bold py-3 px-12 rounded-lg hover:bg-blue-800 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

<a href="{{ route('books.read', $book->id_buku) }}"
class="px-10 py-2.5 bg-[#00A14C] font-poppins text-white font-bold rounded-lg text-sm
focus:outline-none focus:ring-0 active:ring-0"
style="outline:none; box-shadow:none;">

                <a href="{{ route('books.index') }}"
                    class="flex items-center justify-center gap-2 w-full py-3 bg-gray-800 text-white font-bold rounded-xl hover:bg-gray-900 transition text-sm">
                    ← Kembali ke Daftar Buku
                </a>

            </div>
        </div>

    </div>

</div>

@endsection
