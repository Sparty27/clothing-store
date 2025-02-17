<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class Basket
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        $sessionBasketId = session()->get('basket_id');

        if (!$sessionBasketId) {
            $sessionBasketId = Uuid::uuid4()->toString();

            $basket = \App\Models\Basket::firstOrCreate([
                'basket_id' => $sessionBasketId,
            ]);
            
            session()->put('basket_id', $sessionBasketId);
        }

        if ($user) {
            $basket = \App\Models\Basket::firstOrCreate([
                'user_id' => $user->id,
            ], [
                'basket_id' => Uuid::uuid4()->toString(),
            ]);

            if ($sessionBasketId === $basket->basket_id)
                return $next($request);

            $sessionBasket = \App\Models\Basket::where('basket_id', $sessionBasketId)->first();

            if (!$sessionBasket)
                return $next($request);

            if ($sessionBasket->basketProducts()->exists()) {
                $basket->delete();

                $sessionBasket->user_id = $user->id;
                $sessionBasket->save();
            } else {
                session()->put('basket_id', $basket->basket_id);
            }

            return $next($request);
        }

        return $next($request);
    }
}
