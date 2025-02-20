<?php

namespace App\Livewire\Site;

use App\Enums\SortProduct;
use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use Brick\Math\RoundingMode;
use Brick\Money\Money;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Catalog extends Component
{
    use WithPagination;

    public $category;
    #[Url('sizes')]
    public array $selectedSizes = [];
    #[Url('sort')]
    public $selectedSort;
    public $selectedCategory;
    public $minPrice = 0;
    public $maxPrice = 0;
    public $sizes;

    public function mount()
    {
        $this->selectedCategory = $this->category->id ?? null;
        $this->sizes = $this->sizes();

        $requestSizes = request()->get('sizes', []);

        $validatedSizes = [];
        foreach ($requestSizes as $size) {
            $validatedSize = $this->sizes->where('id', $size)->first();

            if ($validatedSize) {
                $validatedSizes[] = $validatedSize->id;
            }
        }

        $this->selectedSizes = $validatedSizes;

        $productsMinMax = $this->productsMinMax;

        if ($productsMinMax->min_price && $productsMinMax->max_price) {
            $this->minPrice = Money::ofMinor($productsMinMax->min_price, 'UAH', roundingMode: RoundingMode::DOWN)->getAmount()->toFloat() ?? 0;
            $this->maxPrice = Money::ofMinor($productsMinMax->max_price, 'UAH', roundingMode: RoundingMode::DOWN)->getAmount()->toFloat() ?? 0;
        }
    }

    #[Computed]
    public function sortingOptions()
    {
        return SortProduct::cases();
    }

    #[Computed]
    public function productsMinMax()
    {
        return Cache::remember("categories-min-max-".$this->category?->id ?? 'all', 10, function () { 
            return $this->getProducts()->selectRaw("MIN(price) as min_price, MAX(price) as max_price")->first();
        });
    }

    #[Computed]
    public function categories(): Collection
    {
        return Category::visible()->get();
    }

    public function sizes(): Collection
    {
        $sizes = collect();

        foreach ($this->products as $product) {
            foreach ($product->productSizes as $productSize) {
                if ($productSize->count > 0) {
                    $sizes->add($productSize->size);
                }
            }
        }

        $sizes = $sizes->unique('id');

        return $sizes;
    }

    #[Computed()]
    public function products()
    {
        $this->selectPrices();

        $selectedSort = SortProduct::tryFrom($this->selectedSort);

        return Product::searchByCategory($this->category)
            ->join('product_size', 'products.id', '=', 'product_size.product_id')
            ->select('products.*', DB::raw('SUM(product_size.count) as total_count'))
            ->groupBy('products.id')
            ->orderByRaw("(CASE WHEN total_count > 0 THEN 1 ELSE 0 END) DESC")
            ->when($this->selectedSizes, function ($builder, $value) { 
                $builder->filterBySizes($value);
            })
            ->when($this->minPrice, function ($builder, $value) {
                $builder->where('price', '>=', Money::of($value, 'UAH', roundingMode: RoundingMode::DOWN)->getMinorAmount()->toInt());
            })
            ->when($this->maxPrice, function ($builder, $value) {
                $builder->where('price', '<=', Money::of($value, 'UAH', roundingMode: RoundingMode::DOWN)->getMinorAmount()->toInt());
            })
            ->when($selectedSort, function ($builder, $value) { 
                $builder->sort($value); 
            })
            ->with('mainPhoto')
            ->paginate(12);
    }

    #[On('updated-basket')]
    public function isInBasket(Product $product)
    {
        return basket()->getBasketProducts()->contains('product_id', $product->id);
    }

    public function addToBasket(Product $product)
    {
        basket()->addProduct($product, 1);

        $this->dispatch('updated-basket');
    }

    public function removeFromBasket(Product $product)
    {
        basket()->removeProduct($product);

        $this->dispatch('updated-basket');
    }

    public function updatedSelectedCategory($value)
    {
        $category = Category::find($value);

        return redirect()->route('catalog', [
            'category' => $category->slug ?? null,
            'sizes' => $this->selectedSizes, // Передаємо масив вибраних розмірів
            'sort' => $this->selectedSort // Передаємо значення сортування
        ]);
    }


    public function selectPrices()
    {
        $this->minPrice = is_numeric($this->minPrice) ? (float) $this->minPrice : null;
        $this->maxPrice = is_numeric($this->maxPrice) ? (float) $this->maxPrice : null;

        if($this->maxPrice != null && $this->minPrice > $this->maxPrice)
            $this->minPrice = $this->maxPrice;


        try {
            $this->validate([
                'minPrice' => 'required|numeric|min:0|max:9999999',
                'maxPrice' => 'required|numeric|min:0|max:9999999|gte:minPrice'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->resetErrorBag(); // Очищає попередні помилки
            $this->addError('minPrice', $e->validator->errors()->first('minPrice'));
            $this->addError('maxPrice', $e->validator->errors()->first('maxPrice'));
        }
    }

    public function clearFilters()
    {
        $this->selectedSizes = [];

        $productsMinMax = $this->productsMinMax;
        $this->minPrice = Money::ofMinor($productsMinMax->min_price, 'UAH', roundingMode: RoundingMode::DOWN)->getAmount()->toFloat();
        $this->maxPrice = Money::ofMinor($productsMinMax->max_price, 'UAH', roundingMode: RoundingMode::DOWN)->getAmount()->toFloat();
    }

    private function getProducts()
    {
        if($this->category) {
            return Product::query()->where('category_id', $this->category->id);
        } else {
            return Product::query();
        }
    }

    public function render()
    {
        return view('livewire.site.catalog');
    }
}
