<div class="overflow-x-auto w-full">
    <div class="max-w-xs mb-3">
        @include('livewire.admin.form.input', [
            'name' => 'Пошук',
            'model' => 'searchText',
            'isLive' => true,
        ])
    </div>
    <table class="table table-sm">
        <thead>
        <tr>
            <th>ID</th>
            <th></th>
            <th>Назва</th>
            <th>Slug</th>
            <th>Артикул</th>
            <th>Категорія</th>
            <th>Кількість</th>
            <th>Ціна</th>
            <th>Стара Ціна</th>
            <th>Активний</th>
            <th>Популярний</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($this->products as $product)
            <tr wire:key="{{ $product->id }}" class="{{ $product->is_active ? 'bg-pastelGreenLight' : 'bg-pastelRedLight' }}">
                <th>{{ $product->id }}</th>
                <td class="p-0.5">
                    <div class="avatar cursor-pointer">
                        <div wire:click="redirectToProduct('{{ $product->id }}')" class="w-12 rounded">
                            <img src="{{ $product->mainPhoto->public_url ?? asset('img/image-not-found.jpg') }}" />
                        </div>
                    </div>
                </td>
                <td class="break-all min-w-[120px]">{{ $product->name }}</td>
                <td class="break-all min-w-[120px]">{{ $product->slug }}</td>
                <td class="break-all">{{ $product->article }}</td>
                <td>{{ $product->category?->name }}</td>
                <td>{{ $product->all_count }}</td>
                <td>
                    <div class="flex justify-end">
                        {{ $product->money_price }} ₴
                    </div>
                </td>
                <td>
                    <div class="flex justify-end">
                        {{ $product->money_old_price !== null ? $product->money_old_price.' ₴' : 'Немає' }}
                    </div>
                </td>
                <td>
                    <div wire:key="product-{{ $product->id }}-active-{{ $product->is_active }}">
                        <input type="checkbox" class="toggle" @if($product->is_active) checked @endif
                            wire:click.prevent="$dispatch('openModal', {
                                component: 'admin.modals.warning-modal',
                                arguments: {
                                    dispatch: 'toggle-product-active',
                                    modelId: {{ $product->id }}
                                }
                            })"/>
                    </div>
                </td>
                <td>
                    <div wire:key="product-{{ $product->id }}-popular-{{ $product->is_popular }}">
                        <input type="checkbox" class="toggle" @if($product->is_popular) checked @endif
                            wire:click.prevent="$dispatch('openModal', {
                                component: 'admin.modals.warning-modal',
                                arguments: {
                                    dispatch: 'toggle-product-popular',
                                    modelId: {{ $product->id }}
                                }
                            })"/>
                    </div>
                </td>
                <td>
                    <div class="flex gap-2 justify-center">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                            <i class="ri-pencil-line"></i>
                        </a>

                        <button class="btn btn-sm btn-error"
                            wire:click="$dispatch('openModal', {
                                component: 'admin.modals.delete-modal',
                                arguments: {
                                    subject: 'Видалити товар?',
                                    text: 'Ця дія безворотня, ви дійсно бажаєте продовжити?',
                                    dispatch: 'delete-product',
                                    modelId: {{ $product->id }}
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
        {{ $this->products->links('vendor.livewire.tailwind') }}
    </div>
</div>

<script>
    document.addEventListener('redirect-to-product', event => {
        window.open(event.detail.url, '_blank');
    });
</script>
