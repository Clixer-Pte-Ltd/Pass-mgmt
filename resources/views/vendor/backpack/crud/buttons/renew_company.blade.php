@if ($crud->hasAccess('update'))
    <!-- Single edit button -->
    <a href="{{ route('admin.expired-company.renew', [$entry->getKey()]) }}" class="btn btn-xs btn-success"><i class="fa fa-user"></i> Renew</a>
@endif