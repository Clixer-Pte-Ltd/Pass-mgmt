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
                {!! $history->properties->implode('') !!}
            </div>
        </div>
    </div>
</div>
