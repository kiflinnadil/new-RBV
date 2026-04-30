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


                <div class="hidden lg:flex items-center gap-6 xl:gap-8 text-[13px] xl:text-[15px] text-[#2A318A]">
                    <a href="/" class="font-poppins font-normal hover:text-blue-700 transition">Beranda</a>
                    <a href="/berita" class="font-poppins font-normal hover:text-blue-700 transition">Berita</a>
                    <a href="/koleksi" class="font-poppins font-normal hover:text-blue-700 transition">Buku</a>

                    @auth
                        @if(auth()->user()->hasRole(['super_admin', 'admin', 'karyawan', 'unit', 'sekretaris']))
                            <a href="/favorite" class="font-poppins font-normal hover:text-blue-700 transition">Favorit</a>
                        @endif

                        @if(auth()->user()->hasRole(['super_admin', 'sekretaris', 'kabag', 'unit']))
                        <div class="relative" id="eofficeDropdownWrapper">
                            <button id="eofficeBtn"
                                class="font-poppins font-normal hover:text-blue-700 transition flex items-center gap-1
                                       {{ request()->is('eoffice*') ? 'text-blue-700 font-semibold' : '' }}">
                                E-Office
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div id="eofficeDropdown"
                                class="absolute left-0 mt-3 w-52 bg-white shadow-xl rounded-2xl hidden z-[9999] border border-gray-100 py-1">

                                <a href="{{ route('eoffice.surat-masuk.index') }}"
                                    class="flex items-center gap-3 px-4 py-3 hover:bg-blue-50 transition rounded-t-xl group">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-[#2B3A8C] transition flex-shrink-0">
                                        <svg class="w-4 h-4 text-[#2B3A8C] group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">Surat Masuk</p>
                                        {{-- <p class="text-xs text-gray-400">Input & monitoring</p> --}}
                                    </div>
                                </a>

                                
                                @if(auth()->user()->hasRole(['super_admin', 'sekretaris']))
                                <a href="{{ route('eoffice.surat-keluar.index') }}"
                                    class="flex items-center gap-3 px-4 py-3 hover:bg-green-50 transition rounded-b-xl group">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-600 transition flex-shrink-0">
                                        <svg class="w-4 h-4 text-green-600 group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">Surat Keluar</p>
                                    </div>
                                </a>
                                @endif
                                {{-- <p class="text-xs text-gray-400">Buat & kirim surat</p> --}}
                            </div>
                        </div>
                        @endif
                    @endauth

                    <a href="/artikel" class="font-poppins font-normal hover:text-blue-700 transition">Artikel</a>
                    <a href="/video" class="font-poppins font-normal hover:text-blue-700 transition">Video</a>
                </div>
            </div>


            <div class="hidden lg:flex items-center gap-3">
                @auth
                    
                    @if(auth()->user()->hasRole(['super_admin', 'sekretaris', 'kabag', 'unit']))
                    <div class="relative" id="bellWrapper">
                        <button id="bellBtn" class="relative p-2 rounded-xl hover:bg-gray-100 transition">
                            <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span id="bellBadge" class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full hidden items-center justify-center">0</span>
                        </button>
                        <div id="bellDropdown" class="absolute right-0 mt-3 w-80 bg-white shadow-xl rounded-2xl hidden z-[9999] border border-gray-100 overflow-hidden">
                            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                                <p class="font-semibold text-sm text-gray-700">Notifikasi</p>
                                <button id="bacaSemuaBtn" onclick="bacaSemua()" class="text-xs text-blue-600 hover:underline">Tandai semua dibaca</button>
                            </div>
                            <div id="notifList" class="max-h-72 overflow-y-auto divide-y divide-gray-50 text-center py-4">
                                <p class="text-xs text-gray-400">Memuat...</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    

                    @if(auth()->user()->hasRole(['super_admin', 'admin', 'karyawan', 'unit', 'sekretaris']))
                        <a href="/layanan"  
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

                @if(auth()->user()->role == 'super_admin')
                <div class="relative" id="profileDropdownWrapper">
                    <img src="{{ asset('images/profile-icon.svg') }}"
                        id="profileBtn"
                        class="w-10 h-10 xl:w-12 xl:h-12 object-contain cursor-pointer rounded-full hover:opacity-80 transition">

                    <div id="profileDropdown"
                        class="absolute right-0 mt-3 w-44 bg-white shadow-xl rounded-xl hidden z-[9999] border border-gray-100">
                        
                        {{-- <a href="/tambah-akun"
                            class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 rounded-t-xl">
                            Tambah Akun
                        </a> --}}

                        <a href="/profil"
                            class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 rounded-b-xl">
                            Profil
                        </a>
                        <a href="{{ route('akun.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Kelola Akun
                        </a>
                        
                    </div>
                </div>

                @else
                <a href="/profil">
                    <img src="{{ asset('images/profile-icon.svg') }}"
                        class="w-10 h-10 xl:w-12 xl:h-12 object-contain cursor-pointer rounded-full hover:opacity-80 transition">
                </a>
                @endif

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
                    <a class="block px-3 py-2.5 rounded-lg font-poppins text-sm text-[#2A318A] font-medium hover:bg-blue-50 transition">E-Office</a>
                @endif

                @if(auth()->user()->hasRole(['super_admin', 'sekretaris', 'kabag', 'unit']))
                    <div class="border-t border-gray-100 mt-1 pt-1">
                        <p class="px-3 py-1.5 text-[10px] text-gray-400 font-bold uppercase tracking-widest">E-Office</p>
                        <a href="{{ route('eoffice.surat-masuk.index') }}" class="block px-3 py-2.5 rounded-lg text-sm text-[#2A318A] font-medium hover:bg-blue-50 transition">Surat Masuk</a>
                        <a href="{{ route('eoffice.surat-keluar.index') }}" class="block px-3 py-2.5 rounded-lg text-sm text-[#2A318A] font-medium hover:bg-green-50 transition">Surat Keluar</a>
                    </div>
                @endif

                <div class="border-t border-gray-100 mt-1 pt-1">
                    <p class="px-3 py-1.5 text-[10px] text-gray-400 font-bold uppercase tracking-widest">Akun</p>
                    <a href="/tambah-akun" class="block px-3 py-2.5 rounded-lg text-sm text-[#2A318A] font-medium hover:bg-blue-50 transition">Tambah Akun</a>
                    <a href="/profil" class="block px-3 py-2.5 rounded-lg text-sm text-[#2A318A] font-medium hover:bg-blue-50 transition">Profil Saya</a>
                </div>

            @endauth
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {

    function setupDropdown(btnId, dropId, wrapId) {
        const btn  = document.getElementById(btnId);
        const drop = document.getElementById(dropId);
        const wrap = document.getElementById(wrapId);
        if (!btn || !drop || !wrap) return;
        btn.addEventListener('click', e => {
            e.stopPropagation();
            drop.classList.toggle('hidden');
        });
        document.addEventListener('click', e => {
            if (!wrap.contains(e.target)) drop.classList.add('hidden');
        });
    }

    @auth
    @if(auth()->user()->role == 'super_admin')
    setupDropdown('profileBtn', 'profileDropdown', 'profileDropdownWrapper');
    @endif
    @endauth

    setupDropdown('eofficeBtn', 'eofficeDropdown', 'eofficeDropdownWrapper');

    const bellBtn  = document.getElementById('bellBtn');
    const bellDrop = document.getElementById('bellDropdown');
    const bellWrap = document.getElementById('bellWrapper');

    if (bellBtn && bellDrop) {
        bellBtn.addEventListener('click', e => {
            e.stopPropagation();
            const isHidden = bellDrop.classList.toggle('hidden');
            if (!isHidden) loadNotifikasi(); 
        });
        document.addEventListener('click', e => {
            if (bellWrap && !bellWrap.contains(e.target)) {
                bellDrop.classList.add('hidden');
            }
        });
    }

    const hamburger  = document.getElementById('hamburgerBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    if (hamburger) {
        hamburger.addEventListener('click', () => {
            const hidden = mobileMenu.classList.toggle('hidden');
            document.getElementById('iconOpen').classList.toggle('hidden', !hidden);
            document.getElementById('iconClose').classList.toggle('hidden', hidden);
        });
    }

    async function loadNotifikasi() {
        const badge  = document.getElementById('bellBadge');
        const list   = document.getElementById('notifList');
        if (!badge || !list) return;

        try {
            const res  = await fetch('{{ route("eoffice.notifikasi.index") }}', {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            });
            const data = await res.json();

            if (data.belum_dibaca > 0) {
                badge.textContent = data.belum_dibaca > 9 ? '9+' : data.belum_dibaca;
                badge.classList.remove('hidden');
                badge.classList.add('flex');
            } else {
                badge.classList.add('hidden');
                badge.classList.remove('flex');
            }

            const dot = {
                'sukses'    : 'bg-green-500',
                'peringatan': 'bg-yellow-500',
                'info'      : 'bg-blue-500',
            };

            if (!data.notifikasi || data.notifikasi.length === 0) {
                list.innerHTML = '<p class="text-xs text-gray-400 text-center py-6">Tidak ada notifikasi</p>';
                return;
            }

            list.innerHTML = data.notifikasi.map(n => `
                <div onclick="tandaiBaca(${n.id}, '${n.url || ''}')"
                    class="flex items-start gap-3 px-4 py-3 cursor-pointer hover:bg-[#F8FAFF] transition
                           ${n.dibaca ? 'opacity-60' : 'bg-blue-50/40'}">
                    <div class="w-2 h-2 rounded-full flex-shrink-0 mt-2 ${dot[n.tipe] || dot['info']}"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold ${n.dibaca ? 'text-gray-600' : 'text-[#2B3A8C]'}">${n.judul}</p>
                        <p class="text-[11px] text-gray-500 mt-0.5 line-clamp-2">${n.pesan}</p>
                        <p class="text-[10px] text-gray-400 mt-1">${n.created_at}</p>
                    </div>
                    ${!n.dibaca ? '<div class="w-2 h-2 rounded-full bg-[#2B3A8C] flex-shrink-0 mt-2"></div>' : ''}
                </div>
            `).join('');

        } catch(e) {
            if (document.getElementById('notifList')) {
                document.getElementById('notifList').innerHTML =
                    '<p class="text-xs text-gray-400 text-center py-6">Gagal memuat notifikasi.</p>';
            }
        }
    }

    window.tandaiBaca = async function(id, url) {
        try {
            await fetch(`/eoffice/notifikasi/${id}/baca`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN'    : document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept'          : 'application/json',
                }
            });
        } catch(e) {}
        if (url) window.location.href = url;
    }

    window.bacaSemua = async function() {
        try {
            await fetch('/eoffice/notifikasi/baca-semua', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN'    : document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept'          : 'application/json',
                }
            });
        } catch(e) {}
        loadNotifikasi();
    }

    async function fetchBadge() {
        const badge = document.getElementById('bellBadge');
        if (!badge) return;
        try {
            const res  = await fetch('{{ route("eoffice.notifikasi.index") }}', {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            });
            const data = await res.json();
            if (data.belum_dibaca > 0) {
                badge.textContent = data.belum_dibaca > 9 ? '9+' : data.belum_dibaca;
                badge.classList.remove('hidden');
                badge.classList.add('flex');
            } else {
                badge.classList.add('hidden');
                badge.classList.remove('flex');
            }
        } catch(e) {}
    }

    fetchBadge();
    setInterval(fetchBadge, 30000);

    const bacaSemuaBtn = document.getElementById('bacaSemuaBtn');
    if (bacaSemuaBtn) {
        bacaSemuaBtn.addEventListener('click', () => bacaSemua());
    }
});
</script>