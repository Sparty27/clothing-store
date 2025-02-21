<?php

namespace App\Livewire\Admin\Modals;

use App\Models\Order;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class EditTtnModal extends ModalComponent
{
    public $ttn;
    public Order $order;

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function mount()
    {
        $this->ttn = $this->order->ttn;
    }

    public function save()
    {
        $validated = $this->validate([
            'ttn' => 'nullable|string|max:17',
        ]);

        $this->order->update([
            'ttn' => $validated['ttn'],
        ]);

        $this->closeModal();
        $this->dispatch('updated-orders-table');
        $this->dispatch('alert-open', "Замовлення {$this->order->id} було оновлено ТТН");
    }
    
    public function render()
    {
        return view('livewire.admin.modals.edit-ttn-modal');
    }
}
