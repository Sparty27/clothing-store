<?php

namespace App\Livewire\Site;

use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Propaganistas\LaravelPhone\PhoneNumber;
use Propaganistas\LaravelPhone\Rules\Phone;

class Settings extends Component
{
    public $oldPassword;
    public $newPassword;
    public $phone;
    public $name;
    public $lastName;
    public $user;

    public function mount()
    {
        if (auth()->user()) {
            $this->user = auth()->user();
        } else {
            return redirect()->route('index')->with('Не авторизований');
        }
    }

    public function changePassword()
    {
        $rules = [
            'oldPassword' => ['required', 'string'],
            'newPassword' => ['required', 'string', 'min:8'],
        ];

        $validated = $this->validate($rules);

        if (Hash::check($validated['oldPassword'], $this->user->password)) {
            $this->user->update([
                'password' => Hash::make($validated['newPassword'])
            ]);

            $this->dispatch('alert-open', 'Пароль було змінено');
        } else {
            $this->addError('oldPassword', 'Пароль введено неправильно');
            return;
        }

        $this->oldPassword = '';
        $this->newPassword = '';
    }

    public function changePhone()
    {
        $this->resetValidation();

        $phoneToValidate = $this->phone;
        try {
            $phoneNumber = new PhoneNumber($this->phone, 'UA');
    
            $phoneToValidate = $phoneNumber->formatE164();
        } catch (Exception $e) {
            Log::warning('Помилка з конвертацію даних в обєкт PhoneNumber, (EditProfile->changePhone): '.$e->getMessage());
        }

        $rules = [
            'phone' => ['required', 'string', 'max:191', (new Phone)->country(['UA']), 'unique:users,phone'],
        ];

        $validated = Validator::make([
            'phone' => $phoneToValidate,
        ], $rules)->validate();

        $this->user->update([
            'phone' => $validated['phone']
        ]);

        $this->phone = '';

        $this->dispatch('alert-open', 'Номер телефону оновлений');
    }

    public function changeName()
    {
        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:191'],
        ];

        $validated = $this->validate($rules);

        $this->user->update([
            'name' => $validated['name'],
        ]);

        $this->name = '';

        $this->dispatch('updated-name');
        $this->dispatch('alert-open', "Імʼя було змінено");
    }
    
    public function changeLastName()
    {
        $rules = [
            'lastName' => ['required', 'string', 'min:3', 'max:191'],
        ];

        $validated = $this->validate($rules);

        $this->user->update([
            'last_name' => $validated['lastName'],
        ]);

        $this->lastName = '';

        $this->dispatch('alert-open', 'Прізвище було змінено');
    }
    
    public function render()
    {
        return view('livewire.site.settings');
    }
}
