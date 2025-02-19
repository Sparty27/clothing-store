<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout()
    {
        return view('site.pages.orders.checkout');
    }

    public function thank()
    {
        return view('site.pages.orders.thank');
    }
}
