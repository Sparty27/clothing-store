@extends('admin.layouts.app')

@section('content')
    @component('admin.components.card', [
        'title' => 'Категорії',
        'create' => route('admin.categories.create'),
    ])
        @slot('headerActions')
            <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">Створити</a>
        @endslot

        @livewire('admin.categories.categories-table')
    @endcomponent
@endsection