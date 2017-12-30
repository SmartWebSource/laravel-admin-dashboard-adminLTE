@extends('layouts.public-master')

@section('page-title') Register @endsection

@section('content')

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>{{$appName}}</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Register</p>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>
                @if ($errors->has('name'))
                    <span class="validation-error">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="form-group has-feedback {{ $errors->has('username') ? ' has-error' : '' }}">
                <input id="username" type="text" class="form-control" maxlength="16" name="username" value="{{ old('username') }}" placeholder="Username" required>
                <span class="fa fa-user form-control-feedback"></span>
                @if ($errors->has('username'))
                    <span class="validation-error">{{ $errors->first('username') }}</span>
                @endif
            </div>

            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                <input id="email" type="email" class="form-control" maxlength="50" name="email" value="{{ old('email') }}" placeholder="Email" required>
                <span class="fa fa-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="validation-error">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group has-feedback {{ $errors->has('phone') ? ' has-error' : '' }}">
                <input id="phone" type="number" class="form-control"  maxlength="13" name="phone" value="{{ old('phone') }}" placeholder="Phone" required autofocus>
                <span class="fa fa-phone form-control-feedback"></span>
                @if ($errors->has('phone'))
                    <span class="validation-error">{{ $errors->first('phone') }}</span>
                @endif
            </div>

            <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                <span class="fa fa-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                    <span class="validation-error">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <input id="password" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                <span class="fa fa-lock form-control-feedback"></span>
                @if ($errors->has('password_confirmation'))
                    <span class="validation-error">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>

            <div class="form-group tg-inputwithicon">
                <div class="g-recaptcha" data-sitekey="{!! env('RECAPTCHA_KEY') !!}"></div>
                <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl={!! env('RECAPTCHA_LANGUAGE') !!}"></script>
                @if ($errors->has('g-recaptcha-response'))
                    <small class="validation-error">{{ $errors->first('g-recaptcha-response') }}</small>
                @endif
            </div>

            <div class="social-auth-links text-center">
                <button type="submit" class="btn btn-block btn-primary">Register</button>
            </div>
        </form>
        <a href="{{url('login')}}">back to login</a>
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
@endsection
