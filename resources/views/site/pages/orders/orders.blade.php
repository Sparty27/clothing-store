@extends('site.layouts.profile')

@section('breadcrumbs')
    {{ Breadcrumbs::render('profile.orders') }}
@endsection

@section('content')

<section>
    @livewire('site.my-orders')
</section>

@endsection
