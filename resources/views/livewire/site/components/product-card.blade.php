<div class="rounded-lg p-6 sm:p-4 shadow-xl border-gray-200 border-[1px] flex flex-col justify-between">
    <a href="{{ route('products.show', $product->slug) }}" class="relative block">
        @if ($product->discount_percentage)
            <div class="absolute top-0 right-0">
                <div class="bg-red-500  p-3 text-white">-{{ $product->discount_percentage }}%</div>
            </div>
        @endif

        <div class="w-full h-[230px] flex items-center justify-center">
            <img src="{{ $mainPhoto->public_url ?? asset('img/image-not-found.jpg') }}" alt="{{ $product->name }}" width="230" height="230" decoding="async" loading="lazy" title="{{ $product->name }}">
        </div>
        <div class="w-full">
            <div class="break-words font-bold text-lg line-clamp-2">{{ $product->name }}</div>
            @if ($product->is_in_stock)
                <span class="text-[#76c267]">{!! clean_trans('global.in_stock') !!}</span>
            @else
                <span class="text-red-500">{!! clean_trans('global.out_stock') !!}</span>
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
            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary w-full">{!! clean_trans('global.product_in_basket') !!}</a>
        {{-- @else
            <button class="button" type="button" wire:click="addToBasket('{{ $product->id }}')">{!! clean_trans('global.to_basket') !!}</button>
        @endif --}}
    </div>

</div>