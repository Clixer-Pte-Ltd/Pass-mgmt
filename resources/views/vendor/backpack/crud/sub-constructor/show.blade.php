@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')).' '.$crud->entity_name !!}.</small>
      </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.preview') }}</li>
	  </ol>
	</section>
@endsection

@section('content')
@if ($crud->hasAccess('list'))
	@if(session()->has(SESS_TENANT_MY_COMPANY))
		<a href="{{ route('admin.tenant.my-company') }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back</a>
	@else
		@if(session()->has(SESS_TENANT_SUB_CONSTRUCTOR))
			<a href="{{ route('crud.tenant.show', [session()->get(SESS_TENANT_SUB_CONSTRUCTOR)]) }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back</a>
		@else
			<a href="{{ starts_with(URL::previous(), url($crud->route)) ? URL::previous() : url($crud->route) }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a>
		@endif
	@endif

	<!-- <a href="javascript: window.print();" class="pull-right hidden-print"><i class="fa fa-print"></i></a> -->
@endif
<div class="row">
	<div class="col-md-12">
		<div class="col-md-4">
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
						@include('crud::inc.button_stack', ['stack' => 'line'])
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="row">
				<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
								<li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-users"></i> Accounts Registered</a></li>
								<li><a href="#tab_2" data-toggle="tab"><i class="fa fa-users"></i> Account Pending Register </a></li>
						</ul>
						<div class="tab-content">
								<div class="tab-pane active" id="tab_1">
										<div class="row">
											<div class="box no-padding no-border">
												@foreach($entry->accounts()->whereNotNull('phone')->get() as $account)
														<div class="col-md-6">
															<div class="info-box bg-green">
																	<span class="info-box-icon"><i class="fa fa-user"></i></span>

																	<div class="info-box-content">
																			<span class="info-box-text">{{ $account->name }} / {{ $account->phone }}</span>
																			<span class="info-box-number">{{ $account->email }}</span>
																			<span class="text-right info-box-text">
																				<a href="{{ route('admin.sub-constructor.account.2fa', [$entry->id, $account->id]) }}" class="btn btn-xs btn-default"><i class="fa fa-google-plus-square"></i> Config 2FA</a>
																				@if($account->id !== auth()->user()->id)
																					<a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="{{ route('crud.user.destroy', [$account->id]) }}" class="btn btn-xs btn-danger" data-button-type="delete"><i class="fa fa-trash"></i> Delete</a>
																				@endif
																			</span>

																	</div>
																	<!-- /.info-box-content -->
															</div>
														</div>


												@endforeach

											</div>
										</div>
								</div>

								<div class="tab-pane" id="tab_2">
									<div class="row">
										<div class="box no-padding no-border">
											@foreach($entry->accounts()->whereNull('phone')->get() as $account)
												<div class="col-md-6">
													<div class="info-box bg-green">
														<span class="info-box-icon"><i class="fa fa-user"></i></span>

														<div class="info-box-content">
															<span class="info-box-text">{{ $account->name }} / {{ $account->phone }}</span>
															<span class="info-box-number">{{ $account->email }}</span>
															<span class="text-right info-box-text">
																@if($account->id !== auth()->user()->id)
																	<a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="{{ route('crud.user.destroy', [$account->id]) }}" class="btn btn-xs btn-danger" data-button-type="delete"><i class="fa fa-trash"></i> Delete</a>
																@endif
															</span>

														</div>
														<!-- /.info-box-content -->
													</div>
												</div>


											@endforeach

										</div>
									</div>
								</div>
								<!-- /.tab-pane -->
						</div>
						<!-- /.tab-content -->
				</div>

			</div>
		</div>
	

	</div>
</div>
@endsection


@section('after_styles')
	<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
	<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/show.css') }}">
@endsection

@section('after_scripts')
	<script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
    <script src="{{ asset('vendor/backpack/crud/js/show.js') }}"></script>
    <script>
	if (typeof deleteEntry != 'function') {
	    $("[data-button-type=delete]").unbind('click');

	    function deleteEntry(button) {
	        // ask for confirmation before deleting an item
	        // e.preventDefault();
	        var button = $(button);
	        var route = button.attr('data-route');
	        var row = $("a[data-route='"+route+"']").closest('div.col-md-6');

	        if (confirm("Are you sure you want to delete this item?") == true) {
	            $.ajax({
	                url: route,
	                type: 'DELETE',
	                success: function(result) {
	                    // Show an alert with the result
	                    new PNotify({
	                        title: "Item Deleted",
	                        text: "The item has been deleted successfully.",
	                        type: "success"
	                    });

	                    // Hide the modal, if any
	                    $('.modal').modal('hide');

	                    // Remove the row from the datatable
	                    row.remove();
	                },
	                error: function(result) {
	                    // Show an alert with the result
	                    new PNotify({
	                        title: "NOT deleted",
	                        text: "There&#039;s been an error. Your item might not have been deleted.",
	                        type: "warning"
	                    });
	                }
	            });
	        } else {
	      	    // Show an alert telling the user we don't know what went wrong
	            new PNotify({
	                title: "Not deleted",
	                text: "Nothing happened. Your item is safe.",
	                type: "info"
	            });
	        }
        }
	}

	// make it so that the function above is run after each DataTable draw event
	// crud.addFunctionToDataTablesDrawEventQueue('deleteEntry');
</script>
@endsection
