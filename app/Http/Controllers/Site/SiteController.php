<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SiteController extends Controller
{
    public function index()
    {
        $categories = Category::visible()->orderPriority()->limit(8)->get();

        $popularProducts = Cache::remember('popular-products', 3600, function () {   
            return Product::active()->popular()->inStock()->inRandomOrder()->with('mainPhoto')->limit(10)->get();
        });

        return view('site.pages.index', compact('categories', 'popularProducts'));
    }
}
