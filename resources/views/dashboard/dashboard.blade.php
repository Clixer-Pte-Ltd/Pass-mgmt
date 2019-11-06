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
        <div class="col-md-6">
            {{--    number  --}}
            <div class="box dashboard dashboardChart">
                @include('dashboard.includes.panel', ['id' => 'pass_holders_active', 'num' => $active_count, 'total' => $total_pass, 'label' => 'Active Passes'])
                @include('dashboard.includes.panel', ['id' => 'pass_holders_expireIn4Weeks', 'num' => $count_pass_holders_expireIn4Weeks, 'total' => $total_pass, 'label' => 'Expired within 4 weeks'])
                @include('dashboard.includes.panel', ['id' => 'pass_pending_return', 'num' => $pass_pending_return_count, 'total' => $total_pass, 'label' => 'Pass pending Return'])
                @if (backpack_user()->hasAnyRole(config('backpack.cag.roles')))
                    @include('dashboard.includes.panel', ['id' => 'expiring_tenants_within_4_weeks', 'num' => $expiring_tenants_within_4_weeks_count, 'total' => $total_company, 'label' => 'Expiring tenants within 4 weeks'])
                @endif
                <div class="col-md-12">
                    <div class="wrapper">
                        <canvas id="myChart"></canvas>
                    </div>
                    <a href="https://vanila.io" target="_blank">vanila.io</a>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="table_listDashboard">
                <div class="col-md-12">
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
                                        <th>Pass Number</th>
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
                <div class="col-md-12">

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
                                        <th>Contact</th>
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
                <div class="col-md-12">
                    {{--Black listed Pass--}}
                    <div class="box dashboard">
                        <div class="box-header text-center">
                            <h2>De-List Pass</h2>
                        </div>
                        <div class="box-body dashboard">
                            <div class="table-responsive">
                                <table class="table no-margin table-striped table-hover dashboard">
                                    <thead class="bg-primary">
                                    <tr>
                                        <th>Name</th>
                                        <th>Pass Number</th>
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
                @if (backpack_user()->hasAnyRole(config('backpack.cag.roles')))
                    <div class="col-md-12">
                        {{--Expiring Company Within 4 Weeks--}}
                        <div class="box dashboard">
                            <div class="box-header text-center">
                                <h2>Expiring tenants within 4 weeks</h2>
                            </div>
                            <div class="box-body dashboard">
                                <div class="table-responsive">
                                    <table class="table no-margin table-striped table-hover dashboard">
                                        <thead class="bg-primary">
                                        <tr>
                                            <th>Name</th>
                                            <th>Uen</th>
                                            <th>Type</th>
                                            <th>Tenancy Start Date</th>
                                            <th>Tenancy End Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($expiring_tenants_within_4_weeks as $company)
                                            <tr>
                                                <td>{{ $company->name }}</td>
                                                <td>{{ $company->uen }}</td>
                                                <td>{{ getTypeAttribute(get_class($company)) }}</td>
                                                <td>{{ custom_date_format($company->tenancy_start_date) }}</td>
                                                <td>{{ custom_date_format($company->tenancy_end_date) }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('after_scripts')
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/bower_components/moment/moment.js') }}"></script>
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
            responsive: true,
            tooltips: {
                enabled: false,
            }
        };
        var data1 = [{{ $active_count }}, {{ $total_pass }}]
        newPanel(options, 'pass_holders_active', data1, ["#aee0f9", "#13a7fd"], ["#aee0f9", "#13a7fd"])
        var data2 = [{{ $pass_holders_expireIn4Weeks->count() }}, {{ $total_pass }}]
        newPanel(options, 'pass_holders_expireIn4Weeks', data2, ["#febf72", "#fb9e1b"], ["#febf72", "#fb9e1b"])
        var data3 = [{{ $pass_pending_return_count }}, {{ $total_pass }}]
        newPanel(options, 'pass_pending_return', data3, ["#7cd5bf", "#00bc8c"], ["#7cd5bf", "#00bc8c"])
        @if (backpack_user()->hasAnyRole(config('backpack.cag.roles')))
        var data4 = [{{ $expiring_tenants_within_4_weeks_count }}, {{ $total_company  }}]
        newPanel(options, 'expiring_tenants_within_4_weeks', data4, ["#dd8f8f", "#d75c5c"], ["#dd8f8f", "#d75c5c"])
        @endif

    </script>

    <script>
        var ctx = document.getElementById('myChart').getContext("2d");

        var gradientStroke1 = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke1.addColorStop(0, '#13a6fd');
        gradientStroke1.addColorStop(1, '#c7f2f4');

        var gradientFill1 = ctx.createLinearGradient(500, 0, 100, 0);
        gradientFill1.addColorStop(0, "rgba(128, 182, 244, 0.1)");
        gradientFill1.addColorStop(1, "rgba(244, 144, 128, 0.1)");


        var gradientStroke2 = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke2.addColorStop(0, '#d75b5c');
        gradientStroke2.addColorStop(1, '#f4dbf1');

        var gradientFill2 = ctx.createLinearGradient(500, 0, 100, 0);
        gradientFill2.addColorStop(0, "rgba(128, 182, 244, 0.1)");
        gradientFill2.addColorStop(1, "rgba(244, 144, 128, 0.1)");

        var dateNow = Date.now();
        var date = [];
        for (i = 6; i >= 0 ; i--) {
            date.push(moment(dateNow).subtract(i , 'day').format("YYYY/MM/DD"))
        }

        var pass_holders_expireIn4Weeks_count = @json($pass_holders_expireIn4Weeks_count);
        var pass_holders_active_count = @json($pass_holders_active_count);

        if (pass_holders_expireIn4Weeks_count.length < 7) {
            pass_holders_expireIn4Weeks_count.unshift(...Array(7-pass_holders_expireIn4Weeks_count.length).fill(0))
        }

        if (pass_holders_active_count.length < 7) {
            pass_holders_active_count.unshift(...Array(7-pass_holders_active_count.length).fill(0))
        }
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: date,
                datasets: [
                    {
                        label: "No Pass Active",
                        borderColor: gradientStroke1,
                        pointBorderColor: gradientStroke1,
                        pointBackgroundColor: gradientStroke1,
                        pointHoverBackgroundColor: gradientStroke1,
                        pointHoverBorderColor: gradientStroke1,
                        pointBorderWidth: 10,
                        pointHoverRadius: 10,
                        pointHoverBorderWidth: 1,
                        pointRadius: 3,
                        fill: true,
                        backgroundColor: gradientFill1,
                        borderWidth: 4,
                        data: pass_holders_active_count
                    },
                    {
                        label: "No Pass Expiring",
                        borderColor: gradientStroke2,
                        pointBorderColor: gradientStroke2,
                        pointBackgroundColor: gradientStroke2,
                        pointHoverBackgroundColor: gradientStroke2,
                        pointHoverBorderColor: gradientStroke2,
                        pointBorderWidth: 10,
                        pointHoverRadius: 10,
                        pointHoverBorderWidth: 1,
                        pointRadius: 3,
                        fill: true,
                        backgroundColor: gradientFill2,
                        borderWidth: 4,
                        data: pass_holders_expireIn4Weeks_count
                    }
                ]},
            options: {
                legend: {
                    position: "bottom"
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            fontColor: "rgba(0,0,0,0.5)",
                            fontStyle: "bold",
                            beginAtZero: true,
                            maxTicksLimit: 5,
                            padding: 20,
                            min:0,
                            max: Math.max(...pass_holders_expireIn4Weeks_count, ...pass_holders_active_count) + 1,
                            stepSize: 1,
                        },
                        gridLines: {
                            drawTicks: false,
                            display: false
                        }

                    }],
                    xAxes: [{
                        gridLines: {
                            zeroLineColor: "transparent"
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "rgba(0,0,0,0.5)",
                            fontStyle: "bold",
                            beginAtZero: true,
                        }
                    }]
                }
            }
        });
    </script>
@endsection
