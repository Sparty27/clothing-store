<div wire:poll.30s>
    @if($this->count > 0)
        <div class="rounded-full bg-green-600 px-1.5 text-xs font-semibold text-white min-w-5 h-5 flex justify-center items-center">
            {{ $this->count }}
        </div>
    @endif
</div>
