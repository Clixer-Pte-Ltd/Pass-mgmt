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
    @default
        <i class="fa fa-calendar bg-default icon_timeline" id="icon_timeline_default" style="color: #ffffff; background-color: #dc3545"></i>
@endswitch
{{--content--}}

{{--created--}}
@if ($history->description == 'created')
    <div class="timeline-item"  id="timeline-created">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            <span href="#"> {{ $history->causer->name }} </span>
            {{ $history->description }}
            <span href="#"> {{ getTypeAttribute($history->subject_type) }} </span>
        </h3>
        <div style="padding: 10px">
            <div class="timeline-body p-b-0">
                @php
                    $dataHistory = $history->changes->toArray();
                @endphp
                {{ $history->causer->name }} created new {{ getTypeAttribute($history->subject_type) }} with detail: <br>

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
        <span href="#"> {{ $history->causer->name }} </span>
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
            <span href="#"> {{ $history->causer->name }} </span>
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

{{--created--}}
@if ($history->description == 'added-account')
    <div class="timeline-item"  id="timeline-added-account">
        <span class="time" style="font-size: 1.1em"><i class="fa fa-clock-o" style="font-size: 1.5em"></i> {{ date('h:ia', strtotime($history->created_at)) }}</span>
        <h3 class="timeline-header">
            <span href="#"> {{ $history->causer->name }} </span>
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
        #icon_timeline_created:after {
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
    </style>
@endsection

@section('after_scripts')

@endsection
