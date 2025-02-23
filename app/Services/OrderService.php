<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\User;
use App\Notifications\Ordered;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function checkout(array $data, array $products)
    {
        DB::beginTransaction();

        try {
            $order = Order::create($data);
    
            foreach($products as $product) {
                $order->orderProducts()->create([
                    'product_id' => $product['product_id'],
                    'size_id' => $product['size_id'],
                    'name' => $product['name'],
                    'count' => $product['count'],
                    'price' => $product['price'],
                ]);
            }

            foreach($products as $product) {
                $productSize = ProductSize::where('product_id', $product['product_id'])->where('size_id', $product['size_id'])->first();
    
                if (($productSize->count - $product['count']) >= 0) {
                    $productSize->count -= (int) $product['count'];
                    $productSize->save();
                } else {
                    throw new Exception('Out of stock. Product id: '.$product->id);
                }
            }

            basket()->clear();

            DB::commit();

            $user = User::where('id', $order->user_id)->first();

            if ($user) {
                $user->notify((new Ordered($order)));
            }

            // telegram()->sendOrderedNotification($order);
            // sms()->sendMessage([$order->phone->formatE164()], "Дякуємо за замовлення на сайті Dressiety. Сума до оплати: ".$data['total']->getAmount()->toFloat());
            
            return $order;
            
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}