@extends('admin.layouts.app')

@section('content')
    @component('admin.components.card', [
        'title' => 'Редагувати користувача',
    ])
        @slot('headerActions')
            @include('admin.parts.back', ['route' => route('admin.users.index')])
        @endslot
        
        @livewire('admin.users.user-form', ['user' => $user])
    @endcomponent
@endsection