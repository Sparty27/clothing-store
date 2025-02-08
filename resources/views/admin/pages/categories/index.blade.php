@extends('admin.layouts.app')

@section('content')
    @component('admin.components.card', [
        'title' => 'Категорії'
    ])
        @livewire('admin.categories.categories-table')
    @endcomponent
@endsection