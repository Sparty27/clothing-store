<div class="">
    <div class="text-2xl md:text-[36px] font-bold flex justify-center">
        Мої покупки
    </div>
    <div class="mt-6 rounded-2xl border-gray-100 border-[1px] p-3 shadow-lg">
        @foreach($this->orders as $order)
            <div class="p-3 rounded-xl shadow-lg border-gray-200 border-[1px] mt-6">
                <div class="flex justify-between border-b-gray-200 border-b-2 pb-2">
                    <h2 class="text-primary font-bold text-md xl:text-xl">{{ $order->formatted_date_time }}</h2>

                    <div class="flex flex-col gap-2">
                        <div>
                            <span class="">Сума замовлення - <strong>{{ $order->money_total }} грн</strong></span>
                        </div>
                        <button wire:click="repeatOrder('{{ $order->id }}')" class="btn btn-sm btn-primary">Повторити замовлення</button>
                    </div>
                </div>
                <div>
                    @foreach($order->orderProducts as $orderProduct)
                    <div class="bg-white flex items-center gap-2 mt-3 p-2" wire:key="{{ $orderProduct->id }}">
                        <div class="flex items-center min-w-max w-max">
                            <a href="{{ route('products.show', $orderProduct->product->slug) }}">
                                <img class="border-primary border-2 rounded-xl overflow-hidden max-sm:w-[50px]" src="{{ $orderProduct->product->mainPhoto->public_url ?? asset('img/image-not-found.jpg') }}" alt="{{ $orderProduct->product->name }}" width="80" height="80">
                            </a>
                        </div>
                        <div class="text-gray-500 w-full max-sm:text-xs">
                            <h3 class="font-bold text-black line-clamp-2">{{ $orderProduct->product->name }}</h3>
                            <div class="my-1">
                                <span class="">Артикул: {{ $orderProduct->product->article }}</span>
                            </div>
                            <div class="">
                                <span class="">Розмір: <span class="font-bold text-black">{{ $orderProduct->size->name }}</span></span>
                            </div>
                        </div>
                        <div class="w-max min-w-max">
                            {{ $orderProduct->count }} шт.
                        </div>
                        <div class="flex justify-center items-center text-primary text-md min-w-max w-max px-2">
                            {{ number_format($orderProduct->product->money_price, 0)}} грн
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        @if(!$this->orders->isEmpty())
            <div class="flex justify-center mt-3">
                <button class="btn btn-primary" wire:click="toggleShowAll">
                    @if (!$showAll)
                        Показати все
                    @else
                        Сховати
                    @endif
                </button>
            </div>
        @endif
    </div>
</div>