<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
<!-- <li><a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li> -->
@if(auth()->user()->hasAnyRole([ADMIN_ROLE, AIRPORT_TEAM_ROLE]))
<li class="treeview">
    <a href="#"><i class="fa fa-university"></i> <span>Companies Management</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
      <li><a href='{{ backpack_url('tenant') }}'><i class='fa fa-list'></i> <span>Tenants</span></a></li>
      <li><a href='{{ backpack_url('sub-constructor') }}'><i class='fa fa-building'></i> <span>Sub Constructors</span></a></li>
      <li><a href='{{ backpack_url('expired-company') }}'><i class='fa fa-bell-slash'></i> <span>Expired Companies</span></a></li>
    </ul>
</li>
<li class="treeview">
    <a href="#"><i class="fa fa-folder-open"></i> <span>Pass Holders Management</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href='{{ backpack_url('zone') }}'><i class='fa fa-th-list'></i> <span>Zones</span></a></li>
        <li><a href='{{ backpack_url('pass-holder') }}'><i class='fa fa-credit-card'></i> <span>Valid Pass Holders</span></a></li>
        <li><a href='{{ backpack_url('blacklist-pass-holder') }}'><i class='fa fa-exclamation-circle'></i> <span>Blacklist Pass Holders</span></a></li>
        <li><a href='{{ backpack_url('terminate-pass-holder') }}'><i class='fa fa-expeditedssl'></i> <span>Terminate Pass Holders</span></a></li>
        <li><a href='{{ backpack_url('return-pass-holder') }}'><i class='fa fa-exchange'></i> <span>Return Pass Holders</span></a></li>
        <li><a href='{{ backpack_url('expire-pass-holder') }}'><i class='fa fa-exchange'></i> <span>Expiring Pass Holder</span></a></li>
    </ul>
</li>

<li class="treeview">
    <a href="#"><i class="fa fa-bell"></i> <span>Communications</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
      <li><a href='{{ backpack_url('adhoc-email') }}'><i class='fa fa-envelope'></i> <span>Adhoc Emails</span></a></li>
    </ul>
</li>

@endif

@if(auth()->user()->hasAnyRole([ADMIN_ROLE, AIRPORT_TEAM_ROLE]))
<!-- Users, Roles Permissions -->
<li class="treeview">
    <a href="#"><i class="fa fa-group"></i> <span>Users Management</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
      <li><a href="{{ backpack_url('user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
      <li><a href="{{ backpack_url('role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
      <!-- <li><a href="{{ backpack_url('permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li> -->
    </ul>
  </li>
<li class="header text-center" style="color: white; font-weight: bold; font-size: 14px;">SETTING</li>
<li class="treeview">
  <a href="#"><i class="fa fa-envelope"></i> <span>Email</span> <i class="fa fa-angle-left pull-right"></i></a>
  <ul class="treeview-menu">
    <li><a href="{{ backpack_url('settings/smtp') }}"><i class="fa fa-comments"></i> <span>SMTP Server</span></a></li>
  </ul>
</li>
@endif

<!-- Tenant Portal -->
@if(auth()->user()->hasAnyRole([TENANT_ROLE, SUB_CONSTRUCTOR_ROLE]))
<li><a href='{{ route("admin.tenant.my-company") }}'><i class='fa fa-building'></i> <span>My Company</span></a></li>
<li class="treeview">
    <a href="#"><i class="fa fa-folder-open"></i> <span>Pass Holders Management</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
      <li><a href='{{ backpack_url('tenant-pass-holder') }}'><i class='fa fa-credit-card'></i> <span>Valid Pass Holders</span></a></li>
      <li><a href='{{ backpack_url('tenant-blacklist-pass-holder') }}'><i class='fa fa-exclamation-circle'></i> <span>Blacklist Pass Holders</span></a></li>
      <li><a href='{{ backpack_url('tenant-terminate-pass-holder') }}'><i class='fa fa-expeditedssl'></i> <span>Terminate Pass Holders</span></a></li>
      <li><a href='{{ backpack_url('tenant-return-pass-holder') }}'><i class='fa fa-exchange'></i> <span>Return Pass Holders</span></a></li>
    </ul>
</li>
@endif