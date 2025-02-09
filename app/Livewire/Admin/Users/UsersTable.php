<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Traits\Searchable;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;

    public $searchText;

    #[Computed()]
    public function users()
    {
        $query = User::searchText($this->searchText);

        return $query->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.users.users-table');
    }
}
