<div class="w-full">
    <div class="flex flex-col sm:flex-row justify-between gap-6 sm:flex-wrap">
        <div role="tablist" class="tabs tabs-boxed text-xs w-min {{-- flex flex-col [&>a]:w-full sm:grid sm:[&>a]:w-max --}} h-fit overflow-x-auto max-w-full sm:hide-scrollbar">
            <a wire:click="updateTab('all')" role="tab" class="tab text-xs @if($this->form->orderStatus == 'all') tab-active @endif">Всі</a>
            @foreach ($this->tabs as $tab)
                <a wire:click="updateTab('{{ $tab->value }}')" role="tab" class="tab text-xs @if($this->form->orderStatus == $tab->value) tab-active @endif">{{ $tab->label() }}</a>
            @endforeach
        </div>

        <div class="flex gap-2 items-center {{-- flex-col w-full md:flex-row md:w-min --}}">
            <input wire:model.live="form.startDate" type="date" class="input input-bordered w-full">
            <hr class="w-[25px] border-gray-300 border-[1px] rounded-lg hidden sm:flex">
            <input wire:model.live="form.endDate" type="date" class="input input-bordered w-full">
        </div>
    </div>

    <div class="flex justify-between items-end mt-8 gap-2 flex-col xl:flex-row">
        <div class="gap-2 grid grid-cols-2 w-full md:grid-cols-4">
            <div>
                @include('livewire.admin.form.select-enum', [
                    'name' => 'Метод оплати',
                    'model' => 'form.paymentMethod',
                    'options' => $this->paymentMethods,
                    'placeholder' => 'Всі',
                    'disabled' => false,
                    'live' => true,
                ])
            </div>
            <div>
                @include('livewire.admin.form.select-enum', [
                    'name' => 'Метод доставки',
                    'model' => 'form.deliveryMethod',
                    'options' => $this->deliveryMethods,
                    'placeholder' => 'Всі',
                    'disabled' => false,
                    'live' => true,
                ])
            </div>
            <div>
                @include('livewire.admin.form.select-enum', [
                    'name' => 'Статус оплати',
                    'model' => 'form.paymentStatus',
                    'options' => $this->paymentStatuses,
                    'placeholder' => 'Всі',
                    'disabled' => false,
                    'live' => true,
                ])
            </div>
            <div>
                @include('livewire.admin.form.select-enum', [
                    'name' => 'Статус доставки',
                    'model' => 'form.deliveryStatus',
                    'options' => $this->deliveryStatuses,
                    'placeholder' => 'Всі',
                    'disabled' => false,
                    'live' => true,
                ])
            </div>
        </div>

        <div class="mt-2 w-full xl:max-w-[320px] flex items-center gap-2">
            <label class="input input-bordered flex items-center gap-2 w-full">
                <i class="ri-search-line"></i>
                <input wire:model.live.debounce.200ms="form.searchText" class="w-full" type="text" class="grow" placeholder="Пошук клієнта" />
            </label>

            <button wire:click="resetFilter" class="btn btn-sm btn-primary px-1 min-w-[40px] min-h-[40px]" aria-label="Reset filter">
                <i class="ri-reset-left-line ri-lg"></i>
            </button>
        </div>
    </div>
</div>
