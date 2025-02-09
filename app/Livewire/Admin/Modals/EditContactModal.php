<?php

namespace App\Livewire\Admin\Modals;

use App\Models\Contact;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class EditContactModal extends ModalComponent
{
    public Contact $contact;
    public $type;
    public $data;
    public $isActive;

    public function mount()
    {
        if ($this->contact->exists()) {
            $this->type = $this->contact->type;
            $this->data = $this->contact->data;
            $this->isActive = (bool) $this->contact->is_active;
        }
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function rules()
    {
        return [
            'data' => 'required|array',
            'data.*' => 'required|string|min:3|max:191',
            'isActive' => 'required|boolean',
        ];
    }

    public function validationAttributes()
    {
        return [
            'data.'.$this->contact->type->value => trans('contacts.'.$this->contact->type->value),
            'data.coordinates' => 'Координати',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        $this->contact->update([
            'data' => $validated['data'],
            'is_active' => $validated['isActive'],
        ]);

        $this->dispatch('contact-updated');

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.modals.edit-contact-modal');
    }
}
