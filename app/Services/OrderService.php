<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
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
                    'name' => $product['name'],
                    'count' => $product['count'],
                    'price' => $product['price'],
                ]);
            }

            foreach($products as $product) {
                $modelProduct = Product::find($product['product_id']);
    
                if (($modelProduct->count - $product['count']) >= 0) {
                    $modelProduct->count -= (int) $product['count'];
                    $modelProduct->save();
                } else {
                    throw new Exception('Out of stock. Product id: '.$product->id);
                }
            }

            basket()->clear();

            DB::commit();

            // telegram()->sendOrderedNotification($order);
            // sms()->sendMessage([$order->phone->formatE164()], "Дякуємо за замовлення на сайті FPVUA.NET. Сума до оплати: ".$data['total']->getAmount()->toFloat());
            
            return $order;
            
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}