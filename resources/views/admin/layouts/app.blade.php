<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dressiety | admin</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

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
</body>
</html>