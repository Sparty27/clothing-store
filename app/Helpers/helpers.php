<?php

use App\Services\BasketService;
use App\Services\MobizonService;

// use App\Services\Notification\Telegram;

if (!function_exists('clean_trans')) {
    function clean_trans($key)
    {
        return strip_tags(trans($key));
    }
}

if (!function_exists('basket')) {
    function basket()
    {
        return resolve(BasketService::class);
    }
}

if (!function_exists('mobizon')) {
    function mobizon()
    {
        return resolve(MobizonService::class);
    }
}

// if (!function_exists('telegram')) {
//     /**
//      * Get the Telegram service instance.
//      *
//      * @return Telegram
//      */
//     function telegram()
//     {
//         return resolve(Telegram::class);
//     }
// }
