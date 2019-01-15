@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
        <span class="text-capitalize">My Company</span>
      </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li class="active">My Company</li>
	  </ol>
	</section>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-4">
				@include('partials.company_detail', ["entry" => $entry])
			</div>
			<div class="col-md-8">
				@include('partials.tenant_detail', ["entry" => $entry])
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
