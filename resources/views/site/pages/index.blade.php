@extends('site.layouts.app')

@section('content')

    <div class="glide-hero glide py-10 pb-16 px-12 sm:px-28 xl:h-[550px] shadow-[0px_20px_50px_0px_rgba(26,27,26,0.15)] border-2 rounded-2xl border-opacity-10 border-primary">
        <div class="glide__track" data-glide-el="track">
        <ul class="glide__slides flex items-center">
            @foreach ($popularProducts as $product)
            <li class="glide__slide rounded-2xl">
                <div class="flex-col xl:flex-row flex justify-between gap-7">
                    <div class="flex flex-col justify-between order-2 xl:order-1">
                        <div>
                            <div class="text-center lg:text-left text-[30px] md:text-[50px] font-bold break-words wrap">
                                {{ $product->name }}
                            </div>
                            <div class="mt-5 sm:mt-3 break-words flex-wrap line-clamp-6">
                                {!! $product->short_description !!}
                            </div>
                        </div>
                        <div class="mt-5 flex justify-center xl:justify-start">
                            <button class="btn btn-primary text-xl w-full md:w-[300px] md:h-[60px]">Купити</button>
                        </div>
                    </div>
                    <div class="lg:min-w-[438px] flex justify-center xl:flex-none mt-5 sm:mt-0 order-1 xl:order-2">
                        <img 
                          src="{{ $product->mainPhoto->public_url ?? asset('img/image-not-found.jpg') }}" 
                          alt="popular product" 
                          class="w-[250px] h-[250px] lg:w-[438px] lg:h-[438px] object-cover"
                        >
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

    <div>
        <select class="js-example-basic-single" name="state">
            <option value="AL">Alabama</option>
            <option value="WY">Wyoming</option>
        </select>
    </div>
    index page

    @for ($i = 0; $i < 15; $i++)
        <div class="mt-6">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum asperiores fugiat possimus corrupti repudiandae repellat sit nihil blanditiis nisi ad quaerat autem incidunt impedit, praesentium perspiciatis? Quisquam ducimus enim quis.
        </div>
    @endfor
@endsection