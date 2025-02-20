<div class="static top-0 z-10 bg-[#5A72A0] h-20 w-full flex items-center">
    <div class="mx-auto container px-4 sm:px-10 lg:px-20 justify-between gap-2 flex items-center">
        <div class="flex items-center gap-4 md:gap-12">
            <div class="w-[125px] xl:w-[200px]">
                <a href='{{ route('index') }}' class="">
                    <img class="" src="/img/svg/logo.svg" alt="search">
                </a>
            </div>

            <div class="md:w-[240px] xl:w-[320px] hidden md:block">
                <div data-search-modal-open class="bg-[#FEFEFE] flex justify-between px-4 items-center rounded-xl h-9">
                    <span>Пошук</span>
                    <i class="ri-search-line ri-xl"></i>
                </div>
            </div>

            <div data-search-modal-open class="md:hidden flex items-center">
                <i class="ri-search-line ri-xl text-white"></i>
            </div>
        </div>

        <div class="flex gap-3 md:gap-6 lg:gap-12 justify-between items-center">
            <div class="flex items-center gap-3 min-w-max">
                <div class="relative">
                    @livewire('site.basket')
                </div>
                <a href="{{ route('catalog') }}">
                    <i class="ri-menu-search-line ri-xl text-white"></i>
                </a>
            </div>
            <div class="flex gap-3 text-white">
                @auth
                    @if(auth()->user()->role === App\Enums\RoleEnum::ADMIN)
                        <a href="{{ route('admin.index') }}" class="flex items-center gap-1">
                            <i class="ri-lock-2-line ri-xl"></i>
                            <span class="max-md:hidden">
                                Адмінка
                            </span>
                        </a>
                    @endif
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="flex items-center gap-1">
                        <i class="ri-user-line ri-xl"></i>
                        Увійти
                    </a>
                @endguest
                @auth
                    <a href="{{ route('profile.home') }}" class="flex items-center gap-1 max-lg:hidden">
                        <i class="ri-user-line ri-xl"></i>
                        <span class="">
                            {{ auth()->user()?->name }}
                        </span>
                    </a>
                @endauth
            </div>

            <div class="drawer drawer-end lg:hidden">
                <input id="my-drawer-menu" type="checkbox" class="drawer-toggle" />
                <div class="drawer-content flex items-center">
                  <!-- Page content here -->
                  <label for="my-drawer-menu" class="drawer-button swap swap-rotate btn-primary">
                        <!-- this hidden checkbox controls the state -->
                        <input type="checkbox" />
                      
                        <!-- hamburger icon -->
                        <i class="ri-menu-line ri-xl swap-off fill-current"></i>
                      
                        <!-- close icon -->
                        <i class="ri-close-line ri-xl swap-on fill-current"></i>
                  </label>
                </div>
                <div class="drawer-side z-[100]">
                  <label for="my-drawer-menu" aria-label="close sidebar" class="drawer-overlay"></label>
                  <ul class="menu bg-base-200 text-base-content min-h-full w-80 max-sm:w-screen p-4">
                    <div class="p-4 flex justify-between items-center border-b-2 border-b-gray-200">
                        <span class="font-bold text-2xl">Меню</span>
        
                        <label for="my-drawer-menu" class="drawer-button btn-primary cursor-pointer">
                            <i class="ri-close-fill ri-xl text-black text-2xl"></i>
                        </label>
                    </div>
                    <div class="shadow-lg p-3 max-sm:w-full max-h-max w-full rounded-lg border-[1px] border-gray-200 mt-9">
                        <div class="text-2xl font-bold border-b-2 border-b-gray-200">
                            Особистий кабінет
                        </div>
            
                        <div class="mt-3 flex flex-col gap-3">
                            <a href="{{ route('profile.home') }}" class="btn {{ request()->routeIs('profile.home') ? 'btn-primary' : '' }} w-full text-lg">
                                <i class="ri-user-line"></i>
                                Профіль
                            </a>
                            <a href="{{ route('profile.orders') }}" class="btn {{ request()->routeIs('profile.orders') ? 'btn-primary' : '' }} w-full text-lg">
                                <i class="ri-shopping-cart-line"></i>
                                Мої покупки
                            </a>
                            <a href="{{ route('profile.settings') }}" class="btn {{ request()->routeIs('profile.settings') ? 'btn-primary' : '' }} w-full text-lg">
                                <i class="ri-settings-4-line"></i>
                                Налаштування
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="btn w-full text-lg text-red-500">
                                    <i class="ri-logout-box-line"></i>
                                    Вийти
                                </button>
                            </form>
                        </div>
                    </div>
                  </ul>
                </div>
              </div>
        </div>

            {{-- <button 
                wire:click="$dispatch('openModal', { component: 'site.modals.search-modal', arguments: { type: 'search' } })"
                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition"
            >
                Пошук
            </button> --}}



            {{-- <div class="header__search__mobile">
                <svg data-search-modal-open width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.5 17.5L22 22" stroke="#F2F3F2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M20 11C20 6.02944 15.9706 2 11 2C6.02944 2 2 6.02944 2 11C2 15.9706 6.02944 20 11 20C15.9706 20 20 15.9706 20 11Z" stroke="#F2F3F2" stroke-width="1.5" stroke-linejoin="round"/>
                </svg>
            </div> --}}
    </div>
</div>

