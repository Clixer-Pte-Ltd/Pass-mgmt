@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
        <span class="text-capitalize">Settings</span>
        <small>Smtp Config.</small>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'),'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li class="active">Smtp Config</li>
	  </ol>
	</section>
@endsection

@section('content')


<div class="row m-t-20">
	<div class="col-md-8 col-md-offset-2">
		<!-- Default box -->
            @if ($errors->any())
                <div class="callout callout-danger">
                    <h4>{{ trans('backpack::crud.please_fix') }}</h4>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
		  <form method="post" action="{{ route('admin.setting.smtp.update') }}">
            {!! csrf_field() !!}
            <div class="col-md-12">
                <div class="row display-flex-wrap">
                    <div class="box col-md-12 padding-10 p-t-20">
                        <div class="form-group col-xs-12 required">
                            <label>Host</label>
                            <input type="text" name="smtp_host" value="{{ old('smtp_host') ?: getSettingValueByKey(SMTP_HOST) }}" class="form-control">
                        </div>
                        <div class="form-group col-xs-12 required">
                            <label>Port</label>
                            <input type="text" name="smtp_port" value="{{ old('smtp_port') ?: getSettingValueByKey(SMTP_PORT) }}" class="form-control">
                        </div>
                        <div class="form-group col-xs-12 required">
                            <label>Username</label>
                            <input type="text" name="smtp_username" value="{{ old('smtp_username') ?: getSettingValueByKey(SMTP_USERNAME) }}" class="form-control">
                        </div>
                        <div class="form-group col-xs-12 required">
                            <label>Password</label>
                            <input type="password" name="smtp_password" value="{{ old('smtp_password') ?: getSettingValueByKey(SMTP_PASSWORD) }}" class="form-control">
                        </div>
                        <div class="form-group col-xs-12">
                            <label>Encryption</label>
                            <input type="text" name="smtp_encryption" value="{{ old('smtp_encryption') ?: getSettingValueByKey(SMTP_ENCRYPTION) }}" class="form-control">
                        </div>
                        <div class="form-group col-xs-12">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success">
                                    <span class="fa fa-save" role="presentation" aria-hidden="true"></span>
                                    <span data-value="save_and_back">Update</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
		  </form>
	</div>
</div>
@endsection

@section('after_styles')
	<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/form.css') }}">
@endsection
