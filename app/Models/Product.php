<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\SortProduct;
use App\Models\Interfaces\Photoable;
use App\Observers\ProductObserver;
use Brick\Math\BigInteger;
use Brick\Money\Money;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Class Product
 * 
 * @property Money $price
 * @property Money $old_price
 */
#[ObservedBy([ProductObserver::class])]
class Product extends Model implements Photoable
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'article',
        'description',
        'short_description',
        // 'count',
        'price',
        'old_price',
        'is_discount',
        'is_day_product',
        'is_active',
        'is_popular',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price' => MoneyCast::class,
        'old_price' => MoneyCast::class,
    ];

    public $translatedAttributes = ['name', 'description', 'short_description'];
    
    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

    public function photo(): MorphOne
    {
        return $this->morphOne(Photo::class, 'photoable');
    }

    public function mainPhoto()
    {
        return $this->morphOne(Photo::class, 'photoable')->where('is_main', true);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productSizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function baskets(): BelongsToMany
    {
        return $this->belongsToMany(Basket::class, 'basket_product')
            ->withPivot('count')
            ->withTimestamps();
    }

    // public function characteristicProducts(): HasMany
    // {
    //     return $this->hasMany(CharacteristicProduct::class, 'product_id', 'id');
    // }

    // public function characteristics()
    // {
    //     return $this->belongsToMany(Characteristic::class, 'characteristic_product')->withPivot('text');
    // }

    // public function orders()
    // {
    //     return $this->belongsToMany(Order::class)
    //         ->withPivot('name', 'count', 'price', 'sum')
    //         ->withTimestamps();
    // }

    public function scopeActive(Builder $builder)
    {
        return $builder->where('is_active', true);
    }

    public function scopePopular(Builder $builder)
    {
        return $builder->where('is_popular', true);
    }

    public function scopeInStock(Builder $builder)
    {
        return $builder->whereHas('productSizes', function ($query) {
            $query->where('count', '>', 0);
        });
    }

    public function scopeDayProduct(Builder $builder)
    {
        return $builder->where('is_day_product', true);
    }

    public function scopeSearch(Builder $query, $value)
    {
        // return $query
        //     ->whereTranslationLike('name', '%'.$value.'%');

        return $query
            ->where('name', 'LIKE', '%' . $value . '%')
            ->orderByRaw("CASE 
                WHEN name LIKE ? THEN 1
                WHEN name LIKE ? THEN 2
                ELSE 3 
            END", [$value . '%', '%' . $value . '%']);
    }

    public function scopeSearchText(Builder $query, $searchText)
    {
        $query->where('article', 'like', "%{$searchText}%")
            ->orWhere('slug', 'like', "%{$searchText}%")
            ->orWhere('name', 'like', "%{$searchText}%");
    }

    public function scopeSearchByCategory(Builder $query, Category $category = null): Builder
    {
        if ($category) {
            return $query->where('category_id', $category->id);
        } else {
            return $query;
        }
    }

    public function scopeFilterBySizes(Builder $query, array $sizes): Builder
    {
        return $query->whereHas('productSizes', function ($q) use ($sizes) {
            $q->whereIn('size_id', $sizes);
        });
    }

    public function scopeSort(Builder $query, SortProduct $sort): Builder
    {
        $sort = explode('_', $sort->value);
        $sortCol = $sort[0];
        $sortDir = $sort[1];
        
        return $query->orderBy($sortCol, $sortDir);
    }

    protected function oldPrice(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $price = $this->price->getMinorAmount()->toBigInteger();

                if ($value === null) {
                    return null;
                }

                if (is_int($value)) {
                    $value = BigInteger::of($value);
                } 
                
                if ($value < $price) {
                    return $this->price;
                }
        
                return Money::ofMinor($value, 'UAH');
            },
        );
    }

    protected function discountPercentage(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($this->money_old_price) {
                    return (int) ((($this->money_old_price - $this->money_price) / $this->money_old_price) * 100);
                }
            },
        );
    }

    protected function moneyPrice(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return number_format($this->price->getAmount()->toFloat(), 2, '.', '');
            },
        );
    }

    protected function moneyOldPrice(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($this->old_price === null) {
                    return null;
                }

                return number_format($this->old_price->getAmount()->toFloat(), 2, '.', '');
            },
        );
    }

    protected function isInStock(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->productSizes()->where('count', '>', 0)->exists();
            },
        );
    }
}
