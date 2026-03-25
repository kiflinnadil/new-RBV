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
                        <div class="relative" id="profileDropdownWrapper">
                            <img src="{{ asset('images/profile-icon.svg') }}"
                                id="profileBtn"
                                class="w-12 h-12 object-contain cursor-pointer">
                            <div id="profileDropdown"
                                class="absolute right-0 mt-3 w-44 bg-white shadow-xl rounded-xl hidden z-[9999]">
                                <a href="/tambah-akun"
                                    class="block px-4 py-3 font-poppins text-sm text-gray-700 hover:bg-gray-100">
                                    Tambah Akun
                                </a>
                                <a href="/profil"
                                    class="block px-4 py-3 font-poppins text-sm text-gray-700 hover:bg-gray-100">
                                    Profil
                                </a>
                            </div>
                        </div>
                    @endauth
            </div>

        </div>
    </div>
</nav>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const btn = document.getElementById("profileBtn");
    const dropdown = document.getElementById("profileDropdown");

    btn.addEventListener("click", function (e) {
        e.stopPropagation();
        dropdown.classList.toggle("hidden");
    });

    document.addEventListener("click", function (e) {
        if (!document.getElementById("profileDropdownWrapper").contains(e.target)) {
            dropdown.classList.add("hidden");
        }
    });

});
</script>