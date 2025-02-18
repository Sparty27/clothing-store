@extends('site.layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('checkout') }}
@endsection


@section('content')
    @livewire('site.checkout')
@endsection