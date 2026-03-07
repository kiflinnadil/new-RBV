<footer class="bg-[#2B3A8C] text-white pt-12 pb-6 px-8 md:px-16 lg:px-24">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12 border-t-4 border-red-600 pt-10">
        
        <div class="flex flex-col gap-4">
            <div class="flex items-center gap-3 py-2">
                <img src="{{ asset('images/logo1.png') }}" alt="Logo RS" class="h-18 w-20 bg-white rounded-full p-1">
                <div class="leading-tight">
                    <h2 class="font-bold text-lg uppercase">Rumah Sakit</h2>
                    <h2 class="font-bold text-lg uppercase leading-3">Citra Husada</h2>
                </div>
            </div>
            <div class="mt-4">
                <p class="font-semibold text-sm mb-2">Kesehatan anda adalah harapan kami</p>
                <p class="text-xs leading-relaxed text-gray-200">
                    Rumah Sakit Swasta Pilihan dengan Pelayanan yang Berkualitas dan Terjangkau
                </p>
            </div>
        </div>

        <div>
            <h3 class="font-bold text-lg mb-4">Navigasi</h3>
            <ul class="flex flex-col gap-3 text-sm text-gray-200">
                <li><a href="#" class="hover:text-white transition">Beranda</a></li>
                <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                <li><a href="#" class="hover:text-white transition">Layanan</a></li>
                <li><a href="#" class="hover:text-white transition">FAQ</a></li>
            </ul>
        </div>

        <div>
            <h3 class="font-bold text-lg mb-4">Media Sosial</h3>
            <div class="flex gap-3 mb-6">
                <a href="#" class="hover:opacity-80 transition"><i class="fab fa-youtube text-xl"><image src="{{ asset('images/youtube.png') }}" alt="YouTube" class="h-6 w-6"></i></a>
                <a href="#" class="hover:opacity-80 transition"><i class="fab fa-instagram text-xl"><image src="{{ asset('images/instagram.png') }}" alt="Instagram" class="h-6 w-6"></i></a>
                <a href="#" class="hover:opacity-80 transition"><i class="fab fa-facebook text-xl"><image src="{{ asset('images/facebook.png') }}" alt="Facebook" class="h-6 w-6"></i></a>
                <a href="#" class="hover:opacity-80 transition"><i class="fab fa-tiktok text-xl"><image src="{{ asset('images/tiktok.png') }}" alt="TikTok" class="h-6 w-6"></i></a>
            </div>
            <div class="rounded-sm overflow-hidden h-25 w-full shadow-inner">
                <div class="w-full h-[400px] rounded-sm overflow-hidden">
                    <iframe
                        class="w-full h-full"
                        src="https://www.google.com/maps?q=Rumah+Sakit+Citra+Husada+Jember&output=embed"
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>

        <div>
            <h3 class="font-bold text-lg mb-4">Kontak Kami</h3>
            <ul class="flex flex-col gap-3 text-sm text-gray-200">
                <li class="flex items-start gap-2">
                    <span>(+62 331) 486200 ext: 142</span>
                </li>
                <li class="flex items-start gap-2">
                    <span>081379048176</span>
                </li>
                <li class="flex items-start gap-2 leading-relaxed">
                    <span>Jl. Teratai No.22, Patrang, Kab Jember <br> Jawa Timur, Indonesia 68117</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="max-w-7xl mx-auto mt-12 pt-6 border-t border-white/20 text-center">
        <p class="text-md text-white">
            &copy; 2026 <span class="font-bold">Rumah Sakit Citra Husada</span>, Semua hak dilindungi.
        </p>
    </div>
</footer>