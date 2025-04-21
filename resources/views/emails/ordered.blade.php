@extends('emails.layout')

@section('title')
    Замовлення №{{ $order->id }}
@endsection

@section('content')
    <div class="section">
        <h3>Клієнт</h3>
        <p>Імʼя: {{ $order->customer_name }}</p>
        <p>Прізвище: {{ $order->customer_last_name }}</p>
    </div>

    @if($order->warehouse_id)
        <div class="section">
            <h3>Доставка</h3>
            <p>Місто: {{ $order->warehouse->city->name }}</p>
            <p>Відділення: {{ $order->warehouse->name }}</p>
        </div>
    @endif

    <div class="section">
        <h3>Товари</h3>

        @foreach ($order->orderProducts as $orderProduct)
            <div class="product">
                <div style="display: flex; align-items: center;">
                    <img src="{{ $orderProduct->product->mainPhoto->public_url ?? 'https://nyshchyi-nazar.pp.ua/img/image-not-found.jpg' }}"
                         alt="{{ $orderProduct->product->name }}" width="80" height="80">
                </div>

                <div class="product-details">
                    <p class="text-bold">{{ $orderProduct->product->name }}</p>
                    <p>Артикул: {{ $orderProduct->product->article }}</p>
                    <p>Розмір: <span class="text-bold">{{ $orderProduct->size->name }}</span></p>
                    <p>Кількість: {{ $orderProduct->count }} шт.</p>
                    <p>Ціна: <span class="text-primary">{{ $orderProduct->product->money_price }} грн</span></p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="section">
        <p>Загальна сума: <span class="text-bold text-primary">{{ $order->money_total }} грн</span></p>
    </div>
@endsection
