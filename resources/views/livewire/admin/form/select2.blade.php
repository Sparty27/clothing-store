{{-- <div wire:key="{{ $key }}">
    <div wire:ignore class="w-full h-full">
        <select style="width: 100%; height: 100%;" id="{{ $id }}" x-data="select2($el, $wire, @js($wireModel)" >
            @foreach ($options as $option)
                <option value="{{ $option->id }}" @if($wireModel == $option->id) selected @endif>{{ $option->name }}</option>
            @endforeach
        </select>
    </div>
</div> --}}

<div wire:key="{{ $key }}">
    <div wire:ignore class="w-full h-full">
        <select style="width: 100%; height: 100%" id="{{ $id }}" x-data="select2simple($el, $wire, @js($wireModel))" >
            @foreach ($options as $option)
                <option value="{{ $option->id }}" @if($modelValue == $option->id) selected @endif>{{ $option->name }}</option>
            @endforeach
        </select>
    </div>

    @error($wireModel)
        <div class="text-red-500 mt-1">
            {{ $message }}
        </div>
    @enderror
</div>
