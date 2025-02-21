@extends('admin.layouts.app')

@section('content')
<div class="shadow-xl flex flex-col p-6 rounded-xl">
    <div class="flex justify-between items-center">
        <h1 class="text-xl font-bold text-black/75">Редагувати замовлення {{ $order->id }}</h1>
        <div class="flex justify-between">
            <div class="">
                @include('admin.parts.back', ['route' => route('admin.orders.index')])
            </div>
        </div>
    </div>
    @livewire('admin.orders.order-form', ['order' => $order])
</div>
@endsection