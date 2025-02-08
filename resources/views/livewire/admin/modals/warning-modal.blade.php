<div class="p-6">
    <div>
        <button wire:click="$dispatch('closeModal')" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </div>
    <h3 class="text-lg font-bold mb-6">Ви дійсно хочете виконати цю дію?</h3>
    <div class="flex justify-end gap-2 mt-3">
        <button wire:click="$dispatch('closeModal')" class="btn btn-sm gap-1">
            <i class="ri-arrow-go-back-line"></i>
            Ні
        </button>
        <button wire:click="confirm" class="btn btn-sm btn-success gap-1">
            Так
        </button>
    </div>
</div>