@if ($crud->hasAccess('update'))
	<!-- Single edit button -->
	<a href="{{ url($crud->route.'/'.$entry->getKey().'/account/create') }}" class="btn btn-success grad-success"><i class="fa fa-user"></i> Add More Account</a>
@endif