@extends('site.layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('category', $category) }}
@endsection

@section('content')
    @livewire('site.catalog', ['category' => $category])
@endsection