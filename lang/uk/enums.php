<?php

return [
    'delivery_methods' => [
        'nova_poshta' => 'Нова Пошта',
        'pickup' => 'Самовивіз',
    ],
    'payment_methods' => [
        'monobank' => 'Монобанк',
        'on_receipt' => 'При отриманні',
        'bank_transfer' => 'На рахунок',
    ],
    'order_status' => [
        'new' => 'Новий',
        'in_process' => 'В обробці',
        'done' => 'Виконаний', 
        'failed' => 'Скасований',
    ],
    'payment_status' => [
        'created' => 'Створено',
        'in_process' => 'В процесі',
        'success' => 'Оплачено',
        'failed' => 'Скасовано',
    ],
    'delivery_status' => [
        'created' => 'Створено',
        'in_process' => 'Доставляється',
        'not_sent' => 'Не відправлено',
        'deliveried' => 'Доставлено',
        'canceled' => 'Скасовано',
        'returned' => 'Повернено',
    ],
    'sort_products' => [
        'name_asc' => 'Назва: А до Я',
        'name_desc' => 'Назва: Я до А',
        'price_asc' => 'Ціна: Спочатку найдешевші',
        'price_desc' => 'Ціна: Спочатку найдорожчі',
    ]
];