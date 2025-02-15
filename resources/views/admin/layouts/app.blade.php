<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dressiety | admin</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Connect tailwind + daisyui -->
    @vite('resources/admin/scss/app.scss')
    @vite('resources/admin/js/app.js')
</head>
<body>
    @livewire('admin.components.alert')

    <main class="drawer lg:drawer-open relative min-h-screen">
        <input id="drawer" type="checkbox" class="drawer-toggle">
        <div class="drawer-content relative">
            @include('admin.parts.header')

            {{-- <div class="px-2 md:p-6 mt-3">
                @yield('breadcrumbs')
            </div> --}}
            

            <div class="w-full p-2 md:p-6 pb-16 flex flex-col gap-8">
                @yield('content')
            </div>
        </div>

        <div class="drawer-side z-40">
            @include('admin.parts.sidebar')
        </div>
    </main>

    @livewire('wire-elements-modal')
    @yield('script')
    @stack('scripts')
</body>
</html>