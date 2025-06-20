<form wire:submit="save" enctype="multipart/form-data" class="flex flex-col">
    @component('admin.components.card', [
        'title' => 'Контент'
    ])
        {{-- <div class="tabs tabs-bordered sticky top-0 z-20 bg-white mt-4 mb-2 rounded-b-lg ">
            @foreach (localization()->getSupportedLocales()->toArray() as $key => $locale)
                <a role="tab" class="tab w-fit max-w-xs @if($selectedLocale == $key) tab-active @endif" wire:click="setLocale('{{ $key }}')">{{ strtoupper($locale['key']) }}</a>
            @endforeach
        </div> --}}

        @include('livewire.admin.form.input', [
            'name' => 'Назва',
            'model' => "data.name",
        ])

        @component('livewire.admin.form.input', [
            'name' => 'Slug',
            'model' => 'data.slug',
        ])
            <div class="join">
                <button type="button" wire:click="generateSlug" class="join-item btn btn-sm btn-primary" title="Згенерувати Slug">
                    <i class="ri-ai-generate-text ri-lg"></i>
                </button>
                <input type="text" placeholder="Type here" wire:model="data.slug" class="join-item input input-sm input-bordered w-full @error('slug') input-error @enderror" />

            </div>
        @endcomponent

        @include('livewire.admin.form.input', [
            'name' => 'Артикул',
            'model' => 'data.article',
        ])

        <div id="quill-short-descriptio" class="w-full">
            @include('livewire.admin.form.quill-editor', [
                'id' => "quill-product-short-desc",
                'wireModel' => "data.short_description",
                'name' => 'Короткий опис',
            ])
        </div>

        <div id="quill-description" class="w-full">
            @include('livewire.admin.form.quill-editor', [
                'id' => "quill-product-desc",
                'wireModel' => "data.description",
                'name' => 'Опис',
            ])
        </div>
    @endcomponent


    @component('admin.components.card', [
        'title' => 'Атрибути'
    ])
        <div class="flex flex-col justify-between sm:flex-row w-full">
            <div class="flex flex-col flex-[1_1]">
                @include('livewire.admin.form.checkbox', [
                    'name' => 'Активний',
                    'model' => 'data.is_active',
                ])

                {{-- @include('livewire.admin.form.checkbox', [
                    'name' => 'Товар дня',
                    'model' => 'data.is_day_product',
                ]) --}}

                @include('livewire.admin.form.checkbox', [
                    'name' => 'Популярний',
                    'model' => 'data.is_popular',
                ])
            </div>

            <div class="flex-[2_1]">
                <div class="flex md:gap-3 flex-col md:flex-row">
                    <div class="form-control w-full md:w-full">
                        <label for="category" class="">
                            <span class="text-md text">Категорія</span>
                        </label>
                        <select name="category" wire:model="data.category_id" class="select select-sm select-bordered @error('data.category_id') select-error @enderror">
                            <option value="null" disabled selected>Виберіть категорію</option>
                            @foreach ($this->categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('data.category_id')
                        <div class="text-red-500 mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="flex gap-3 w-full">
                        {{-- @include('livewire.admin.form.input', [
                            'name' => 'Кількість',
                            'model' => 'data.count',
                            'type' => 'number',
                        ]) --}}

                        @include('livewire.admin.form.input', [
                            'name' => 'Ціна',
                            'model' => 'data.price',
                        ])
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full">
            <label class="mt-3">
                <div class="label">
                    <span class="label-text">Акція</span>
                </div>
                <input type="checkbox" wire:model.live="data.is_discount"  class="toggle"/>
                @error('data.is_discount')
                <div class="text-red-500 mt-1">
                    {{ $message }}
                </div>
                @enderror
            </label>

            @if($data['is_discount'])
                @include('livewire.admin.form.input', [
                    'name' => 'Стара Ціна',
                    'model' => 'data.old_price',
                ])
            @endif
        </div>
    @endcomponent

    @component('admin.components.card', [
        'title' => 'Розміри товару'
    ])
        {{-- <div wire:ignore class="">
            <select class=".js-example-basic-single" id="select2-1">
                <option value="AL">Alabama</option>
                <option value="WY">Wyoming</option>
            </select>
        </div> --}}

        <div class="overflow-x-auto w-full">
            <table class="table">
                <thead>
                <tr>
                    <th>Розмір</th>
                    <th>Кількість</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($addSizes as $index => $addSize)
                    <tr>
                        <td class="w-[200px]">
                            {{-- <div wire:ignore class="w-full h-full">
                                <select style="width: 100%; height: 100%;" id="select2-{{ $index }}-{{ $addSizes[$index]['size_id'] }}" x-data="select2($el, $wire, @js("addSizes.".$index.".size_id"))" >
                                    @foreach ($this->sizes as $size)
                                        <option value="{{ $size->id }}" @if($addSize['size_id'] == $size->id) selected @endif>{{ $size->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            @include('livewire.admin.form.select2', [
                                'key' => "addSize-$index-".$addSizes[$index]['size_id'],
                                'id' => "select2-$index-".$addSizes[$index]['size_id'],
                                'wireModel' => "addSizes.".$index.".size_id",
                                'options' => $this->sizes,
                                'modelValue' => $addSizes[$index]['size_id'],
                                'index' => $index,
                                'addSizes' => $addSizes,
                                'addSize' => $addSize,
                            ])
                        </td>
                        <td>
                            @include('livewire.admin.form.input', [
                                'isLive' => true,
                                'id' => 'addSize-{{ $index }}',
                                'model' => "addSizes.".$index.".count"
                            ])
                        </td>
                        <td class="max-w-[60px] w-[60px]">
                            <div class="flex justify-center">
                                <button type="button" class="btn btn-error" wire:click="removeSize('{{ $index }}')">
                                    <i class="ri-delete-bin-line ri-lg text-white"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex justify-center">
                <button type="button" class="btn btn-success" wire:click="addSize">
                    <i class="ri-add-circle-line ri-xl text-white"></i>
                </button>
            </div>

            @error('addSizes')
                <div class="text-red-500 mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- @foreach ($selectedSizes as $index => $selectedSize)
            <div wire:ignore class="w-full">
                <select style="width: 100%;" id="select2-{{ $index }}" x-data="select2($el, $wire, @js('selectedSizes.{{ $index }}'))" >
                    @foreach ($this->sizes as $size)
                        <option value="{{ $size->id }}" @if($selectedSize == $size->id) selected @endif>{{ $size->name }}</option>
                    @endforeach
                </select>
            </div>
        @endforeach --}}
    @endcomponent

    @component('admin.components.card', [
        'title' => 'Зображення'
    ])
        <ul wire:sortable="renderPhotos" class="flex flex-wrap gap-4 items-center">
            @foreach($gallery->photos as $index => $photo)
                <li wire:sortable.item="{{ $photo['id'] }}" draggable="true">
                    <div class="avatar">
                        <div class="w-36 sm:w-48 rounded relative">
                            <div class="absolute left-1 top-1 bg-white rounded-full px-2 flex gap-1">
                                {{ $index + 1 }}
                                <div class="bg-white px-1 rounded-full cursor-pointer" wire:click="setMain('{{ $photo['id'] }}')">
                                    @if($photo['is_main'])
                                        <i class="ri-star-fill"></i>
                                    @else
                                        <i class="ri-star-line"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="absolute right-1 top-1 flex gap-2">
                                <div class="cursor-pointer bg-red-500 hover:bg-red-600 rounded-full px-1" wire:click="deletePhoto('{{ $photo['id'] }}')">
                                    <i class="ri-delete-bin-line"></i>
                                </div>
                            </div>
                            <img src="{{ $photo['storage_path'] ?? asset('img/image-not-found.jpg') }}" />
                        </div>
                    </div>
                </li>
            @endforeach

            <div class="cursor-pointer">
                <button type="button" class="btn px-3 rounded-full" onclick="document.getElementById('photo-input').click()">
                    <i class="ri-add-circle-line text-2xl"></i>
                </button>
                <input accept="image/png, image/jpeg, image/jpg" type="file" id="photo-input" wire:model="gallery.uploadedPhotos" class="hidden" multiple/>
            </div>
            @error('gallery.uploadedPhotos.*')
            <div class="text-red-500 mt-1">
                {{ $message }}
            </div>
            @enderror
        </ul>
    @endcomponent

    <div class="mt-6 flex justify-end">
        <button type="submit" class="btn btn-primary">
            {{ $product === null ? 'Створити' : 'Редагувати' }}
        </button>
    </div>
</form>
