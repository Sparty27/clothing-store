<?php

namespace App\Rules;

use App\Models\City;
use App\Models\Warehouse;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WarehouseBelongsToCity implements ValidationRule
{
    protected $cityId;

    public function __construct($cityId)
    {
        $this->cityId = $cityId;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $city = City::find($this->cityId);

        if ($city->exists()) {
            $warehouseBelongs = Warehouse::where('id', $value)->where('city_id', $city->ref)->exists();

            if (!$warehouseBelongs) {
                $fail('validation.city_dependency')->translate();
            }
        }
    }
}
