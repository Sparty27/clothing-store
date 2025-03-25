<?php

namespace App\Telegram\Handlers;

use Telegram\Bot\Keyboard\Keyboard;

class Handler
{
    public static function isModerator(int $chatId): bool
    {
        return in_array($chatId, config('telegram.moderators', []));
    }

    public static function formatOrdersPage($orders, int $page): string
    {
        if ($orders->isEmpty()) {
            return "На сторінці {$page} замовлень не знайдено.";
        }

        $text = view('telegram.orders', [
            'orders' => $orders,
            'page' => $page,
        ])->render();

        return $text;
    }

    public static function buildPaginationKeyboard($orders, int $currentPage): Keyboard
    {
        $keyboard = Keyboard::make()->inline();

        foreach ($orders as $order) {
            $keyboard->row([
                Keyboard::inlineButton([
                    'text' => "✏️ Замовлення #{$order->id}",
                    'callback_data' => "edit_order_{$order->id}_{$currentPage}"
                ])
            ]);
        }

        $paginationRow = [];
        if ($currentPage > 1) {
            $paginationRow[] = Keyboard::inlineButton([
                'text' => '⬅️ Попередня',
                'callback_data' => 'orders_page_'.($currentPage - 1)
            ]);
        }
        
        if ($orders->hasMorePages()) {
            $paginationRow[] = Keyboard::inlineButton([
                'text' => 'Наступна ➡️',
                'callback_data' => 'orders_page_'.($currentPage + 1)
            ]);
        }
        
        if (!empty($paginationRow)) {
            $keyboard->row([...$paginationRow]);
        }

        return $keyboard;
    }
}