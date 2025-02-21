<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsTable extends Component
{
    use WithPagination;

    public $searchText;

    #[Computed()]
    public function products()
    {
        return Product::query()->searchText($this->searchText)->orderByDesc('is_active')->with('category')->paginate(10);
    }

    #[On('toggle-product-active')]
    public function toggleActive(Product $model)
    {
        $model->update([
            'is_active' => !$model->is_active,
        ]);

        $this->dispatch('alert-open', 'Активність товара успішно змінено!');
    }

    #[On('toggle-product-popular')]
    public function togglePopular(Product $product)
    {
        $product->update([
            'is_popular' => !$product->is_popular,
        ]);

        $this->dispatch('alert-open', 'Популярність товара успішно змінено!');
    }

    #[On('delete-product')]
    public function deleteProduct(Product $model)
    {
        $photos = $model->photos;

        foreach ($photos as $photo) {
            if (Storage::disk('public')->exists($photo->path)) {
                Storage::disk('public')->delete($photo->path);
            }

            $photo->delete();
        }

        if ($model->exists()) {
            $model->delete();

            $this->dispatch('alert-open', 'Товар "'.$model->name.'" успішно видалено!');
        }

        if ($this->products?->isEmpty() ?? true) {
            return redirect()->route('admin.products.index')->with('alert', 'Товар "'.$model->name.'" успішно видалено!');
        }
    }

    public function redirectToProduct(Product $product)
    {
        $this->dispatch('redirect-to-product', url: route('products.show', $product->slug));
    }
    
    public function render()
    {
        return view('livewire.admin.products.products-table');
    }
}
