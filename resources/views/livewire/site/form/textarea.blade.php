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
        <textarea @isset($id) id="{{ $id }}" @endisset name="{{ $model }}" class="textarea textarea-bordered dark:text-black {{ $class ?? '' }} @error($model) textarea-error @enderror" placeholder="{{ $placeholder ?? 'Type here' }}" 
            @isset($isLive) wire:model.live="{{ $model }}" @else wire:model="{{ $model }}" @endisset></textarea>
    @endisset
    
    @error($model)
    <div class="text-red-500 mt-1">
        {{ $message }}
    </div>
    @enderror
</div>