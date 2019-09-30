@php
    $dataHistory = $history->changes->toArray();
    $tran = $history->subject ? $history->subject->getTable() : 'crud';
    $fieldShow = $history->subject ? get_class($history->subject)::FIELD_LOG : [];
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
                    @if ($dataHistory['attributes'][$key] !== $dataHistory['old'][$key])
                        <b>{{ trans('backpack::'.$tran.'.'.$key, []) }}</b>:&emsp; from <span>&emsp;'{{ $dataHistory['old'][$key] }}'&emsp;</span> to  <span>&emsp;'{{ $dataHistory['attributes'][$key] }}'&emsp;</span>
                        <br>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
