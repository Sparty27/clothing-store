<div class="p-4 mb-5 mt-5 shadow-lg border-[1px] border-gray-200 rounded-lg gap-2 flex flex-col items-start w-full">

    <div class="flex justify-between items-center w-full">
        <h3 class="text-md font-bold text-black">{{ $title }}</h3>

        <div class="flex justify-between">
            {!! $headerActions ?? '' !!}
        </div>
    </div>

    {!! $slot !!}
</div>