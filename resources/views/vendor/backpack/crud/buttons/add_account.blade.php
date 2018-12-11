@if ($crud->hasAccess('update'))
	<!-- Single edit button -->
	<a href="{{ url($crud->route.'/'.$entry->getKey().'/account/create') }}" class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Add More Account</a>
@endif