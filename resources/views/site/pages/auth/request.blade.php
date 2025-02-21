@extends('site.layouts.app')

@section('content')

<div class="flex justify-center items-center min-h-[calc(100vh-150px)]">
    <div class="w-[450px] mx-auto shadow-xl rounded px-4 py-6 border-[1px] border-gray-100">
        <div class="card-header">
            <div class="font-bold text-xl">Відновлення пароля</div>
        </div>

        <div class="card-body pb-6">
            <form action="{{ route('password.request.post') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <label for="login" class="">{{ __('Email або телефон') }}</label>

                    <div class="col-md-6">
                        {{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus> --}}
                        <label class="input input-bordered flex items-center gap-2">
                            <i class="ri-user-line"></i>

                            <input name="login" id="email" type="text" class="grow" placeholder="Email або телефон" @error('login') is-invalid @enderror value="{{ old('login') }}" autocomplete="email" required autofocus/>
                        </label>

                        @error('login')
                            <span class="invalid-feedback text-sm text-red-500 font-medium" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn w-full bg-primary text-white border-primary hover:bg-[#516791] hover:border-[#516791]">
                            {{ __('Send Code') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection