@extends('admin.layouts.app')

@section('content')
    @component('admin.components.card', [
        'title' => 'Контакти',
    ])
        @livewire('admin.contacts.contacts-table')
    @endcomponent
@endsection