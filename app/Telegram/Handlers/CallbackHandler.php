<?php

namespace App\Telegram\Handlers;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class CallbackHandler extends Handler
{
    public static function handle(Update $update)
    {
        $callback = $update->callbackQuery;
        $data = $callback->data;
        $chatId = $callback->message->chat->id;
        $messageId = $callback->message->messageId;

        if (str_starts_with($data, 'orders_page_')) {
            self::handleOrdersPage($chatId, $messageId, (int) str_replace('orders_page_', '', $data));
        } elseif (str_starts_with($data, 'edit_order_')) {
            $parts = explode('_', $data);
            self::showEditMenu($chatId, $messageId, $parts[2], $parts[3]);
        } elseif (str_starts_with($data, 'edit_field_')) {
            $parts = explode('_', $data);
            self::handleFieldEdit($chatId, $messageId, $parts[3], $parts[4], $parts[2]);
        } elseif (str_starts_with($data, 'save_')) {
            self::handleSaveField($chatId,$messageId, $data);
        }
    }

    private static function handleOrdersPage(int $chatId, int $messageId, int $page)
    {
        if (!self::isModerator($chatId)) return;

        $orders = Order::orderBy('created_at', 'desc')
            ->paginate(2, ['*'], 'page', $page);

        Telegram::editMessageText([
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => self::formatOrdersPage($orders, $page),
            'parse_mode' => 'HTML',
            'reply_markup' => self::buildPaginationKeyboard($orders, $page)
        ]);
    }

    private static function showEditMenu(int $chatId, int $messageId, int $orderId, int $page)
    {
        $order = Order::withoutEvents(function () use ($orderId) {
            return Order::findOrFail($orderId);
        });
        
        $keyboard = Keyboard::make()->inline();
        $keyboard->row([
            Keyboard::inlineButton(['text' => '📦 ТТН', 'callback_data' => "edit_field_ttn_{$orderId}_{$page}"]),
            Keyboard::inlineButton(['text' => '🔄 Статус', 'callback_data' => "edit_field_status_{$orderId}_{$page}"])
        ]);
        $keyboard->row([
            Keyboard::inlineButton(['text' => '🚚 Доставка', 'callback_data' => "edit_field_delivery_{$orderId}_{$page}"]),
            Keyboard::inlineButton(['text' => '↩️ Назад', 'callback_data' => "orders_page_{$page}"])
        ]);

        $responseText = view('telegram.edit-order-menu', [
            'order' => $order,
        ])->render();

        Telegram::editMessageText([
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => $responseText,
            'parse_mode' => 'HTML',
            'reply_markup' => $keyboard
        ]);
    }

    private static function handleFieldEdit(int $chatId, int $messageId, int $orderId, int $page, string $field)
    {
        $config = [
            'ttn' => ['type' => 'text', 'force_reply' => true, 'message' => "Введіть новий ТТН для замовлення #{$orderId}:"],
            'status' => ['type' => 'options', 'options' => ['new', 'in-process', 'done']],
            'delivery' => ['type' => 'options', 'options' => ['created', 'in-process', 'deliveried', 'canceled', 'returned']],
        ][$field];

        if ($field === 'ttn') {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $config['message'],
                'reply_markup' => Keyboard::forceReply(['selective' => true]),
                'reply_to_message_id' => $messageId
            ]);
            return;
        }

        Log::info(json_encode($config, JSON_PRETTY_PRINT));

        $keyboard = $config['type'] === 'options' 
            ? self::buildOptionsKeyboard($field, $orderId, $page, $config['options'])
            : null;

        Log::info(json_encode($keyboard, JSON_PRETTY_PRINT));

        Telegram::editMessageText([
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => $config['message'] ?? "Оберіть нове значення для {$field}:",
            'reply_markup' => $keyboard
        ]);
    }

    public static function buildOptionsKeyboard(string $field, int $orderId, int $page, array $options): Keyboard
    {
        $keyboard = Keyboard::make()->inline();
        foreach ($options as $option) {
            $keyboard->row([Keyboard::inlineButton([
                'text' => $option,
                'callback_data' => "save_{$field}_{$orderId}_{$page}_".urlencode($option)
            ])]);
        }
        $keyboard->row([Keyboard::inlineButton([
            'text' => '↩️ Скасувати',
            'callback_data' => "edit_order_{$orderId}_{$page}"
        ])]);
        return $keyboard;
    }

    public static function handleSaveField(int $chatId, $messageId, string $data)
    {
        $parts = explode('_', $data);
        $field = $parts[1];
        $orderId = $parts[2];
        $page = $parts[3];
        $value = str_replace('-', '_', urldecode($parts[4]));
        Log::info(json_encode($field, JSON_PRETTY_PRINT));
        Log::info(json_encode($value, JSON_PRETTY_PRINT));

        $order = Order::findOrFail($orderId);
        Log::info(json_encode($order, JSON_PRETTY_PRINT));
        $order->update([$field => $value]);
        Log::info(json_encode($order, JSON_PRETTY_PRINT));

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "✅ Поле {$field} успішно оновлено!"
        ]);

        self::handleOrdersPage($chatId, $messageId, $page);
    }
}