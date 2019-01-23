@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            {{ trans('backpack::base.dashboard') }}<small>{{ trans('backpack::base.first_page_you_see') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">{{ trans('backpack::base.dashboard') }}</li>
        </ol>
    </section>
@endsection

@section('before_styles')
    <style>
        div.statistical i {
            -webkit-transition: font-size 2s; /* For Safari 3.1 to 6.0 */
            transition: font-size 0.5s;
        }
        div.statistical:hover i  {
            font-size: 90px;
        }
    </style>
@endsection
@php
    use Carbon\Carbon;

    $pass_holders_expireIn4Weeks = $pass_holders->where('pass_expiry_date','<=', Carbon::now()->addWeeks(4))->where('pass_expiry_date','>', Carbon::now());
@endphp
@section('content')
    <div class="row">
        <div class="col-md-12">

            {{--    number  --}}
            <div class="box" style="color:#ffffff">
                <div class="row">
                    {{--Active Pass--}}
                    @include('dashboard.includes.panel',
                    ['background_color' => 'rgb(64, 199, 95)',
                    'icon' => 'fa fa-child',
                    'number' => $pass_holders->where('status', PASS_STATUS_VALID)->count(),
                    'title' => 'Active Pass'])

                    {{--Pass Expiring Within 4 Weeks--}}
                    @include('dashboard.includes.panel',
                    ['background_color' => 'rgb(223, 67, 49)', 'icon' => 'fa fa-user-times',
                    'number' => $pass_holders_expireIn4Weeks->count(),
                    'title' => 'Pass Expiring Within 4 Weeks'])

                    {{--Pending Return--}}
                    @include('dashboard.includes.panel',
                    ['background_color' => '#337ab7',
                    'icon' => 'fa fa-mail-reply',
                    'number' => $pass_holders->where('status', PASS_STATUS_TERMINATED)->count(),
                    'title' => 'Expired Pending Return'])
                </div>
            </div>
        </div>
        <div class="col-md-6">

            {{--Expiring Pass Within 4 Weeks--}}
            <div class="box">
                <div class="box-header text-center">
                    <h2>Expiring Pass Within 4 Weeks</h2>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin table-striped table-hover">
                            <thead class="bg-primary">
                            <tr>
                                <th>Name</th>
                                <th>NRIC</th>
                                <th>Issue Date</th>
                                <th>Expiry Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pass_holders_expireIn4Weeks as $pass)
                                <tr>
                                    <td>{{ $pass->applicant_name }}</td>
                                    <td>{{ $pass->nric }}</td>
                                    <td>{{ custom_date_format($pass->created_at) }}</td>
                                    <td>{{ custom_date_format($pass->pass_expiry_date) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">

            {{--Sub-Contractor Expiring Pass--}}
            <div class="box">
                <div class="box-header text-center">
                    <h2>Sub-Contractor Expiring Pass</h2>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin table-striped table-hover">
                            <thead class="bg-primary">
                            <tr>
                                <th>Name</th>
                                <th>Tenant/Sub-Contractor</th>
                                <th>Contac</th>
                                <th>Expiry Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pass_holders_expireIn4Weeks as $pass)
                                <tr>
                                    <td>{{ $pass->applicant_name }}</td>
                                    <td>{{ isset($pass->company) ? $pass->company->name : '' }}</td>
                                    <td>{{ custom_date_format($pass->created_at) }}</td>
                                    <td>{{ custom_date_format($pass->pass_expiry_date) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            {{--Black listed Pass--}}
            <div class="box">
                <div class="box-header text-center">
                    <h2>Black listed Pass</h2>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin table-striped table-hover">
                            <thead class="bg-primary">
                            <tr>
                                <th>Name</th>
                                <th>NRIC</th>
                                <th>Issue Date</th>
                                <th>Expiry Date</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($pass_holders->where('status', PASS_STATUS_BLACKLISTED) as $pass)
                                    <tr>
                                        <td>{{ $pass->applicant_name }}</td>
                                        <td>{{ $pass->nric }}</td>
                                        <td>{{ custom_date_format($pass->created_at) }}</td>
                                        <td>{{ custom_date_format($pass->pass_expiry_date) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            {{--Pass Pending Return--}}
            <div class="box">
                <div class="box-header text-center">
                    <h2>Pass Pending Return</h2>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead class="bg-primary">
                            <tr>
                                <th>Name</th>
                                <th>NRIC</th>
                                <th>Issue Date</th>
                                <th>Expiry Date</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($pass_holders->where('status', PASS_STATUS_TERMINATED) as $pass)
                                    <tr>
                                        <td>{{ $pass->applicant_name }}</td>
                                        <td>{{ $pass->nric }}</td>
                                        <td>{{ custom_date_format($pass->created_at) }}</td>
                                        <td>{{ custom_date_format($pass->pass_expiry_date) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
