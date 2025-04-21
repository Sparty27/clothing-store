<form wire:submit="save" enctype="multipart/form-data">
    <div class="mb-6">
        <h2 class="font-bold text-lg">Замовлення</h2>  
        <div class="">
            <div class="flex">
                <div class="p-3 rounded-lg bg-{{ $data['status']->colorTailwind() }}">
                    {{ $order->status->label() }}
                </div>
            </div>
    
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Примітка</span>
                </div>
                <textarea class="min-h-[100px] border-gray-200 border-[1px] p-3 rounded-lg break-all w-full @error('data.note') input-error @enderror" wire:model="data.note"></textarea>
                @error('data.note')
                <div class="text-red-500 mt-1">
                    {{ $message }}
                </div>
                @enderror
            </label>
        </div>
    </div>

    <div class="my-6">
        <h2 class="font-bold text-lg">Контакти замовника</h2>
        <div x-data="{ isEditing: false }" class="form-control w-full">
            <div x-show="!isEditing" class="flex justify-between items-center">
                <div>
                    <div class="">
                        <span class="label-text">Імʼя</span>
                    </div>
                    <div class="font-bold">
                        {{ $data['customer_name'] }}
                    </div>
                </div>

                <div>
                    <div class="">
                        <span class="label-text">Прізвище</span>
                    </div>
                    <div class="font-bold">
                        {{ $data['customer_last_name'] }}
                    </div>
                </div>

                <div>
                    <div class="">
                        <span class="label-text">Номер телефона</span>
                    </div>
                    <div class="font-bold">
                        {{ $data['phone'] }}
                    </div>
                </div>

                <button @click="isEditing = true" class="btn btn-sm btn-primary mt-2" type="button">
                    <i class="ri-pencil-line"></i>
                </button>
            </div>
        
            <div x-show="isEditing" class="flex gap-4">
                @include('livewire.admin.form.input', [
                    'name' => 'Імʼя',
                    'model' => 'data.customer_name',
                    'placeholder' => 'Введіть імʼя замовника',
                ])
        
                @include('livewire.admin.form.input', [
                    'name' => 'Прізвище',
                    'model' => 'data.customer_last_name',
                    'placeholder' => 'Введіть прізвище замовника',
                ])
        
                @include('livewire.admin.form.input', [
                    'name' => 'Номер телефона',
                    'model' => 'data.phone',
                    'placeholder' => 'Введіть номер замовника',
                ])
            </div>
        </div>
    </div>

    <div class="my-6">
        <h2 class="font-bold text-lg">Оплата</h2>
        <div class="flex gap-4 w-full">
            <div class="">
                @include('livewire.admin.form.select-enum', [
                    'name' => 'Тип оплати',
                    'options' => App\Enums\PaymentMethodEnum::cases(),
                    'disabled' => true,
                    'live' => true,
                    'model' => 'data.payment_method',
                    'placeholder' => 'Виберіть статус',
                ])
            </div>
            <div>
                @include('livewire.admin.form.select-enum', [
                    'name' => 'Статус оплати',
                    'options' => App\Enums\PaymentStatusEnum::cases(),
                    'disabled' => true,
                    'live' => true,
                    'model' => 'data.payment_status',
                    'placeholder' => 'Виберіть статус',
                    'class' => 'bg-'.$data['payment_status']->colorTailwind(),
                ])
            </div>
        </div>
        <div class="mt-3">
            Сума до сплати: <b>{{ $order->money_total }}</b>₴
        </div>
    </div>

    <div class="my-6">
        <h2 class="font-bold text-lg">Доставка</h2>
        <div class="flex gap-4 w-full">
            <div class="">
                @include('livewire.admin.form.select-enum', [
                    'name' => 'Тип доставки',
                    'options' => App\Enums\DeliveryMethodEnum::cases(),
                    'disabled' => true,
                    'live' => true,
                    'model' => 'data.delivery_method',
                    'placeholder' => 'Виберіть статус',
                ])
            </div>
            <div>
                @include('livewire.admin.form.select-enum', [
                    'name' => 'Статус доставки',
                    'options' => App\Enums\DeliveryStatusEnum::cases(),
                    'disabled' => true,
                    'live' => true,
                    'model' => 'data.delivery_status',
                    'placeholder' => 'Виберіть статус',
                    'class' => 'bg-'.$data['delivery_status']->colorTailwind(),
                ])
            </div>
        </div>

        @if($data['delivery_method'] === App\Enums\DeliveryMethodEnum::NOVAPOSHTA)
            <label class="form-control max-w-[250px]">
                <div class="label">
                    <span class="label-text">ТТН</span>
                </div>
                <input x-mask="99 9999 9999 9999" type="text" placeholder="Введіть ТТН" wire:model="data.ttn" class="input input-bordered w-full text-lg @error('data.ttn') input-error @enderror" />
                @error('data.ttn')
                <div class="text-red-500 mt-1">
                    {{ $message }}
                </div>
                @enderror
            </label>
            
            <div class="flex gap-4 flex-wrap">
                <label class="form-control max-w-[300px] w-full">
                    <div class="label">
                        <span class="label-text">Місто</span>
                    </div>
                    
                    @include('livewire.admin.form.select2-api', [
                        'wireModel' => 'selectedCity',
                        'key' => 'city-selector',
                        'url' => '/api/novaposhta/cities',
                        'passedData' => [
                            'placeholder' => 'Виберіть місто',
                            'not_found' => 'Нічого не знайдено'
                        ]
                    ])
                </label>
                
                <label class="form-control max-w-[300px] w-full">
                    <div class="label">
                        <span class="label-text">Відділення</span>
                    </div>

                    @include('livewire.admin.form.select2-api', [
                        'wireModel' => 'selectedWarehouse',
                        'key' => 'warehouse-selector',
                        'url' => '/api/novaposhta/warehouses',
                        'passedData' => [
                            'placeholder' => 'Виберіть відділення',
                            'selectedCity' => 'novaposhtaForm.selectedCity',
                            'relatedOnly' => true,
                            'not_found' => 'Нічого не знайдено'
                        ]
                    ])
                </label>
            </div>
        @endif
    </div>

    <div class="my-6">
        <h2 class="font-bold text-lg">Товари</h2>
        <div class="overflow-x-scroll">
            <table class="table table-xs table-fixed max-sm:w-[700px]">
                <thead>
                    <tr>
                    <th>Зображення</th>
                    <th>Назва</th>
                    <th>Розмір</th>
                    <th>Кількість</th>
                    <th>Ціна</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->orderProducts as $index => $orderProduct)
                    <tr wire:key="{{ $orderProduct->id }}">
                    <td>
                        <div class="avatar">
                            <div class="w-16 rounded">
                              <img
                                src="{{ $orderProduct->product->mainPhoto->public_url ?? asset('img/image-not-found.jpg') }}"
                                alt="{{ $orderProduct->name }}" />
                            </div>
                          </div>
                    </td>
                    <td>
                        {{ $orderProduct->name }}
                    </td>
                    <td>
                        {{ $orderProduct->productSize->size->name }}
                    </td>
                    <td>
                        <div class="">
                            <div class="flex gap-3 items-center">
                                <input type="number" min="1" max="99999"
                                    wire:model.live.debounce.250ms="quantities.{{ $orderProduct->id }}" 
                                    class="input input-bordered max-w-[100px] w-full">
                                <span class="text-lg">шт.</span>
                                @if($orderProduct->count != $quantities[$orderProduct->id])
                                    <div wire:click="restoreOrderProduct('{{ $orderProduct->id }}', 'quantity')" class="bg-pastelBlue cursor-pointer rounded-full min-w-8 w-8 min-h-8 h-8 flex justify-center items-center">
                                        <i class="ri-edit-2-line ri-lg"></i>
                                    </div>
                                @endif
                            </div>
                            @error('quantities.'.$orderProduct->id)
                            <div class="text-red-500 mt-1 break-words">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </td>
                    <td>
                        <div>
                            <div class="flex gap-3 items-center">
                                <input type="text"
                                    wire:model.live.debounce.250ms="prices.{{ $orderProduct->id }}" 
                                    class="input input-bordered w-full">
                                <span class="text-lg">₴</span>
                                @if(!$this->isPriceEqual($orderProduct))
                                    <div wire:click="restoreOrderProduct('{{ $orderProduct->id }}', 'price')" class="bg-pastelBlue cursor-pointer rounded-full min-w-8 w-8 min-h-8 h-8 flex justify-center items-center">
                                        <i class="ri-edit-2-line ri-lg"></i>
                                    </div>
                                @endif
                            </div>
                            @error('prices.'.$orderProduct->id)
                            <div class="text-red-500 mt-1 break-words">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 flex justify-between items-center">
        <div class="text-2xl md:text-3xl">
            Сума: <span class="font-bold text-green-700">{{ $this->pricesTotal }} ₴</span>
        </div>
        <button type="submit" class="btn btn-primary">
            {{ $order === null ? 'Створити' : 'Редагувати' }}
        </button>
    </div>
</form>