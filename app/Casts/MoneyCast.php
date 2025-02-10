<?php

namespace App\Casts;

use Brick\Math\RoundingMode;
use Brick\Money\Money;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class MoneyCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }

        return Money::ofMinor($value, 'UAH');
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }

        if (! $value instanceof Money) {
            throw new \Exception("$key is not Money type");
        }

        return $value->getMinorAmount()->toBigInteger();
    }
}
