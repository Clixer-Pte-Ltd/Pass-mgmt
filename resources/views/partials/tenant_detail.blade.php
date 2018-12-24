<div class="row">
	<div class="{{ backpack_user()->hasRole(TENANT_ROLE) ? 'col-md-6' : 'col-md-12' }}">
		<div class="box no-padding no-border">
			<h4 class="text-center"><i class="fa fa-user"></i> Accounts</h4>
			<table class="table table-striped table-bordered" id="tenant_account">
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($entry->accounts as $account)
					<tr>
						<td>{{ $account->name }}</td>
						<td>{{ $account->email }}</td>
						<td>{{ $account->phone }}</td>
						<td>
                            @if($account->id !== auth()->user()->id)
                                <a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="{{ route('crud.user.destroy', [$account->id]) }}" class="btn btn-xs btn-danger" data-button-type="delete"><i class="fa fa-trash"></i> Delete</a>
                            @endif
							<a href="{{ route('admin.tenant.account.2fa', [$entry->id, $account->id]) }}" class="btn btn-xs btn-default"><i class="fa fa-google-plus-square"></i> Config 2FA</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	@if(backpack_user()->hasRole(TENANT_ROLE))
	<div class="col-md-6">
		<div class="box no-padding no-border">
			<h4 class="text-center"><i class="fa fa-building"></i> Sub Constructors</h4>
			<table class="table table-striped table-bordered" id="tenant_account">
				<thead>
					<tr>
						<th>Name</th>
						<th>Uen</th>
						<th>Tenancy Start Date</th>
						<th>Tenancy End Date</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($entry->subContructors as $company)
					<tr>
						<td>{{ $company->name }}</td>
						<td>{{ $company->uen }}</td>
						<td>{{ custom_date_format($company->tenancy_start_date) }}</td>
						<td>{{ custom_date_format($company->tenancy_end_date) }}</td>
						<td>
							<a href="{{ route('crud.sub-constructor.show', [$company->id]) }}" class="btn btn-xs btn-default"><i class="fa fa-eye"></i> Detail</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	@endif
</div>