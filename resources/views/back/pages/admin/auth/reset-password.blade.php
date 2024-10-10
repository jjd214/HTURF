@extends('back.layout.auth-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Reset password')
@section('content')
<div class="login-box bg-white box-shadow border-radius-10">
    <div class="login-title">
        <h2 class="text-center text-primary">Reset Password</h2>
    </div>
    <h6 class="mb-20">Enter your new password, confirm and submit</h6>
    <x-form-alerts></x-form-alerts>
    <form action="{{ route('admin.reset-password-handler',['token' => request()->token]) }}" method="post">
        @csrf
        <div class="input-group custom">
            <input type="text" class="form-control form-control-lg" name="new_password" value="{{ old('new_password') }}" placeholder="New Password">
            <div class="input-group-append custom">
                <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
            </div>
        </div>
        @error('new_password')
            <span class="text-danger ml-1">{{ $message }}</span>
        @enderror
        <div class="input-group custom">
            <input type="text" class="form-control form-control-lg" name="new_password_confirmation" value="{{ old('new_password_confirmation') }}" placeholder="Confirm New Password">
            <div class="input-group-append custom">
                <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
            </div>
        </div>
        @error('new_password_confirmation')
            <span class="text-danger ml-1">{{ $message }}</span>
        @enderror
        <div class="row align-items-center">
            <div class="col-5">
                <div class="input-group mb-0">

                    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">

                    {{-- <a class="btn btn-primary btn-lg btn-block" href="index.html">Submit</a> --}}
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
