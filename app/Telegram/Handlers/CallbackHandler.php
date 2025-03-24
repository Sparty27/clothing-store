<?php

namespace App\Telegram\Handlers;

use App\Models\Order;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class CallbackHandler
{
    public static function handle(Update $update)
    {
        $callback = $update->callbackQuery;
        $data = $callback->data;
        $chatId = $callback->message->chat->id;
        $messageId = $callback->message->messageId;

        if (str_starts_with($data, 'orders_page_')) {
            $page = (int) str_replace('orders_page_', '', $data);
            self::handleOrdersPage($chatId, $messageId, $page);
        }
    }

    private static function handleOrdersPage(int $chatId, int $messageId, int $page)
    {
        if (!MessageHandler::isModerator($chatId)) {
            return;
        }

        $orders = Order::orderBy('created_at', 'desc')
            ->paginate(2, ['*'], 'page', $page);

        $responseText = MessageHandler::formatOrdersPage($orders, $page);
        $keyboard = MessageHandler::buildPaginationKeyboard($orders, $page);

        cache()->put("orders_msg_{$chatId}", $messageId, now()->addDay());

        Telegram::editMessageText([
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => $responseText,
            'parse_mode' => 'HTML',
            'reply_markup' => $keyboard->isNotEmpty() ? $keyboard : Keyboard::remove()
        ]);
    }
}