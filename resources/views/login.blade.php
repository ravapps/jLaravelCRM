@extends('layouts.auth')
@section('content')

<div class="auth-fluid" style="background-image: url({{ asset('uploads/site/bg-auth.jpg')}});">
    <!--Auth fluid left content -->
    <div class="auth-fluid-form-box">
        <div>
            <div class="card-body">
                <!-- Logo -->
                <div class="auth-brand text-center">
                    <div class="auth-logo">
                        <a href="{{ url('/') }}" class="logo auth-logo-dark">
                            <span class="logo-lg">
                              <img src="{{ asset('uploads/site/'.Settings::get('site_logo')) }}"         alt="{{ Settings::get('site_name') }}" class="site_logo" height="70">
                            </span>
                        </a>
                    </div>
                </div>

                <!-- title-->
                <div class="text-center">
                    <h4 class="mt-0">{{trans('auth.sign_account')}}</h4>
                    <p class="text-muted mb-2">Enter your email address and password to access account.</p>
                </div>
                @include('flash::message')
                <!-- form -->
                {!! Form::open(['url' => url('signin'), 'method' => 'post', 'name' => 'form']) !!}
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    {!! Form::label(trans('auth.email')) !!} :
                    <span>{{ $errors->first('email', ':message') }}</span>
                    {!! Form::email('email', null, ['class' => 'form-control', 'required'=>'required', 'placeholder'=>'E-mail','autofocus'=>true ]) !!}
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    {!! Form::label(trans('auth.password')) !!} :
                    <div class="float-right">
                      <a href="{{url('forgot')}}" class="btn btn-link text-small">{{trans('auth.forgot')}}?</a>
                    </div>
                    <span>{{ $errors->first('password', ':message') }}</span>
                    {!! Form::password('password', ['class' => 'form-control', 'required'=>'required', 'placeholder'=>'Password']) !!}
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" id="remember" value="remember" name="remember">
                        <i class="primary"></i> {{trans('auth.keep_login')}}
                    </label>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-success btn-block" value="{{trans('auth.login')}}"></input>
                </div>
              {!! Form::close() !!}
                <!-- end form-->

                <!-- Footer-->
                <footer class="footer footer-alt">
                    <p class="text-muted">Copyright Vital Shield 2021</p>
                </footer>

            </div> <!-- end .card-body -->
        </div>
    </div>
    <!-- end auth-fluid-form-box-->
</div>

@stop
