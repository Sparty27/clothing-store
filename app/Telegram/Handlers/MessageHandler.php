<?php

namespace App\Telegram\Handlers;

use App\Models\Order;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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

        if ($message->replyToMessage) {
            $replyText = $message->replyToMessage->text;
            
            if (Str::startsWith($replyText, 'Введіть новий ТТН для замовлення #')) {
                self::processTtnInput($chatId, $text, $replyText, $message->replyToMessage->messageId);
            }
        }
    }

    private static function processTtnInput(int $chatId, string $newTtn, string $replyText, int $messageId)
    {
        preg_match('/#(\d+)/', $replyText, $matches);
        $orderId = $matches[1] ?? null;

        if (!$orderId) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "❗ Помилка: Невірний формат замовлення"
            ]);
            return;
        }

        $page = Cache::get("user_{$chatId}_current_page", 1);
        $fakeCallbackData = "save_ttn_{$orderId}_{$page}_".urlencode($newTtn);

        CallbackHandler::handleSaveField(
            $chatId,
            $messageId,
            $fakeCallbackData
        );
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