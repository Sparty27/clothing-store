<?php

namespace App\Services;

use App\Models\Basket;
use App\Models\BasketProduct;
use App\Models\Product;
use Brick\Money\Money;
use Exception;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class BasketService
{
    protected Basket $basket;

    public function __construct()
    {
        $basket = Basket::where('basket_id', session()->get('basket_id'))->first();

        if ($basket) {
            $this->basket = $basket;
            return;
        }

        $uuid = Uuid::uuid4()->toString();
    
        if (auth()->user()) {
            $basket = Basket::firstOrCreate([
                'user_id' => auth()->user()->id
            ], [
                'basket_id' => $uuid,
            ]);
        } else {
            $basket = Basket::firstOrCreate([
                'basket_id' => $uuid,
            ]);
        }
        
        session()->put('basket_id', $uuid);
    
        $this->basket = $basket;
    }

    public function getBasket()
    {
        return $this->basket;
    }

    public function getBasketProducts()
    {
        return $this->basket->basketProducts;
    }

    public function isInBasket(Product $product): bool
    {
        return $this->basket->products->contains('id', $product->id);
    }

    public function addProduct(Product $product, int $selectedSize, int $count = 1)
    {
        $productSize = $product->productSizes()->where('size_id', $selectedSize)->first();

        if ($productSize->count < 1 || $count > $productSize->count || $product->is_active == false) {
            return false;
        }

        $existingProduct = $this->basket->basketProducts()->where('product_id', $product->id)->where('size_id', $selectedSize)->first();

        if (!$existingProduct) {
            // $this->basket->products()->attach($product->id, ['size_id' => $selectedSize, 'count' => $count, 'created_at' => now(), 'updated_at' => now()]);

            $this->basket->basketProducts()->create([
                'product_id' => $product->id,
                'size_id' => $selectedSize,
                'count' => $count,
            ]);

            return true;
        } 

        $newCount = $existingProduct->count + $count;

        if ($newCount > $productSize->count) {
            $newCount = $productSize->count;
        }

        $existingProduct->update([
            'count' => $newCount,
        ]);

        return true;
    }

    public function removeProduct(BasketProduct $product)
    {
        if ($product->exists()) {
            $product->delete();
        }
    }

    // public function isEmpty(): bool
    // {
    //     return $this->basket->basketProducts->count() == 0;
    // }

    // public function addProduct(Product $product, int $count = 1)
    // {
    //     $this->basket->basketProducts()->firstOrCreate([
    //         'product_id' => $product->id
    //     ], [
    //         'title' => $product->title,
    //         'count' => $count,
    //         'price' => Money::ofMinor($product->price, 'UAH')->getAmount()->toBigDecimal(),
    //         'product_id' => $product->id,
    //     ]);
    // }

    // public function removeProduct(Product $product)
    // {
    //     $this->basket->basketProducts()->where('product_id', $product->id)->delete();
    // }

    public function changeProductCount(BasketProduct $basketProduct, int $num = 1)
    {
        if (($basketProduct->count + $num) < 0 || ($basketProduct->count + $num) > $basketProduct->productSize->count) {
            return false;
        }

        $basketProduct->increment('count', $num);

        return true;
    }

    public function clear()
    {
        $this->basket->basketProducts()->delete();
    }
}