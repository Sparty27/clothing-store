@extends('admin.layouts.app')

@section('content')
    @component('admin.components.card', [
        'title' => 'Створити категорію',
    ])
        @slot('headerActions')
            @include('admin.parts.back', ['route' => route('admin.categories.index')])
        @endslot

        @livewire('admin.categories.category-form', ['category' => null])
    @endcomponent
@endsection