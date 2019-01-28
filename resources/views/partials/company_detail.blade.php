<div class="box box-widget widget-user">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header bg-aqua-active">
        <h3 class="widget-user-username">{{ $entry->name }}</h3>
        <h5 class="widget-user-desc">{{ $entry->uen }}</h5>
    </div>
    <div class="widget-user-image">
        <img class="img-circle" src="{{ asset('images/company.png') }}" alt="User Avatar">
    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-sm-4 border-right">
                <div class="description-block">
                    <h5 class="description-header">Tenancy Start Date</h5>
                    <span class="description-text">{{ custom_date_format($entry->tenancy_start_date) }}</span>
                </div>
            <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 border-right">
                <div class="description-block">
                    <h5 class="description-header">Status</h5>
                    <span class="description-text">{{ getCompanyStatus($entry->status) }}</span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4">
                <div class="description-block">
                    <h5 class="description-header">Tenancy End Date</h5>
                    <span class="description-text">{{ custom_date_format($entry->tenancy_end_date) }}</span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row text-center">
            <hr>
            @if(backpack_user()->hasRole(COMPANY_CO_ROLE))
                <a href="{{ route('crud.tenant.edit', [$entry->id]) }}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>
                <a href="{{ route('admin.tenant.account.create', [$entry->id]) }}" class="btn btn-xs btn-success"><i class="fa fa-user"></i> Add More Account</a>
                <a href="{{ route('admin.tenant.sub-constructor.create', [$entry->id]) }}" class="btn btn-xs btn-warning"><i class="fa fa-building"></i> Add More Sub Constructor</a>
            @else
                <a href="{{ route('crud.sub-constructor.edit', [$entry->id]) }}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>
                <a href="{{ route('admin.sub-constructor.account.create', [$entry->id]) }}" class="btn btn-xs btn-success"><i class="fa fa-user"></i> Add More Account</a>
            @endif
        </div>
    </div>
</div>