<nav class="bg-white sticky top-0 z-50 shadow-sm border-b border-gray-100">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 sm:h-18 lg:h-20">

            <div class="flex items-center gap-10">

                <div class="flex-shrink-0">
                    <a href="/">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Citra Husada"
                            class="h-10 sm:h-12 lg:h-14 w-auto object-contain">
                    </a>
                </div>
    
                
                <div class="hidden lg:flex items-center gap-6 xl:gap-8 text-[1px] xl:text-[15px] text-[#2A318A]">
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

            
            <div class="hidden lg:flex items-center gap-3">
                @auth
                    @if(auth()->user()->role == 'super_admin')
                        <a href="#"
                            class="font-poppins px-4 xl:px-6 py-2 border-2 border-blue-900 text-blue-900 rounded-lg font-bold text-sm hover:bg-blue-50 transition whitespace-nowrap">
                            Layanan
                        </a>
                    @endif
                @endauth

                @guest
                    <a href="{{ route('login') }}"
                        class="px-4 xl:px-6 py-2 bg-blue-900 text-white rounded-lg font-bold text-sm hover:bg-blue-800 transition whitespace-nowrap">
                        Login
                    </a>
                @endguest

                @auth
                    <div class="relative" id="profileDropdownWrapper">
                        <img src="{{ asset('images/profile-icon.svg') }}"
                            id="profileBtn"
                            class="w-10 h-10 xl:w-12 xl:h-12 object-contain cursor-pointer rounded-full hover:opacity-80 transition">
                        <div id="profileDropdown"
                            class="absolute right-0 mt-3 w-44 bg-white shadow-xl rounded-xl hidden z-[9999] border border-gray-100">
                            <a href="/tambah-akun"
                                class="block px-4 py-3 font-poppins text-sm text-gray-700 hover:bg-gray-100 rounded-t-xl transition">
                                Tambah Akun
                            </a>
                            <a href="/profil"
                                class="block px-4 py-3 font-poppins text-sm text-gray-700 hover:bg-gray-100 rounded-b-xl transition">
                                Profil
                            </a>
                        </div>
                    </div>
                @endauth
            </div>

            
            <div class="flex lg:hidden items-center gap-2">
                @auth
                    <div class="relative" id="profileDropdownWrapperMobile">
                        <img src="{{ asset('images/profile-icon.svg') }}"
                            id="profileBtnMobile"
                            class="w-9 h-9 object-contain cursor-pointer rounded-full hover:opacity-80 transition">
                        <div id="profileDropdownMobile"
                            class="absolute right-0 mt-3 w-40 bg-white shadow-xl rounded-xl hidden z-[9999] border border-gray-100">
                            <a href="/tambah-akun"
                                class="block px-4 py-3 font-poppins text-sm text-gray-700 hover:bg-gray-100 rounded-t-xl transition">
                                Tambah Akun
                            </a>
                            <a href="/profil"
                                class="block px-4 py-3 font-poppins text-sm text-gray-700 hover:bg-gray-100 rounded-b-xl transition">
                                Profil
                            </a>
                        </div>
                    </div>
                @endauth

                @guest
                    <a href="{{ route('login') }}"
                        class="px-3 py-1.5 bg-blue-900 text-white rounded-lg font-bold text-xs sm:text-sm hover:bg-blue-800 transition">
                        Login
                    </a>
                @endguest

                
                <button id="hamburgerBtn"
                    class="p-2 rounded-lg text-[#2A318A] hover:bg-blue-50 transition focus:outline-none"
                    aria-label="Toggle menu">
                    
                    <svg id="iconOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    
                    <svg id="iconClose" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <div id="mobileMenu"
        class="lg:hidden hidden border-t border-gray-100 bg-white shadow-md">
        <div class="px-4 py-4 flex flex-col gap-1">
            <a href="/" class="block px-3 py-2.5 rounded-lg font-poppins text-sm text-[#2A318A] font-medium hover:bg-blue-50 transition">Beranda</a>
            <a href="/berita" class="block px-3 py-2.5 rounded-lg font-poppins text-sm text-[#2A318A] font-medium hover:bg-blue-50 transition">Berita</a>
            <a href="/koleksi" class="block px-3 py-2.5 rounded-lg font-poppins text-sm text-[#2A318A] font-medium hover:bg-blue-50 transition">Buku</a>
            @auth
                @if(auth()->user()->role == 'super_admin')
                    <a href="/favorite" class="block px-3 py-2.5 rounded-lg font-poppins text-sm text-[#2A318A] font-medium hover:bg-blue-50 transition">Favorit</a>
                    <a href="/e-office" class="block px-3 py-2.5 rounded-lg font-poppins text-sm text-[#2A318A] font-medium hover:bg-blue-50 transition">E-Office</a>
                @endif
            @endauth
            <a href="/artikel" class="block px-3 py-2.5 rounded-lg font-poppins text-sm text-[#2A318A] font-medium hover:bg-blue-50 transition">Artikel</a>
            <a href="/video" class="block px-3 py-2.5 rounded-lg font-poppins text-sm text-[#2A318A] font-medium hover:bg-blue-50 transition">Video</a>

            @auth
                @if(auth()->user()->role == 'super_admin')
                    <div class="pt-2 border-t border-gray-100 mt-1">
                        <a href="#"
                            class="block w-full text-center px-4 py-2.5 border-2 border-blue-900 text-blue-900 rounded-lg font-bold text-sm hover:bg-blue-50 transition">
                            Layanan
                        </a>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</nav>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const btn = document.getElementById("profileBtn");
    const dropdown = document.getElementById("profileDropdown");
    const wrapper = document.getElementById("profileDropdownWrapper");

    if (btn && dropdown && wrapper) {
        btn.addEventListener("click", function (e) {
            e.stopPropagation();
            dropdown.classList.toggle("hidden");
        });
        document.addEventListener("click", function (e) {
            if (!wrapper.contains(e.target)) {
                dropdown.classList.add("hidden");
            }
        });
    }

    const btnMobile = document.getElementById("profileBtnMobile");
    const dropdownMobile = document.getElementById("profileDropdownMobile");
    const wrapperMobile = document.getElementById("profileDropdownWrapperMobile");

    if (btnMobile && dropdownMobile && wrapperMobile) {
        btnMobile.addEventListener("click", function (e) {
            e.stopPropagation();
            dropdownMobile.classList.toggle("hidden");
        });
        document.addEventListener("click", function (e) {
            if (!wrapperMobile.contains(e.target)) {
                dropdownMobile.classList.add("hidden");
            }
        });
    }

    const hamburger = document.getElementById("hamburgerBtn");
    const mobileMenu = document.getElementById("mobileMenu");
    const iconOpen = document.getElementById("iconOpen");
    const iconClose = document.getElementById("iconClose");

    if (hamburger && mobileMenu) {
        hamburger.addEventListener("click", function () {
            const isHidden = mobileMenu.classList.contains("hidden");
            mobileMenu.classList.toggle("hidden", !isHidden);
            iconOpen.classList.toggle("hidden", isHidden);
            iconClose.classList.toggle("hidden", !isHidden);
        });
    }

});
</script>