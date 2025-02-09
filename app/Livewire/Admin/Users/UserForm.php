<?php

namespace App\Livewire\Admin\Users;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Propaganistas\LaravelPhone\PhoneNumber;

class UserForm extends Component
{
    public $user;
    // public $name;
    // public $role;
    // public $phone;
    public $data = [];
    public $newPassword;

    public function mount($user)
    {
        if ($user !== null && $user instanceof User) {
            $this->user = $user;


            $this->data['name'] = $user->name;
            $this->data['last_name'] = $user->last_name;
            $this->data['role'] = $user->role;
            $this->data['email'] = $user->email;
            $this->data['phone'] = $user->phone?->formatE164();


            // $this->phone = $user->phone->formatE164();
        }
    }

    #[Computed()]
    public function roles()
    {
        return RoleEnum::cases();
    }

    public function rules()
    {
        return [
            'data.email' => ['nullable', 'email:rfc,dns'],
            'data.name' => 'required|string|min:3|max:191',
            'data.last_name' => 'nullable|string|min:3|max:191',
            'data.phone' => ['required', 'string', 'max:191', Rule::unique('users', 'phone')->ignore($this->user->id), 'phone:UA'],
            'data.role' => ['required', Rule::enum(RoleEnum::class)],
            'newPassword' => 'nullable|string|min:8'
        ];
    }

    public function validationAttributes()
    {
        return [
            'data.name' => 'Імʼя'
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        $data = $validated['data'];

        $phone = new PhoneNumber($data['phone'], 'UA');
        $data['phone'] = $phone->formatE164();

        if ($validated['newPassword']) {
            $data['password'] = Hash::make($validated['newPassword']);
        }

        if ($this->user === null) {
            $this->user = User::create($data);
        } else {
            $this->user->update($data);
        }

        return redirect()->route('admin.users.index')->with('status', $this->user !== null ? $data['name'].' відредаговано' : $data['name'].' добавлено');
    }
    public function render()
    {
        return view('livewire.admin.users.user-form');
    }
}
