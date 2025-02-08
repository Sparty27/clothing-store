<?php

namespace App\Livewire\Admin\Modals;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class WarningModal extends ModalComponent
{
    public $dispatch;
    public $modelId;

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function confirm()
    {
        $this->dispatch($this->dispatch, $this->modelId);
        
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.modals.warning-modal');
    }
}
