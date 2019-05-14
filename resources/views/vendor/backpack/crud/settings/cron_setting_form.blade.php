<form method="post" action="{{ $route }}">
    @csrf
    <input type="hidden" value="every-minutes" name="type-cron">
    <div class="row display-flex-wrap">
        <div class="box col-md-12 padding-10 p-t-20">
            <div class="form-group col-xs-12 required" id="time-show-box">
                <p><b>Current Frequency:  &nbsp;&nbsp;&nbsp;</b><span style="color: #189eff" class="old_value" value="{{ $value }}"></span></p>
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
                                <div class="input-group date" id='{{ $type }}-daily-at'>
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
                                <div class="input-group date" id='{{ $type }}-weekly-on'>
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
                                <div class="input-group date" id='{{ $type }}-monthly-on'>
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
                                <div class="input-group date" id='{{ $type }}-yearly-on'>
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
@push('after_scripts')
    <script>
        $('#{{ $type }}-daily-at').datetimepicker({
            format: 'HH:mm'
        });

        $('#{{ $type }}-weekly-on').datetimepicker({
            format: 'HH:mm'
        });

        $('#{{ $type }}-monthly-on').datetimepicker({
            format: 'HH:mm'
        });

        $('#{{ $type }}-yearly-on').datetimepicker({
            format: 'HH:mm'
        });
    </script>
@endpush
