<b>📖 Сторінка {{ $page }}</b>

@foreach($orders as $order)
🆔 ID: {{ $order->id }}
👤 Клієнт: {{ $order->customer_last_name }} {{ $order->customer_name }}
📞 Телефон: {{ $order->phone }}
🚚 Доставка: {{ $order->delivery_method?->label() ?? 'N/A' }} ({{ $order->delivery_status?->label() ?? 'N/A' }})
📦 Статус: {{ $order->status?->label() ?? 'N/A' }}
💳 Оплата: {{ $order->payment_method?->label() ?? 'N/A' }} ({{ $order->payment_status?->label() ?? 'N/A' }})
🏷️ ТТН: {{ $order->ttn ?? 'не вказано' }}
🕒 Створено: {{ $order->created_at->format('d.m.Y H:i') }}

@endforeach