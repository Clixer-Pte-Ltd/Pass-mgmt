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
			<select name="tenant_select_id" style="width: 100%" class="form-control select2_tenant_ajax" id="select2_ajax_tenant_select_id">
				@foreach (backpack_user()->tenants as $tenant)
					<option value="{{ $tenant->id }}" {{ ($tenant->id == $entry->id) ? 'selected' : '' }}>{{ $tenant->name }}</option>
				@endforeach
			</select>
		</div>
		@include('partials.company_detail_content', ["entry" => $entry])
	</div>
@endsection


@section('after_styles')
	<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
	<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/show.css') }}">
	@stack('crud_mycompany_styles')
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

	<script>
        jQuery(document).ready(function($) {
            // trigger select2 for each untriggered select2 box
            $("#select2_ajax_tenant_select_id").each(function (i, obj) {
                var form = $(obj).closest('form');

                if (!$(obj).hasClass("select2-hidden-accessible"))
                {
                    $(obj).select2({
                        theme: 'bootstrap',
                        multiple: false,
						{{-- allow clear --}}
						allowClear: true,
                        ajax: {
                            url: "{{ route('admin.tenant.detail.ajax') }}",
                            type: 'GET',
                            dataType: 'html',
                            quietMillis: 250,
                            data: function (params) {
                                return {
                                    tenant_select_id: params.tenant_select_id, // search term
                                };
                            },
                            processResults: function (data, params) {
                                console.log(data)
                                return result;
                            },
                            cache: true
                        },
                    }).on('select2:unselecting', function(e) {
                            $(this).val('').trigger('change');
                            // console.log('cleared! '+$(this).val());
                            e.preventDefault();
                        })
                    ;

                }
            });
        });
	</script>

	@stack('crud_mycompany_scripts')
@endsection
