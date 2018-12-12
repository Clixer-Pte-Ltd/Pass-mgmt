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
	<a href="{{ starts_with(URL::previous(), url($crud->route)) ? URL::previous() : url($crud->route) }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a>

	<!-- <a href="javascript: window.print();" class="pull-right hidden-print"><i class="fa fa-print"></i></a> -->
@endif
<div class="row">
	<div class="{{ $crud->getShowContentClass() }}">

	<!-- Default box -->
	  <div class="m-t-20">
	  	@if ($crud->model->translationEnabled())
	    <div class="row">
	    	<div class="col-md-12 m-b-10">
				<!-- Change translation button group -->
				<div class="btn-group pull-right">
				  <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    {{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[$crud->request->input('locale')?$crud->request->input('locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				  	@foreach ($crud->model->getAvailableLocales() as $key => $locale)
					  	<li><a href="{{ url($crud->route.'/'.$entry->getKey()) }}?locale={{ $key }}">{{ $locale }}</a></li>
				  	@endforeach
				  </ul>
				</div>
			</div>
	    </div>
	    @else
	    @endif
	    <div class="box no-padding no-border">
			<table class="table table-striped">
		        <tbody>
		        @foreach ($crud->columns as $column)
		            <tr>
		                <td>
		                    <strong>{{ $column['label'] }}</strong>
		                </td>
                        <td>
							@if (!isset($column['type']))
		                      @include('crud::columns.text')
		                    @else
		                      @if(view()->exists('vendor.backpack.crud.columns.'.$column['type']))
		                        @include('vendor.backpack.crud.columns.'.$column['type'])
		                      @else
		                        @if(view()->exists('crud::columns.'.$column['type']))
		                          @include('crud::columns.'.$column['type'])
		                        @else
		                          @include('crud::columns.text')
		                        @endif
		                      @endif
		                    @endif
                        </td>
		            </tr>
		        @endforeach
				@if ($crud->buttons->where('stack', 'line')->count())
					<tr>
						<td><strong>{{ trans('backpack::crud.actions') }}</strong></td>
						<td>
							@include('crud::inc.button_stack', ['stack' => 'line'])
						</td>
					</tr>
				@endif
		        </tbody>
			</table>
        </div><!-- /.box-body -->
        
        <div class="box no-padding no-border">
            <h4 class="text-center">Accounts</h4>
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
							<a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="{{ route('crud.user.destroy', [$account->id]) }}" class="btn btn-xs btn-danger" data-button-type="delete"><i class="fa fa-trash"></i> Delete</a>
							<a href="{{ route('admin.tenant.account.2fa', [$entry->id, $account->id]) }}" class="btn btn-xs btn-default"><i class="fa fa-google-plus-square"></i> Config 2FA</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
	  </div><!-- /.box -->

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
	        var row = $("#tenant_account a[data-route='"+route+"']").closest('tr');

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

	                    // Remove the details row, if it is open
	                    if (row.hasClass("shown")) {
	                        row.next().remove();
	                    }

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
