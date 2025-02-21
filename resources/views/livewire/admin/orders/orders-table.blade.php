<div class="overflow-x-auto w-full">
    <table class="table table-xs">
        <thead>
        <tr>
            <th>ID</th>
            <th class="cursor-pointer" wire:click="toggleSortColumn('order_date')">
                <div class="flex items-center gap-1">
                    Дата замовлення
                    @if($sortColumn == 'order_date')
                        @if($sortDirection == 'asc')
                            <i class="ri-arrow-up-line mt-0.5"></i>
                        @else
                            <i class="ri-arrow-down-line mt-0.5"></i>
                        @endif
                    @else
                        <i class="ri-arrow-up-down-line mt-0.5"></i>
                    @endif
                </div>
            </th>
            <th>Статус</th>
            <th>Клієнт</th>
            <th>Оплата</th>
            <th>Доставка</th>
            <th>Примітка</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($this->orders as $order)    
            <tr wire:key="{{ $order->id }}">
                <th class="w-[30px]">
                    <div class="w-[30px]">
                        {{ $order->id }}
                    </div>
                </th>
                <td class="w-[140px]">
                    <div class="text-xs max-w-[140px]">
                        {{ $order->formatted_date_time }}
                    </div>
                </td>
                <td class="w-[150px]">
                    <div>
                        <label class="form-control w-full max-w-[150px]">
                            <select class="select select-bordered w-full max-w-xs select-xs font-mono tracking-wider bg-{{ $order->status->colorTailwind() }}"
                                    wire:change="updateOrderStatus({{ $order->id }}, $event.target.value)">
                                    <option value="" @if(!$order->status) selected @endif disabled>Виберіть статус</option>
                                @foreach(\App\Enums\OrderStatusEnum::cases() as $option)
                                    <option @if($option == $order->status) selected @endif value="{{ $option->value }}">
                                        {{ $option->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </td>
                <td class="">
                    <div class="text-xs">
                        <div class="">{{ $order->customer_last_name }} {{ $order->customer_name }}</div>
                        <div class="text-gray-500">{{ $order->phone->formatInternational() }}</div>
                    </div>
                </td>
                <td>
                    <div>
                        <div class="">
                            Метод: <b>{{ $order->payment_method->label() }}</b>
                        </div>
                        <div>
                            Сума: <span class="font-bold">{{ $order->money_total }} ₴</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <div>Статус:</div>
                            <div class="p-1 rounded-lg bg-{{ $order->payment_status->colorTailwind() }}">
                                {{ $order->payment_status->label() }}
                            </div>
                        </div>
                    </div>
                </td>
                <td @if(empty($order->note)) colspan="2" @endif class="w-[200px]">
                    <div class="">
                        Метод: <b>{{ $order->delivery_method->label() }}</b>
                    </div>
                    <div class="">
                        @if($order->delivery_method == App\Enums\DeliveryMethodEnum::NOVAPOSHTA)
                            <div>
                                н.п.: <b>{{ $order?->warehouse?->city->name }}</b>
                            </div>
                            <div class="break-words">
                                Відділення: <b>{{ $order?->warehouse?->name }}</b>
                            </div>
                            <div class="flex gap-1 items-center">
                                <button class="btn btn-xs btn-primary bg-primary" 
                                    wire:click="$dispatch('openModal', { 
                                        component: 'admin.modals.edit-ttn-modal', 
                                        arguments: { 
                                            order: {{ $order->id }}
                                        } 
                                    })">

                                    <i class="ri-pencil-line"></i>
                                </button>
                                <div x-data="{ hover: false, clicked: false }" @mouseenter="hover = true" @mouseleave="hover = false" @click="clicked = true; setTimeout(() => clicked = false, 200)" :class="clicked ? 'text-pastelGreen' : 'text-black'"  class="relative text-gray-800 hover:cursor-pointer hover:opacity-75 duration-100" wire:click="copy('toCopyTTN{{ $order->id }}')">
                                    ТТН:
                                    <span id="toCopyTTN{{ $order->id }}">
                                        {{ $order?->ttn }}
                                    </span>
                                    <span x-cloak x-show="hover" class="absolute" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 transform scale-50" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-50">
                                        <i class="ri-clipboard-line"></i>
                                    </span>
                                </div>
                            </div>
                        @endif
                        <div class="flex items-center gap-1">
                            <div>Статус:</div>
                            <div class="p-1 rounded-lg bg-{{ $order->delivery_status->colorTailwind() }}">
                                {{ $order->delivery_status->label() }}
                            </div>
                        </div>
                    </div>
                </td>
                @if($order->note)
                <td class="w-[200px]" colspan="0">
                    <textarea class="min-h-[45px] h-[45px] border-gray-200 border-[1px] p-3 rounded-lg break-all max-w-[200px]" name="" id="" cols="30" rows="10" readonly>{{ $order->note ?? ''}}</textarea>
                </td>
                @endif
                <td>
                    <div class="flex gap-2 justify-center">
                        <a href="{{ route('admin.orders.edit', ['order' => $order]) }}" class="btn btn-xs btn-primary">
                            <i class="ri-pencil-line"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-3">
        {{ $this->orders->links('vendor.livewire.tailwind') }}
    </div>
</div>