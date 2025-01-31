<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dressiety | admin</title>

    <!-- Connect tailwind + daisyui -->
    @vite('resources/admin/scss/app.scss')
    @vite('resources/admin/js/app.js')

    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body>
    @yield('content')
</body>

</html>
