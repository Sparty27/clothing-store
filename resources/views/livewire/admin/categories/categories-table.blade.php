<div class="overflow-x-auto w-full">
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Зображення</th>
            <th>Категорія</th>
            <th>Активний</th>
            <th>Активний у футері</th>
            <th>Пріоритет</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($categories as $category)
            <tr wire:key="{{ $category->id }}" class="{{ $category->is_visible ? 'bg-pastelGreenLight' : 'bg-pastelRedLight' }}">
                <th>{{ $category->id }}</th>
                <td>
                    <div class="avatar">
                        <div class="w-12 rounded">
                            <img src="{{ $category->photo_url ?? asset('img/image-not-found.jpg') }}" />
                        </div>
                    </div>
                </td>
                <td>{{ $category->name }}</td>
                <td>
                    <div wire:key="category-{{ $category->id }}-visible-{{ $category->is_visible }}">
                        <input type="checkbox" class="toggle" @if($category->is_visible) checked="checked" @endif 
                            wire:click.prevent="$dispatch('openModal', { 
                                component: 'admin.modals.warning-modal', 
                                arguments: { 
                                    dispatch: 'toggle-category-visible', 
                                    modelId: {{ $category->id }} 
                                } 
                            })"/>
                    </div>
                </td>
                <td>
                    <div wire:key="category-{{ $category->id }}-footer-visible-{{ $category->is_footer_visible }}">
                        <input type="checkbox" class="toggle" @if($category->is_footer_visible) checked="checked" @endif 
                            wire:click.prevent="$dispatch('openModal', { 
                                component: 'admin.modals.warning-modal', 
                                arguments: { 
                                    dispatch: 'toggle-category-footer-visible', 
                                    modelId: {{ $category->id }} 
                                } 
                            })"/>
                    </div>
                </td>
                <td>
                    <div class="flex items-center gap-3">
                        {{ $category->priority ?? ''}}
                        <div class="">
                            <div>
                                <button wire:click="increasePriority('{{ $category->id }}')" class="rounded-full bg-green-300 shadow w-5 h-5"><i class="ri-arrow-up-line ri-sm"></i></button>
                            </div>
                            <div>
                                <button wire:click="decreasePriority('{{ $category->id }}')" class="rounded-full bg-red-300 shadow w-5 h-5 mt-1"><i class="ri-arrow-down-line ri-sm"></i></button>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="flex gap-2 justify-center">
                        <a href="#" class="btn btn-sm btn-primary">
                        {{-- <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-primary"> --}}
                            <i class="ri-pencil-line"></i>
                        </a>

                        <button class="btn btn-sm btn-error" 
                            wire:click="$dispatch('openModal', { 
                                component: 'admin.components.delete-modal', 
                                arguments: { 
                                    subject: 'Видалити категорію?', 
                                    text: 'Ця дія не зворотня, ви дійсно бажаєте продовжити?', 
                                    dispatch: 'delete-category', 
                                    modelId: {{ $category->id }} 
                                } 
                            })">

                            <i class="ri-delete-bin-line text-white"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-3">
        {{ $categories->links('vendor.livewire.tailwind') }}
    </div>
</div>