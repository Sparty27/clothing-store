<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfBasketEmpty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (basket()->getBasketProducts()->isEmpty()) {
            return redirect()->route('index')->with('alert', 'Кошик пустий, виберіть спочатку товар!');
        } else {
            return $next($request);
        }
    }
}
