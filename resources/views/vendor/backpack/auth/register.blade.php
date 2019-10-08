@extends('backpack::layout_guest')
@php
    $isAddAccount = session()->get('add_account') ? true :false;
@endphp
@section('content')
    <div class="login_content register">
        <div class="row m-t-40">
            <div class="col-md-4 col-md-offset-4">
                <div class="title_register">
                    <h2 class="text-center m-b-20">
                        <img class="icon_logo" src="{{ asset('/storage/imgs/logo-mini2.png') }}" >
                        {{ trans('backpack::base.register') }}
                    </h2>
                </div>
                <div class="box login register">
                    <div class="box-body register">
                        <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ $isAddAccount ? route('backpack.auth.add.account') : route('backpack.auth.register.post') }}">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="control-label">{{ trans('backpack::base.name') }}</label>

                                <div class="input_register name_register">
                                    <input type="text" class="form-control" name="name" value="{{ is_null($account) ? old('name') : $account->name }}">
                                </div>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has(backpack_authentication_column()) ? ' has-error' : '' }}">
                                <label class="control-label">{{ config('backpack.base.authentication_column_name') }}</label>

                                <div class='input_register email_register'>
                                    <input type="{{ backpack_authentication_column()=='email'?'email':'text'}}" class="form-control" name="{{ backpack_authentication_column() }}" value="{{ is_null($account) ? old(backpack_authentication_column()) : $account->email }}">
                                </div>
                                @if ($errors->has(backpack_authentication_column()))
                                    <span class="help-block">
                                            <strong>{{ $errors->first(backpack_authentication_column()) }}</strong>
                                        </span>
                                @endif
                            </div>
                            @if($isAddAccount)
                                <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                                    <label for="select-role">Role Account</label>
                                    <div class="form-group input_register role_register">
                                        <select class="form-control" name='role' id="select-role" style="padding-left: 30px; margin-left: 30px; width: 95%">
                                            @if (session()->has(SESS_NEW_ACC_FROM_TENANT) || session()->has(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR))
                                                <option value="{{ COMPANY_CO_ROLE_ID }}">{{ COMPANY_CO_ROLE }}</option>
                                                <option value="{{ COMPANY_AS_ROLE_ID }}">{{ COMPANY_AS_ROLE }}</option>
                                                <option value="{{ COMPANY_VIEWER_ROLE_ID }}">{{ COMPANY_VIEWER_ROLE }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    @if ($errors->has('role'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('role') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            @endif
                            @if(!$isAddAccount)
                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <label class="control-label">Contact number</label>

                                    <div class="input_register phone_register">
                                        <input type="text" class="form-control" name="phone" value="{{ is_null($account) ? old('phone') : $account->phone }}">
                                    </div>
                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="control-label">{{ trans('backpack::base.password') }}</label>

                                    <div class="input_register pwd_register">
                                        <input type="password" class="form-control" name="password">
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label class="control-label">{{ trans('backpack::crud.confirm_password') }}</label>

                                    <div class="input_register pwd_register">
                                        <input type="password" class="form-control" name="password_confirmation">
                                    </div>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            @endif
                            <input type="hidden" name="token" value="{{ @$account->token }}">
                            @if(session()->has(SESS_NEW_ACC_FROM_TENANT))
                                <input type="hidden" name="tenant_id" value="{{ session()->get('tenant') }}">
                            @endif

                            @if(session()->has(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR))
                                <input type="hidden" name="sub_constructor_id" value="{{ session()->get('sub_constructor') }}">
                            @endif

                            <div class="form-group">
                                <div class="button_register">
                                    <button type="submit" class="btn btn-block btn-primary">
                                        {{ trans('backpack::base.register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
