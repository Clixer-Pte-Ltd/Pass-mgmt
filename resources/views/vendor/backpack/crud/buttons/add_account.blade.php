@if ($crud->hasAccess('update'))
	<!-- Single edit button -->
	<a href="{{ url($crud->route.'/'.$entry->getKey().'/account/create') }}" class="btn btn-xs btn-success"><i class="fa fa-user"></i> Add More Account</a>
@endif