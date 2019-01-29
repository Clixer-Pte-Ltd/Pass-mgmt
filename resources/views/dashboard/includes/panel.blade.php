<div class="col-xs-4 text-center ">
    <div class="chartDashboard">
        <div class="title_chart">
            <p>
                {{ $num }}/{{ $total }}
            </p>
            <p>{{ $label }}</p>
        </div>
        <canvas id="{{ $id }}" width="200" height="200"></canvas>
    </div>
</div>