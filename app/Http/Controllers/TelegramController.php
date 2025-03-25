<?php

namespace App\Http\Controllers;

use App\Telegram\Handlers\CallbackHandler;
use App\Telegram\Handlers\MessageHandler;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function webhook()
    {
        try {
            $update = Telegram::getWebhookUpdate();
    
            if ($update->isType('message')) {
                MessageHandler::handle($update);
            }
            
            if ($update->isType('callback_query')) {
                CallbackHandler::handle($update);
            }

        } catch (Exception $e) {
            Log::error($e->getMessage());
        } finally {
            return response()->json(['status' => 'success']);
        }
    }
}
