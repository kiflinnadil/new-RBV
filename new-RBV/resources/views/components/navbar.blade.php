<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Citra Husada</title>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Nunito Sans', sans-serif;
}
</style>
</head>

<body class="bg-slate-50">

    <nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-5">
        <div class="flex items-center justify-between h-20">

            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo.png') }}"
                     alt="Logo Citra Husada"
                     class="h-12 w-auto">
            </div>

            <div class="hidden md:flex px-1 gap-10 text-[16px] font-semibold text-gray-700">

                <a href="/" class="hover:text-blue-700 transition">
                    Beranda
                </a>

                <a href="/berita" class="hover:text-blue-700 transition">
                    Berita
                </a>

                <a href="/koleksi" class="hover:text-blue-700 transition">
                    Koleksi
                </a>

                <a href="/artikel" class="hover:text-blue-700 transition">
                    Artikel
                </a>

                <a href="/video" class="hover:text-blue-700 transition">
                    Video
                </a>

            </div>

            <div class="hidden md:flex items-center gap-4">

                <a href="#"
                   class="px-6 py-2 border-2 border-blue-900 text-blue-900 rounded-lg font-semibold hover:bg-blue-50 transition">
                    Layanan
                </a>

                <a href="/login"
                   class="px-6 py-2 bg-blue-900 text-white rounded-lg font-semibold hover:bg-blue-800 transition">
                    Login
                </a>

            </div>

        </div>
    </div>
</nav>

</body>
</html>