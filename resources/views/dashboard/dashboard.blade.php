@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            <span class="text-capitalize">
                {{ trans('backpack::base.dashboard') }}<small class="content_title_header">{{ trans('backpack::base.first_page_you_see') }}</small>
            </span>
        </h1>
       <!--  <ol class="breadcrumb">
            <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">{{ trans('backpack::base.dashboard') }}</li>
        </ol> -->
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
@section('content')

    <div class="row">
        <div class="col-md-12">
            {{--    number  --}}
            <div class="box dashboard dashboardChart">
                @include('dashboard.includes.panel', ['id' => 'pass_holders_active', 'num' => $pass_holders_active->count(), 'total' => $pass_holders->count(), 'label' => 'Active Passes'])
                @include('dashboard.includes.panel', ['id' => 'pass_holders_expireIn4Weeks', 'num' => $pass_holders_expireIn4Weeks->count(), 'total' => $pass_holders->count(), 'label' => 'Expired withim 4 weeks'])
                @include('dashboard.includes.panel', ['id' => 'pass_pending_return', 'num' => $pass_pending_return->count(), 'total' => $pass_holders->count(), 'label' => 'Pass pending Return'])
            </div>
        </div>
        <div class="table_listDashboard">
            <div class="col-md-6">

                {{--Expiring Pass Within 4 Weeks--}}
                <div class="box dashboard">
                    <div class="box-header text-center">
                        <h2>Expiring Pass Within 4 Weeks</h2>
                    </div>
                    <div class="box-body dashboard">
                        <div class="table-responsive">
                            <table class="table no-margin table-striped table-hover dashboard">
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
                <div class="box dashboard">
                    <div class="box-header text-center">
                        <h2>Sub-Contractor Expiring Pass</h2>
                    </div>
                    <div class="box-body dashboard">
                        <div class="table-responsive">
                            <table class="table no-margin table-striped table-hover dashboard">
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
                <div class="box dashboard">
                    <div class="box-header text-center">
                        <h2>Black listed Pass</h2>
                    </div>
                    <div class="box-body dashboard">
                        <div class="table-responsive">
                            <table class="table no-margin table-striped table-hover dashboard">
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
        </div>
    </div>
@endsection
@section('after_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.min.js"></script>
    <script type="text/javascript">
        var newPanel = function(options, id, data, backgroundColor, hoverBackgroundColor) {
            new Chart($("#" + id), {
                type: 'doughnut',
                tooltipFillColor: "rgba(51, 51, 51, 0.55)",
                data: {
                    labels: [
                    ],
                    datasets: [{
                        data: data,
                        backgroundColor: backgroundColor,
                        hoverBackgroundColor: hoverBackgroundColor
                    }]
                },
                options: options
            });
        }
        var options = {
            // legend: false,
            responsive: false,
            tooltips: {
                enabled: false,
            }
        };
        var data1 = [{{ $pass_holders_active->count() }}, {{ $pass_holders->count() }}]
        newPanel(options, 'pass_holders_active', data1, ["#aee0f9", "#13a7fd"], ["#aee0f9", "#13a7fd"])
        var data2 = [{{ $pass_holders_expireIn4Weeks->count() }}, {{ $pass_holders->count() }}]
        newPanel(options, 'pass_holders_expireIn4Weeks', data2, ["#febf72", "#13a7fd"], ["#febf72", "#13a7fd"])
        var data3 = [{{ $pass_pending_return->count() }}, {{ $pass_holders->count() }}]
        newPanel(options, 'pass_pending_return', data3, ["#7cd5bf", "#13a7fd"], ["#7cd5bf", "#13a7fd"])
    </script>
@endsection