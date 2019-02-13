{{-----------------------dashboard------------------}}
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>

{{-----------------------tenant, subcontructor-------------------}}
@if(auth()->user()->hasAnyRole(config('backpack.cag.roles')))
<li class="treeview">
    <a href="#"><i class="fa fa-university"></i> <span>Companies</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
      <li><a href='{{ backpack_url('tenant') }}'><i class='fa fa-list'></i> <span>Tenants</span></a></li>
      <li><a href='{{ backpack_url('sub-constructor') }}'><i class='fa fa-building'></i> <span>Sub Constructors</span></a></li>
      <li><a href='{{ backpack_url('expired-company') }}'><i class='fa fa-bell-slash'></i> <span>Expired Companies</span></a></li>
    </ul>
</li>
<li class="treeview">
    <a href="#"><i class="fa fa-folder-open"></i> <span>Pass Holders</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href='{{ backpack_url('zone') }}'><i class='fa fa-th-list'></i> <span>Zones</span></a></li>
        <li><a href='{{ backpack_url('pass-holder') }}'><i class='fa fa-credit-card'></i> <span>Valid Pass Holders</span></a></li>
        <li><a href='{{ backpack_url('expire-pass-holder') }}'><i class='fa fa-user-times'></i> <span>Expiring Pass Holder</span></a></li>
        <li><a href='{{ backpack_url('blacklist-pass-holder') }}'><i class='fa fa-exclamation-circle'></i> <span>Expired Pass Holders</span></a></li>
        <li><a href='{{ backpack_url('return-pass-holder') }}'><i class='fa fa-exchange'></i> <span>Returned Pass Holders</span></a></li>
    </ul>
</li>
<li class="treeview">
    <a href="#"><i class="fa fa-bell"></i> <span>Communications</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
      <li><a href='{{ backpack_url('adhoc-email') }}'><i class='fa fa-envelope'></i> <span>Send Email Messages</span></a></li>
    </ul>
</li>
@endif

{{-------------------pass holder, my company--------------}}
@if(auth()->user()->hasAnyRole(config('backpack.company.roles')))
    <li><a href='{{ route("admin.tenant.my-company") }}'><i class='fa fa-building'></i> <span>My Company</span></a></li>
    <li class="treeview">
        <a href="#"><i class="fa fa-folder-open"></i> <span>Pass Holders Management</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href='{{ backpack_url('tenant-pass-holder') }}'><i class='fa fa-credit-card'></i> <span>Valid Pass Holders</span></a></li>
            <li><a href='{{ backpack_url('tenant-expire-pass-holder') }}'><i class='fa fa-user-times'></i> <span>Expiring Pass Holder</span></a></li>
            <li><a href='{{ backpack_url('tenant-blacklist-pass-holder') }}'><i class='fa fa-exclamation-circle'></i> <span>Expired Pass Holders</span></a></li>
            <li><a href='{{ backpack_url('tenant-return-pass-holder') }}'><i class='fa fa-exchange'></i> <span>Returned Pass Holders</span></a></li>
        </ul>
    </li>
@endif

{{-------------------user-----------------------}}
@if(auth()->user()->hasAnyRole([CAG_ADMIN_ROLE, COMPANY_CO_ROLE]))
<li class="treeview">
    <a href="#"><i class="fa fa-users"></i> <span>Users Management</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
      <li><a href="{{ backpack_url('user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
        @if(auth()->user()->hasAnyRole([CAG_ADMIN_ROLE]))
            <li><a href="{{ backpack_url('role') }}"><i class="fa fa-key"></i> <span>Roles</span></a></li>
        @endif
      <!-- <li><a href="{{ backpack_url('permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li> -->
    </ul>
</li>
@endif

{{-------------------revisions-----------------------}}
<li><a href="{{ backpack_url('revisions/list') }}"><i class="fa fa-sticky-note-o"></i> <span>Revisions</span></a></li>

{{-------------------setting-----------------------}}
@if(auth()->user()->hasAnyRole([CAG_ADMIN_ROLE]))
    <li class="header text-center">SETTING</li>
    <li><a href="{{ backpack_url('settings/revisions') }}"><i class="fa fa-asterisk"></i> <span>Revisions Setting</span></a></li>
    <li class="treeview">
        <a href="#"><i class="fa fa-envelope"></i> <span>Email</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{ backpack_url('settings/smtp') }}"><i class="fa fa-comments"></i> <span>SMTP Server</span></a></li>
            <li><a href="{{ backpack_url('settings/frequency-email') }}"><i class="fa fa-refresh"></i> <span>Frequency Send</span></a></li>
        </ul>
    </li>
@endif

