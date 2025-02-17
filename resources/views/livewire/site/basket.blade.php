<div class="drawer drawer-end">
    <input id="my-drawer-4" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content">
        <label for="my-drawer-4" class="drawer-button btn-primary cursor-pointer relative">
            <i class="ri-shopping-basket-line ri-xl text-white"></i>
            <div class="absolute -top-4 -right-1">
                {{ $this->basketProductsCount }}
            </div>
        </label>
    </div>
    <div class="drawer-side z-50">
        <label for="my-drawer-4" aria-label="close sidebar" class="drawer-overlay"></label>
        <ul class="menu p-0 bg-base-200 min-h-full max-sm:w-screen w-[450px]">
            <div class="p-4 flex justify-between items-center border-b-2 border-b-gray-200">
                <span class="font-bold text-2xl">Кошик</span>

                <div class="flex justify-between items-center gap-4">
                    <span class="text-md">{{ $this->basketProductsCount }} Товарів</span>

                    <label for="my-drawer-4" class="drawer-button btn-primary cursor-pointer">
                        <i class="ri-close-fill ri-xl text-black text-2xl"></i>
                    </label>
                </div>
            </div>

            <div class="p-3 flex-col flex grow">
                <div class="basket__content">
                    @foreach($this->basketProducts as $basketProduct)
                        <div class="bg-white flex items-center gap-2 mt-3 p-2" wire:key="{{ $basketProduct->id }}">
                            <div class="flex items-center min-w-max w-max">
                                <a href="{{ route('products.show', $basketProduct->product->slug) }}">
                                    <img class="border-primary border-2 rounded-xl overflow-hidden" src="{{ $basketProduct->product->mainPhoto->public_url ?? asset('img/image-not-found.jpg') }}" alt="{{ $basketProduct->product->name }}" width="70" height="70">
                                </a>
                            </div>
                            <div class="text-gray-500 w-full max-sm:text-xs">
                                <h3 class="font-bold text-black line-clamp-2">{{ $basketProduct->product->name }}</h3>
                                <div class="my-1">
                                    <span class="">Артикул: {{ $basketProduct->product->article }}</span>
                                </div>
                                <div class="">
                                    <span class="">Розмір: <span class="font-bold text-black">{{ $basketProduct->size->name }}</span></span>
                                </div>
                            </div>
                            <div class="flex flex-col justify-between gap-2">
                                <button wire:click="increment('{{ $basketProduct->id }}')" class="button button--ghost button--icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                </button>
                                <div class="flex justify-center items-center text-lg mr-[1px]">
                                    <span class="">
                                        {{ $basketProduct->count }}
                                    </span>
                                </div>
                                <button wire:click="decrement('{{ $basketProduct->id }}')" class="button button--ghost button--icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus"><path d="M5 12h14"/></svg>
                                </button>
                            </div>
                            <div class="flex justify-center items-center text-primary text-md min-w-max w-max px-2">
                                {{ number_format($basketProduct->product->money_price, 0)}} грн
                            </div>
                            <div class="flex justify-center items-center">
                                <button class="btn btn-sm w-[36px] h-[36px] bg-red-500 hover:bg-red-600"
                                    wire:click="$dispatch('openModal', { 
                                        component: 'site.modals.delete-basket-product-modal', 
                                        arguments: { 
                                            subject: 'Видалити товар?', 
                                            text: 'Ви дійсно хочете видалити товар з кошика?', 
                                            dispatch: 'remove-from-basket', 
                                            modelId: {{ $basketProduct->id }} 
                                        } 
                                    })">
                                    <i class="ri-delete-bin-line text-white text-lg"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="p-4 border-t-2 border-t-gray-200">
                <div class="flex justify-between items-center ">
                    <span class="font-bold text-2xl">До сплати</span>
    
                    <span class="text-2xl text-primary">{{ $this->total }} грн.</span>
                </div>

                <div class="mt-3 px-3 text-lg w-full btn btn-primary">
                    Оформити замовлення
                </div>
            </div>
        </ul>
    </div>
</div>