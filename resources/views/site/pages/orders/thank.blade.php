@extends('site.layouts.app')

@section('content')
    <div class="min-h-[calc(100dvh-300px)] flex justify-center items-center">
        <div class="">
            <h2 class="font-bold text-2xl lg:text-[54px] dark:text-white">Дякуємо за замовлення!</h2>
            <div class="flex justify-center">
                <a class="mt-6 text-primary hover:underline hover:underline-offset-4" href="{{ route('index') }}">Повернутись на головну</a>
            </div>
        </div>
    </div>
@endsection