@extends('backpack::layout_guest')
@php
    $isCompany = session()->has(SESS_NEW_ACC_FROM_TENANT) || session()->has(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR) ? true : false;
@endphp
@section('content')
    <div class="row m-t-40">
        <div class="col-md-4 col-md-offset-4">
            <h3 class="text-center m-b-20">{{ trans('backpack::base.register') }}</h3>
            <div class="box">
                <div class="box-body">
                    <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ $isCompany ? route('backpack.auth.add.account') : route('backpack.auth.register.post') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="control-label">{{ trans('backpack::base.name') }}</label>

                            <div>
                                <input type="text" class="form-control" name="name" value="{{ is_null($user) ? old('name') : $user->name }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has(backpack_authentication_column()) ? ' has-error' : '' }}">
                            <label class="control-label">{{ config('backpack.base.authentication_column_name') }}</label>

                            <div>
                                <input type="{{ backpack_authentication_column()=='email'?'email':'text'}}" class="form-control" name="{{ backpack_authentication_column() }}" value="{{ is_null($user) ? old(backpack_authentication_column()) : $user->email }}">

                                @if ($errors->has(backpack_authentication_column()))
                                    <span class="help-block">
                                        <strong>{{ $errors->first(backpack_authentication_column()) }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if(!$isCompany)
                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label class="control-label">Phone</label>

                                <div>
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">

                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="control-label">{{ trans('backpack::base.password') }}</label>

                                <div>
                                    <input type="password" class="form-control" name="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label class="control-label">{{ trans('backpack::base.confirm_password') }}</label>

                                <div>
                                    <input type="password" class="form-control" name="password_confirmation">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        <input type="hidden" name="token" value="{{ @$user->token }}">
                        @if(session()->has('tenant'))
                            <input type="hidden" name="tenant_id" value="{{ session()->get('tenant') }}">
                        @endif

                        @if(session()->has('sub_constructor'))
                            <input type="hidden" name="sub_constructor_id" value="{{ session()->get('sub_constructor') }}">
                        @endif

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-block btn-primary">
                                    {{ trans('backpack::base.register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if(session()->has(SESS_TENANT_MY_COMPANY))
                <div class="text-center m-t-10"><a href="{{ route('admin.tenant.my-company') }}">Not now, back to portal</a></div>
            @else
                @if(!session()->has(SESS_NEW_ACC_FROM_TENANT) && !session()->has(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR))
                    <div class="text-center m-t-10"><a href="{{ route('backpack.auth.login') }}">{{ trans('backpack::base.login') }}</a></div>
                @else
                    @if(session()->has(SESS_NEW_ACC_FROM_TENANT))
                        <div class="text-center m-t-10"><a href="{{ route('crud.tenant.show', [session()->get('tenant')]) }}">Not now, back to portal</a></div>
                    @else
                        <div class="text-center m-t-10"><a href="{{ route('crud.sub-constructor.show', [session()->get('sub_constructor')]) }}">Not now, back to portal</a></div>
                    @endif
                @endif
            @endif
        </div>
    </div>
@endsection
