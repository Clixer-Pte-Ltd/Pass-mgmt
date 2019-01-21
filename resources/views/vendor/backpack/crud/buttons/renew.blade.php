@if ($crud->hasAccess('update'))
	<!-- Single edit button -->
	<a href="{{ route('admin.blacklist-pass-holder.renew', [$entry->getKey()]) }}" class="btn btn-success grad-success"><i class="fa fa-user"></i> Renew</a>
@endif