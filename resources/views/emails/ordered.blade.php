@extends('emails.layout')

@section('title')
    Замовлено
@endsection

@section('content')
    <div class="mt-2">
        <h3 class="font-bold">Клієнт</h3>
        <div class="px-2">
            <p>Імʼя: {{ $order->customer_name }}</p>
            <p>Прізвище: {{ $order->customer_last_name }}</p>
        </div>
    </div>

    @if($order->warehouse_id)
        <div class="mt-2">
            <h3 class="font-bold">Доставка</h3>
            <div class="px-2">
                <p>Місто: {{ $order->warehouse->city->name }}</p>
                <p>Відділення: {{ $order->warehouse->name }}</p>
            </div>
        </div>
    @endif

    <div class="mt-2">
        <h3 class="font-bold">Товари</h3>
        <div>
            @foreach ($order->orderProducts as $orderProduct)
            <div class="bg-white dark:bg-[#3f3f3f] flex items-center gap-2 mt-3 p-2" wire:key="{{ $orderProduct->id }}">
                <div class="flex items-center min-w-max w-max">
                    <a href="{{ route('products.show', $orderProduct->product->slug) }}">
                        <img class="border-primary border-2 rounded-xl overflow-hidden max-sm:w-[50px]" src="{{ $orderProduct->product->mainPhoto->public_url ?? asset('img/image-not-found.jpg') }}" alt="{{ $orderProduct->product->name }}" width="80" height="80">
                    </a>
                </div>
                <div class="text-gray-500 w-full max-sm:text-xs">
                    <h3 class="font-bold text-black line-clamp-2 dark:text-primary">{{ $orderProduct->product->name }}</h3>
                    <div class="my-1">
                        <span class="dark:text-white">Артикул: {{ $orderProduct->product->article }}</span>
                    </div>
                    <div class="">
                        <span class="dark:text-white">Розмір: <span class="font-bold text-black dark:text-primary">{{ $orderProduct->size->name }}</span></span>
                    </div>
                </div>
                <div class="w-max min-w-max">
                    {{ $orderProduct->count }} шт.
                </div>
                <div class="flex justify-center items-center text-primary text-md min-w-max w-max px-2">
                    {{ number_format($orderProduct->product->money_price, 0)}} грн
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="mt-2">
        <p>Загальна сума: <b class="text-primary">{{ $order->money_total }} грн</b></p>
    </div>
@endsection