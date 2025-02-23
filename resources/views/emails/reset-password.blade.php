@extends('emails.layout')

@section('title')
    Відновлення пароля
@endsection

@section('content')
<div>
    <div>
        Ваш код для відновлення пароля: <span class="font-bold">{{ $token }}</span>
    </div>
    
    <div class="mt-3">
        Якщо ви не запитували зміну пароля, просто ігноруйте це повідомлення.
    </div>
</div>
@endsection