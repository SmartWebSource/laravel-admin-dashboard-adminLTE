@extends('layouts.public-master')

@section('page-title') Get Password Reset Link @endsection

@section('content')

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>{{$appName}}</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Get Password Reset Link</p>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}
            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="validation-error">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="social-auth-links text-center">
                <button type="submit" class="btn btn-block btn-primary">Send Password Reset Link</button>
            </div>
        </form>
        <a href="{{url('login')}}">back to login</a>
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
@endsection
