{{-- <div wire:key="{{ $key }}">
    <div wire:ignore class="w-full h-full">
        <select style="width: 100%; height: 100%;" id="{{ $id }}" x-data="select2($el, $wire, @js($wireModel)" >
            @foreach ($options as $option)
                <option value="{{ $option->id }}" @if($wireModel == $option->id) selected @endif>{{ $option->name }}</option>
            @endforeach
        </select>
    </div>
</div> --}}

{{-- <div wire:key="{{ $key }}">
    <div wire:ignore class="w-full h-full">
        <select style="width: 100%; height: 100%" id="{{ $id }}" x-data="select2($el, $wire, @js($wireModel))" >
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
</div> --}}

<div class="form__control">
    <label for="{{ $id ?? 'select2-'.$wireModel }}">
        @isset($icon)
            <span x-data="icons()">
                <i data-lucide="{{ $icon }}"></i>
            </span>
        @endisset
        {{ $title ?? '' }}
    </label>

    <div wire:key="{{ $key }}">
        <div wire:ignore class="">
            <select style="width: 100%; height: 100%" id="{{ $key }}" x-data="select2($el, $wire, @js($wireModel), @js($url), @js($passedData))">
                @isset($options)
                    <option value="null" @isset($disableEmptyOption) disabled @endisset selected>{{ $placeholder ?? '' }}</option>
                    @foreach ($options as $option)
                        <option value="{{ $option->id }}" @if($modelValue == $option->id) selected @endif>{{ $option->name }}</option>
                    @endforeach
                @endisset
            </select>
        </div>

        @error($wireModel)
            <span class="text-red-500">Помилка: {{ $message }}</span>
        @enderror
    </div>
</div>
