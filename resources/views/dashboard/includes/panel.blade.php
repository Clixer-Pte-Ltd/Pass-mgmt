<div class="col-xs-12 col-sm-6 col-md-3 text-center chartDashboard-box">
    <div class="row chartDashboard">
        <div class="{{ $id }} col-xs-12 col-sm-12 col-md-4 chartDashboard-lable">
            <span>
                <b>{{ $num }}/{{ $total }}</b>
            </span>
            <span>{{ $label }}</span>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-8 chartDashboard-graph">
            <canvas id="{{ $id }}"></canvas>
        </div>
    </div>
</div>