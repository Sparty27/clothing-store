<?php

namespace App\Livewire\Admin\Contacts;

use App\Enums\ContactEnum;
use App\Models\Contact;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class ContactsTable extends Component
{
    #[Url('contact')]
    public $selectedTab = ContactEnum::PHONE->value;

    public function mount()
    {

    }
    
    #[Computed()]
    public function tabs()
    {
        return ContactEnum::cases();
    }

    #[Computed()]
    #[On('contact-updated')]
    public function contacts()
    {
        return Contact::selectedType($this->selectedTab)->get();
    }

    public function selectTab(ContactEnum $tab)
    {
        $this->selectedTab = $tab->value;
    }

    #[On('toggle-contact-active')]
    public function toggleActive(Contact $contact)
    {
        $contact->update([
            'is_active' => !$contact->is_active,
        ]);
    }
    public function render()
    {
        return view('livewire.admin.contacts.contacts-table');
    }
}
