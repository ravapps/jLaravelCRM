@extends('layouts.install')
@section('content')
    @include('install.steps', ['steps' => [
        'welcome' => 'selected done',
        'requirements' => 'selected done',
        'permissions' => 'selected done',
        'database' => 'selected done',
        'disable' => 'selected done',
        'settings' => 'selected done',
        'mail_settings' => 'selected ',
    ]])
    @include('layouts.messages')
    {!! Form::open(['url' => 'install/email_settings']) !!}
    <div class="step-content">
        <div class="blade-fileh">
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="header_bottom">{{trans('install.mail_settings')}}</h3>
                    <div class="form-group required {{ $errors->has('email_driver') ? 'has-error' : '' }}">
                        {!! Form::label('email_driver', trans('settings.email_driver'), ['class' => 'control-label']) !!}
                        <div class="controls">
                            <div class="form-inline">
                                <div class="radio">
                                    {!! Form::radio('email_driver', 'smtp', false, ['id'=>'smtp', 'class'=>'email_driver icheck'])  !!}
                                    {!! Form::label('smtp', 'SMTP') !!}
                                </div>
                                <div class="radio">
                                    {!! Form::radio('email_driver', 'ses', false,['id'=>'ses','class' => 'email_driver icheck'])  !!}
                                    {!! Form::label('false', 'SES') !!}
                                </div>
                                <div class="radio">
                                    {!! Form::radio('email_driver', 'mailgun', false,['id'=>'mailgun','class' => 'email_driver icheck'])  !!}
                                    {!! Form::label('false', 'Mailgun') !!}
                                </div>
                            </div>
                            <span class="help-block">{{ $errors->first('email_driver', ':message') }}</span>
                        </div>
                    </div>
                    <div class="smtp">
                        <div class="form-group required {{ $errors->has('email_host') ? 'has-error' : '' }}">
                            {!! Form::label('email_host', trans('settings.email_host'), ['class' => 'control-label']) !!}
                            <div class="controls">
                                {!! Form::input('text','email_host', old('email_host'), ['class' => 'form-control']) !!}
                                <span class="help-block">{{ $errors->first('email_host', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('email_port') ? 'has-error' : '' }}">
                            {!! Form::label('email_port', trans('settings.email_port'), ['class' => 'control-label']) !!}
                            <div class="controls">
                                {!! Form::input('text','email_port', old('email_port'), ['class' => 'form-control']) !!}
                                <span class="help-block">{{ $errors->first('email_port', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('email_username') ? 'has-error' : '' }}">
                            {!! Form::label('email_username', trans('settings.email_username'), ['class' => 'control-label']) !!}
                            <div class="controls">
                                {!! Form::input('text','email_username', old('email_username'), ['class' => 'form-control']) !!}
                                <span class="help-block">{{ $errors->first('email_username', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('email_password') ? 'has-error' : '' }}">
                            {!! Form::label('email_password', trans('settings.email_password'), ['class' => 'control-label']) !!}
                            <div class="controls">
                                {!! Form::input('text','email_password', old('email_password'), ['class' => 'form-control']) !!}
                                <span class="help-block">{{ $errors->first('email_password', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('mail_encryption') ? 'has-error' : '' }}">
                            {!! Form::label('mail_encryption', trans('settings.mail_encryption'), ['class' => 'control-label']) !!}
                            <div class="controls">
                                {!! Form::input('text','mail_encryption', old('mail_encryption'), ['class' => 'form-control']) !!}
                                <span class="help-block">{{ $errors->first('mail_encryption', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="ses_section">
                        <div class="form-group required {{ $errors->has('ses_key') ? 'has-error' : '' }}">
                            {!! Form::label('ses_key', trans('settings.ses_key'), ['class' => 'control-label']) !!}
                            <div class="controls">
                                {!! Form::input('text','ses_key', old('ses_key'), ['class' => 'form-control']) !!}
                                <span class="help-block">{{ $errors->first('ses_key', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('ses_secret') ? 'has-error' : '' }}">
                            {!! Form::label('ses_secret', trans('settings.ses_secret'), ['class' => 'control-label']) !!}
                            <div class="controls">
                                {!! Form::input('text','ses_secret', old('ses_secret'), ['class' => 'form-control']) !!}
                                <span class="help-block">{{ $errors->first('ses_secret', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('ses_region') ? 'has-error' : '' }}">
                            {!! Form::label('ses_region', trans('settings.ses_region'), ['class' => 'control-label']) !!}
                            <div class="controls">
                                {!! Form::input('text','ses_region', old('ses_region'), ['class' => 'form-control']) !!}
                                <span class="help-block">{{ $errors->first('ses_region', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mailgun_section">
                        <div class="form-group required {{ $errors->has('mailgun_domain') ? 'has-error' : '' }}">
                            {!! Form::label('mailgun_domain', trans('settings.mailgun_domain'), ['class' => 'control-label']) !!}
                            <div class="controls">
                                {!! Form::input('text','mailgun_domain', old('mailgun_domain'), ['class' => 'form-control']) !!}
                                <span class="help-block">{{ $errors->first('mailgun_domain', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group required {{ $errors->has('mailgun_secret') ? 'has-error' : '' }}">
                            {!! Form::label('mailgun_secret', trans('settings.mailgun_secret'), ['class' => 'control-label']) !!}
                            <div class="controls">
                                {!! Form::input('text','mailgun_secret', old('mailgun_secret'), ['class' => 'form-control']) !!}
                                <span class="help-block">{{ $errors->first('mailgun_secret', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary pull-right">
                        {{trans('install.finish')}}
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
        </div>
    {!! Form::close() !!}
@stop
@section('scripts')
    <script src="{{ asset('js/icheck.min.js') }}" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function($) {
            $('.icheck').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });

            $("#smtp").on("ifChecked",function(){
                $('.smtp').show();
            });
            $("#smtp").on("ifUnchecked",function(){
                $(".smtp").hide();
            });
            if($("#smtp").closest(".iradio_minimal-blue").hasClass("checked")){
                $('.smtp').show();
            }else{
                $('.smtp').hide();
            }

            //            ses
            $("#ses").on("ifChecked",function(){
                $('.ses_section').show();
            });
            $("#ses").on("ifUnchecked",function(){
                $(".ses_section").hide();
            });
            if($("#ses").closest(".iradio_minimal-blue").hasClass("checked")){
                $(".ses_section").show();
            }else{
                $(".ses_section").hide();
            }

            //            mailgun
            $("#mailgun").on("ifChecked",function(){
                $('.mailgun_section').show();
            });
            $("#mailgun").on("ifUnchecked",function(){
                $(".mailgun_section").hide();
            });
            if($("#mailgun").closest(".iradio_minimal-blue").hasClass("checked")){
                $(".mailgun_section").show();
            }else{
                $(".mailgun_section").hide();
            }

        })
    </script>
@stop