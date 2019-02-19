{{--icon--}}
@switch($history->description)
    @case('created')
        <i class="fa fa-plus-square icon_timeline" id="icon_timeline_created" style="color: #ffffff; background-color: #28a745"></i>
    @break
    @case('updated')
        <i class="fa fa-gears icon_timeline" id="icon_timeline_updated" style="color: #ffffff; background-color: #ffc107"></i>
    @break
    @case('deleted')
        <i class="fa fa-remove icon_timeline" id="icon_timeline_deleted" style="color: #ffffff; background-color: #dc3545"></i>
    @break
    @case('added-account')
        <i class="fa fa-address-book-o icon_timeline" id="icon_timeline_added-account" style="color: #ffffff; background-color: #dc3545"></i>
    @break
    @case('Send Mail Account Info')
        <i class="fa fa-mail-forward icon_timeline" id="icon_timeline_send_account_infor_mail" style="color: #ffffff; background-color: #b427e6"></i>
    @break
    @case('Send Mail Adhoc Mail')
        <i class="fa fa-mail-forward icon_timeline" id="icon_timeline_send_adhoc_mail" style="color: #ffffff; background-color: #b427e6"></i>
    @break
    @case('Send Mail Bi Annual Mail')
        <i class="fa fa-mail-forward icon_timeline" id="icon_timeline_send_bi_anual" style="color: #ffffff; background-color: #b427e6"></i>
    @break
    @case('Send Mail Companies List Not Validate')
        <i class="fa fa-mail-forward icon_timeline" id="icon_timeline_companies_list_not_validate" style="color: #ffffff; background-color: #b427e6"></i>
    @break
    @case('Send Mail Company Expired Mail')
        <i class="fa fa-mail-forward icon_timeline" id="icon_timeline_send_company_expired" style="color: #ffffff; background-color: #b427e6"></i>
    @break
    @case('Send Mail Company Expire Soon')
        <i class="fa fa-mail-forward icon_timeline" id="icon_timeline_send_company_expire_soon" style="color: #ffffff; background-color: #b427e6"></i>
    @break
    @case('Send Mail Company Need Validate Mail')
        <i class="fa fa-mail-forward icon_timeline" id="icon_timeline_send_company_need_validate" style="color: #ffffff; background-color: #b427e6"></i>
    @break
    @case('Company Notify New Account')
        <i class="fa fa-mail-forward icon_timeline" id="icon_timeline_company_notify_new_account" style="color: #ffffff; background-color: #b427e6"></i>
    @break
    @case('Create Pass Holder Success Mail')
        <i class="fa fa-mail-forward icon_timeline" id="icon_timeline_create_pass_holder_success" style="color: #ffffff; background-color: #b427e6"></i>
    @break
    @case('Pass Holder Expired Mail')
        <i class="fa fa-mail-forward icon_timeline" id="icon_timeline_pass_holder_expired" style="color: #ffffff; background-color: #b427e6"></i>
    @break
    @case('Pass Holder Expire Soon Mail')
        <i class="fa fa-mail-forward icon_timeline" id="icon_timeline_pass_holder_expire_soon" style="color: #ffffff; background-color: #b427e6"></i>
    @break
    @case('Pass Holder List Pending Return Mail')
        <i class="fa fa-mail-forward icon_timeline" id="icon_timeline_pass_holder_List_pending_return" style="color: #ffffff; background-color: #b427e6"></i>
    @break
    @case('Pass Holder Renew Mail')
        <i class="fa fa-mail-forward icon_timeline" id="icon_timeline_pass_holder_renew" style="color: #ffffff; background-color: #b427e6"></i>
    @break
    @case('Pass Holder Terminate Mail')
        <i class="fa fa-mail-forward icon_timeline" id="icon_timeline_pass_holder_terminate" style="color: #ffffff; background-color: #b427e6"></i>
    @break
    @case('Pass Holder Valid Daily Mail')
        <i class="fa fa-mail-forward icon_timeline" id="icon_timeline_pass_holder_valid_daily" style="color: #ffffff; background-color: #b427e6"></i>
    @break
    @default
        <i class="fa fa-calendar bg-default icon_timeline" id="icon_timeline_default" style="color: #ffffff; background-color: #dc3545"></i>
@endswitch
{{--content--}}

