@extends('admin.layouts.app')

@section('content')
    @component('admin.components.card', [
        'title' => 'Редагувати категорію',
        'back' => route('admin.categories.index')
    ])
        @slot('headerActions')
            @include('admin.parts.back', ['route' => route('admin.categories.index')])
        @endslot

        @livewire('admin.categories.category-form', ['category' => $category])
    @endcomponent
@endsection