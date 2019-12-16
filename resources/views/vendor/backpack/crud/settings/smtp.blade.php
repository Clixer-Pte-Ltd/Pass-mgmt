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
	<div class="col-md-12">
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
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#retentation-rate">Smtp Config</a></li>
                    <li><a data-toggle="tab" href="#action-audit-log">Allow send mail</a></li>
                </ul>

                <div class="tab-content">
                    <div id="retentation-rate" class="tab-pane fade in active">
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
                    </div><!-- /.box -->
                    <div id="action-audit-log" class="tab-pane fade">
                        <form method="post" action="{{ route('admin.setting.allow-send-mail') }}">
                            @csrf
                            <div class="row display-flex-wrap">
                                <div class="box col-md-12 padding-10 p-t-20">
                                    @foreach(ALLOW_MAIL as $key => $value)
                                        <div class="form-group col-xs-12" style="text-align: left">
                                            {{--checkbox--}}
                                            <div class="action-audit-log">
                                                <input type="checkbox" id="cbx-{{$value}}" style="display:none" name="{{ $value }}" value="1" {{ getSettingValueByKey($value) ? 'checked' : ''  }}/>
                                                <label for="cbx-{{$value}}" class="toggle"><span></span></label>
                                            </div>
                                            <div style="margin-left: 50px">{{ ALLOW_MAIL_NAME[$key] }}</div>
                                        </div>
                                    @endforeach
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
                        </form>
                    </div>
                </div>
            </div>

	</div>
</div>
@endsection

@section('after_styles')
	<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/form.css') }}">
    <style>
        @foreach(ALLOW_MAIL as $key => $value)
            .action-audit-log #cbx-{{ $value }}:checked+.toggle:before {
                background: #947ADA
            }
            .action-audit-log #cbx-{{ $value }}:checked+.toggle span {
                background:  #4F2EDC;
                transform: translateX(20px);
                transition: all .2s cubic-bezier(.8,.4,.3,1.25), background .15s ease;
                box-shadow: 0 3px 8px rgba(79,46,220,.2);
            }
            .action-audit-log #cbx-{{ $value }}:checked+.toggle span:before{
                transform: scale(1);
                opacity: 0;
                transition: all .4s ease;
            }
        @endforeach
    </style>
@endsection
