<div class="rounded-lg p-6 sm:p-4 @if($isSmall) p-3 sm:p-2 @endif shadow-xl border-gray-200 dark:border-[#575757] border-[1px] flex flex-col justify-between">
    <a href="{{ route('products.show', $product->slug) }}" class="relative block">
        @if ($product->discount_percentage)
            <div class="absolute top-0 right-0">
                <div class="bg-red-500 p-3 @if($isSmall) text-sm p-1 @endif text-white">-{{ $product->discount_percentage }}%</div>
            </div>
        @endif

        <div class="w-full h-[230px] flex items-center justify-center">
            <img class="w-full max-w-[230px] @if($isSmall) max-w-[150px] @endif" src="{{ $mainPhoto->public_url ?? asset('img/image-not-found.jpg') }}" alt="{{ $product->name }}" width="230" height="230" decoding="async" loading="lazy" title="{{ $product->name }}">
        </div>
        <div class="w-full">
            <div class="break-words font-bold text-lg @if($isSmall) text-md @endif line-clamp-2 dark:text-white">{{ $product->name }}</div>
            @if ($product->is_in_stock)
                <span class="text-[#76c267]">В наявності</span>
            @else
                <span class="text-red-500">Немає в наявності</span>
            @endif
        </div>
        <div class="flex gap-1">
            @foreach ($this->productSizes as $productSize)
                <div class="text-gray-400 text-xs">
                    {{ $productSize->size->name }}
                </div>
            @endforeach
        </div>
    </a>
    <div>
        <div class="flex justify-end my-3">
            @if ($product->money_old_price)
                <strong class="text-primary">₴{{ $product->money_price }}</strong>
                <span class="line-through text-gray-500 ml-2">₴{{ $product->money_old_price }}</span>
            @else
                <strong class="text-primary">₴{{ $product->money_price }}</strong>
            @endif
        </div>

        {{-- @if($this->isInBasket($product)) --}}
            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary w-full text-lg">Купити</a>
        {{-- @else
            <button class="btn btn-primary w-full" type="button" wire:click="addToBasket('{{ $product->id }}')">{!! clean_trans('global.to_basket') !!}</button>
        @endif --}}
    </div>

</div>