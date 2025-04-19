<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dressiety') }}</title>

    {{-- <style>
        body { opacity: 0; transition: opacity 0.2s ease-in-out; }
    </style> --}}
    <script>
        if (localStorage.getItem("theme") === "dark" || 
            (!localStorage.getItem("theme") && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
            document.documentElement.classList.add("dark");
        } else {
            document.documentElement.classList.remove("dark");
        }
    </script>
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
    <div id="app" class="dark:bg-[#121212] dark:text-white">
        @livewire('site.components.alert')
        @livewire('site.components.header')

        <main class='mx-auto px-4 sm:px-10 lg:px-20 container min-h-[calc(100vh-300px)]'>
            <div class="mb-10 mt-3">
                @yield('breadcrumbs')
            </div>
            <div class="flex gap-12">
                <div class="shadow-lg p-3 max-w-[300px] max-h-max w-full rounded-lg border-[1px] border-gray-100 max-lg:hidden">
                    <div class="text-2xl font-bold border-b-2 border-b-gray-200">
                        Особистий кабінет
                    </div>
        
                    <div class="mt-3 flex flex-col gap-3">
                        <a href="{{ route('profile.home') }}" class="btn dark:bg-[#3f3f3f] dark:text-white dark:border-[#575757] {{ request()->routeIs('profile.home') ? 'btn-primary dark:bg-primary' : '' }} w-full text-md">
                            <i class="ri-user-line"></i>
                            Профіль
                        </a>
                        <a href="{{ route('profile.orders') }}" class="btn dark:bg-[#3f3f3f] dark:text-white dark:border-[#575757] {{ request()->routeIs('profile.orders') ? 'btn-primary dark:bg-primary' : '' }} w-full text-md">
                            <i class="ri-shopping-cart-line"></i>
                            Мої покупки
                        </a>
                        <a href="{{ route('profile.settings') }}" class="btn dark:bg-[#3f3f3f] dark:text-white dark:border-[#575757] {{ request()->routeIs('profile.settings') ? 'btn-primary dark:bg-primary' : '' }} w-full text-md">
                            <i class="ri-settings-4-line"></i>
                            Налаштування
                        </a>
                        @auth
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="btn dark:bg-[#3f3f3f] dark:border-[#575757] w-full text-md text-red-500">
                                    <i class="ri-logout-box-line"></i>
                                    Вийти
                                </button>
                            </form>
                        @endauth
                        @guest
                            <a href="{{ route('login') }}" class="flex items-center gap-1">
                                <i class="ri-user-line ri-xl"></i>
                                <span class="max-sm:hidden">
                                    Увійти
                                </span>
                            </a>
                        @endguest
                    </div>
                </div>
                <div class="w-full">
                    @yield('content')
                </div>
            </div>
        </main>

        @livewire('site.components.footer')
        @include('site.parts.search-modal')
        @livewire('wire-elements-modal')
    </div>
</body>
</html>
