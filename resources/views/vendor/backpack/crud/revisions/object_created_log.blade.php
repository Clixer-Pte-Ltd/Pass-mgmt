@php
    $dataHistory = $history->changes->toArray();
    $tran = $history->subject_type ? (new $history->subject_type)->getTable() : 'crud';
    $fieldShow = $history->subject_type::FIELD_LOG ?? [];
@endphp
<div style="padding: 10px">
    <div class="timeline-body p-b-0">
        <p>
            <button class="btn btn-primary" type="button" data-toggle="collapse"
                    data-target="#history_{{ $history->id }}" aria-expanded="false"
                    aria-controls="history_{{ $history->id }}">
                Show content
            </button>
        </p>
        <div class="collapse" id="history_{{ $history->id }}">
            <div class="card card-body">
                @foreach(array_keys($dataHistory['attributes']) as $key)
                    @if (in_array($key, $fieldShow))
                        <b>{{ trans('backpack::'.$tran.'.'.$key, []) }}</b>:&emsp; {{ $dataHistory['attributes'][$key] }}
                        <br>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
