<label class="form-control w-full max-w-xs">
    <div class="label p-0 mb-0.5">
        <span class="label-text">{{ $name }}</span>
    </div>
    <select @if(isset($live) && $live === true) wire:model.live={{ $model }} @else wire:model={{ $model }} @endif class="select max-sm:select-sm select-bordered @error($model) select-error @enderror @if(isset($class)) {{ $class }} @endif">
        <option value="all" @if($disabled ?? false) disabled @endif selected>{{ $placeholder }}</option>
        @foreach ($options as $option)
            <option value="{{ $option->value }}">{{ $option->label() }}</option>
        @endforeach
    </select>
    @error($model)
    <div class="text-red-500 mt-1">
        {{ $message }}
    </div>
    @enderror
</label>