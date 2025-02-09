@extends('admin.layouts.app')

@section('content')
    @component('admin.components.card', [
        'title' => 'Користувачі',
    ])
        @livewire('admin.users.users-table')
    @endcomponent
@endsection