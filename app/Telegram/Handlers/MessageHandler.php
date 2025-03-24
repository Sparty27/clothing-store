<?php

namespace App\Telegram\Handlers;

use App\Models\Order;
use App\Telegram\Commands\OrdersCommand;
use App\Telegram\Commands\StartCommand;
use App\Telegram\Dialogs\Dialog;
use App\Telegram\StateManager;
use Exception;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Laravel\Facades\Telegram;

class MessageHandler
{
    public static function handle(Update $update)
    {
        $message = $update->getMessage();
        $text = $message->text;
        $chatId = $message->chat->id;

        if (str_starts_with($text, '/orders')) {
            self::handleOrdersCommand($chatId);
        }
    }

    public static function handleOrdersCommand(int $chatId, int $page = 1)
    {
        if (!self::isModerator($chatId)) {
            Log::info($chatId.' не модератор');
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Доступ заборонено!'
            ]);
            return;
        }

        Log::info($chatId.' модератор');

        $orders = Order::orderBy('created_at', 'desc')
            ->paginate(2, ['*'], 'page', $page);

        $responseText = self::formatOrdersPage($orders, $page);
        $keyboard = self::buildPaginationKeyboard($orders, $page);

        $lastMessageId = cache()->get("orders_msg_{$chatId}");

        if ($lastMessageId) {
            try {
                Telegram::editMessageText([
                    'chat_id' => $chatId,
                    'message_id' => $lastMessageId,
                    'text' => $responseText,
                    'parse_mode' => 'HTML',
                    'reply_markup' => $keyboard->isNotEmpty() ? $keyboard : Keyboard::remove()
                ]);
                return;
            } catch (\Exception $e) {
            }
        }

        $message = Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $responseText,
            'parse_mode' => 'HTML',
            'reply_markup' => $keyboard->isNotEmpty() ? $keyboard : Keyboard::remove()
        ]);

        cache()->put("orders_msg_{$chatId}", $message->getMessageId(), now()->addDay());
    }

    public static function isModerator(int $chatId): bool
    {
        $moderators = config('telegram.moderators', []);
        return in_array($chatId, $moderators);
    }

    public static function formatOrdersPage($orders, int $page): string
    {
        if ($orders->isEmpty()) {
            return "На сторінці {$page} замовлень не знайдено.";
        }
    
        $text = "<b>📖 Сторінка {$page}</b>\n\n";
        foreach ($orders as $order) {
            $text .= sprintf(
                "🆔 ID: %s\n"
                . "👤 Клієнт: %s %s\n"
                . "📞 Телефон: %s\n"
                . "🚚 Доставка: %s\n"
                . "📦 Статус: %s\n"
                . "💳 Оплата: %s (%s)\n"
                . "🏷️ ТТН: %s\n"
                . "🕒 Створено: %s\n\n",
                $order->id,
                $order->customer_name,
                $order->customer_last_name,
                $order->phone,
                $order->delivery_method,
                $order->status,
                $order->payment_method,
                $order->payment_status,
                $order->ttn ?? 'не вказано',
                $order->created_at->format('d.m.Y H:i')
            );
        }
        return $text;
    }

    public static function buildPaginationKeyboard($orders, int $currentPage): Keyboard
    {
        $keyboard = Keyboard::make()->inline();
    
        $buttons = [];
    
        if ($currentPage > 1) {
            $buttons[] = Keyboard::inlineButton([
                'text' => '⬅️ Попередня',
                'callback_data' => 'orders_page_' . ($currentPage - 1)
            ]);
        }
    
        if ($orders->hasMorePages()) {
            $buttons[] = Keyboard::inlineButton([
                'text' => 'Наступна ➡️',
                'callback_data' => 'orders_page_' . ($currentPage + 1)
            ]);
        }
    
        if (!empty($buttons)) {
            $keyboard->row($buttons);
        }
    
        return $keyboard;
    }
}