{{--created--}}
@if ($history->description == 'created')
    <div class="timeline-item"  id="timeline-created">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            <span href="#"> {{ @$history->causer->name }} </span>
            {{ $history->description }}
            <span href="#"> {{ getTypeAttribute($history->subject_type) }} </span>
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">
                @php
                    $dataHistory = $history->changes->toArray();
                @endphp
                {{ @$history->causer->name }} created new {{ getTypeAttribute($history->subject_type) }} with detail: <br>

                @foreach(array_keys($dataHistory['attributes']) as $key)
                    <b>{{ $key }}</b>:&emsp; {{ $dataHistory['attributes'][$key] }}
                    <br>
                @endforeach

            </div>
        </div>
        {{--<div class="timeline-footer p-t-0">--}}
            {{--<form method="post" action="{{ url(\Request::url().'/'.$history->id.'/restore') }}">--}}
            {{--{!! csrf_field() !!}--}}
            {{--<spanutton type="submit" class="btn btn-primary btn-sm restore-btn" data-entry-id="{{ $entry->id }}" data-revision-id="{{ $history->id }}" onclick="onRestoreClick(event)">--}}
            {{--<i class="fa fa-undo"></i> {{ trans('backpack::crud.undo') }}</button>--}}
            {{--</form>--}}
        {{--</div>--}}
    </div>
@endif

{{--update--}}
@if ($history->description == 'updated')
<div class="timeline-item" id="timeline-updated">
    <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
    <h3 class="timeline-header">
        <span href="#"> {{ @$history->causer->name }} </span>
        {{ $history->description }}
        <span href="#"> {{ getTypeAttribute($history->subject_type) }} </span>
        with id:
        {{ $history->subject_id }}
    </h3>
    <div style="padding: 10px">
        <div class="timeline-body p-b-0">
            @php
                $dataHistory = $history->changes->toArray();
            @endphp
            @foreach(array_keys($dataHistory['attributes']) as $key)
                @if ($dataHistory['attributes'][$key] !== $dataHistory['old'][$key] )
                    <b>{{ $key }}</b>:&emsp; from <span>&emsp;'{{ $dataHistory['old'][$key] }}'&emsp;</span> to  <span>&emsp;'{{ $dataHistory['attributes'][$key] }}'&emsp;</span>
                    <br>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endif

{{--deleted--}}
@if ($history->description == 'deleted')
    <div class="timeline-item"  id="timeline-deleted">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            <span href="#"> {{ @$history->causer->name }} </span>
            {{ $history->description }}
            <span href="#"> {{ getTypeAttribute($history->subject_type) }} </span>
            with id:
            {{ $history->subject_id }}
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">
                @php
                    $dataHistory = $history->changes->toArray();
                @endphp
            </div>
        </div>
    </div>
@endif

{{--add account--}}
@if ($history->description == 'added-account')
    <div class="timeline-item"  id="timeline-added-account">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            <span href="#"> {{ @$history->causer->name }} </span>
            added account 
            with id:
            {{ $history->subject_id }}
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">
                @php
                    $dataHistory = $history->properties->toArray();
                @endphp
                <b>Name:</b>:&emsp; <span>&emsp;'{{ $dataHistory['name'] }}'</span><br>
                <b>Email:</b>:&emsp; <span>&emsp;'{{ $dataHistory['email'] }}'</span>
            </div>
        </div>
    </div>
@endif

{{--account infor mail--}}
@if ($history->description == 'Send Mail Account Info')
    <div class="timeline-item"  id="timeline-send-mail-account-info">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            System sended notify imported account infor mail
            <br>
            Account id:
            {{ $history->subject_id }}
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">
                @php
                    $dataHistory = $history->properties->toArray();
                @endphp
                <b>Name:</b>:&emsp; <span>&emsp;'{{ $dataHistory['name'] }}'</span><br>
                <b>Email:</b>:&emsp; <span>&emsp;'{{ $dataHistory['email'] }}'</span>
            </div>
        </div>
    </div>
@endif

{{--adhoc mail--}}
@if ($history->description == 'Send Mail Adhoc Mail')
    <div class="timeline-item"  id="timeline-send-mail-adhoc">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            @php
                $dataHistory = $history->properties->toArray();
            @endphp
            {{ @$history->subject->name }} sended adhoc mail to {{ @$dataHistory['name'] }}
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">

            </div>
        </div>
    </div>
@endif

{{--bi annual mail--}}
@if ($history->description == 'Send Mail Bi Annual Mail')
    <div class="timeline-item"  id="timeline-send-mail-bi-annual">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            @php
                $dataHistory = $history->properties->toArray();
            @endphp
            System sended bi annual mail to {{ @$dataHistory['name'] }}
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">

            </div>
        </div>
    </div>
