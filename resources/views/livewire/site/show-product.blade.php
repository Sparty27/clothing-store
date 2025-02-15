<div>
    <div class="static lg:flex gap-12">
        <div class="lg:max-w-[400px] xl:max-w-[600px] shrink-0">
            <div class="h-[600px] rounded-2xl overflow-hidden flex justify-center items-center relative">
                @if ($product->discount_percentage)
                    <div class="absolute top-2 right-2">
                        <div class="bg-red-500  p-3 text-white">-{{ $product->discount_percentage }}%</div>
                    </div>
                @endif
                <div class="absolute left-6 text-[50px] text-white drop-shadow-lg">
                    <button type="button" wire:click="selectPreviousPhoto">
                        <i class="ri-arrow-left-wide-fill ri-xl "></i>
                    </button>
                </div>
                <div class="absolute right-6 text-[50px] text-white drop-shadow-lg">
                    <button type="button" wire:click="selectNextPhoto">
                        <i class="ri-arrow-right-wide-fill ri-xl"></i>
                    </button>
                </div>
                <img class="object-fit max-h-[600px]" src="{{ $selectedPhoto->public_url ?? asset('img/image-not-found.jpg') }}" alt="{{ $product->name }}" height="600" title="{{ $product->name }}">
            </div>
            <div class="mx-auto">
                <div class="flex gap-2 flex-wrap mt-3">
                    @foreach($product->photos as $photo)
                        <img class="cursor-pointer object-cover w-[92px] h-[92px] bg-black @if($selectedPhoto->id == $photo->id) brightness-100 border-2 border-primary rounded-lg @else brightness-75 @endif" wire:click="selectPhoto('{{ $photo->id }}')" src="{{ $photo->public_url ?? asset('img/image-not-found.jpg') }}" alt="{{ $product->name }}" width="92" height="92" decoding="async" loading="lazy">
                    @endforeach
                </div>
            </div>
        </div>
    
        <div>
            <div>
                <h1 class="text-[40px]">{{ $product->name }}</h1>
                <div class="flex gap-5">
                    <span class="">
                        {{-- {!! clean_trans('global.article') !!}: {{ $product->article }} --}}
                        Артикул: {{ $product->article }}
                    </span>
                    <span>
                        Категорія: {{ $product->category->name }}
                    </span>
                </div>
                <div class="w-full">
                    @if ($product->is_in_stock)
                        <span class="text-[#76c267]">
                            {{-- {!! clean_trans('global.in_stock') !!} --}}
                            Є в наявності
                        </span>
                    @else
                        <span class="text-red-500">
                            {{-- {!! clean_trans('global.out_stock') !!} --}}
                            Немає в наявності
                        </span>
                    @endif
                </div>
            </div>
    
            <div class="mt-3">
                <span class="font-semibold text-lg">Розмір</span>
                <div class="flex gap-3 pl-1">
                    @foreach ($this->productSizes as $productSize)
                        <button type="button" wire:click="selectSize('{{ $productSize->size_id }}')" class="@if($productSize->count <= 0) cursor-default  text-gray-200 @else cursor-pointer @endif @if($selectedSize == $productSize->size_id) underline font-bold text-primary @endif">
                            {{ $productSize->size->name }}
                        </button>
                    @endforeach
                </div>
            </div>
    
            <div class="my-3 text-[24px]">
                @if ($product->money_old_price)
                    <strong class="text-primary">{{ $product->money_price }} грн.</strong>
                    <span class="line-through text-gray-500 ml-2">{{ $product->money_old_price }} грн.</span>
                @else
                    <strong class="text-primary">{{ $product->money_price }} грн.</strong>
                @endif
            </div>
        
            <button type="button" wire:click="addToBasket('{{ $product->id }}')" class="btn btn-primary">
                {{-- {!! clean_trans('global.buy') !!} --}}
                Купити
            </button>
    
            @if($product->description)
                <div class="mt-3">
                    <div class="text-lg pl-1 text-center">
                        Опис
                    </div>
                    <div class="text-sm font-semibold leading-relaxed">
                        @if($showFullDesc)
                            {!! $product->description !!}
                        @else
                            {!! Str::limit(strip_tags($product->description), 400, '...') !!}
                        @endif
                    </div>
                    <div class="flex justify-center">
                        <button wire:click="toggleShowDesc" class="text-primary text-sm bg-white border-primary p-1 border-2 rounded-2xl mt-2 hover:bg-primary hover:text-white duration-200">
                            {{ $showFullDesc ? 'Показати менше' : 'Показати більше' }}
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="flex items-center justify-center w-full mt-6">
        <div class="flex items-center w-full">
            <div class="flex-1 border-t border-black"></div>
            <span class="px-4 text-center text-2xl">Схожі товари</span>
            <div class="flex-1 border-t border-black"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4 gap-y-6 mt-6">
        @foreach ($this->similarProducts as $product)
            @livewire('site.components.product-card', ['product' => $product, 'mainPhoto' => $product->mainPhoto])
        @endforeach
    </div>
</div>