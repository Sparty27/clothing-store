<form wire:submit="save" enctype="multipart/form-data">
    <div class="mb-6">
        <h2 class="font-bold text-lg">Замовлення</h2>  
        <div class="">
            <div class="flex">
                <div class="p-3 rounded-lg bg-{{ $formData['status']->colorTailwind() }}">
                    {{ $order->status->label() }}
                </div>
            </div>
    
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Примітка</span>
                </div>
                <textarea class="min-h-[100px] border-gray-200 border-[1px] p-3 rounded-lg break-all w-full @error('formData.note') input-error @enderror" wire:model="formData.note"></textarea>
                @error('formData.note')
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
                        {{ $formData['customer_name'] }}
                    </div>
                </div>

                <div>
                    <div class="">
                        <span class="label-text">Прізвище</span>
                    </div>
                    <div class="font-bold">
                        {{ $formData['customer_last_name'] }}
                    </div>
                </div>

                <div>
                    <div class="">
                        <span class="label-text">Номер телефона</span>
                    </div>
                    <div class="font-bold">
                        {{ $formData['phone'] }}
                    </div>
                </div>

                <button @click="isEditing = true" class="btn btn-sm btn-primary mt-2" type="button">
                    <i class="ri-pencil-line"></i>
                </button>
            </div>
        
            <div x-show="isEditing" class="flex gap-4">
                @include('livewire.admin.form.input', [
                    'name' => 'Імʼя',
                    'model' => 'formData.customer_name',
                    'placeholder' => 'Введіть імʼя замовника',
                ])
        
                @include('livewire.admin.form.input', [
                    'name' => 'Прізвище',
                    'model' => 'formData.customer_last_name',
                    'placeholder' => 'Введіть прізвище замовника',
                ])
        
                @include('livewire.admin.form.input', [
                    'name' => 'Номер телефона',
                    'model' => 'formData.phone',
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
                    'model' => 'formData.payment_method',
                    'placeholder' => 'Виберіть статус',
                ])
            </div>
            <div>
                @include('livewire.admin.form.select-enum', [
                    'name' => 'Статус оплати',
                    'options' => App\Enums\PaymentStatusEnum::cases(),
                    'disabled' => true,
                    'live' => true,
                    'model' => 'formData.payment_status',
                    'placeholder' => 'Виберіть статус',
                    'class' => 'bg-'.$formData['payment_status']->colorTailwind(),
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
                    'model' => 'formData.delivery_method',
                    'placeholder' => 'Виберіть статус',
                ])
            </div>
            <div>
                @include('livewire.admin.form.select-enum', [
                    'name' => 'Статус доставки',
                    'options' => App\Enums\DeliveryStatusEnum::cases(),
                    'disabled' => true,
                    'live' => true,
                    'model' => 'formData.delivery_status',
                    'placeholder' => 'Виберіть статус',
                    'class' => 'bg-'.$formData['delivery_status']->colorTailwind(),
                ])
            </div>
        </div>

        @if($formData['delivery_method'] === App\Enums\DeliveryMethodEnum::NOVAPOSHTA)
            <label class="form-control max-w-[250px]">
                <div class="label">
                    <span class="label-text">ТТН</span>
                </div>
                <input x-mask="99 9999 9999 9999" type="text" placeholder="Введіть ТТН" wire:model="formData.ttn" class="input input-bordered w-full text-lg @error('formData.ttn') input-error @enderror" />
                @error('formData.ttn')
                <div class="text-red-500 mt-1">
                    {{ $message }}
                </div>
                @enderror
            </label>
            
            <div class="flex gap-4">
                <div class="form-control w-full mt-3">
                    <label for="searchCities" class="">
                        <i class="ri-building-line"></i>
                        <span class="text-md text">Населений пункт</span>
                    </label>
                
                    <div wire:key="searchCities">
                        <div wire:ignore class="w-full h-full">
                            <select style="width: 100%; height: 100%" id="searchCities" x-data="select2($el, $wire, 'selectedCity', '/api/novaposhta/cities')" ></select>
                        </div>
            
                        @error($selectedCity)
                            <div class="text-red-500 mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-control w-full mt-3">
                    <label for="searchWarehouses" class="">
                        <i class="ri-box-3-line"></i>
                        <span class="text-md text">Відділення Нової Пошти</span>
                    </label>
                
                    <div wire:key="searchWarehouses">
                        <div wire:ignore class="w-full h-full">
                            <select style="width: 100%; height: 100%" id="searchWarehouses" x-data="select2($el, $wire, 'selectedWarehouse', '/api/novaposhta/warehouses', @js(['selectedCity' => 'selectedCity', 'relatedOnly' => true]))"></select>
                        </div>
            
                        @error($selectedWarehouse)
                            <div class="text-red-500 mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
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