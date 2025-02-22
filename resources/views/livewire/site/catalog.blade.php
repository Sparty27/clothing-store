<div class="flex gap-4">
    <div class="min-w-[300px] max-w-[300px] w-[300px] max-lg:hidden">
        <div>
            <h2 class="text-2xl font-bold dark:text-white">Фільтри</h2>
        
            <div>
                <button wire:click="clearFilters" class="btn btn-primary mt-2 w-full">
                    Очистити фільтри
                </button>
            </div>

            <div class="collapse collapse-arrow join-item border-base-300 border mt-3">
                <input type="checkbox" name="my-accordion-1" checked/>
                <div class="collapse-title text-base font-medium dark:text-white">Категорії</div>
                <div class="collapse-content">
                    <select class="select select-bordered w-full max-w-xs" wire:model.live="selectedCategory">
                        <option value="null" selected>Всі</option>
                        @foreach($this->categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        
            @if(!empty($this->sizes))
            <div class="collapse collapse-arrow join-item border-base-300 border mt-3">
                <input type="checkbox" name="my-accordion-1" checked/>
                <div class="collapse-title text-base font-medium dark:text-white">Розміри</div>
                <div class="collapse-content">
                    <div class="form-control max-h-[300px] overflow-y-scroll">
                        @foreach($this->sizes as $size)
                            <label class="label cursor-pointer">
                                <span class="label-text dark:text-white">{{ $size->name }}</span>
                                <input type="checkbox" class="checkbox dark:bg-white" value="{{ $size->id }}" wire:model.live="selectedSizes"/>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        
            <div class="collapse collapse-arrow join-item border-base-300 border mt-3">
                <input type="checkbox" name="my-accordion-3" checked/>
                <div class="collapse-title text-base font-medium dark:text-white">Ціна</div>
                <div class="collapse-content">
                    <div class="flex justify-between items-top gap-4">
                        <label class="form-control">
                            <div class="flex items-center relative">
                                <input type="text" placeholder="0" class="input input-bordered text-sm h-9
                                    @error('minPrice') input-error @enderror w-full"
                                    wire:model="minPrice" />
                            </div>
                            @error('minPrice')
                            <div class="label">
                                <span class="label-text-alt text-red-500">{{ $message }}</span>
                            </div>
                            @enderror
                        </label>
                        <span class="mt-1">
                            -
                        </span>
                        <label class="form-control">
                            <div class="flex items-center relative">
                                <input type="text" placeholder="Type here" class="input input-bordered text-sm h-9
                                    @error('maxPrice') input-error @enderror w-full"
                                    wire:model="maxPrice" />
                            </div>
                            @error('maxPrice')
                            <div class="label">
                                <span class="label-text-alt text-red-500">{{ $message }}</span>
                            </div>
                            @enderror
                        </label>
                        <button class="btn btn-primary !min-h-8 !h-8 w-8" wire:click="selectPrices">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full p-2">
        <div class="flex justify-between lg:justify-end items-center">
            <div class="drawer lg:hidden">
                <input id="my-drawer-filters" type="checkbox" class="drawer-toggle" />
                <div class="drawer-content">
                     <!-- Page content here -->
                    <label for="my-drawer-filters" class="btn btn-primary drawer-button">Фільтри</label>
                </div>
                <div class="drawer-side z-[100]">
                    <label for="my-drawer-filters" aria-label="close sidebar" class="drawer-overlay"></label>
                    <ul class="menu bg-white text-base-content min-h-full w-80 p-4">
                    <div class="min-w-[300px] max-w-[300px] w-[300px]">
                        <div>
                            <h2 class="text-2xl font-bold">Фільтри</h2>
                        
                            <div>
                                <button wire:click="clearFilters" class="btn btn-primary mt-2 w-full">
                                    Очистити фільтри
                                </button>
                            </div>

                            <div class="collapse collapse-arrow join-item border-base-300 border mt-3">
                                <input type="checkbox" name="my-accordion-1" checked/>
                                <div class="collapse-title text-base font-medium">Категорії</div>
                                <div class="collapse-content">
                                    <select class="select select-bordered w-full max-w-xs" wire:model.live="selectedCategory">
                                        <option value="null" selected>Всі</option>
                                        @foreach($this->categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        
                            @if(!empty($this->sizes))
                            <div class="collapse collapse-arrow join-item border-base-300 border mt-3">
                                <input type="checkbox" name="my-accordion-1" checked/>
                                <div class="collapse-title text-base font-medium">Розміри</div>
                                <div class="collapse-content">
                                    <div class="form-control max-h-[300px] overflow-y-scroll">
                                        @foreach($this->sizes as $size)
                                            <label class="label cursor-pointer">
                                                <span class="label-text">{{ $size->name }}</span>
                                                <input type="checkbox" class="checkbox" value="{{ $size->id }}" wire:model.live="selectedSizes"/>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                        
                            <div class="collapse collapse-arrow join-item border-base-300 border mt-3">
                                <input type="checkbox" name="my-accordion-3" checked/>
                                <div class="collapse-title text-base font-medium">Ціна</div>
                                <div class="collapse-content">
                                    <div class="flex justify-between items-top gap-4">
                                        <label class="form-control">
                                            <div class="flex items-center relative">
                                                <input type="text" placeholder="0" class="input input-bordered text-sm h-9
                                                    @error('minPrice') input-error @enderror w-full"
                                                    wire:model="minPrice" />
                                            </div>
                                            @error('minPrice')
                                            <div class="label">
                                                <span class="label-text-alt text-red-500">{{ $message }}</span>
                                            </div>
                                            @enderror
                                        </label>
                                        <span class="mt-1">
                                            -
                                        </span>
                                        <label class="form-control">
                                            <div class="flex items-center relative">
                                                <input type="text" placeholder="Type here" class="input input-bordered text-sm h-9
                                                    @error('maxPrice') input-error @enderror w-full"
                                                    wire:model="maxPrice" />
                                            </div>
                                            @error('maxPrice')
                                            <div class="label">
                                                <span class="label-text-alt text-red-500">{{ $message }}</span>
                                            </div>
                                            @enderror
                                        </label>
                                        <button class="btn btn-primary !min-h-8 !h-8 w-8" wire:click="selectPrices">OK</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </ul>
                </div>
            </div>

            <div>
                <select class="select select-bordered w-full max-w-xs" wire:model.live="selectedSort">
                    <option value="null" disabled selected>Вибрати сортування</option>
                        @foreach($this->sortingOptions as $option)
                            <option value="{{ $option->value }}">{{ $option->label() }}</option>
                        @endforeach
                </select>
            </div>
        </div>


        <div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 gap-y-6 mt-6">
                @foreach ($this->products as $index => $product)
                    @livewire('site.components.product-card', ['product' => $product, 'mainPhoto' => $product->mainPhoto, 'isSmall' => true], key($product->id))
                @endforeach
            </div>
            <div class="mt-12">
                {{ $this->products->links('vendor.livewire.tailwind') }}
            </div>
        </div>
    </div>
</div>
