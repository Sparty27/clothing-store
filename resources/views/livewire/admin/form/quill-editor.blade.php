<div class="form-control w-full ">
    <span class="">
        <span class="text-md text">{{ $name }}</span>
    </span>
    <div wire:ignore class="ql-rounded">
        <div id="{{ $id }}" x-data="quillEditor($el, $wire, @js($wireModel))" >
        </div>
    </div>

    @error($wireModel)
        <div class="text-red-500 mt-1">
            {{ $message }}
        </div>
    @enderror

</div>