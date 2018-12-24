<div class="row">
	<div class="col-md-12">

	<!-- Default box -->
	  <div class="m-t-20">
	    <div class="box no-padding no-border">
			<table class="table table-striped">
		        <tbody>
		            <tr>
		                <td class="col-md-4"><strong>Name</strong></td>
                        <td>{{ $entry->name }}</td>
                    </tr>
                    <tr>
		                <td><strong>Uen</strong></td>
                        <td>{{ $entry->uen }}</td>
                    </tr>
                    <tr>
		                <td><strong>Tenancy Start Date</strong></td>
                        <td>{{ custom_date_format($entry->tenancy_start_date) }}</td>
                    </tr>
                    <tr>
		                <td><strong>Tenancy End Date</strong></td>
                        <td>{{ custom_date_format($entry->tenancy_end_date) }}</td>
                    </tr>
                    <tr>
		                <td><strong>Actions</strong></td>
                        <td>
                            @if(backpack_user()->hasRole(TENANT_ROLE))
                                <a href="{{ route('crud.tenant.edit', [$entry->id]) }}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>
                                <a href="{{ route('admin.tenant.account.create', [$entry->id]) }}" class="btn btn-xs btn-success"><i class="fa fa-user"></i> Add More Account</a>
                                <a href="{{ route('admin.tenant.sub-constructor.create', [$entry->id]) }}" class="btn btn-xs btn-warning"><i class="fa fa-building"></i> Add More Sub Constructor</a>
                            @else
                                <a href="{{ route('crud.sub-constructor.edit', [$entry->id]) }}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>
                                <a href="{{ route('admin.sub-constructor.account.create', [$entry->id]) }}" class="btn btn-xs btn-success"><i class="fa fa-user"></i> Add More Account</a>
                            @endif
                        </td>
                    </tr>
		        </tbody>
			</table>
        </div><!-- /.box-body -->
	  </div><!-- /.box -->
	</div>
</div>