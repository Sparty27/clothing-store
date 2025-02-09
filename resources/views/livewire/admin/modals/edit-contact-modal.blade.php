<div class="p-6">
    <div>
        <button wire:click="$dispatch('closeModal')" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </div>
    <h3 class="text-lg font-bold">Редагувати Контакт</h3>
    <div class="mt-6">
        @include('livewire.admin.form.input', [
            'name' => trans('contacts.'.$type->value),
            'model' => "data.$type->value",
        ])

        @if($type == App\Enums\ContactEnum::ADDRESS)
            @include('livewire.admin.form.input', [
                'name' => 'Координати',
                'model' => 'data.coordinates',
            ])
        @endif

        <div class="flex">
            @include('livewire.admin.form.checkbox', [
                'name' => 'Активний',
                'model' => 'isActive',
            ])
        </div>
    </div>
    <div class="flex justify-end gap-2 mt-6">
        <button wire:click="$dispatch('closeModal')" class="btn btn-sm gap-1">
            <i class="ri-arrow-go-back-line"></i>
            Назад
        </button>
        <button wire:click="save" class="btn btn-sm btn-success gap-1 text-white">
            Редагувати
        </button>
    </div>
</div>