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
        $categories = Category::visible()->orderPriority()->get();

        $popularProducts = Cache::remember('popular-products', 1, function () {   
            return Product::active()->popular()->inRandomOrder()->with('mainPhoto', 'productSizes', 'productSizes.size')->limit(10)->get();
        });

        return view('site.pages.index', compact('categories', 'popularProducts'));
    }
}
