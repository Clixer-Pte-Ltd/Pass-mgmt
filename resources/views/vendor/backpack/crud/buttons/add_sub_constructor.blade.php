@if ($crud->hasAccess('update'))
	<!-- Single edit button -->
	<a href="{{ url($crud->route.'/'.$entry->getKey().'/sub-constructor/create') }}" class="btn btn-warning grad-warning"><i class="fa fa-building"></i> Add More Sub Contractor</a>
@endif
