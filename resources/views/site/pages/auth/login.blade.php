@extends('site.layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-[calc(100vh-150px)]">
    <div class="w-[350px] mx-auto shadow-xl rounded px-4 py-6 border-[1px] border-gray-100 dark:bg-[#282828] dark:border-[#575757]">
        <div class="card-header">
            <div class="font-bold text-x dark:text-white">{{ __('Login') }}</div>
        </div>

        <div class="card-body pb-6">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="row mb-3">
                    <label for="login" class="dark:text-white">{{ __('Email або телефон') }}</label>

                    <div class="col-md-6">
                        {{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus> --}}
                        <label class="input input-bordered flex items-center gap-2">
                            <i class="ri-user-line"></i>

                            <input name="login" id="login" type="text" class="grow" placeholder="Email або телефон" @error('login') is-invalid @enderror value="{{ old('login') }}" autocomplete="email" required autofocus/>
                        </label>

                        @error('login')
                            <span class="invalid-feedback text-sm text-red-500 font-medium" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end dark:text-white">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        {{-- <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"> --}}
                        <label class="input input-bordered flex items-center gap-2">
                            <i class="ri-lock-line"></i>

                            <input name="password" id="password" type="password" class="grow" placeholder="Пароль" @error('passsword') is-invalid @enderror required autocomplete="current-password"/>
                        </label>

                        @error('password')
                            <span class="invalid-feedback text-sm text-red-500 font-medium" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label dark:text-white" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn w-full bg-primary text-white border-primary hover:bg-[#516791] hover:border-[#516791]">
                            {{ __('Login') }}
                        </button>

                        <a class="btn btn-link no-underline hover:underline p-0" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    </div>
                </div>

                <div class="flex items-center justify-center w-full mt-3">
                    <div class="flex items-center w-full">
                        <div class="flex-1 border-t border-black dark:border-white"></div>
                        <span class="px-4 text-center dark:text-white">або</span>
                        <div class="flex-1 border-t border-black dark:border-white"></div>
                    </div>
                </div>

                <div class="flex justify-center mt-3">
                    <a href="{{ route('register') }}" class="text-primary text-sm hover:underline underline-offset-2">Зареєструватись</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
