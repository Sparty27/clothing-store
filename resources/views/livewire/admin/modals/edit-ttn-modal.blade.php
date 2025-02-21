<form wire:submit="save" class="p-6">
    <div class="mt-2 flex justify-center">
        <button wire:click="$dispatch('closeModal')" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </div>
    <div class="flex flex-wrap justify-start gap-5">
        <div class="font-extrabold text-xl flex">
            Відредагувати ТТН
        </div>
    </div>
    <div class="mt-8 text-center text-lg flex gap-3">
        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">ТТН</span>
            </div>
            <input x-mask="99 9999 9999 9999" type="text" placeholder="{{ $placeholder ?? 'Type here' }}" wire:model="ttn" class="input input-bordered w-full text-lg @error($ttn) input-error @enderror" />
            @error($ttn)
            <div class="text-red-500 mt-1">
                {{ $message }}
            </div>
            @enderror
        </label>
    </div>
    <div class="flex gap-3 justify-center mt-6">
        <button type="submit" class="btn btn-sm bg-green-600 hover:bg-green-700 text-white">Зберегти</button>
        <button type="button" wire:click="$dispatch('closeModal')" class="btn btn-sm gap-1">
            <i class="ri-arrow-go-back-line"></i>
            Ні
        </button>
    </div>
</form>