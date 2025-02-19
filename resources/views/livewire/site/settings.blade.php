<div class="">
    <div class="text-2xl md:text-[36px] font-bold flex justify-center">
        Налаштування профілю
    </div>
    <div class="">
        <div class="mt-6 rounded-2xl border-gray-100 border-[1px] p-3 shadow-lg">
            <h3 class="font-bold mb-2">Змінити пароль</h3>
            <form wire:submit="changePassword" class="flex flex-col gap-3">
                @include('livewire.site.form.input', [
                    'model' => 'oldPassword',
                    'type' => 'password',
                    'title' => 'Старий пароль',
                    'placeholder' => 'Введіть старий пароль',
                    'autocomplete' => 'off'
                ])
                @include('livewire.site.form.input', [
                    'model' => 'newPassword',
                    'type' => 'password',
                    'title' => 'Новий пароль',
                    'placeholder' => 'Введіть новий пароль',
                    'autocomplete' => 'off',
                ])
                <div class="">
                    <button class="btn btn-primary" type="submit">Змінити</button>
                </div>
            </form>
        </div>
    
        <div class="mt-6 rounded-2xl border-gray-100 border-[1px] p-3 shadow-lg">
            <h3 class="font-bold mb-2">Змінити номер телефону</h3>
            <form wire:submit="changePhone" class="flex flex-col gap-3">
                @include('livewire.site.form.input', [
                    'model' => 'phone',
                    'type' => 'text',
                    'title' => 'Новий номер телефону',
                    'placeholder' => '+38 (099) 444 33 22'
                ])
                <div class="">
                    <button class="btn btn-primary" type="submit">Змінити</button>
                </div>
            </form>
        </div>
    
        <div class="mt-6 rounded-2xl border-gray-100 border-[1px] p-3 shadow-lg">
            <h3 class="font-bold mb-2">Змінити імʼя</h3>
            <form wire:submit="changeName" class="flex flex-col gap-3">
                @include('livewire.site.form.input', [
                    'model' => 'name',
                    'type' => 'text',
                    'title' => 'Нове імʼя',
                    'placeholder' => "Введіть нове ім'я"
                ])
                <div class="">
                    <button class="btn btn-primary" type="submit">Змінити</button>
                </div>
            </form>
        </div>
    
        <div class="mt-6 rounded-2xl border-gray-100 border-[1px] p-3 shadow-lg">
            <h3 class="font-bold mb-2">Змінити прізвище</h3>
            <form wire:submit="changeLastName" class="flex flex-col gap-3">
                @include('livewire.site.form.input', [
                    'model' => 'lastName',
                    'type' => 'text',
                    'title' => 'Нове прізвище',
                    'placeholder' => "Введіть нове прізвище"
                ])
                <div class="">
                    <button class="btn btn-primary" type="submit">Змінити</button>
                </div>
            </form>
        </div>
    </div>
</div>