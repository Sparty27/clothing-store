<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dressiety') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite('resources/emails/scss/app.scss')
    @vite('resources/emails/js/app.js')
</head>
<body>
    <main class='bg-gray-300 min-h-screen pt-9'>
        <div class="mx-auto max-sm:max-w-[400px] max-w-[500px] p-4 bg-white shadow-lg rounded-lg">
            <div class="flex justify-center">
                <img class="" src="{{ asset('img/svg/logo.svg') }}" alt="search" width="200">
            </div>
            <div class="mt-3 font-bold text-lg">
                @yield('title')
            </div>
            <div class="mt-6">
                @yield('content')
            </div>

            <div class="border-t-[1px] border-t-gray-100 text-sm p-4 mt-6">
                Дякую, що користуєтесь Dressiety!
            </div>
        </div>
    </main>
</body>
</html>
