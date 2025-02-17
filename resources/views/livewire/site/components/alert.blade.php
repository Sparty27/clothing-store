<div class="static">
    @if ($opened)
    <div class="fixed top-[40px] right-[25px] z-[100]" wire:poll.1s="update">
        @foreach ($alerts as $key => $alert)
        <div class="alert z-[100] flex justify-between @if ($alert['style'] ?? false) {{ " alert-{$alert['style']}" }} @endif shadow-lg mb-2 ">
            @if ($alert['icon'] ?? false)
                <i class="{{ $alert['icon'] }}"></i>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" stroke="#5A72A0" fill="none" viewBox="0 0 24 24" class="stroke-info shrink-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="#5A72A0"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            @endif
            <div class="w-full max-w-xs">
                <div class="flex gap-3 items-center justify-between">
                    <h3 class="font-bold">
                        {{ $alert['title'] ?? 'Повідомлення' }}
                    </h3>
    
                    <small class="text-end">
                        {{ $this->elapsedSeconds($alert['created']) }} секунд назад
                    </small>
                </div>
    
                <div class="text-xs break-words">
                    {{ $alert['text'] ?? '' }}
                </div>
    
            </div>
            <button class="btn btn-sm btn-ghost" wire:click="btnClick('{{ $key }}')">
                @if ($alert['url'] ?? false)
                    {{-- see --}}
                @else
                    <i class="ri-close-line"></i>
                @endif
            </button>
        </div>
        @endforeach
    </div>
    @endif
</div>