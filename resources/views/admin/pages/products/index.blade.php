@extends('admin.layouts.app')

@section('content')
    @component('admin.components.card', [
        'title' => 'Товари',
    ])
        @slot('headerActions')
            <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">Створити</a>
        @endslot

        @livewire('admin.products.products-table')
    @endcomponent
@endsection