<div class="col-xs-12 col-sm-4 col-md-4 text-center ">
    <div class="chartDashboard">
        <div class="{{ $id }}">
            <p>
                {{ $num }}/{{ $total }}
            </p>
            <p>{{ $label }}</p>
        </div>
        <canvas id="{{ $id }}" width="200" height="200"></canvas>
    </div>
</div>