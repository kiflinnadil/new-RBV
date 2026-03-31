@extends('layouts.app')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(to bottom, #E0EDFF 0%, #FFFFFF 100%);">

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16 pt-8 sm:pt-10">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <h1 class="font-poppins font-extrabold text-[#2B3A8C]
                       text-2xl sm:text-3xl lg:text-4xl
                       [text-shadow:_0px_4px_5px_rgb(0_0_0_/_20%)]">
                Daftar Buku
            </h1>

            <div class="flex items-center gap-3">

                <form method="GET" action="{{ route('books.index') }}" class="flex-1 sm:flex-none">
                    <div class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari buku"
                            class="pl-4 sm:pl-5 pr-11 py-2.5 rounded-xl border border-gray-200 bg-white
                                   w-full sm:w-[240px] lg:w-[287px] h-[44px] sm:h-[49px]
                                   font-montserrat text-sm
                                   focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition-all">
                        <div class="absolute right-0 top-0 h-[44px] sm:h-[49px] w-[40px] sm:w-[43px]
                                    flex items-center justify-center
                                    bg-gray-100 rounded-r-xl text-gray-400
                                    group-focus-within:bg-[#2B3A8C] group-focus-within:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </form>

                @auth
                    @if(auth()->user()->role == 'super_admin')
                    <a href="{{ route('books.create') }}"
                        class="flex items-center justify-center flex-shrink-0
                               w-[44px] h-[44px] sm:w-[47px] sm:h-[49px]
                               rounded-md border border-gray-300 bg-white text-[#606060]
                               transition hover:scale-110 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
                        </svg>
                    </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16 py-8 sm:py-10">
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-10">

            @forelse ($books as $buku)

            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden flex flex-col border border-white p-3 sm:p-4 lg:p-5 pt-0.5 group">

                <div class="relative aspect-[3/4] w-full rounded-2xl overflow-hidden shadow-inner bg-gray-50 mt-1.5">
                    <img src="{{ asset('storage/'.$buku->cover) }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                        alt="{{ $buku->judul }}">
                </div>

                <div class="pt-3 sm:pt-4 lg:pt-6 pb-2 flex flex-col flex-grow text-center">
                    <h2 class="font-poppins font-extrabold text-[#2B3A8C] leading-tight mb-1 line-clamp-2
                               text-sm sm:text-base lg:text-xl">
                        {{ $buku->judul }}
                    </h2>
                    <p class="font-poppins font-bold text-black opacity-80 mb-3 sm:mb-5 lg:mb-6
                              text-xs sm:text-sm">
                        {{ $buku->penulis }}
                    </p>
                    <div class="mt-auto px-0 sm:px-1 lg:px-2">
                        <button onclick="document.getElementById('modal-{{ $buku->id_buku }}').showModal()"
                            class="block w-full py-2 sm:py-2.5 bg-[#00A14C] font-poppins text-white font-bold rounded-lg hover:bg-[#008a41] transition shadow-md
                                   text-[11px] sm:text-[12px] lg:text-[13px]">
                            Detail Buku
                        </button>
                    </div>
                </div>
            </div>

            <dialog id="modal-{{ $buku->id_buku }}"
                class="rounded-[20px] sm:rounded-[32px] p-0 backdrop:bg-black/50 shadow-2xl
                       w-[95vw] sm:w-full max-w-sm sm:max-w-lg lg:max-w-2xl
                       overflow-hidden fixed inset-0 m-auto">
                <div class="bg-white p-5 sm:p-8 lg:p-12 relative max-h-[90vh] overflow-y-auto">

                    <button onclick="document.getElementById('modal-{{ $buku->id_buku }}').close()"
                        class="absolute top-3 right-4 text-gray-400 hover:text-gray-700 transition text-2xl leading-none z-10">
                        &times;
                    </button>

                    <div class="flex flex-col items-center">

                        <div class="w-32 sm:w-48 lg:w-64 aspect-[3/4] mb-5 sm:mb-8 shadow-2xl rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/'.$buku->cover) }}" class="w-full h-full object-cover">
                        </div>

                        <div class="w-full text-left">

                            <div class="flex justify-between items-start mb-1 gap-2">
                                <h1 class="font-poppins font-bold text-black text-lg sm:text-xl lg:text-2xl leading-tight">
                                    {{ $buku->judul }}
                                </h1>

                                @auth
                                    @if(auth()->user()->role == 'super_admin')
                                    <div class="flex gap-1.5 sm:gap-2 flex-shrink-0 items-center">

                                        <button class="p-1.5 sm:p-2 bg-[#00A14C] text-white rounded-md">
                                            <a href="{{ route('books.edit', $buku->id_buku) }}">
                                                <img src="{{ asset('images/edit.png') }}" class="w-4 h-4 sm:w-5 sm:h-5 object-contain">
                                            </a>
                                        </button>

                                        <div x-data="deleteModal()" x-init="init()" x-cloak>
                                            <button @click="openDelete = true"
                                                class="p-1.5 sm:p-2 bg-red-500 text-white rounded-md shadow transition">
                                                <img src="{{ asset('images/delete.png') }}" class="w-4 h-4 sm:w-5 sm:h-5 object-contain">
                                            </button>

                                            <div x-show="openDelete"
                                                @click.self="openDelete = false"
                                                x-transition
                                                class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">
                                                <div class="bg-white rounded-[24px] sm:rounded-[30px] p-7 sm:p-10 max-w-xs sm:max-w-sm w-full shadow-2xl text-center">
                                                    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-2">Hapus</h2>
                                                    <p class="text-gray-500 text-sm sm:text-base mb-6 sm:mb-8">Apa anda yakin ingin hapus?</p>
                                                    <div class="flex gap-3 sm:gap-4">
                                                        <button @click="openDelete = false"
                                                            class="bg-gray-400 text-white font-bold py-2.5 sm:py-3 rounded-xl w-full text-sm sm:text-base">
                                                            Tidak
                                                        </button>
                                                        <form action="{{ route('books.delete', $buku->id_buku) }}" method="POST" class="w-full">
                                                            @csrf @method('DELETE')
                                                            <button type="submit"
                                                                class="bg-red-600 text-white font-bold py-2.5 sm:py-3 rounded-xl w-full text-sm sm:text-base">
                                                                Ya
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <form action="{{ route('books.favorite', $buku->id_buku) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="hover:scale-110 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6 sm:h-8 sm:w-8 {{ $buku->is_favorite ? 'text-yellow-400 fill-current' : 'text-gray-400' }}"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                                                </svg>
                                            </button>
                                        </form>

                                    </div>
                                    @endif
                                @endauth
                            </div>

                            <p class="font-poppins font-bold text-black text-xs sm:text-sm">{{ $buku->penulis }}</p>
                            <p class="font-poppins text-gray-400 text-xs mb-3 sm:mb-4">{{ $buku->tahun }}</p>

                            <p class="font-poppins text-gray-500 leading-relaxed mb-6 sm:mb-10 text-justify
                                      text-xs sm:text-[13px]">
                                {{ $buku->deskripsi }}
                            </p>

                            <div class="flex justify-center">
                                <a href="{{ route('books.read', $buku->id_buku) }}" target="_blank"
                                    class="px-8 sm:px-10 py-2.5 bg-[#00A14C] font-poppins text-white font-bold rounded-lg text-sm hover:bg-[#008a41] transition">
                                    Baca Buku
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </dialog>

            @empty
            <div class="col-span-2 sm:col-span-2 md:col-span-3 lg:col-span-4 text-center py-16 sm:py-20
                        bg-white/50 rounded-[2rem] sm:rounded-[3rem] border-2 border-dashed border-blue-100">
                <p class="text-gray-400 text-base sm:text-xl font-medium">Koleksi buku belum tersedia.</p>
            </div>
            @endforelse

        </div>
    </div>
</div>

<script>
const searchInput = document.querySelector('input[name="search"]');
let timeout = null;
searchInput.addEventListener('keyup', function () {
    clearTimeout(timeout);
    timeout = setTimeout(() => { this.closest('form').submit(); }, 500);
});

document.querySelectorAll("dialog").forEach(dialog => {
    dialog.addEventListener("click", e => {
        const rect = dialog.getBoundingClientRect();
        const isInDialog =
            rect.top <= e.clientY && e.clientY <= rect.top + rect.height &&
            rect.left <= e.clientX && e.clientX <= rect.left + rect.width;
        if (!isInDialog) dialog.close();
    });
});

function deleteModal() {
    return { openDelete: false, init() { this.openDelete = false; } };
}
</script>
@endsection