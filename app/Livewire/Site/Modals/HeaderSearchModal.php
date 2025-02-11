<?php

namespace App\Livewire\Site\Modals;

use App\Models\Product;
use Livewire\Component;

class HeaderSearchModal extends Component
{
    public $searchText;
    public $products = [];

    public function mount()
    {
        $this->updatedSearchText('');
    }

    public function close()
    {
        $this->searchText = '';
        $this->updatedSearchText('');
    }

    public function updatedSearchText($value)
    {
        $this->products = Product::active()->inStock()->search($value)->limit(10)->with('mainPhoto')->get();
    }
    
    public function render()
    {
        return view('livewire.site.modals.header-search-modal');
    }
}
