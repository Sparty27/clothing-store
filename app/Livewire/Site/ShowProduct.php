<?php

namespace App\Livewire\Site;

use App\Models\Photo;
use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ShowProduct extends Component
{
    public $product;
    public $selectedSize;
    public $selectedPhoto;
    public $showFullDesc = false;

    public function mount()
    {
        if (!$this->product->is_active) {
            return redirect()->route('index')->with('alert', 'Товар недоступний');
        }
        
        $this->selectedPhoto = $this->product->mainPhoto;

        foreach ($this->productSizes as $productSize) {
            if ($productSize->count > 0) {
                $this->selectedSize = $productSize->size_id;
                break;
            }
        }
    }

    #[Computed()]
    public function productSizes()
    {
        return $this->product->productSizes;
    }

    #[Computed()]
    public function similarProducts()
    {
        return Product::where('category_id', $this->product->category_id)
            ->whereNot('id', $this->product->id)
            ->active()
            ->inStock()
            ->with(['mainPhoto', 'productSizes', 'productSizes.size'])
            ->limit(4)
            ->get();
    }

    public function selectPhoto(Photo $photo)
    {
        $this->selectedPhoto = $photo;
    }

    public function selectPreviousPhoto()
    {
        if (!($this->product->photos->count() > 0)) {
            return;
        }

        $nextPhoto = $this->product->photos->where('priority', $this->selectedPhoto->priority - 1)->first();

        if ($nextPhoto && $nextPhoto->exists()) {
            $this->selectedPhoto = $nextPhoto;
        } else {
            $this->selectedPhoto = $this->product->mainPhoto;
        }
    }

    public function selectNextPhoto()
    {
        if (!($this->product->photos->count() > 0)) {
            return;
        }

        $nextPhoto = $this->product->photos->where('priority', $this->selectedPhoto->priority + 1)->first();

        if ($nextPhoto && $nextPhoto->exists()) {
            $this->selectedPhoto = $nextPhoto;
        } else {
            $this->selectedPhoto = $this->product->mainPhoto;
        }
    }

    public function selectSize($sizeId)
    {
        if ($this->product->productSizes->where('size_id', $sizeId)->first()->count > 0) {

            $this->selectedSize = $sizeId;
        }
    }

    public function toggleShowDesc()
    {
        $this->showFullDesc = !$this->showFullDesc;
    }

    public function addToBasket(Product $product)
    {
        if (basket()->addProduct($product, $this->selectedSize, 1)) {
            $this->dispatch('show-basket');
        }

        $this->dispatch('updated-basket');
    }

    public function render()
    {
        return view('livewire.site.show-product');
    }
}
