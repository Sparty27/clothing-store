@extends('site.layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-[calc(100vh-150px)]">
    <div class="w-[400px] mx-auto shadow-xl rounded px-4 py-6 border-[1px] border-gray-100">
        <div class="card-header">
            <div class="font-bold text-xl">{{ __('Register') }}</div>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row mb-3">
                    <label for="name" class="">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <label class="input input-bordered flex items-center gap-2">
                            <i class="ri-user-line"></i>

                            <input id="name" type="text" placeholder="Name" class="grow @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        </label>

                        @error('name')
                            <span class="" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="">{{ __('Email Address') }}</label>

                    <div class="col-md-6">
                        {{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus> --}}
                        <label class="input input-bordered flex items-center gap-2">
                            <i class="ri-mail-line"></i>

                            <input name="email" id="email" type="email" class="grow" placeholder="Email" @error('email') is-invalid @enderror value="{{ old('email') }}" required autocomplete="email" autofocus/>
                        </label>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        {{-- <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"> --}}
                        <label class="input input-bordered flex items-center gap-2">
                            <i class="ri-lock-line"></i>

                            <input name="password" id="password" type="password" class="grow" placeholder="Password" @error('passsword') is-invalid @enderror required autocomplete="new-password"/>
                        </label>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        {{-- <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"> --}}
                        <label class="input input-bordered flex items-center gap-2">
                            <i class="ri-lock-line"></i>

                            <input name="password_confirmation" id="password-confirm" type="password" class="grow" placeholder="Confirm password" @error('passsword_confirmation') is-invalid @enderror required autocomplete="new-password"/>
                        </label>

                        @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0 mt-6">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn w-full bg-primary text-white border-primary hover:bg-[#516791] hover:border-[#516791]">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-center w-full mt-6">
                    <div class="flex items-center w-full">
                        <div class="flex-1 border-t border-black"></div>
                        <span class="px-4 text-center">або</span>
                        <div class="flex-1 border-t border-black"></div>
                    </div>
                </div>

                <div class="flex justify-center mt-3">
                    <a href="{{ route('login') }}" class="text-primary text-sm hover:underline underline-offset-2">Увійти</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
