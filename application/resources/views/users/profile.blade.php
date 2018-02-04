@extends('layouts.master')

@section('page-title') My Profile @endsection

@section('page-header') My Profile @endsection


@section('content')
<div class="row">
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="{{getProfilePhoto()}}" alt="User profile picture">

                <h3 class="profile-username text-center">{{$user->name}}</h3>

                <p class="text-muted text-center hide">Software Engineer</p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Last Login</b> <a class="pull-right">{{Carbon::parse($user->last_login)->format('d M, Y @ h:i:s A')}}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Last Login IP</b> <a class="pull-right">{{$user->last_login_ip}}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Member since</b> <a class="pull-right">{{$user->created_at->format('m. Y')}}</a>
                    </li>
                </ul>

                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header"></div>
            <div class="box-body">
                {!! Form::model($user, ['url'=>'profile', 'class'=>'form-horizontal']) !!}
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" value="{{old('name', $user->name)}}" placeholder="Name">
                        @if ($errors->has('name'))
                        <span class="validation-error">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">Username</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{old('username', $user->username)}}" readonly="readonly">
                    </div>
                </div>

                <div class="form-group">
                    <label for="Email" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                        <input type="email" class="form-control" value="{{old('email', $user->email)}}" readonly="readonly">
                    </div>
                </div>

                <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                    <label for="phone" class="col-sm-2 control-label">Phone</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="phone" value="{{old('phone', $user->phone)}}" maxlength="13">
                        @if ($errors->has('phone'))
                        <span class="validation-error">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                </div>

                <hr>

                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-sm-2 control-label">Password</label>

                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        @if ($errors->has('password'))
                        <span class="validation-error">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label for="password_confirmation" class="col-sm-2 control-label">Confirm Password</label>

                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                        @if ($errors->has('password_confirmation'))
                        <span class="validation-error">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-danger">Update</button>
                        <small><i class='fa fa-info-circle'></i> If you do not want to update your password, leave password fields blank.</small>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <!-- /.col -->
</div>
@endsection
