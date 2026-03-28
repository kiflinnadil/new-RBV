@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 min-h-screen py-16">
        <div class="max-w-4xl mx-auto px-6">
            
            <h1 class="font-poppins text-5xl font-extrabold text-[#272E84] text-center mb-10 [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)]">
                Edit Buku
            </h1>

            <div class="bg-white rounded-[30px] shadow-xl p-10 md:p-14 border border-gray-100">
                
                <form action="{{ route('books.update', $book->id_buku) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">

                        <div>
                            <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">Judul Buku</label>
                            <input type="text" name="judul" 
                                value="{{ $book->judul }}"
                                class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none">
                        </div>
                        
                        <div>
                            <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">Pengarang</label>
                            <input type="text" name="pengarang" 
                                value="{{ $book->penulis }}"
                                class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none">
                        </div>

                        <div>
                            <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">Kategori</label>
                            <select name="kategori"
                                class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none">

                                <option value="">Pilih Kategori</option>
                                <option value="Kesehatan" {{ $book->kategori == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                <option value="Non Kesehatan" {{ $book->kategori == 'Non Kesehatan' ? 'selected' : '' }}>Non Kesehatan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">Tahun Terbit</label>
                            <input type="text" name="tahun_terbit" 
                                value="{{ $book->tahun }}"
                                class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none">
                        </div>

                        <div>
                            <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">Deskripsi</label>
                            <textarea name="deskripsi" rows="4"
                                class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none">{{ $book->deskripsi }}</textarea>
                        </div>
                        
                        <div>
                            <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                                File Buku
                            </label>

                            <label class="flex items-center justify-between w-full bg-gray-100 rounded-xl py-3 px-5 cursor-pointer hover:bg-gray-200">
                                <span id="filePdfName" class="font-montserrat text-gray-400 text-sm italic">
                                    {{ $book->file_pdf ? basename($book->file_pdf) : 'File maksimal 20 MB' }}
                                </span>
                                <input type="file" name="file_pdf" id="file_pdf" class="hidden">
                            </label>
                        </div>

                        <div>
                            <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                                Cover Photo
                            </label>

                            <label class="flex items-center justify-between w-full bg-gray-100 rounded-xl py-3 px-5 cursor-pointer hover:bg-gray-200">
                                <span id="coverName" class="font-montserrat text-gray-400 text-sm italic">
                                    {{ $book->cover ? basename($book->cover) : 'File maksimal 20 MB' }}
                                </span>
                                <input type="file" name="cover" id="cover" class="hidden">
                            </label>
                        </div>

                    </div>

                    <div class="flex justify-center mt-10">
                        <button type="submit" 
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
        document.getElementById('filePdfName').textContent = fileName;
    }
});

document.getElementById('cover').addEventListener('change', function(e){
    const fileName = e.target.files[0]?.name;
    if(fileName){
        document.getElementById('coverName').textContent = fileName;
    }
});
</script>

@endsection