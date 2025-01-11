@extends('back.layout.auth-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Forgot password')
@section('content')
    <div class="login-box bg-white box-shadow border-radius-10">
        <div class="login-title">
            <h2 class="text-center text-dark">Forgot Password</h2>
        </div>
        <h6 class="mb-20">
            Enter your email address to reset your password
        </h6>
        <form action="{{ route('admin.send-reset-password-link') }}" method="post">
            <x-form-alerts></x-form-alerts>
            @csrf
            <div class="input-group custom mb-2">
                <input type="text" class="form-control form-control-lg" name="email" value="{{ old('email') }}"
                    placeholder="Email">
                <div class="input-group-append custom">
                    <span class="input-group-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                </div>
            </div>
            @error('email')
                <span class="text-danger ml-1 mb-2">{{ $message }}</span>
            @enderror
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="input-group mb-0">

                        <input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">

                        {{-- <a class="btn btn-primary btn-lg btn-block" href="index.html">Submit</a> --}}
                    </div>
                </div>
                <div class="col-2">
                    <div class="font-16 weight-600 text-center" data-color="#707373" style="color: rgb(112, 115, 115);">
                        OR
                    </div>
                </div>
                <div class="col-5">
                    <div class="input-group mb-0">
                        <a class="btn btn-outline-primary btn-lg btn-block" href="{{ route('admin.login') }}">Login</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