@endif

{{--companies list not validate--}}
@if ($history->description == 'Send Mail Companies List Not Validate')
    <div class="timeline-item"  id="timeline-send-mail-bi-annual">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            @php
                $dataHistory = $history->properties->toArray();
            @endphp
            System sended mail to <b>{{ @$history->subject->name }}</b> list company not validate:
            @foreach (@$dataHistory as $company)
                <br>
                {{ $company['name'] }}
            @endforeach
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">

            </div>
        </div>
    </div>
@endif

{{--send company expired--}}
@if ($history->description == 'Send Mail Company Expired Mail')
    <div class="timeline-item"  id="timeline-send-mail-bi-annual">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            @php
                $dataHistory = $history->properties->toArray();
            @endphp
            System sended mail to <b>{{ @$history->subject->name }}</b> notify company <b>{{ $dataHistory['name'] }}</b> was expired
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">

            </div>
        </div>
    </div>
@endif

{{--send company expire soon --}}
@if ($history->description == 'Send Mail Company Expire Soon')
    <div class="timeline-item"  id="timeline-send-mail-bi-annual">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            @php
                $dataHistory = $history->properties->toArray();
            @endphp
            System sended mail to <b>{{ @$history->subject->name }}</b> notify company <b>{{ $dataHistory['name'] }}</b> expire soon
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">

            </div>
        </div>
    </div>
@endif

{{--send mail company need validate mail--}}
@if ($history->description == 'Send Mail Company Need Validate Mail')
    <div class="timeline-item"  id="timeline-send-mail-bi-annual">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            @php
                $dataHistory = $history->properties->toArray();
            @endphp
            System sended mail to <b>{{ @$history->subject->name }}</b> notify company <b>{{ $dataHistory['name'] }}</b> need validate
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">

            </div>
        </div>
    </div>
@endif

{{--company add account--}}
@if ($history->description == 'Company Notify New Account')
    <div class="timeline-item"  id="timeline-send-mail-account-info">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            System sended mail notify {{ @$history->causer->name }} add account:
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">
                @php
                    $dataHistory = $history->properties->toArray();
                @endphp
                <b>Name:</b>:&emsp; <span>&emsp;'{{ $dataHistory['name'] }}'</span><br>
                <b>Email:</b>:&emsp; <span>&emsp;'{{ $dataHistory['email'] }}'</span>
            </div>
        </div>
    </div>
@endif

{{--create pass holder--}}
@if ($history->description == 'Create Pass Holder Success Mail')
    <div class="timeline-item"  id="timeline-send-mail-account-info">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            System sended mail notify {{ @$history->causer->name }} create new pass holder:
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">
                @php
                    $dataHistory = $history->properties->toArray();
                @endphp
                <b>Name:</b>:&emsp; <span>&emsp;'{{ $dataHistory['applicant_name'] }}'</span><br>
            </div>
        </div>
    </div>
@endif

{{--pass holder expired--}}
@if ($history->description == 'Pass Holder Expired Mail')
    <div class="timeline-item"  id="timeline-send-mail-account-info">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            System sended mail notify {{ @$history->causer->name }} list pass holder expired:
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">
                @php
                    $dataHistory = $history->properties->toArray();
                @endphp
                @foreach ($dataHistory as $pass)
                    <br>
                    <b>Name:</b>:&emsp; <span>&emsp;'{{ $pass['applicant_name'] }}'</span>
                @endforeach
            </div>
        </div>
    </div>
@endif

{{--pass holder expire soon--}}
@if ($history->description == 'Pass Holder Expire Soon Mail')
    <div class="timeline-item"  id="timeline-send-mail-account-info">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            System sended mail notify {{ @$history->causer->name }} list pass holder expire soon:
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">
                @php
                    $dataHistory = $history->properties->toArray();
                @endphp
                @foreach ($dataHistory as $pass)
                    <br>
                    <b>Name:</b>:&emsp; <span>&emsp;'{{ $pass['applicant_name'] }}'</span>
                @endforeach
            </div>
        </div>
    </div>
@endif

{{--pass holder expire soon--}}
@if ($history->description == 'Pass Holder List Pending Return Mail')
    <div class="timeline-item"  id="timeline-send-mail-account-info">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            System sended mail notify {{ @$history->causer->name }} list pass holder pendding return:
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">
                @php
                    $dataHistory = $history->properties->toArray();
                @endphp
                @foreach ($dataHistory as $pass)
                    <br>
                    <b>Name:</b>:&emsp; <span>&emsp;'{{ $pass['applicant_name'] }}'</span>
                @endforeach
            </div>
        </div>
    </div>
