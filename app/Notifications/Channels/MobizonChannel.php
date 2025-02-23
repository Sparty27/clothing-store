<?php

namespace App\Notifications\Channels;

use App\Services\MobizonService;
use Exception;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class MobizonChannel
{
    protected MobizonService $mobizon;

    public function __construct(MobizonService $mobizon)
    {
        $this->mobizon = $mobizon;
    }

    public function send(object $notifiable, Notification $notification): void
    {
        try {
            $message = $notification->toSms($notifiable);
    
            $this->mobizon->sendMessage($notifiable->phone->formatE164(), $message);
        } catch (Exception $e) {
            Log::error('MobizonService, send method. '.$e->getMessage());
        }
    }
}