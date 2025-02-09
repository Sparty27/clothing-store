<form wire:submit="save" enctype="multipart/form-data" class="w-full flex flex-col gap-3">
    @include('livewire.admin.form.input', [
        'name' => 'Назва',
        'model' => 'name'
    ])

    @component('livewire.admin.form.input', [
        'name' => 'Slug',
        'model' => 'slug',
    ])
        <div class="join">
            <button type="button" wire:click="generateSlug" class="join-item btn btn-sm btn-primary" title="Згенерувати Slug">
                <i class="ri-ai-generate-text ri-lg"></i>
            </button>
            <input type="text" placeholder="Type here" wire:model="slug" class="join-item input input-sm input-bordered w-full @error('slug') input-error @enderror" />

        </div>
    @endcomponent

    @if($category)
        @include('livewire.admin.form.input', [
            'name' => 'Пріоритет',
            'model' => 'priority',
            'type' => 'number',
        ])
    @endif

    @component('livewire.admin.form.input', [
        'name' => 'Зображення',
        'model' => 'image',
        'type' => 'file',
    ])
        @if ($category?->photo_url)
            <div class="avatar mb-3">
                <div class="w-24 rounded">
                    <img src="{{ $category->photo_url ?? asset('img/image-not-found.jpg') }}" />
                </div>
            </div>
        @endif

        <input wire:model="image" name="image" type="file" class="file-input file-input-bordered w-full max-w-xs @error('image') file-input-error @enderror" />
    @endcomponent

    <div class="mt-6 flex justify-end">
        <button type="submit" class="btn btn-primary">
            {{ $category === null ? 'Створити' : 'Редагувати' }}
        </button>
    </div>
</form>