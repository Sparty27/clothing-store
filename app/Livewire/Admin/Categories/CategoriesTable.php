<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CategoriesTable extends Component
{
    use WithPagination;

    protected $categories;

    public function loadCategories()
    {
        $this->categories = Category::orderBy('priority')->paginate(10);
    }

    public function increasePriority(Category $category)
    {
        $priority = $category->priority;

        $nextCategory = Category::where('priority', ($priority - 1))->first();

        if ($nextCategory) {
            $nextCategory->priority++;
            $nextCategory->save();

            $category->priority--;
            $category->save();

            $this->loadCategories();
        }
    }

    public function decreasePriority(Category $category)
    {
        $priority = $category->priority;

        $previousCategory = Category::where('priority', $priority + 1)->first();

        if ($previousCategory) {
            $previousCategory->priority--;
            $previousCategory->save();

            $category->priority++;
            $category->save();

            $this->loadCategories();
        }
    }

    #[On('toggle-category-visible')]
    public function toggleVisible(Category $category)
    {
        $category->update([
            'is_visible' => !$category->is_visible,
        ]);

        $this->dispatch('alert-open', 'Видимість категорії успішно змінено!');
    }

    #[On('toggle-category-footer-visible')]
    public function toggleFooterVisible(Category $category)
    {
        $category->update([
            'is_footer_visible' => !$category->is_footer_visible,
        ]);

        $this->dispatch('alert-open', 'Видимість категорії у футері успішно змінено!');
    }

    #[On('delete-category')]
    public function deleteCategory(Category $model)
    {
        $photoPath = $model->photo_path;
        if ($photoPath) {
            if (Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }
        }
        
        if ($model->exists()) {
            $model->delete();

            $this->dispatch('alert-open', 'Категорію "'.$model->name.'" успішно видалено!');
        }

        if ($this->categories?->isEmpty() ?? true) {
            return redirect()->route('admin.categories.index')->with('alert', 'Категорію "'.$model->name.'" успішно видалено!');
        }
    }

    public function render()
    {
        return view('livewire.admin.categories.categories-table', ['categories' => Category::orderBy('priority')->paginate(2)]);
    }
}
