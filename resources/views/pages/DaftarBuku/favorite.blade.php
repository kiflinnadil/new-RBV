@extends('layouts.app')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(to bottom,#E0EDFF 0%,#FFFFFF 100%);">

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16 pt-8 sm:pt-10">
        <h1 class="font-poppins font-extrabold text-[#2B3A8C]
                   text-2xl sm:text-3xl lg:text-4xl
                   [text-shadow:_0px_4px_5px_rgb(0_0_0_/_20%)]">
            Buku Favorit
        </h1>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-16 py-8 sm:py-10">

        @if(!empty($books))

        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-10">

            @foreach ($books as $buku)

            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden flex flex-col border border-white p-3 sm:p-4 lg:p-5 group">

                <div class="relative aspect-[3/4] w-full rounded-2xl overflow-hidden shadow-inner bg-gray-50">
                    <img src="{{ asset('storage/'.$buku->cover) }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                        alt="{{ $buku->judul }}">

                    <form action="{{ route('books.favorite', $buku->id_buku) }}" method="POST"
                        class="absolute top-2 right-2 sm:top-3 sm:right-3 z-10">
                        @csrf
                        <button type="submit" class="hover:scale-125 transition drop-shadow-md">
                            <img src="{{ asset('images/star.svg') }}"
                                class="w-7 h-7 sm:w-8 sm:h-8 lg:w-9 lg:h-9 object-contain"
                                alt="favorite">
                        </button>
                    </form>
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
                        <button onclick="document.getElementById('modal-fav-{{ $buku->id_buku }}').showModal()"
                            class="block w-full py-2 sm:py-2.5 bg-[#00A14C] font-poppins text-white font-bold rounded-xl hover:bg-[#008a41] transition shadow-md
                                   text-[11px] sm:text-[12px] lg:text-[13px]">
                            Detail Buku
                        </button>
                    </div>
                </div>
            </div>

            <dialog id="modal-fav-{{ $buku->id_buku }}"
                class="rounded-[20px] sm:rounded-[32px] p-0 backdrop:bg-black/50 shadow-2xl
                       w-[95vw] sm:w-full max-w-sm sm:max-w-lg lg:max-w-2xl
                       overflow-hidden fixed inset-0 m-auto">
                <div class="bg-white p-5 sm:p-8 lg:p-12 relative max-h-[90vh] overflow-y-auto">

                    <button onclick="document.getElementById('modal-fav-{{ $buku->id_buku }}').close()"
                        class="absolute top-3 right-4 text-gray-400 hover:text-gray-700 transition text-2xl leading-none z-10">
                        &times;
                    </button>

                    <div class="flex flex-col items-center">
                        <div class="w-32 sm:w-48 lg:w-64 aspect-[3/4] mb-5 sm:mb-8 shadow-2xl rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/'.$buku->cover) }}" class="w-full h-full object-cover">
                        </div>

                        <div class="w-full text-left">
                            <h1 class="font-poppins font-bold text-black mb-1
                                       text-lg sm:text-xl lg:text-2xl">
                                {{ $buku->judul }}
                            </h1>
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

            @endforeach
        </div>

        @else

        <div class="flex flex-col items-center justify-center py-20 sm:py-32 text-center px-4">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-14 w-14 sm:h-20 sm:w-20 text-gray-300 mb-4 sm:mb-6"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
            </svg>
            <p class="font-montserrat font-bold text-gray-400 mb-2
                      text-lg sm:text-2xl">
                Belum ada buku favorit
            </p>
            <p class="text-gray-400 text-xs sm:text-sm mb-6 sm:mb-8">
                Tambahkan buku ke favorit dengan menekan ikon bintang
            </p>
            <a href="{{ route('books.index') }}"
                class="font-poppins px-5 sm:px-6 py-2.5 sm:py-3 bg-[#00A14C] text-white font-bold rounded-lg hover:bg-emerald-700 transition text-sm sm:text-base">
                Jelajahi Buku
            </a>
        </div>

        @endif

    </div>
</div>

<script>
document.querySelectorAll("dialog").forEach(dialog => {
    dialog.addEventListener("click", e => {
        const rect = dialog.getBoundingClientRect();
        const isInDialog =
            rect.top <= e.clientY && e.clientY <= rect.top + rect.height &&
            rect.left <= e.clientX && e.clientX <= rect.left + rect.width;
        if (!isInDialog) dialog.close();
    });
});
</script>

@endsection