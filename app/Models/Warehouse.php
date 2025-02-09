<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'ref',
        'name',
        'updated_at',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'ref');
    }

    public function scopeSearch(Builder $query, $value)
    {
        return $query
            ->where('name', 'LIKE', '%' . $value . '%')
            ->orderByRaw("CASE 
                WHEN name LIKE ? THEN 1
                WHEN name LIKE ? THEN 2
                ELSE 3 
            END", [$value . '%', '%' . $value . '%']);
    }
}
