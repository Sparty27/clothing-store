<form wire:submit="save"  enctype="multipart/form-data" class="w-full flex flex-col gap-3">
    @include('livewire.admin.form.input', [
        'name' => 'Імʼя',
        'model' => 'data.name',
    ])

    @include('livewire.admin.form.input', [
        'name' => 'Прізвище',
        'model' => 'data.last_name',
    ])

    @if(auth()->user()->id == $user->id)
        @include('livewire.admin.form.select', [
            'name' => 'Роль',
            'model' => 'data.role',
            'options' => $this->roles,
            'placeholder' => 'Виберіть роль',
            'value' => 'value',
            'optionName' => 'value',
            'disabledOption' => true,
            'disabled' => true,
        ])
    @else
        @include('livewire.admin.form.select', [
            'name' => 'Роль',
            'model' => 'data.role',
            'options' => $this->roles,
            'placeholder' => 'Виберіть роль',
            'value' => 'value',
            'optionName' => 'value',
            'disabledOption' => true,
        ])
    @endif

    @include('livewire.admin.form.input', [
        'name' => 'Email',
        'model' => 'data.email',
    ])

    @include('livewire.admin.form.input', [
        'name' => 'Номер телефону',
        'model' => 'data.phone',
    ])

    @include('livewire.admin.form.input', [
        'name' => 'Новий пароль',
        'model' => 'newPassword',
    ])

    <div class="mt-6 flex justify-end">
        <button type="submit" class="btn btn-primary">
            {{ $user === null ? 'Створити' : 'Редагувати' }}
        </button>
    </div>
</form>