<header class="w-full shadow-md">
    <div class="flex justify-between w-full py-2 px-3 md:px-8 items-center">
        <h1 class="text-xl font-bold hidden lg:block">
            <a href="{{ route('admin.index') }}">Панель адміністратора</a>
        </h1>
        <div>
            <label for="drawer" class="btn btn-square btn-ghost drawer-button lg:hidden">
                <svg width="20" height="20"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        class="inline-block h-5 w-5 stroke-current md:h-6 md:w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </label>
        </div>

        <div class="dropdown dropdown-end">
            <div class="join">
                <span  tabindex="0" class="shadow-lg border-gray-100 border-1 avatar cursor-pointer btn btn-ghost font-bold">Admin</span>
            </div>

            <ul tabindex="0" class="mt-3 p-2 shadow menu menu-compact dropdown-content bg-base-100 rounded-box w-52">
                <li>
                    <label for="logout">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" id="logout" class="flex items-center gap-2">Вийти <i class="ri-logout-box-line"></i></button>
                        </form>
                    </label>
                </li>
            </ul>
        </div>
    </div>
</header>
