@extends('back.layout.auth-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Login')
@section('content')
    <div class="login-box bg-white box-shadow border-radius-10">
        <div class="login-title">
            <h2 class="text-center text-dark">User Login</h2>
        </div>
        <form action="{{ route('consignor.login-handler') }}" method="POST">
            <x-form-alerts></x-form-alerts>
            @csrf
            <div class="input-group custom mb-1">
                <input type="text" class="form-control form-control-lg" placeholder="Username / Email" name="login_id"
                    value="{{ old('login_id') }}">
                <div class="input-group-append custom">
                    <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                </div>
            </div>
            @error('login_id')
                <span class="text-danger ml-1">{{ $message }}</span>
            @enderror
            <div class="input-group custom mb-1 mt-2">
                <input type="password" class="form-control form-control-lg" placeholder="**********" name="password">
                <div class="input-group-append custom">
                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                </div>
            </div>
            @error('password')
                <span class="text-danger ml-1">{{ $message }}</span>
            @enderror
            <div class="row pb-30">
                <div class="col-6">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1">Remember</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="forgot-password">
                        <a href="{{ route('consignor.forgot-password') }}">Forgot Password</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="input-group mb-0">
                        <input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
                    </div>
                </div>
            </div>

            <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373" style="color: rgb(112, 115, 115);">
                OR
            </div>

            <div class="input-group mb-0" style="margin-top: -15px;">
                <a href="{{ route('google-auth') }}" class="btn btn-dark btn-block my-3">
                    <i class="bi bi-google"></i> Sign in with Google
                </a>
            </div>

        </form>
    </div>
@endsection
