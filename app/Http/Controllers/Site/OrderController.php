<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout()
    {
        return view('site.pages.checkout');
    }

    // public function thank()
    // {
    //     return view('site.static-page.thank');
    // }
}
