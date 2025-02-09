<div class="p-6">
    <div>
        <button wire:click="$dispatch('closeModal')" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </div>
    <h3 class="text-lg font-bold">{{ $subject }}</h3>
    <p class="py-4">{{ $text }}</p>
    <div class="flex justify-end gap-2 mt-3">
        <button wire:click="$dispatch('closeModal')" class="btn btn-sm gap-1">
            <i class="ri-arrow-go-back-line"></i>
            Назад
        </button>
        <button wire:click="delete" class="btn btn-sm btn-error gap-1">
            <i class="ri-delete-bin-line"></i>
            Видалити
        </button>
    </div>
</div>