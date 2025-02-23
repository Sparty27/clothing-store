<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Notifications\Ordered;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Propaganistas\LaravelPhone\PhoneNumber;

class TestController extends Controller
{
    public function test()
    {
        $notifiable = (object) ['phone' => (new PhoneNumber('380500243492', ['UA']))];
        Notification::send($notifiable, new ResetPasswordNotification(123456));

        dd('test');

        // $user->notify((new Ordered()));

        return view('emails.ordered', ['order' => $order]);
        dd('test');
    }
}
