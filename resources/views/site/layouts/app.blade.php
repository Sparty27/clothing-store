<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dressiety') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Scripts -->
    @vite('resources/site/scss/app.scss')
    @vite('resources/site/js/app.js')

    @stack('scripts')
</head>
<body>
    <div id="app">
        @livewire('site.components.alert')
        @livewire('site.components.header')

        <main class='mx-auto px-4 sm:px-10 lg:px-20 container min-h-[calc(100dvh-450px)]'>
            <div class="mb-10 mt-3">
                @yield('breadcrumbs')
            </div>
            @yield('content')
        </main>

        @livewire('site.components.footer')
        @include('site.parts.search-modal')
        @livewire('wire-elements-modal')
    </div>
</body>
</html>
