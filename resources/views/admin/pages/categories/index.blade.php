@extends('admin.layouts.app')

@section('content')
    @component('admin.components.card', [
        'title' => 'Категорії',
    ])
        @slot('headerActions')
            <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">Створити</a>
        @endslot

        @livewire('admin.categories.categories-table')
    @endcomponent
@endsection