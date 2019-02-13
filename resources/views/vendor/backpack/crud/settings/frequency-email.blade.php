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
                </ul>

                <div class="tab-content">
                    <div id="expiring-pass-holder-alert" class="tab-pane fade in active">
                        <form method="post" action="{{ route('admin.setting.frequency-email.expiring-pass-holder-alert') }}">
                            @csrf
                            <input type="hidden" value="every-minutes" name="type-cron">
                            <div class="row display-flex-wrap">
                                <div class="box col-md-12 padding-10 p-t-20">
                                    <div class="form-group col-xs-12 required" id="time-show-box">
                                        <label>Frequency Send Email : </label>
                                        &emsp;
                                        <span style="color: red" id="time-lable">Every Minutes&emsp;</span>
                                        &emsp;
                                        <span style="color: red" id="time-value-dayOfWeek" class="time-lable-span">&emsp;</span>
                                        &emsp;
                                        <span style="color: red" id="time-value-dayOfMonth" class="time-lable-span">&emsp;</span>
                                        &emsp;
                                        <span style="color: red" id="time-value-month" class="time-lable-span">&emsp;</span>
                                        &emsp;
                                        <span style="color: red" id="time-value-time" class="time-lable-span">&emsp;</span>
                                        {{--<input type="text" name="frequency-email-expiring-pass-holder-alert"--}}
                                               {{--value="{{ old('frequency-email-expiring-pass-holder-alert') ?: getSettingValueByKey(FREQUENCY_EXPIRING_PASS_EMAIL) }}"--}}
                                               {{--class="form-control">--}}
                                        <div class="col-md-12">
                                            <button class="button-time-picker btn btn-danger" type="button" id="every-minutes-btn">Every Minutes</button>
                                            <div class="cron-setting">
                                                <input type="hidden" value="1" name="every-minutes">
                                            </div>
                                            </div>
                                        <div class="col-md-12">
                                            <div class="time-picker-box">
                                                <div class="time-picker">
                                                    <button class="button-time-picker btn btn-primary" type="button" id="daily-at-btn">Daily At:</button>
                                                    <div class="cron-setting">
                                                        <span style="display: inline-block; float: left; margin-top: 8px" class="time-lable">time:</span>
                                                        <div class="input-group date" id='daily-at'>
                                                            <input type='text' value="00:00" name="time" class="form-control input-group-addon input-time-picker"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="time-picker-box">
                                                <div class="time-picker">
                                                    <button class="button-time-picker btn btn-success" type="button" id="weekly-on-btn">Weekly On:</button>
                                                    <div class="cron-setting">
                                                        <span style="display: inline-block; float: left; margin-top: 8px" class="time-lable">day of week:</span>
                                                        <select class="form-control input-day-of-week-picker" name='day-of-week'>
                                                            <option value="1" hidden></option>
                                                            <option value="1">Monday</option>
                                                            <option value="2">Tuesday</option>
                                                            <option value="3">Wednesday</option>
                                                            <option value="4">Thursday</option>
                                                            <option value="5">Friday</option>
                                                            <option value="6">Saturday</option>
                                                            <option value="0">Sunday</option>
                                                        </select>
                                                        <span style="display: inline-block; float: left; margin-top: 8px" class="time-lable">time:</span>
                                                        <div class="input-group date" id='weekly-on'>
                                                            <input type='text' value="00:00" name="time" class="form-control input-group-addon input-time-picker"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="time-picker-box">
                                                <div class='time-picker'>
                                                    <button class="button-time-picker btn btn-info" type="button" id="monthly-on-btn">Monthly On:</button>
                                                    <div class="cron-setting">
                                                        <span style="display: inline-block; float: left; margin-top: 8px" class="time-lable">day of month:</span>
                                                        <select class="form-control input-day-of-month-picker" name='day-of-month'>
                                                            <option value="1" hidden></option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                            <option value="13">13</option>
                                                            <option value="14">14</option>
                                                            <option value="15">15</option>
                                                            <option value="16">16</option>
                                                            <option value="17">17</option>
                                                            <option value="18">18</option>
                                                            <option value="19">19</option>
                                                            <option value="20">20</option>
                                                            <option value="21">21</option>
                                                            <option value="22">22</option>
                                                            <option value="23">23</option>
                                                            <option value="24">24</option>
                                                            <option value="25">25</option>
                                                            <option value="26">26</option>
                                                            <option value="27">27</option>
                                                            <option value="28">28</option>
                                                            <option value="29">29</option>
                                                            <option value="30">30</option>
                                                        </select>
                                                        <span style="display: inline-block; float: left; margin-top: 8px" class="time-lable">time:</span>
                                                        <div class="input-group date" id='monthly-on'>
                                                            <input type='text' value="00:00" name="time" class="form-control input-group-addon input-time-picker"/>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="time-picker-box">
                                                <div class='time-picker'>
                                                    <button class="button-time-picker btn btn-warning" type="button" id="yearly-on-btn">Yearly On:</button>
                                                    <div class="cron-setting">
                                                        <span style="display: inline-block; float: left; margin-top: 8px" class="time-lable">month of year:</span>
                                                        <select class="form-control input-month-picker" name='month'>
                                                            <option value="1" hidden></option>
                                                            <option value="1">January</option>
                                                            <option value="2">February</option>
                                                            <option value="3">March</option>
                                                            <option value="4">April</option>
                                                            <option value="5">May</option>
                                                            <option value="6">June</option>
                                                            <option value="7">July</option>
                                                            <option value="8">August</option>
                                                            <option value="9">September</option>
                                                            <option value="10">October</option>
                                                            <option value="11">November</option>
                                                            <option value="12">December</option>
                                                        </select>
                                                        <span style="display: inline-block; float: left; margin-top: 8px" class="time-lable">day of month:</span>
                                                        <select class="form-control input-day-of-month-picker" name='day-of-month'>
                                                            <option value="1" hidden></option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                            <option value="13">13</option>
                                                            <option value="14">14</option>
                                                            <option value="15">15</option>
                                                            <option value="16">16</option>
                                                            <option value="17">17</option>
                                                            <option value="18">18</option>
                                                            <option value="19">19</option>
                                                            <option value="20">20</option>
                                                            <option value="21">21</option>
                                                            <option value="22">22</option>
                                                            <option value="23">23</option>
                                                            <option value="24">24</option>
                                                            <option value="25">25</option>
                                                            <option value="26">26</option>
                                                            <option value="27">27</option>
                                                            <option value="28">28</option>
                                                            <option value="29">29</option>
                                                            <option value="30">30</option>
                                                        </select>
                                                        <span style="display: inline-block; float: left; margin-top: 8px" class="time-lable">time:</span>
                                                        <div class="input-group date" id='yearly-on'>
                                                            <input type='text' value="00:00" name="time" class="form-control input-group-addon input-time-picker"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12" style="text-align: center;">
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
    <script type="text/javascript">
        $(function () {
            $('#daily-at').datetimepicker({
                format: 'HH:mm'
            });

            $('#weekly-on').datetimepicker({
                format: 'HH:mm'
            });

            $('#monthly-on').datetimepicker({
                format: 'HH:mm'
            });

            $('#yearly-on').datetimepicker({
                format: 'HH:mm'
            });
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
        });
    </script>
@endsection
