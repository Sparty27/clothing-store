<b>📖 Сторінка {{ $page }}</b>

@foreach($orders as $order)
🆔 ID: {{ $order->id }}
📦 Статус: {{ $order->status?->label() ?? 'N/A' }}
👤 Клієнт: {{ $order->customer_last_name }} {{ $order->customer_name }}
📞 Телефон: {{ $order->phone }}
🚚 Доставка: {{ $order->delivery_method?->label() ?? 'N/A' }} ({{ $order->delivery_status?->label() ?? 'N/A' }})
🏷️ ТТН: {{ $order->ttn ?? 'не вказано' }}
💳 Оплата: {{ $order->payment_method?->label() ?? 'N/A' }} ({{ $order->payment_status?->label() ?? 'N/A' }})
💰 Сума: {{ $order->money_total.' ₴' ?? 'N/A' }}
🕒 Створено: {{ $order->created_at->format('d.m.Y H:i') }}

@endforeach