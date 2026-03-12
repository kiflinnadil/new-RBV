<nav class="bg-white sticky top-0 z-50 shadow-sm border-b border-gray-100">
    <div class="w-full flex items-center h-20">
        <div class="w-full px-6 flex items-center justify-between h-24">

            <div class="flex items-center gap-10">
                <div class="flex-shrink-0">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Citra Husada" class="h-14 w-auto object-contain">
                </div>

                <div class="hidden lg:flex items-center gap-8 text-[15px] text-[#2A318A]">
                    <a href="/" class="font-poppins font-normal hover:text-blue-700 transition">Beranda</a>
                    <a href="/berita" class="font-poppins font-normal hover:text-blue-700 transition">Berita</a>
                    <a href="/koleksi" class="font-poppins font-normal hover:text-blue-700 transition">Buku</a>
                    <a href="/favorite" class="font-poppins font-normal hover:text-blue-700 transition">Favorit</a>
                    <a href="/e-office" class="font-poppins font-normal hover:text-blue-700 transition">E-Office</a>
                    <a href="/artikel" class="font-poppins font-normal hover:text-blue-700 transition">Artikel</a>
                    <a href="/video" class="font-poppins font-normal hover:text-blue-700 transition">Video</a>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-4">
                <a href="#" class="font-poppins px-6 py-2 border-2 border-blue-900 text-blue-900 rounded-lg font-bold hover:bg-blue-50 transition">
                    Layanan
                </a>

                @if(!session('is_logged_in'))
                    <a href="/login" class="font-poppins px-6 py-2 bg-blue-900 text-white rounded-lg font-bold hover:bg-blue-800 transition">
                        Login
                    </a>
                @endif

                @if(session('is_logged_in'))
                    <a href="{{ route('profil.index') }}" class="flex items-center group">
                        <div class="w-12 h-12 bg-[#2A318A] rounded-full flex items-center justify-center text-white shadow-md transition hover:bg-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </a>
                @endif
            </div>

        </div>
    </div>
</nav>