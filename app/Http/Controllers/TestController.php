<?php

namespace App\Http\Controllers;

use App\Console\Commands\Email\SendTestEmail;
use App\Models\Order;
use App\Models\User;
use App\Notifications\Ordered;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Propaganistas\LaravelPhone\PhoneNumber;

class TestController extends Controller
{
    public function test()
    {
        return Artisan::call('email:test nazaraboba@gmail.com');
    }

    public function testview()
    {
        $order = Order::latest()->first();
        return view('emails.reset-password', compact('order'));
    }
}
