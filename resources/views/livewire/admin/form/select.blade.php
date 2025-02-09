<label class="form-control w-full max-w-xs">
    <div class="label">
        <span class="label-text">{{ $name }}</span>
    </div>
    <select wire:model="{{ $model }}" class="select select-sm select-bordered @error($model) select-error @enderror" @isset($disabled) disabled @endisset>
        <option value="null" @isset($disabledOption) disabled @endisset selected>{{ $placeholder }}</option>
        @foreach ($options as $option)
            <option value="{{ $option->$value }}">{{ $option->$optionName }}</option>
        @endforeach
    </select>
    @error($model)
    <div class="text-red-500 mt-1">
        {{ $message }}
    </div>
    @enderror
</label>