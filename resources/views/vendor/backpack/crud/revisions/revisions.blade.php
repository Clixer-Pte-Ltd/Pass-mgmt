@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            <span class="text-capitalize">Revisions</span>
            <small>Revisions</small>
        </h1>
        {{--<ol class="breadcrumb">--}}
            {{--<li><a href="{{ url(config('backpack.base.route_prefix'),'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>--}}
            {{--<li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>--}}
            {{--<li class="active">{{ trans('backpack::crud.revisions') }}</li>--}}
        {{--</ol>--}}
    </section>
@endsection

@section('content')
    <div class="row m-t-20">
        <div>
            <!-- Default box -->
            @if(!count($revisions))
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('backpack::crud.no_revisions') }}</h3>
                    </div>
                </div>
            @else
                <ul class="timeline" style="margin: 0 0 30px 10px">
                    @foreach($revisions as $revisionDate => $dateRevisions)
                        <li class="time-label" data-date="{{ date('Y-m-d', strtotime($revisionDate)) }}">
                          <span class="bg-red">
                            {{ $revisionDate }}
                          </span>
                        </li>
                        @foreach($dateRevisions as $history)
                            <li class="timeline-item-wrap">
                                @include('crud::revisions.timeline_item')
                            </li>
                        @endforeach
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection


@section('after_styles')
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/revisions.css') }}">
@endsection

@section('after_scripts')
    <script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
    <script src="{{ asset('vendor/backpack/crud/js/revisions.js') }}"></script>
@endsection