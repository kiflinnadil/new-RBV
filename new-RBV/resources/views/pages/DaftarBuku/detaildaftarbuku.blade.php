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

                <form action="{{ route('books.favorite', $book->id_buku) }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 group w-full">
                        <div class="p-2 rounded-full bg-gray-100 group-hover:bg-yellow-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="h-6 w-6 {{ $book->is_favorite ? 'text-yellow-400 fill-current' : 'text-gray-400' }}" 
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium {{ $book->is_favorite ? 'text-yellow-600' : 'text-gray-500' }}">
                            {{ $book->is_favorite ? 'Tersimpan di Favorit' : 'Tambah ke Favorit' }}
                        </span>
                    </button>
                </form>

                <a href="{{ route('books.read', $book->id_buku) }}" target="_blank"
                   class="flex items-center justify-center gap-2 w-full py-3 bg-[#00A14C] text-white font-bold rounded-xl hover:bg-emerald-700 transition text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Baca Buku
                </a>

                <a href="{{ route('books.index') }}"
                   class="flex items-center justify-center gap-2 w-full py-3 bg-gray-800 text-white font-bold rounded-xl hover:bg-gray-900 transition text-sm">
                    ← Kembali ke Daftar Buku
                </a>

            </div>
        </div>

    </div>

</div>

@endsection
