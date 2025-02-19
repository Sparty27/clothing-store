@extends('site.layouts.profile')

@section('breadcrumbs')
    {{ Breadcrumbs::render('profile.settings') }}
@endsection

@section('content')

<section>
    @livewire('site.settings')
</section>

@endsection
