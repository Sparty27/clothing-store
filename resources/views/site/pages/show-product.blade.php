@extends('site.layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('product', $product) }}
@endsection

@section('content')
    @livewire('site.show-product', compact('product'))
@endsection