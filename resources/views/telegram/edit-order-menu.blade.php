Оберіть поле для редагування замовлення #{{ $order->id }}
Поточні значення:
📦 ТТН: {{ $order->ttn ?? 'не вказано' }}
🔄 Статус: {{ $order->status->label() ?? 'N/A' }}
🚚 Доставка: {{ $order?->delivery_status?->label() ?? 'N/A' }}