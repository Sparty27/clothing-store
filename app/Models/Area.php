<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'ref',
        'name',
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'area_id', 'ref');
    }
}
