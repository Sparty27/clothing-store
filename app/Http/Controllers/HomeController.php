<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home()
    {
        $data = [];
        $user = auth()->user();
        
        $data['phone'] = $user->phone->formatInternational();
        $data['email'] = $user->email;
        $data['name'] = $user->name;
        $data['last_name'] = $user->last_name;
        $data['created_at'] = Carbon::parse($user->created_at)->format('d.m.Y');
        // $data['orders_count'] = Order::where('user_id', $user->id)->count();

        return view('site.pages.profile', ['data' => $data]);
    }

    public function orders()
    {
        return view('site.pages.orders');
    }

    public function settings()
    {
        return view('site.pages.settings');
    }
}
