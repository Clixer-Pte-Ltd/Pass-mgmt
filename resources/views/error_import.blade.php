@extends('backpack::layout_guest')

@section('content')
    <div class="row" style="padding: 10px;overflow-y: scroll; height:500px;">
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
                <tr>
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
                            @php
                                $len = count($row);
                            @endphp
                            @foreach($row as $key => $cell)
                                <td>{{ strlen($cell) > 15 && ($key + 1) != $len ? substr($cell,0,12).'...' : $cell }}</td>
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
        .fixed_header thead {
            background: #a30d0d;
            color:#fff;
        }
    </style>
@endpush
