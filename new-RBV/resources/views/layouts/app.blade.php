<!DOCTYPE html>
<html lang="en">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ruang Baca Virtual</title>
</head>
<body class="overflow-y-scroll">
    @include('components.navbar')

    @yield('content')
    @include('components.footer')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>