@endif

{{--pass holder confirm return pass holder--}}
@if ($history->description == 'Pass Holder Need Confirm Return Mail')
    <div class="timeline-item"  id="timeline-send-mail-account-info">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            System sended mail notify {{ @$history->causer->name }} need confirm return passholder:
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">
                @php
                    $dataHistory = $history->properties->toArray();
                @endphp
                <b>Name:</b>:&emsp; <span>&emsp;'{{ $dataHistory['applicant_name'] }}'</span><br>
            </div>
        </div>
    </div>
@endif

{{--Pass Holder Renew Mail--}}
@if ($history->description == 'Pass Holder Renew Mail')
    <div class="timeline-item"  id="timeline-send-mail-account-info">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            System sended mail notify {{ @$history->causer->name }} pass holder was renewed:
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">
                @php
                    $dataHistory = $history->properties->toArray();
                @endphp
                <b>Name:</b>:&emsp; <span>&emsp;'{{ $dataHistory['applicant_name'] }}'</span><br>
            </div>
        </div>
    </div>
@endif

{{--Pass Holder Renew Mail--}}
@if ($history->description == 'Pass Holder Terminate Mail')
    <div class="timeline-item"  id="timeline-send-mail-account-info">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            System sended mail notify {{ @$history->causer->name }} pass holder was terminated:
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">
                @php
                    $dataHistory = $history->properties->toArray();
                @endphp
                <b>Name:</b>:&emsp; <span>&emsp;'{{ $dataHistory['applicant_name'] }}'</span><br>
            </div>
        </div>
    </div>
@endif

{{--Pass Holder Valid Daily Mail--}}
@if ($history->description == 'Pass Holder Valid Daily Mail')
    <div class="timeline-item"  id="timeline-send-mail-account-info">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            System sended mail notify {{ @$history->causer->name }} list pass holder valid daily:
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">
                @php
                    $dataHistory = $history->properties->toArray();
                @endphp
                @foreach ($dataHistory as $pass)
                    <br>
                    <b>Name:</b>:&emsp; <span>&emsp;'{{ $pass['applicant_name'] }}'</span>
                @endforeach
            </div>
        </div>
    </div>
@endif

@section('after_styles')
    <style>
        i.icon_timeline:after{
            content: '';
            display: inline-block;
            width: 10px;
            height: 30px;
            position: absolute;
        }
        i.icon_timeline:before{
            z-index: 9999999;
            position: absolute;
        }
        .timeline-item {
            font-size: 0.9em ;border: 1px solid #b6b5b561 !important;
            -webkit-box-shadow: 3px 4px 25px -6px rgba(0,0,0,0.75) !important;
            -moz-box-shadow: 3px 4px 25px -6px rgba(0,0,0,0.75) !important;
            box-shadow: 3px 4px 25px -6px rgba(0,0,0,0.75) !important;
        }

        /*created*/
        #icon_timeline_created:after{
            border-left: 60px solid #28a745;
        }

        /*updated*/
        #icon_timeline_updated:after {
            border-left: 60px solid #ffc107;
        }

        /*deleted*/
        #icon_timeline_deleted:after {
            border-left: 60px solid #dc3545;
        }

        /*added-account*/
        #icon_timeline_added-account:after {
            border-left: 60px solid #dc3545;
        }

        /* mail */
        #icon_timeline_send_account_infor_mail::after,#icon_timeline_send_adhoc_mail::after
        ,#icon_timeline_send_bi_anual::after, #icon_timeline_companies_list_not_validate::after,#icon_timeline_send_company_expired::after
        ,#icon_timeline_send_company_expire_soon::after, #icon_timeline_send_company_need_validate::after
        ,#icon_timeline_company_notify_new_account::after,#icon_timeline_create_pass_holder_success::after
        ,#icon_timeline_pass_holder_expired::after,#icon_timeline_pass_holder_expire_soon::after
        ,#icon_timeline_pass_holder_List_pending_return::after,#icon_timeline_pass_holder_renew::after
        ,#icon_timeline_pass_holder_terminate::after,#icon_timeline_pass_holder_valid_daily::after
        {
            border-left: 60px solid #b427e6;
        }
    </style>
@endsection

@section('after_scripts')

@endsection
