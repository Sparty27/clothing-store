<div class="flex gap-12 max-lg:block">
    <div class="rounded-xl shadow-xl border-gray-100 border-[1px] p-4 w-full lg:max-w-[550px] dark:bg-[#282828] dark:border-[#575757] dark:text-white">
        <h3 class="font-bold text-2xl">
            Форма замовлення
        </h3>

        <div class="mt-3">
            @include('livewire.site.form.input', [
                'model' => 'name',
                'name' => 'Імʼя',
                'icon' => 'ri-user-line',
            ])
        </div>

        <div class="mt-3">
            @include('livewire.site.form.input', [
                'model' => 'lastName',
                'name' => 'Прізвище',
                'icon' => 'ri-user-line',
            ])
        </div>

        <div class="mt-3">
            @include('livewire.site.form.input', [
                'model' => 'phone',
                'name' => 'Телефон',
                'icon' => 'ri-phone-line',
            ])
        </div>

        <div class="mt-3">
            @include('livewire.site.form.radio', [
                'model' => 'deliveryMethod',
                'name' => 'Метод доставки',
                'cases' => \App\Enums\DeliveryMethodEnum::cases(),
                'icon' => 'ri-truck-line',
                'listClass' => 'max-sm:flex-wrap max-md:gap-y-3',
            ])
        </div>

        @if($deliveryMethod === \App\Enums\DeliveryMethodEnum::NOVAPOSHTA->value)
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
        @endif

        <div class="mt-3">
            @include('livewire.site.form.radio', [
                'model' => 'paymentMethod',
                'name' => 'Метод оплати',
                'cases' => \App\Enums\PaymentMethodEnum::cases(),
                'icon' => 'ri-bank-card-line',
                'listClass' => 'max-sm:flex-wrap max-md:gap-y-3',
            ])
        </div>

        <div class="mt-3">
            @include('livewire.site.form.textarea', [
                'model' => 'note',
                'name' => 'Додаткова інформація',
                'placeholder' => 'Додаткова інформація',
                'icon' => 'ri-sticky-note-line',
            ])
        </div>

        <div class="flex justify-center mt-3">
            <button type="button" class="btn btn-primary text-white" wire:click="save" wire:loading.attr="disabled">
                Підтвердити замовлення
            </button>
        </div>
    </div>

    <div class="rounded-xl shadow-xl border-gray-100 border-[1px] p-4 w-full max-lg:mt-12 dark:bg-[#282828] dark:border-[#575757] dark:text-white">
        <div class="border-b-2 border-b-gray-200 pb-3 flex justify-between items-center">
            <div class="max-sm:text-lg text-2xl font-bold">
                Ваше замовлення
            </div>
            <div>
                <div class="text-md">
                    До сплати:
                </div>
                <div class="max-sm:flex max-sm:flex-col max-sm:gap-3">
                    <span class="text-gray-500 line-through text-sm">{{ number_format($this->totalOldPrice, 2, '.', ' ') }} грн</span>
                    <span class="text-primary max-sm:text-lg text-2xl w-max">{{ number_format($this->total, 2, '.', ' ') }} грн</span>
                </div>
            </div>
        </div>
        <div>
            @foreach ($this->basketProducts as $basketProduct)
            <div class="bg-white dark:bg-[#3f3f3f] flex items-center gap-2 mt-3 p-2" wire:key="{{ $basketProduct->id }}">
                <div class="flex items-center min-w-max w-max">
                    <a href="{{ route('products.show', $basketProduct->product->slug) }}">
                        <img class="border-primary border-2 rounded-xl overflow-hidden max-sm:w-[50px]" src="{{ $basketProduct->product->mainPhoto->public_url ?? asset('img/image-not-found.jpg') }}" alt="{{ $basketProduct->product->name }}" width="80" height="80">
                    </a>
                </div>
                <div class="text-gray-500 w-full max-sm:text-xs">
                    <h3 class="font-bold text-black line-clamp-2 dark:text-primary">{{ $basketProduct->product->name }}</h3>
                    <div class="my-1">
                        <span class="dark:text-white">Артикул: {{ $basketProduct->product->article }}</span>
                    </div>
                    <div class="">
                        <span class="dark:text-white">Розмір: <span class="font-bold text-black dark:text-primary">{{ $basketProduct->size->name }}</span></span>
                    </div>
                </div>
                <div class="w-max min-w-max">
                    {{ $basketProduct->count }} шт.
                </div>
                <div class="flex justify-center items-center text-primary text-md min-w-max w-max px-2">
                    {{ number_format($basketProduct->product->money_price, 0)}} грн
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>