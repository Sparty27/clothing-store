<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'priority',
        'is_main',
    ];

    public function photoable()
    {
        return $this->morphTo();
    }

    public function scopeOrderPriority(Builder $query)
    {
        return $query->orderBy('priority');
    }

    public function getPublicUrlAttribute()
    {
        return Storage::disk('public')->url($this->path);
    }
}
