Номер замовлення: <code>{{ $order->id }}</code>
Прізвище та імʼя: {{ $order->customer_last_name }} {{ $order->customer_name }}
Телефон: {{ $order->phone->formatE164() }}
@if($order->warehouse_id)
Місто: {{ $order->warehouse->city->name }}
Відділення: {{ $order->warehouse->name }}
@endif

Загальна сума: <b>{{ $order->money_total }} грн</b>


📋 Список замовлень (стор. {{ $currentPage }})
Показано замовлення з {{ $from }} по {{ $to }} із {{ $total }}