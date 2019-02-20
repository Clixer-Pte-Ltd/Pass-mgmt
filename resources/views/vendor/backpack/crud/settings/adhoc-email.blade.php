@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            <span class="text-capitalize">Settings</span>
            <small>Adhoc Email Config.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix'),'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
            <li class="active">Adhoc Email Config</li>
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
                </ul>

                <div class="tab-content">
                    <div id="retentation-rate" class="tab-pane fade in active">
                        <form method="post" action="{{ route('admin.setting.adhoc-email.retentation-rate') }}">
                            @csrf
                            <div class="row display-flex-wrap">
                                <div class="box col-md-12 padding-10 p-t-20">
                                    <div class="form-group col-xs-12 required">
                                        <label>Retentation Rate (Months)</label>
                                        <input type="number" name="{{ ADHOC_EMAIL_RETENTATION_RATE }}" value="{{ old('smtp_host') ?: getSettingValueByKey(ADHOC_EMAIL_RETENTATION_RATE) }}" class="form-control">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/form.css') }}">
@endsection
