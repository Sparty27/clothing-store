<?php

namespace App\Telegram\Handlers;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Laravel\Facades\Telegram;

class MessageHandler extends Handler
{
    public static function handle(Update $update)
    {
        $message = $update->getMessage();
        $text = $message->text ?? '';
        $chatId = $message->chat->id;

        if (str_starts_with($text, '/orders')) {
            self::handleOrdersCommand($chatId);
        } elseif (str_starts_with($text, 'ping')) {
            $message = Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'pong',
                'parse_mode' => 'HTML',
            ]);
        }
    }

    public static function handleOrdersCommand(int $chatId, int $page = 1)
    {
        if (!self::isModerator($chatId)) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Доступ заборонено!'
            ]);
            return;
        }

        $orders = Order::orderBy('created_at', 'desc')
            ->paginate(2, ['*'], 'page', $page);

        $responseText = self::formatOrdersPage($orders, $page);
        $keyboard = self::buildPaginationKeyboard($orders, $page);

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $responseText,
            'parse_mode' => 'HTML',
            'reply_markup' => $keyboard
        ]);
    }
}