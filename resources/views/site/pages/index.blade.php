@extends('site.layouts.app')

@section('content')
    <div class="glide-hero dark:bg-[#282828] glide py-10 pb-16 px-9 sm:px-28 xl:h-[550px] shadow-[0px_20px_50px_0px_rgba(26,27,26,0.15)] border-2 rounded-2xl border-opacity-10 border-primary">
        <div class="glide__track" data-glide-el="track">
        <ul class="glide__slides">
            @foreach ($popularProducts as $product)
            <li class="glide__slide rounded-2xl">
                <div class="xl:flex xl:flex-row-reverse gap-7 justify-between">
                    <div class="xl:min-w-[438px] flex justify-center xl:flex-none">
                        <img 
                            src="{{ $product->mainPhoto->public_url ?? asset('img/image-not-found.jpg') }}" 
                            alt="popular product" 
                            class="w-[250px] h-[250px] xl:w-[438px] xl:h-[438px] object-cover"
                        >
                    </div>
                    <div class="flex flex-col justify-between h-[320px] md:h-[350px] xl:h-[438px] relative xl:static">
                        <div>
                            <div class="text-center xl:text-left text-[25px] sm:text-[30px] md:text-[40px] 2xl:text-[50px] font-bold break-words wrap line-clamp-2 dark:text-white">
                                {{ $product->name }}
                            </div>
                            <div class="mt-5 sm:mt-3 break-words flex-wrap line-clamp-6 dark:text-white">
                                {!! strip_tags($product->short_description) !!}
                            </div>
                        </div>

                        <div class="flex absolute bottom-0 left-1/2 transform -translate-x-1/2 justify-center xl:translate-x-0 xl:static xl:justify-start">
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary text-xl w-[150px] md:w-[300px] md:h-[60px] dark:bg-primary">Купити</a>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        </div>

        <div class="glide__arrows" data-glide-el="controls">
            <button class="glide__arrow glide__arrow--left" data-glide-dir="<">
                <i class="ri-arrow-left-fill ri-lg text-primary"></i>
            </button>
            <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
                <i class="ri-arrow-right-fill ri-lg text-primary"></i>
            </button>
        </div>

        <div class="glide__bullets" data-glide-el="controls[nav]">
            @foreach ($popularProducts as $index => $product)
                <button class="glide__bullet" data-glide-dir="={{ $index }}"></button>
            @endforeach
        </div>
    </div>

    <div class="mt-24">
        <h2 class="font-bold text-3xl text-center dark:text-white">Категорії</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mt-6">
            @foreach ($categories as $category)
                <a href="{{ route('catalog', $category->slug) }}" class="w-full h-24 p-3 sm:p-2 flex justify-center items-center text-xl cursor-pointer duration-200 shadow-[20px_10px_30px_0px_rgba(0,0,0,0.1)] border-gray-200 border-[1px] bg-white dark:bg-[#3f3f3f] dark:text-white dark:border-[#575757] dark:hover:bg-[#575757] hover:text-primary hover:border-primary">
                    <span class="line-clamp-1 break-words text-wrap">
                        {{ $category->name }}
                    </span>
                </a>
            @endforeach
        </div>

        <div class="flex justify-center mt-6">
            <a href="{{ route('catalog') }}" class="text-xl text-primary underline decoration-primary underline-offset-8">
                Перейти до каталогу
            </a>
        </div>
    </div>

    <div class="mt-24 ">
        <h2 class="font-bold text-3xl text-center dark:text-white">Популярні товари</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4 gap-y-6 mt-6">
            @foreach ($popularProducts as $index => $product)
                @livewire('site.components.product-card', ['product' => $product, 'mainPhoto' => $product->mainPhoto], key($index))
            @endforeach
        </div>
    </div>
@endsection