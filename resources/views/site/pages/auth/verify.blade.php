@extends('site.layouts.app')

@section('content')

<div class="flex justify-center items-center min-h-[calc(100vh-150px)]">
    <div class="w-[450px] mx-auto shadow-xl rounded px-4 py-6 border-[1px] border-gray-100">
        <div class="card-header">
            <div class="font-bold text-xl">Введіть код</div>
        </div>

        <div class="card-body pb-6">
            <form action="{{ route('password.verify.post') }}" method="POST">
                @csrf

                <input type="hidden" name="login" value="{{ old('login', session('login')) }}">

                <div class="row mb-3">
                    <label for="token" class="">{{ __('Код') }}</label>

                    <div class="col-md-6">
                        <label class="input input-bordered flex items-center gap-2">
                            <i class="ri-lock-2-line"></i>

                            <input value="{{ old('token') }}" id="token" required name="token" class="grow" type="text" placeholder="Введіть код">
                        </label>

                        @error('token')
                            <span class="invalid-feedback text-sm text-red-500 font-medium" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn w-full bg-primary text-white border-primary hover:bg-[#516791] hover:border-[#516791]">
                            {{ __('Підтвердити') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection