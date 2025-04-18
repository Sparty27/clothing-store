<div>
    <div class="search flex relative items-center">
        {{-- <input type="search" wire:model.live="searchText" name="search" id="search" class="input" placeholder="Пошук"> --}}
        @include('livewire.site.form.input', [
            'model' => 'searchText',
            'isLive' => true,
            'class' => 'w-full h-12 text-md'
        ])
        
        <div class="search__icons absolute right-3 z-10">
            <button wire:click="close" data-search-modal-close class="mt-[2px]">
                <i class="ri-close-line ri-xl"></i>
            </button>
        </div>
    </div>
    <div class="search-modal__cards bg-[#FEFEFE]">
        @forelse ($products as $product)
            <a href="{{ route('products.show', $product->slug) }}" class="flex rounded-2xl h-12 w-full mt-1 items-center p-5 gap-4 text-lg bg-white shadow">
                <img src="{{ $product->mainPhoto->public_url ?? asset('img/image-not-found.jpg') }}" alt="{{ $product->name }}" width="38" height="38">
                <div class="flex items-center text-sm sm:text-lg justify-between w-full">
                    <span class="text-black line-clamp-1 flex-wrap break-words">{{ $product->name }}</span>
                    <strong class="text-primary">₴{{ $product->money_price }}</strong>
                </div>
            </a>
        @empty
            <span class="text-center">Товарів не знайдено</span>
        @endforelse
    </div>
</div>