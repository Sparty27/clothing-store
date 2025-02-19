<?php

namespace App\Http\Middleware;

use App\Enums\PaymentMethodEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MonobankPayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $order = $request->route('order');

        if ($order && $order->payment_method === PaymentMethodEnum::MONOBANK) {
            return $next($request);
        }

        abort(404);
    }
}
