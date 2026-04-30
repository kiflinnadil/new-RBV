
const quoteGroups = [
    // senin
    [
        "Selamat datang! Semangat bekerja hari ini.",
        "Pelayanan terbaik dimulai dari niat yang tulus.",
        "Satu tim, satu tujuan — kesehatan masyarakat.",
        "Disiplin adalah kunci profesionalisme.",
        "Mulai hari dengan semangat, akhiri dengan bangga.",
    ],
    // selasa
    [
        "Disiplin hari ini, hasil luar biasa esok hari.",
        "Pasien kita adalah keluarga kita.",
        "Kerja ikhlas, kerja tuntas, kerja berkualitas.",
        "Setiap langkah kecil membawa perubahan besar.",
        "Melayani adalah kehormatan, bukan beban.",
    ],
    // rabu
    [
        "Terus belajar, terus berkembang, terus melayani.",
        "Kehadiran kamu hari ini berarti bagi banyak orang.",
        "Keselamatan pasien adalah tanggung jawab kita bersama.",
        "Ilmu yang baik lahir dari niat yang tulus.",
        "Jangan berhenti bertumbuh — pasien membutuhkanmu.",
    ],
    // kamis
    [
        "Senyum kamu adalah bagian dari obat terbaik.",
        "Jaga semangat — kerja kerasmu tidak sia-sia.",
        "Profesional bukan hanya soal ilmu, tapi juga akhlak.",
        "Empati adalah kompetensi yang paling berharga.",
        "Layani setiap pasien seperti melayani keluarga sendiri.",
    ],
    // jumat
    [
        "Kolaborasi yang baik menghasilkan pelayanan terbaik.",
        "Setiap tugas kecil yang kamu lakukan sangat berarti.",
        "Bangga menjadi bagian dari RS Citra Husada.",
        "Kerja tim yang solid adalah kekuatan terbesar kita.",
        "Akhiri pekan dengan hasil yang membanggakan.",
    ],
    // sabtu
    [
        "Akhir pekan tetap semangat melayani dengan hati.",
        "Dedikasi tidak mengenal hari libur.",
        "Kerja keras hari ini, kebanggaan esok hari.",
        "Konsistensi adalah bukti nyata profesionalisme.",
        "Pasien tidak memilih hari — begitu pula dedikasimu.",
    ],
    // minggu
    [
        "Istirahat yang cukup, semangat yang baru.",
        "Terima kasih telah hadir dan melayani.",
        "Bersama kita lebih kuat, bersama kita lebih baik.",
        "Recharge energi — pekan baru penuh peluang menantimu.",
        "Setiap pengorbananmu memberi harapan bagi orang lain.",
    ],
];

function getTodayGroup() {
    const day = new Date().getDay();
    const idx = day === 0 ? 6 : day - 1;
    return quoteGroups[idx];
}

const todayQuotes = getTodayGroup();
let currentIndex = 0;

function showQuote(idx, animate) {
    const el = document.getElementById('quoteText');
    if (!el) return;

    if (animate) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(6px)';
        setTimeout(function () {
            el.textContent = todayQuotes[idx];
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, 300);
    } else {
        el.textContent = todayQuotes[idx];
    }
}

function startAuto() {
    setInterval(function () {
        currentIndex = (currentIndex + 1) % todayQuotes.length;
        showQuote(currentIndex, true);
    }, 5000);
}

function togglePassword() {
    var input = document.getElementById('passwordInput');
    var icon = document.getElementById('eyeIcon');
    if (!input) return;
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var el = document.getElementById('quoteText');
    if (el) {
        el.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
    }
    currentIndex = 0;
    showQuote(currentIndex, false);
    startAuto();
});