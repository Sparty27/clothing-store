<div class="form-control w-full">
    @if ($name ?? null)
        <label for="{{ $model }}" class="">
            <span class="text-md text">{{ $name }}</span>
        </label>
    @endif

    @isset ($slot)
        {!! $slot !!}
    @else
        <input @isset($id) id="{{ $id }}" @endisset type="{{ $type ?? 'text' }}" placeholder="{{ $placeholder ?? 'Type here' }}" wire:model="{{ $model }}" name="{{ $model }}" class="input {{ $size ?? 'input-sm' }} input-bordered w-full @error($model) input-error @enderror" />
    @endisset
    
    @error($model)
    <div class="text-red-500 mt-1">
        {{ $message }}
    </div>
    @enderror
</div>