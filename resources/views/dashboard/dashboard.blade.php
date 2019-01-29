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
@php
    use Carbon\Carbon;

    $pass_holders_expireIn4Weeks = $pass_holders->where('pass_expiry_date','<=', Carbon::now()->addWeeks(4))->where('pass_expiry_date','>', Carbon::now());
@endphp
@section('content')

    <div class="row">
        <div class="col-md-12">

            {{--    number  --}}
            <div class="box dashboard dashboardChart">
                {{--Active Pass--}}
                @include('dashboard.includes.panel')

                {{--Pass Expiring Within 4 Weeks--}}
                @include('dashboard.includes.panel1')

                {{--Pending Return--}}
                @include('dashboard.includes.panel2')
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
        var options = {
            // legend: false,
            responsive: false
        };
        new Chart($("#canvas1"), {
            type: 'doughnut',
            tooltipFillColor: "rgba(51, 51, 51, 0.55)",
            data: {
            labels: [
                
            ],
            datasets: [{
            data: [10, 80],
            backgroundColor: [
                "#aee0f9",
                "#13a7fd",
            ],
            hoverBackgroundColor: [
                "#aee0f9",
                "#13a7fd",
            ]
            }]
        },
            options: { responsive: false }
        });     
        new Chart($("#canvas2"), {
            type: 'doughnut',
            tooltipFillColor: "rgba(51, 51, 51, 0.55)",
            data: {
            labels: [
                
            ],
            datasets: [{
            data: [10, 80],
            backgroundColor: [
                "#febf72",
                "#fc9d29",
            ],
            hoverBackgroundColor: [
                "#febf72",
                "#fc9d29",
            ]
            }]
        },
            options: { responsive: false }
        }); 
        new Chart($("#canvas3"), {
            type: 'doughnut',
            tooltipFillColor: "rgba(51, 51, 51, 0.55)",
            data: {
            labels: [
                
            ],
            datasets: [{
            data: [10, 80],
            backgroundColor: [
                "#7cd5bf",
                "#00be8e",
            ],
            hoverBackgroundColor: [
                "#7cd5bf",
                "#00be8e",
            ]
            }]
        },
            options: { responsive: false }
        });       

    </script>
@endsection