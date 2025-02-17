<?php

namespace App\Livewire\Site\Modals;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class DeleteBasketProductModal extends ModalComponent
{
    public $subject;
    public $text;
    public $dispatch;
    public int $modelId;

    public static function modalMaxWidth(): string
    {
        return 'md';
    }
    
    public function delete()
    {
        $this->dispatch($this->dispatch, $this->modelId);
        
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.site.modals.delete-basket-product-modal');
    }
}
