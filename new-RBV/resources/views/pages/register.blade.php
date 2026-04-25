@extends('layouts.app')

@section('content')

<div class="relative min-h-screen flex items-center justify-center overflow-hidden">

    {{-- Background Image --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/image0.jpg') }}"
            alt="background"
            class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/40"></div>
    </div>

    {{-- Card --}}
    <div class="relative z-10 w-full max-w-sm mx-4">
        <div class="backdrop-blur-md bg-white/20 border border-white/30 rounded-2xl shadow-2xl px-10 py-10">

            {{-- Judul --}}
            <h1 class="font-montserrat text-3xl font-bold text-white text-center mb-1 tracking-wide">
                Login
            </h1>
            <p class="font-montserrat text-white/80 text-sm text-center mb-3">
                Gunakan akun anda untuk masuk.
            </p>

            {{-- Quote dengan animasi slide --}}
            <div class="mb-7 min-h-[52px] flex items-center justify-center overflow-hidden">
                <div id="quoteWrapper" class="text-center w-full">
                    <p id="quoteText"
                        class="font-montserrat text-white/70 text-xs italic leading-relaxed px-2
                               transition-all duration-700 ease-in-out">
                    </p>
                    <p id="quoteAuthor"
                        class="font-montserrat text-white/50 text-[10px] mt-1
                               transition-all duration-700 ease-in-out">
                    </p>
                </div>
            </div>

            {{-- Error --}}
            @if(session('error'))
            <div class="bg-red-500/20 border border-red-500/50 text-white text-xs p-3 rounded-lg text-center mb-4">
                {{ session('error') }}
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-500/20 border border-red-500/50 text-white text-xs p-3 rounded-lg text-center mb-4">
                {{ $errors->first() }}
            </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block font-montserrat text-white text-sm font-medium mb-1">NIK</label>
                    <input
                        type="text"
                        name="NIK"
                        value="{{ old('NIK') }}"
                        required
                        placeholder="Masukkan NIK kamu"
                        class="w-full px-4 py-2.5 rounded-lg bg-white/90 font-montserrat text-gray-800
                               placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-white/60 transition">
                </div>

                <div>
                    <label class="block font-montserrat text-white text-sm font-medium mb-1">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="passwordInput"
                            required
                            placeholder="Masukkan password kamu"
                            class="w-full px-4 py-2.5 pr-10 rounded-lg bg-white/90 font-montserrat text-gray-800
                                   placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-white/60 transition">
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600 transition">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember"
                        class="w-4 h-4 rounded border-gray-300 text-[#1E3A8A]">
                    <label for="remember" class="font-montserrat text-white/70 text-xs cursor-pointer">
                        Ingat saya
                    </label>
                </div>

                <div class="pt-1">
                    <button type="submit"
                        class="w-full py-2.5 bg-[#1E3A8A] hover:bg-[#1e40af] font-poppins text-white font-semibold
                               rounded-lg transition duration-200 tracking-wide shadow-lg">
                        Masuk
                    </button>
                </div>

            </form>

            <p class="text-center text-white/40 text-[10px] mt-6">
                &copy; {{ date('Y') }} RS Citra Husada
            </p>

        </div>
    </div>

</div>

<script>
// ── Daftar quote — berubah berdasarkan hari dalam setahun ──────────────
const quotes = [
    { text: "Selamat datang di Ruang Baca Virtual RS Citra Husada.", author: "— RBV System" },
    { text: "Kesehatan anda adalah harapan kami. Mari bekerja bersama dengan penuh dedikasi.", author: "— RS Citra Husada" },
    { text: "Pelayanan terbaik lahir dari tim yang solid dan berdedikasi.", author: "— RS Citra Husada" },
    { text: "Ilmu yang dibagikan akan terus tumbuh dan memberi manfaat.", author: "— Inspirasi Hari Ini" },
    { text: "Setiap surat yang terkelola dengan baik adalah langkah menuju birokrasi yang lebih sehat.", author: "— RBV System" },
    { text: "Kerja keras hari ini adalah fondasi kesuksesan hari esok.", author: "— Pepatah" },
    { text: "Profesionalisme bukan hanya soal keahlian, tapi juga tanggung jawab.", author: "— RS Citra Husada" },
    { text: "Dokumentasi yang rapi adalah cermin dari organisasi yang baik.", author: "— RBV System" },
    { text: "Bersama kita wujudkan pelayanan kesehatan yang berkualitas untuk masyarakat.", author: "— RS Citra Husada" },
    { text: "Semangat pagi! Hari baru, semangat baru, karya terbaik untuk pasien kita.", author: "— Inspirasi Hari Ini" },
    { text: "Kepercayaan pasien adalah amanah yang harus kita jaga sepenuh hati.", author: "— RS Citra Husada" },
    { text: "Teknologi hadir untuk memudahkan, bukan mempersulit. Gunakanlah dengan bijak.", author: "— RBV System" },
    { text: "Setiap langkah kecil dalam pekerjaan kita berkontribusi pada kesehatan masyarakat.", author: "— RS Citra Husada" },
    { text: "Disiplin dalam administrasi adalah disiplin dalam pelayanan.", author: "— Inspirasi Hari Ini" },
    { text: "Hari ini adalah kesempatan untuk memberikan yang terbaik bagi tim dan pasien kita.", author: "— RS Citra Husada" },
];

// Tentukan quote berdasarkan hari dalam setahun (berubah tiap hari)
function getQuoteOfTheDay() {
    const now       = new Date();
    const start     = new Date(now.getFullYear(), 0, 0);
    const diff      = now - start;
    const oneDay    = 1000 * 60 * 60 * 24;
    const dayOfYear = Math.floor(diff / oneDay);
    return quotes[dayOfYear % quotes.length];
}

// Animasi slide in dari bawah
function showQuote(quote) {
    const textEl   = document.getElementById('quoteText');
    const authorEl = document.getElementById('quoteAuthor');

    // Slide keluar ke atas
    textEl.style.opacity   = '0';
    textEl.style.transform = 'translateY(-12px)';
    authorEl.style.opacity = '0';

    setTimeout(() => {
        textEl.textContent   = `"${quote.text}"`;
        authorEl.textContent = quote.author;

        // Slide masuk dari bawah
        textEl.style.transform = 'translateY(12px)';

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                textEl.style.opacity   = '1';
                textEl.style.transform = 'translateY(0)';
                authorEl.style.opacity = '1';
            });
        });
    }, 350);
}

// Init
document.addEventListener('DOMContentLoaded', () => {
    const textEl   = document.getElementById('quoteText');
    const authorEl = document.getElementById('quoteAuthor');

    // Set transition
    textEl.style.transition   = 'opacity 0.6s ease, transform 0.6s ease';
    authorEl.style.transition = 'opacity 0.6s ease';

    // Tampilkan quote hari ini dengan delay kecil agar smooth
    setTimeout(() => showQuote(getQuoteOfTheDay()), 200);
});
</script>

<style>
#quoteText, #quoteAuthor {
    opacity: 0;
    transform: translateY(12px);
}
</style>

@endsection