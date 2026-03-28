@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-16">

    <div class="max-w-4xl mx-auto px-6">

        <h1 class="font-poppins text-5xl font-extrabold text-[#272E84] text-center mb-10 [text-shadow:_0px_4px_5px_rgb(0_0_0_/_40%)]">
            Edit Berita
        </h1>

        <div class="bg-white rounded-[30px] shadow-xl p-10 md:p-14 border border-gray-100">

            <form action="{{ route('berita.update',$berita->id_berita) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            Judul Berita
                        </label>

                        <input
                            type="text"
                            name="judul"
                            value="{{ $berita->judul }}"
                            class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none">
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            Kategori
                        </label>

                        <select name="kategori"
                            class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none">

                            <option value="Kesehatan" {{ $berita->kategori=='Kesehatan'?'selected':'' }}>Kesehatan</option>
                            <option value="Kegiatan" {{ $berita->kategori=='Kegiatan'?'selected':'' }}>Kegiatan</option>
                            <option value="Inovasi" {{ $berita->kategori=='Inovasi'?'selected':'' }}>Inovasi</option>

                        </select>
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            Deskripsi
                        </label>

                        <textarea
                            name="deskripsi"
                            rows="4"
                            class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 font-montserrat focus:ring-2 focus:ring-[#2B3A8C] outline-none">{{ $berita->deskripsi }}</textarea>
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            Link Berita
                        </label>

                        <input
                            type="url"
                            name="link"
                            value="{{ $berita->file_url }}"
                            class="w-full bg-gray-100 border-none rounded-xl py-3 px-5 focus:ring-2 focus:ring-[#2B3A8C] outline-none">
                    </div>

                    <div>
                        <label class="block font-montserrat text-gray-400 text-sm mb-2 ml-1">
                            Cover Berita
                        </label>

                        <label class="flex items-center w-full bg-gray-100 rounded-xl py-3 px-5 font-montserrat cursor-pointer hover:bg-gray-200">
                            <span id="fileText" class="block text-gray-400 text-sm ml-1 italic">
                                {{ $berita->cover ? basename($berita->cover) : 'Upload cover berita' }}
                            </span>
                            <input type="file" name="cover" id="coverInput" class="hidden" accept="image/*">
                        </label>
                    </div>

                </div>

                <div class="flex justify-center mt-10">

                    <button
                        type="submit"
                        class="bg-[#2B3A8C] text-white font-poppins font-bold py-3 px-12 rounded-lg hover:bg-blue-800 transition shadow-md">
                        Update Berita
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>
document.getElementById('coverInput').addEventListener('change', function (e) {
    const file = e.target.files[0];

    if (file) {
        document.getElementById('fileText').innerText = file.name;
    }
});
</script>

@endsection