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
		@if (backpack_user()->hasRole(COMPANY_AS_ROLE))
			<div class="col-md-12">
				<label>Select Tenant: </label>
				<select name="tenant_select_id" style="width: 100%" class="form-control select2_tenant_ajax" id="select2_ajax_tenant_select_id">
					@foreach (backpack_user()->tenantsOfAs as $tenant)
						<option value="{{ $tenant->id }}" {{ ($tenant->id == $entry->id) ? 'selected' : '' }}>{{ $tenant->name }}</option>
					@endforeach
				</select>
			</div>
		@endif
		<div id="company_detail_content">
			@include('partials.company_detail_content', ["entry" => $entry])
		</div>
	</div>
@endsection


@section('after_styles')
	<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
	<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/show.css') }}">
	<!-- include select2 css-->
	<link href="{{ asset('vendor/adminlte/bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet"
		  type="text/css"/>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
		  rel="stylesheet" type="text/css"/>
	<style>
		@if (backpack_user()->hasRole(COMPANY_AS_ROLE))
			#company_detail_content {
				margin-top: 80px;
			}
		@endif
	</style>
	@stack('crud_show_company_styles')
@endsection

@section('after_scripts')
	<script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
    <script src="{{ asset('vendor/backpack/crud/js/show.js') }}"></script>
	<script src="{{ asset('vendor/adminlte/bower_components/select2/dist/js/select2.min.js') }}"></script>
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
	@if (backpack_user()->hasRole(COMPANY_AS_ROLE))
		<script>
            jQuery(document).ready(function($) {
                $(".select2_tenant_ajax").select2({
                    theme: "bootstrap"
                }).on('select2:select', function (e) {
                    console.log($(this).val())
                    $.ajax({
                        url: "{{ route('admin.tenant.detail.ajax') }}",
                        type: 'GET',
                        dataType: 'html',
                        data: {
                            tenant_select_id: $(this).val(),
                        }
                    }).done(function(result) {
                        $('#company_detail_content').html(result).hide().fadeIn();
                    });
                });
            });
		</script>
	@endif
	@stack('crud_show_company_scripts')
@endsection
