Замовлення #{{ $order->id }}. Клієнт: {{ $order->customer_last_name }} {{ $order->customer_name }}
Загальна сума: {{ $order->money_total }} грн. Доставка: {{ $order->warehouse->city->name }}, {{ $order->warehouse->name }}. Дякуємо за замовлення!

{{-- Замовлення #{{ $order->id }}. Клієнт: {{ $order->customer_last_name }} {{ $order->customer_name }}
Товари:
@foreach ($order->orderProducts as $orderProduct)
- {{ $orderProduct->product->name }} ({{ $orderProduct->size->name }}), {{ $orderProduct->count }} шт. × {{ number_format($orderProduct->product->money_price, 0) }} грн
@endforeach

Загальна сума: {{ $order->money_total }} грн. Доставка: {{ $order->warehouse->city->name }}, {{ $order->warehouse->name }}. Дякуємо за замовлення! --}}