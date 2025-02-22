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
        <input @isset($id) id="{{ $id }}" @endisset type="{{ $type ?? 'text' }}" placeholder="{{ $placeholder ?? 'Type here' }}" 
            @isset($isLive) wire:model.live="{{ $model }}" @else wire:model="{{ $model }}" @endisset
            @isset($autocomplete) autocomplete="{{ $autocomplete }}" @endisset
            name="{{ $model }}" class="input dark:text-black {{ $size ?? 'input-sm' }} input-bordered w-full outline-none hover:outline-none focus:outline-none {{ $class ?? '' }} @error($model) input-error @enderror" />
    @endisset
    
    @error($model)
    <div class="text-red-500 mt-1">
        {{ $message }}
    </div>
    @enderror
</div>