@extends('backpack::layout_guest')

@section('content')
    <div class="row" style="padding: 10px">
        @php
            $errorsData = $errors->groupBy('code')
        @endphp
        @foreach($errorsData as $error)
            <table class="table fixed_header" style="background: #fff; font-size: 0.8em">
                <thead>
                @php

                    $first = $error->first();
                    $headers = json_decode($first->header, true);
                    $fileName = $first->name;
                    $time = $first->time;
                    $errorRow = $error->pluck('errors');
                @endphp
                <tr style="display:block;">
                    <th scope="col">Time import</th>
                    <th scope="col">File Name</th>
                    @foreach($headers as $header)
                        <th scope="col">{{ $header }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($errorRow as $row)
                    @php
                        $rows = json_decode($row, true);
                    @endphp
                    @foreach($rows as $row)
                        <tr>
                            <td>{{ $time }}</td>
                            <td>{{ $fileName }}</td>
                            @foreach($row as $cell)
                                <td>{{ $cell }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        @endforeach
    </div>
    {{ $errors->links() }}
@endsection

@push('after_styles')
    <style>
        .fixed_header{
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }
        .fixed_header tbody{
            display:block;
            width: 100%;
            overflow: auto;
            height: 500px;
        }
        .fixed_header thead tr {
            display: block;
        }
        .fixed_header thead {
            background: #a30d0d;
            color:#fff;
        }
        .fixed_header th, .fixed_header td {
            padding: 5px;
            text-align: left;
            width: 200px;
        }

    </style>
@endpush
