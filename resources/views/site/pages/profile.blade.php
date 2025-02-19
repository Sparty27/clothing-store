@extends('site.layouts.profile')

@section('breadcrumbs')
    {{ Breadcrumbs::render('profile') }}
@endsection

@section('content')
    <div class="">
        <div class="text-2xl md:text-[36px] font-bold flex justify-center">
            Профіль
        </div>
        <div class="mt-6 rounded-2xl border-gray-100 border-[1px] p-5 shadow-lg">
            <span class="font-bold text-lg">
                Дані користувача
            </span>
            <ul class="">
                <li class="mt-2">
                    Імʼя: <span class="font-bold text-primary">{{ $data['name'] }}</span>
                </li>
                <li class="mt-2">
                    Прізвище: <span class="font-bold text-primary">{{ $data['last_name'] }}</span>
                </li>
                <li class="mt-2">
                    Пошта: <span class="font-bold text-primary">{{ $data['email'] }}</span>
                </li>
                <li class="mt-2">
                    Телефон: <span class="font-bold text-primary">{{ $data['phone'] }}</span>
                </li>
                <li class="mt-2">
                    Дата реєстрації: <span class="font-bold text-primary">{{ $data['created_at'] }}</span>
                </li>
                <li class="mt-2">
                    Всього замовлень: <span class="font-bold text-primary">{{ $data['orders_count'] }}</span>
                </li>
            </ul>
        </div>
    </div>
@endsection