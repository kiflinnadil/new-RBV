<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">

    <title>Ruang Baca Virtual</title>

    <style>
        *:focus {
            outline: none !important;
            box-shadow: none !important;
        }
        a, button {
            -webkit-tap-highlight-color: transparent;
        }
        dialog:focus {
            outline: none !important;
        }
    </style>

</head>

<body class="overflow-y-scroll">

    @include('components.navbar')
    @yield('content')
    @include('components.footer')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>