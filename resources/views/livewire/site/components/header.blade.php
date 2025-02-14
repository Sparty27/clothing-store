<div class="fixed top-0 z-10 bg-[#5A72A0] h-20 w-full flex items-center">
    <div class="mx-auto container px-4 sm:px-10 lg:px-20 flex items-center gap-12">
        <a href='{{ route('index') }}' class="w-[125px] md:w-[200px]">
            <img src="/img/svg/logo.svg" alt="search">
        </a>

            {{-- <button 
                wire:click="$dispatch('openModal', { component: 'site.modals.search-modal', arguments: { type: 'search' } })"
                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition"
            >
                Пошук
            </button> --}}

        <div class="w-full max-w-xs hidden sm:block">
            <div data-search-modal-open class="bg-[#FEFEFE] flex justify-between px-4 items-center rounded-xl h-9">
                <span>{!! trans('global.search') !!}</span>
                <i class="ri-search-line ri-xl"></i>
            </div>
        </div>
        <div data-search-modal-open class="sm:hidden">
            <i class="ri-search-line ri-xl text-white"></i>
        </div>
            {{-- <div class="header__search__mobile">
                <svg data-search-modal-open width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.5 17.5L22 22" stroke="#F2F3F2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M20 11C20 6.02944 15.9706 2 11 2C6.02944 2 2 6.02944 2 11C2 15.9706 6.02944 20 11 20C15.9706 20 20 15.9706 20 11Z" stroke="#F2F3F2" stroke-width="1.5" stroke-linejoin="round"/>
                </svg>
            </div> --}}
    </div>
</div>

