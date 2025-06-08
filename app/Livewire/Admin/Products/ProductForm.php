<?php

namespace App\Livewire\Admin\Products;

use App\Livewire\Forms\Gallery;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Size;
use App\Traits\QuillEditorImageUpload;
use Brick\Math\RoundingMode;
use Brick\Money\Money;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ProductForm extends Component
{
    use QuillEditorImageUpload, WithFileUploads;

    public $product;
    public Gallery $gallery;
    public $isCreated = false;

    public array $initialCounts = [];
    public array $addSizes = [];
    public $data = [];

    public function mount($product)
    {
        if ($product !== null && $product instanceof Product) {
            $this->product = $product;

            foreach ($product->productSizes as $productSize) {
                $this->addSizes[] = [
                    'size_id' => $productSize->size_id,
                    'count' => $productSize->count,
                ];

                $this->initialCounts[$productSize->id] = $productSize->count;
            }

            $this->isCreated = true;
        } else {
            $this->isCreated = false;
        }

        // dd($this->addSizes, $this->sizes);

        $this->data['name'] = $this->product->name ?? '';
        $this->data['slug'] = $this->product->slug ?? '';
        $this->data['article'] = $this->product->article ?? '';
        $this->data['description'] = $this->product->description ?? '';
        $this->data['short_description'] = $this->product->short_description ?? '';
        $this->data['count'] = $this->product->count ?? '';
        $this->data['price'] = $this->product?->price->getAmount()->toFloat() ?? 0;
        $this->data['old_price'] = $this->product?->old_price?->getAmount()->toFloat() ?? 0;
        $this->data['is_discount'] = (bool) $this->product?->is_discount ?? false;
        $this->data['is_day_product'] = (bool) $this->product?->is_day_product ?? false;
        $this->data['is_active'] = (bool) $this->product?->is_active ?? false;
        $this->data['is_popular'] = (bool) $this->product?->is_popular ?? false;
        $this->data['category_id'] = $this->product?->category->id ?? null;

        $this->gallery->setPhotos($product);
    }

    #[Computed()]
    public function categories()
    {
        return Category::orderPriority()->get();
    }

    #[Computed()]
    public function sizes()
    {
        return Size::get();
    }

    public function generateSlug()
    {
        $this->data['slug'] = Str::slug($this->data['name']);
    }

    public function updatedGallery()
    {
        $this->gallery->updatedUploadedPhotos();
    }

    public function deletePhoto($id)
    {
        $this->gallery->deletePhoto($id);
    }

    public function setMain($id)
    {
        $this->gallery->setMain($id);
    }

    public function renderPhotos($ids)
    {
        $this->gallery->renderPhotos($ids);
    }

    public function addSize()
    {
        $this->addSizes[] = [
            'size_id' => $this->sizes[0]->id,
            'count' => 0,
        ];
    }

    public function removeSize($index)
    {
        unset($this->addSizes[$index]);
    }

    public function updatedIsDiscount($value)
    {
        if ($value === false) {
            $this->data['old_price'] = 0;
        }
    }

    public function updatedAddSizes($value, $key)
    {
    }

    public function rules()
    {
        $rules = [
            'data.name' => 'required|string|min:3|max:191',
            'data.slug' => ['required', 'string', 'max:191', Rule::unique('products', 'slug')->ignore($this->product?->id)],
            'data.article' => ['required', 'string','max:50', Rule::unique('products', 'article')->ignore($this->product?->id)],
            'data.description' => 'nullable|string|max:5000',
            'data.short_description' => 'nullable|string|max:5000',
            'data.category_id' => 'required|exists:categories,id',
            // 'data.count' => 'required|integer|min:0|max:999999',
            'data.price' => 'required_with:data.old_price|numeric|regex:/^\d+(\.\d{1,2})?$/|min:1|max:1000000',
            'data.old_price' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0|max:1000000',
            'data.is_discount' => 'required|boolean',
            // 'data.isDayProduct' => 'required|boolean',
            'data.is_active' => 'required|boolean',
            'data.is_popular' => 'required|boolean',
            'addSizes' => 'required|array',
            'addSizes.*.size_id' => 'required|exists:sizes,id|distinct',
            'addSizes.*.count' => 'required|integer|min:0|max:999999',
        ];

        if ($this->data['is_discount'] === true) {
            $rules['data.old_price'] = 'required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:0|max:1000000|gt:data.price';
        }

        return $rules;
    }

    public function messages()
    {
        return [];
    }

    public function validationAttributes()
    {
        return [
            'addSizes.*.size_id' => '',
            'addSizes.*.count' => 'Кількість',
            'names.*' => 'Назва',
            'descriptions.*' => 'Опис',
            'shortDescriptions.*' => 'Короткий опис',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        $validatedAddSizes = $validated['addSizes'];
        $validated = $validated['data'];

        $validated['price'] = Money::of($validated['price'], 'UAH', roundingMode: RoundingMode::DOWN);

        if (empty($validated['old_price'])) {
            $validated['old_price'] = null;
        } else {
            $validated['old_price'] = Money::of($validated['old_price'], 'UAH', roundingMode: RoundingMode::DOWN);
        }

        if ($this->product === null) {
            $this->product = Product::create($validated);
        } else {
            // $validated['count'] = $this->product->count + ((int)$validated['count'] - (int)$this->initialCount);

            $validatedAddSizes = $this->checkCounts($validatedAddSizes);

            $this->product->update($validated);
        }

        $this->saveSizes($validatedAddSizes, $this->product);

        $this->gallery->store($this->product);

        $alertText = 'Товар "'.$this->product->name.'"'.($this->isCreated ? ' оновлено!' : ' створено!');

        if ($this->isCreated === false) {
            return redirect()->route('admin.products.index')->with('alert', $alertText);
        }

        return redirect(request()->header('Referer'))->with('alert', $alertText);
    }

    private function checkCounts(array $validatedAddSizes)
    {
        foreach ($validatedAddSizes as $index => $addSize) {
            $productSize = ProductSize::where('size_id', $addSize['size_id'])->first();

            if ($productSize && isset($this->initialCounts[$productSize->id])) {
                $validatedAddSizes[$index]['count'] = $productSize->count + ($validatedAddSizes[$index]['count'] - $this->initialCounts[$productSize->id]);
            }
        }

        return $validatedAddSizes;
    }

    private function saveSizes(array $sizes, Product $product)
    {
        $sizeIds = collect($sizes)->pluck('size_id')->all();

        // Позначаємо як видалені ті розміри, яких немає у новому списку
        ProductSize::where('product_id', $product->id)
            ->whereNotIn('size_id', $sizeIds)
            ->delete();

        foreach ($sizes as $size) {
            $productSize = ProductSize::withTrashed()
                ->where('product_id', $product->id)
                ->where('size_id', $size['size_id'])
                ->first();

            if ($productSize) {
                $productSize->count = $size['count'];
                if ($productSize->trashed()) {
                    $productSize->restore();
                }
                $productSize->save();
            } else {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size_id' => $size['size_id'],
                    'count' => $size['count'],
                ]);
            }
        }
    }


    public function render()
    {
        return view('livewire.admin.products.product-form');
    }
}
