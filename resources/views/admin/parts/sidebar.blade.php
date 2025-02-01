<label for="drawer" class="drawer-overlay"></label>
<aside class="w-80 h-screen bg-base-200">
    <div class="z-20 sticky top-0 items-center justify-center p-4 pt-6 lg:flex">
        <a href="/"
            {{-- target="_blank"  --}}
            aria-current="page" aria-label="Homepage" class="p-0 flex justify-center flex-1">
           <img src="/img/svg/logo.svg" alt="Logo" class="w-[200px]">
        </a>
    </div>

    <ul class="menu menu-sm lg:menu-md px-4 py-4 gap-2 [&_a.active]:!text-white [&_a.active]:!bg-primary">

        <li>
            <a href="#" class="flex gap-4 {{ request()->routeIs('admin.orders.*') ? 'active':'' }}">
                <span class="rounded-lg shadow-lg w-8 h-8 bg-base-100 text-black flex justify-center items-center flex-shrink-0">
                    <i class="ri-receipt-line"></i>
                </span>

                <div class="flex justify-between w-full items-center">
                    <div>
                        Замовлення
                    </div>

                    <div>
                        {{-- TODO: add counter --}}
                        {{-- @livewire('admin.orders.order-counter') --}}
                    </div>
                </div>
            </a>
        </li>

        <li>
            <a href="#" class="flex gap-4 {{ request()->routeIs('admin.products.*') ? 'active':'' }}">
                <span class="rounded-lg shadow-lg w-8 h-8 bg-base-100 text-black flex justify-center items-center">
                    <i class="ri-inbox-line"></i>
                </span>

                <span class="flex-1">
                    Товари
                </span>
            </a>
        </li>

        <li>
            <a href="#" class="flex gap-4 {{ request()->routeIs('admin.categories.*') ? 'active':'' }}">
                <span class="rounded-lg shadow-lg w-8 h-8 bg-base-100 text-black flex justify-center items-center">
                    <i class="ri-list-check"></i>
                </span>

                <span class="flex-1">
                    Категорії
                </span>
            </a>
        </li>

        <li>
            <a href="#" class="flex gap-4 {{ request()->routeIs('admin.characteristics.*') ? 'active':'' }}">
                <span class="rounded-lg shadow-lg w-8 h-8 bg-base-100 text-black flex justify-center items-center">
                    <i class="ri-list-check-3"></i>
                </span>

                <span class="flex-1">
                    Характеристики товару
                </span>
            </a>
        </li>

        <li>
            <a href="#" class="flex gap-4 {{ request()->routeIs('admin.users.*') ? 'active':'' }}">
                <span class="rounded-lg shadow-lg w-8 h-8 bg-base-100 text-black flex justify-center items-center">
                    <i class="ri-user-line"></i>
                </span>

                <span class="flex-1">
                    Користувачі
                </span>
            </a>
        </li>

        <li>
            <a href="#" class="flex gap-4">
                <span class="rounded-lg shadow-lg w-8 h-8 bg-base-100 text-black flex justify-center items-center">
                    <i class="ri-news-line"></i>
                </span>

                <span class="flex-1">
                    Logs
                </span>
            </a>
        </li>

        <li>
            <details open>
                <summary>
                    <span class="rounded-lg shadow-lg w-8 h-8 bg-base-100 text-black flex justify-center items-center">
                        <i class="ri-tools-fill"></i>
                    </span>
                    Налаштування системи
                </summary>

                <ul>
                    <li>
                        <a href="#" class="flex gap-4 mt-2 {{ request()->routeIs('admin.contacts.*') ? 'active':'' }}">
                            <span class="rounded-lg shadow-lg w-8 h-8 bg-base-100 text-black flex justify-center items-center">
                                <i class="ri-contacts-line"></i>
                            </span>

                            <span class="flex-1">
                                Контакти
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex gap-4 mt-2 {{ request()->routeIs('admin.language-lines.*') ? 'active':'' }}">
                            <span class="rounded-lg shadow-lg w-8 h-8 bg-base-100 text-black flex justify-center items-center">
                                <i class="ri-earth-line"></i>
                            </span>

                            <span class="flex-1">
                                Локалізація сторінок
                            </span>
                        </a>
                    </li>
                </ul>
            </details>
        </li>
    </ul>
</aside>
