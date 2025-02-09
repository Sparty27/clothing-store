<?php

namespace App\Livewire\Admin\Modals;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class DeleteModal extends ModalComponent
{
    public $subject;
    public $text;
    public $dispatch;
    public int $modelId;
    
    public function delete()
    {
        $this->dispatch($this->dispatch, $this->modelId);
        
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.modals.delete-modal');
    }
}
