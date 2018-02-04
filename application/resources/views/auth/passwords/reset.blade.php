@extends('layouts.public-master')

@section('page-title') Reset Password @endsection

@section('content')

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>{{$appName}}</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Reset Password</p>

        <form method="POST" action="{{ route('password.request') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="Email" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="validation-error">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                    <span class="validation-error">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <input id="password" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password_confirmation'))
                    <span class="validation-error">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>
            <div class="social-auth-links text-center">
                <button type="submit" class="btn btn-block btn-primary">Reset Password</button>
            </div>
        </form>
        <a href="{{url('login')}}">back to login</a>
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
@endsection
