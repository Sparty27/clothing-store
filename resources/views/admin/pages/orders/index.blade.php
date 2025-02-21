@extends('admin.layouts.app')

@section('content')
    @component('admin.components.card', [
        'title' => 'Замовлення',
    ])
        @livewire('admin.orders.orders-filter')
        @livewire('admin.orders.orders-table')
    @endcomponent
@endsection