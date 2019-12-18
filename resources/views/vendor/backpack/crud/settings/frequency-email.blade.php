@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            <span class="text-capitalize">Settings</span>
            <small>Frequency Send Email Config.</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url(config('backpack.base.route_prefix'),'dashboard') }}">{{ trans('backpack::crud.admin') }}</a>
            </li>
            <li class="active">Frequency Send Email Config</li>
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
                    <li class="active"><a data-toggle="tab" href="#expiring-pass-holder-alert">Expiring Pass Holder Alert</a></li>
                    <li><a data-toggle="tab" href="#delist-pass-alert">De-Listed Pass Alert</a>
                    <li><a data-toggle="tab" href="#renew-pass-alert ">Renew Pass Alert </a></li>
                    <li><a data-toggle="tab" href="#terminated-pass-alert">Terminated Pass Alert</a></li>
                </ul>
                <div class="tab-content">
                    <div id="expiring-pass-holder-alert" class="tab-pane fade in active">
                        @include('vendor.backpack.crud.settings.cron_setting_form', ['route' => route('admin.setting.frequency-email.expiring-pass-holder-alert'),
                            'type' => 'expiring-pass-holder-alert',
                            'value' =>  getSettingValueByKey(FREQUENCY_EXPIRING_PASS_EMAIL)])
                    </div><!-- /.box -->
                    <div id="delist-pass-alert" class="tab-pane fade">
                        @include('vendor.backpack.crud.settings.cron_setting_form', ['route' => route('admin.setting.frequency-email.expiring-pass-holder-alert'),
                            'type' => 'blacklisted-pass-alert',
                            'value' =>  getSettingValueByKey(FREQUENCY_BLACKLISTED_PASS_EMAIL)])
                        ])
                    </div><!-- /.box -->
                    <div id="renew-pass-alert" class="tab-pane fade">
                        @include('vendor.backpack.crud.settings.cron_setting_form', ['route' => route('admin.setting.frequency-email.renew-pass-holder-alert'),
                            'type' => 'renew-pass-alert',
                            'value' =>  getSettingValueByKey(FREQUENCY_RENEWED_PASS_EMAIL)])
                        ])
                    </div><!-- /.box -->
                    <div id="terminated-pass-alert" class="tab-pane fade">
                        @include('vendor.backpack.crud.settings.cron_setting_form', ['route' => route('admin.setting.frequency-email.terminated-pass-alert'),
                            'type' => 'terminated-pass-alert',
                            'value' =>  getSettingValueByKey(FREQUENCY_TERMINATED_PASS_EMAIL)])
                        ])
                    </div><!-- /.box -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/bower_components/bootstrap-datatimepicker/dist/css/bootstrap-datetimepicker.css') }}">
    <style>
        .time-picker{
            width: 100%;
        }
        .input-time-picker {
            display: inline-block !important;
            width: 100px !important;
            background: red!important;
            height: 35px !important;
            background: #e6f6fb!important;
            border-radius: 10px !important;
            margin-left: 10px!important;
        }
        .button-time-picker {
            display: inline-block;
            margin-top: 3px;
            float:left;
            height: 30px;
            padding: 5px;
            margin-right: 20px;
        }
        .dropdown-menu.top{
            /*left: 80%!important;*/
        }
        .time-picker-box{
            margin: 5px 0;
        }
        .input-month-picker, .input-day-of-month-picker,.input-day-of-week-picker {
            width: 20% !important;
            margin-left: 10px!important;
            display: inline-block!important;
            float: left!important;
        }
        .time-lable {
            margin-left: 10px;
        }
    </style>
@endsection

@section('after_scripts')
    <script src="{{ asset('vendor/adminlte/bower_components/bootstrap-datatimepicker/dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/bower_components/bootstrap-datatimepicker/dist/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('vendor/backpack/cron/later.js') }}"></script>
    <script src="{{ asset('vendor/backpack/cron/prettycron.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('.cron-setting').css("display", "none")
            timeValue = ''
            $(document).on('click', '.button-time-picker', function (event) {
                $('.cron-setting').css("display", "none")
                $(this).siblings('.cron-setting').css("display", "block")
                $('.time-lable-span').text('');
                timeValue = $(this).text()
                var btnId = $(this).attr('id')

                switch(btnId) {
                    case 'every-minutes-btn':
                        $("input[name='every-minutes']").val(1)
                        $("input[name='type-cron']").val('every-minutes')
                        $('#time-lable').text(timeValue)
                        break;
                    case 'daily-at-btn':
                        $("input[name='every-minutes']").val(0)
                        $("input[name='type-cron']").val('daily')
                        $('#time-lable').text(timeValue)
                        // code block
                        break;
                    case 'weekly-on-btn':
                        $("input[name='every-minutes']").val(0)
                        $("input[name='type-cron']").val('weekly')
                        $('#time-lable').text(timeValue)
                        // code block
                        break;
                    case 'monthly-on-btn':
                        $("input[name='every-minutes']").val(0)
                        $("input[name='type-cron']").val('monthly')
                        $('#time-lable').text(timeValue)
                        // code block
                        break;
                    case 'yearly-on-btn':
                        $("input[name='every-minutes']").val(0)
                        $("input[name='type-cron']").val('yearly')
                        $('#time-lable').text(timeValue)
                        break;
                    default:
                }
                $("select[name='day-of-week']").val(1)
                $("select[name='day-of-month']").val(1)
                $("select[name='month']").val(1)
                $("input[name='time']").val('00:00')
                $('#time-value').text(timeValue)

            })

            $('.date').on('dp.change', function(e){
                var value = $(this).find("input[name='time']").val()
                $("input[name='time']").val(value)
                $('#time-value-time').text(value)
            })

            $(document).on('change', '.input-day-of-week-picker', function (event) {
                var daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
                $('#time-value-dayOfWeek').text(daysOfWeek[$(this).val()])
                $("select[name='day-of-week']").val($(this).val());
            })

            $(document).on('change', '.input-day-of-month-picker', function (event) {
                var value = $(this).val();
                $("select[name='day-of-month']").val(value);
                switch(value) {
                    case '1':
                        dayOfMonth = value + 'st'
                        break;
                    case '2':
                        dayOfMonth = value + 'nd'
                        break;
                    case '3':
                        dayOfMonth = value + 'rd'
                        break;
                    default:
                        dayOfMonth = value + 'th'
                }
                $('#time-value-dayOfMonth').text(dayOfMonth)
            })

            $(document).on('change', '.input-month-picker', function (event) {
                $("select[name='month']").val($(this).val());
                var months = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
                $('#time-value-month').text(months[$(this).val()-1])
            })

            $('.old_value').each(function(index) {
                let value = $(this).attr('value');
                $(this).text(prettyCron.toString(value));
            });
        });
    </script>
@endsection
