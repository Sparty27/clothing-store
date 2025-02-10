@extends('admin.layouts.app')

@section('content')
<div class="flex flex-col">
    <div class="flex justify-between items-center">
        <h1 class="text-xl font-bold text-black/75">Редагувати товар</h1>
        <div class="flex justify-between">
            <div class="">
                @include('admin.parts.back', ['route' => route('admin.products.index')])
            </div>
        </div>
    </div>

    @livewire('admin.products.product-form', ['product' => $product])
</div>
@endsection