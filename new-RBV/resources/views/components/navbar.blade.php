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
                    @auth
                        @if(auth()->user()->role == 'super_admin')
                    <a href="/favorite" class="font-poppins font-normal hover:text-blue-700 transition">Favorit</a>
                    <a href="/e-office" class="font-poppins font-normal hover:text-blue-700 transition">E-Office</a>
                        @endif
                    @endauth
                    <a href="/artikel" class="font-poppins font-normal hover:text-blue-700 transition">Artikel</a>
                    <a href="/video" class="font-poppins font-normal hover:text-blue-700 transition">Video</a>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-4">
                @auth
                    @if(auth()->user()->role == 'super_admin')
                <a href="#" class="font-poppins px-6 py-2 border-3 border-blue-1000 text-blue-900 rounded-lg font-bold hover:bg-blue-50 transition">
                    Layanan
                </a>
                    @endif
                @endauth

                @guest
                    <a href="{{ route('login') }}"
                    class="px-6 py-2 bg-blue-900 text-white rounded-lg font-bold hover:bg-blue-800 transition">
                        Login
                    </a>
                    @endguest


                    @auth
                        <div class="relative group">

                            <img src="{{ asset('images/profile-icon.svg') }}"
                                class="w-12 h-12 object-contain cursor-pointer">

                            <div class="absolute right-0 top-full pt-2 w-44 bg-white shadow-lg rounded-xl hidden group-hover:block">

                                <div class="px-4 py-3 text-sm text-gray-700 border-b font-semibold">
                                    {{ auth()->user()->name }}
                                </div>

                                <button class="w-full text-left px-4 py-3 font-poppins text-sm text-gray-700 hover:bg-gray-100 rounded-b-xl">
                                    <a href="/tambah-akun" >
                                        Tambah Akun
                                    </a>
                                </button>

                                <button class="w-full text-left px-4 py-3 font-poppins text-sm text-gray-700 hover:bg-gray-100 rounded-b-xl">
                                    <a href="/profil" >
                                        Profil
                                    </a>
                                </button>

                                {{-- <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-gray-100 rounded-b-xl">
                                        Logout
                                    </button>
                                </form> --}}

                            </div>

                        </div>
                    @endauth
            </div>

        </div>
    </div>
</nav>