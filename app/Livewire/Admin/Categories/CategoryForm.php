<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CategoryForm extends Component
{
    use WithFileUploads;

    public $category;
    public $name;
    public $image;
    public $priority;
    public $slug;
    public $isCreated = false;

    public function mount($category)
    {
        if ($category !== null && $category instanceof Category) {
            $this->category = $category;

            $this->isCreated = true;

            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->priority = $category->priority;
        } else {
            $this->isCreated = false;
        }
    }
    
    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:191',
            'slug' => ['required', 'string', 'max:191', Rule::unique('categories', 'slug')->ignore($this->category?->id)],
            'image' => 'nullable|image|mimes:webp,jpg,jpeg,png|max:2048',
        ];

        if ($this->category) {
            $rules['priority'] = 'required|integer|min:1';
        }

        $validated = $this->validate($rules);

        if (isset($validated['priority'])) {
            if ($this->category->priority != $validated['priority']) {
                if ($this->category->priority < $validated['priority']) {
                    Category::whereBetween('priority', [$this->category->priority + 1, $validated['priority']])
                        ->decrement('priority');
                } else {
                    Category::whereBetween('priority', [$validated['priority'], $this->category->priority - 1])
                        ->increment('priority');
                }
            }
        }

        if ($validated['image']) {
            $photo_path = Storage::disk('public')->put('/photos/categories', $validated['image']);

            if ($this->category && $this->category->photo_path && Storage::disk('public')->exists($this->category->photo_path)) {
                Storage::disk('public')->delete($this->category->photo_path);
            }
        } else {
            $photo_path = $this->category->photo_path ?? null;
        }

        $maxPriority = Category::max('priority') ?? 0;

        if ($this->category === null) {
            $this->category = Category::create([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'priority' => $maxPriority + 1,
                'photo_path' => $photo_path ?? null,
            ]);
        } else {
            $this->category->update([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'priority' => $validated['priority'],
                'photo_path' => $photo_path ?? null,
            ]);
        }

        $alertText = "Категорію \"{$this->category->name}\"".($this->isCreated ? ' оновлено!' : ' створено!');

        return redirect()->route('admin.categories.index')->with('alert', $alertText);
    }

    public function render()
    {
        return view('livewire.admin.categories.category-form');
    }
}
