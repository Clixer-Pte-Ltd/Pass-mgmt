@extends('backpack::layout_guest')

@section('content')
    <div class="login_content">
        <div class="row m-t-40">
            <div class="col-md-6 col-md-offset-3">
                <div class="box login">
                    <div class="box-body login">
                        <div class="col-md-6">
                            <div class="title_login">
                                <h1 class="text-center title">
                                    Welcome to <br>CAG Airport Pass Tracking Portal
                                </h1>
                                <div class="content_title">
                                    <ul>
                                        <li>Secure and Reliable</li>
                                        <li>Integrate with 2FA (Google Authenticator)</li>
                                    </ul>
                                </div>
                                <div class="content_title">
                                    Please download Google Authenticator before logging in with your registered email address and password. Should you encounter any technical issues, please contact us at "CAS_APO_General@certisgroup.com".
                                </div>
                            </div>
                        </div>
                        <form class="col-md-6 p-t-10 p-b-10 p-r-10 p-l-10 fromLogin " role="form" method="POST" action="{{ route('backpack.auth.login') }}">
                            {!! csrf_field() !!}
                            <h3 class="text-center m-b-20">
                                <img class="img_logo" src="{{ asset('/storage/imgs/logo-mini2.png') }}" style="margin-bottom: 24px; width:100px; height: auto">
                                {{ trans('backpack::base.login') }}
                            </h3>
                            <div class="form-group{{ $errors->has($username) ? ' has-error' : '' }}">
                                <label class="control-label">{{ config('backpack.base.authentication_column_name') }}</label>

                                <div class="emailForm">
                                    <input  type="text" class="form-control" name="{{ $username }}" value="{{ old($username) }}" placeholder="Email Address">

                                    @if ($errors->has($username))
                                        <span class="help-block">
                                            <strong>{{ $errors->first($username) }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="control-label">{{ trans('backpack::base.password') }}</label>

                                <div class="passwordForm">
                                    <input  type="password" class="form-control" name="password" placeholder="Password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> {{ trans('backpack::base.remember_me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-block btn-primary grad-red">
                                        {{ trans('backpack::base.login') }}
                                    </button>
                                </div>
                                <div class="text-center m-t-10"><a href="{{ route('backpack.auth.password.reset') }}">{{ trans('backpack::base.forgot_your_password') }}</a></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
