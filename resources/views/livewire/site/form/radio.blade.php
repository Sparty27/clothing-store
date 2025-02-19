<div class="form-control w-full">
    @if ($name ?? null)
        <label for="{{ $model }}" class="">
            @isset($icon)
                <i class="{{ $icon }}"></i>
            @endisset
            <span class="text-md text">{{ $name }}</span>
        </label>
    @endif

    @isset ($slot)
        {!! $slot !!}
    @else
        <div class="flex gap-9 {{ $listClass ?? '' }}">
            @foreach($cases as $case)
                <label class="flex gap-2 cursor-pointer" for="{{ $case->value }}">
                    <input class="radio radio-primary" id="{{ $case->value }}" wire:model.live="{{ $model }}" type="radio" value="{{ $case->value }}">
                    {{ $case->label() }}
                </label>
            @endforeach
        </div>
    @endisset
    
    @error($model)
    <div class="text-red-500 mt-1">
        {{ $message }}
    </div>
    @enderror
</div>