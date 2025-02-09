<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'ref',
        'name',
        'updated_at',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id', 'ref');
    }

    public function warehouses(): HasMany
    {
        return $this->hasMany(Warehouse::class, 'city_id', 'ref');
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
