@extends('site.layouts.app')

@section('content')

<div class="flex justify-center items-center min-h-[calc(100vh-150px)]">
    <div class="w-[450px] mx-auto shadow-xl rounded px-4 py-6 border-[1px] border-gray-100">
        <div class="card-header">
            <div class="font-bold text-xl dark:text-white">Створіть новий пароль</div>
        </div>

        <div class="card-body pb-6">
            <form action="{{ route('password.reset.post') }}" method="POST">
                @csrf

                <input type="hidden" name="login" value="{{ old('login', session('login')) }}">

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end dark:text-white">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        {{-- <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"> --}}
                        <label class="input input-bordered flex items-center gap-2">
                            <i class="ri-lock-line"></i>

                            <input name="password" id="password" type="password" class="grow" placeholder="Пароль" @error('passsword') is-invalid @enderror required autocomplete="new-password"/>
                        </label>

                        @error('password')
                            <span class="invalid-feedback text-sm text-red-500 font-medium" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end dark:text-white">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        {{-- <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"> --}}
                        <label class="input input-bordered flex items-center gap-2">
                            <i class="ri-lock-line"></i>

                            <input name="password_confirmation" id="password-confirm" type="password" class="grow" placeholder="Підтвердити пароль" @error('passsword_confirmation') is-invalid @enderror required autocomplete="new-password"/>
                        </label>

                        @error('password_confirmation')
                            <span class="invalid-feedback text-sm text-red-500 font-medium" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn w-full bg-primary text-white border-primary hover:bg-[#516791] hover:border-[#516791]">
                            {{ __('Створити') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection