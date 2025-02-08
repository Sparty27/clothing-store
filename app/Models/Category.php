<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[ObservedBy([CategoryObserver::class])]
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'priority',
        'is_visible',
        'is_footer_visible',
        'photo_path',
    ];

    // public function products()
    // {
    //     return $this->hasMany(Product::class, 'category_id', 'id');
    // }

    public function scopeOrderPriority(Builder $query)
    {
        return $query->orderBy('priority');
    }

    public function scopeFooterVisible(Builder $query)
    {
        return $query->where('is_footer_visible', true);
    }

    public function scopeVisible(Builder $query)
    {
        return $query->where('is_visible', true);
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

    public function getPhotoUrlAttribute()
    {
        if (!$this->photo_path) {
            return asset('img/image-not-found.jpg');
        }
        
        return Storage::disk('public')->url($this->photo_path) ?? asset('img/image-not-found.jpg');
    }
}
