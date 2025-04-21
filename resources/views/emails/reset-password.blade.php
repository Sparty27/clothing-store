@extends('emails.layout')

@section('title')
    Відновлення пароля
@endsection

@section('content')
<div>
    <div>
        Ваш код для відновлення пароля: <b>{{ $token }}</b>
    </div>
    
    <div style="margin-top: 0.75rem">
        Якщо ви не запитували зміну пароля, просто ігноруйте це повідомлення.
    </div>
</div>
@endsection