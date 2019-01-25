@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            <span class="text-capitalize">Settings</span>
            <small>Revision Config.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix'),'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
            <li class="active">Revison Config</li>
        </ol>
    </section>
@endsection

@section('content')


    <div class="row m-t-20">
        <div class="col-md-8 ">
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
                    <li class="active"><a data-toggle="tab" href="#retentation-rate">Retentation Rate</a></li>
                    <li><a data-toggle="tab" href="#action-audit-log">Action Audit Log</a></li>
                </ul>

                <div class="tab-content">
                    <div id="retentation-rate" class="tab-pane fade in active">
                        <form method="post" action="{{ route('admin.setting.revisions.retentation-rate') }}">
                            @csrf
                            <div class="row display-flex-wrap">
                                <div class="box col-md-12 padding-10 p-t-20">
                                    <div class="form-group col-xs-12 required">
                                        <label>Retentation Rate (Months)</label>
                                        <input type="number" name="revision_retentation_rate" value="{{ old('smtp_host') ?: getSettingValueByKey(REVISION_RETENTATION_RATE) }}" class="form-control">
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
                        </form>
                    </div><!-- /.box -->
                    <div id="action-audit-log" class="tab-pane fade">
                        <form method="post" action="{{ route('admin.setting.revisions.action-audit-log') }}">
                            @csrf
                            <div class="row display-flex-wrap">
                                <div class="box col-md-12 padding-10 p-t-20">
                                    <div class="form-group col-xs-12" style="text-align: left">
                                        {{--checkbox--}}
                                        <div class="action-audit-log">
                                            <input type="checkbox" id="cbx-update" style="display:none" name="{{ REVISION_UPDATED }}" value="1" {{ getSettingValueByKey(REVISION_UPDATED) ? 'checked' : ''  }}/>
                                            <label for="cbx-update" class="toggle"><span></span></label>
                                        </div>
                                        <div style="margin-left: 50px">Update</div>
                                    </div>
                                    <div class="form-group col-xs-12" style="text-align: left">
                                        {{--checkbox--}}
                                        <div class="action-audit-log">
                                            <input type="checkbox" id="cbx-create" style="display:none" name="{{ REVISION_CREATED }}" value="1" {{ getSettingValueByKey(REVISION_CREATED) ? 'checked' : ''  }}/>
                                            <label for="cbx-create" class="toggle"><span></span></label>
                                        </div>
                                        <div style="margin-left: 50px">Create</div>
                                    </div>
                                    <div class="form-group col-xs-12" style="text-align: left">
                                        {{--checkbox--}}
                                        <div class="action-audit-log">
                                            <input type="checkbox" id="cbx-delete" style="display:none" name="{{ REVISION_DELETED }}" value="1" {{ getSettingValueByKey(REVISION_DELETED) ? 'checked' : ''  }}/>
                                            <label for="cbx-delete" class="toggle"><span></span></label>
                                        </div>
                                        <div style="margin-left: 50px">Delete</div>
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
                        </form>
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/form.css') }}">
@endsection
