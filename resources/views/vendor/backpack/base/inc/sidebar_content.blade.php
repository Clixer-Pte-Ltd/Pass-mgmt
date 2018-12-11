<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
<li><a href="{{ backpack_url('elfinder') }}"><i class="fa fa-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
<!-- Users, Roles Permissions -->
<li class="treeview">
    <a href="#"><i class="fa fa-group"></i> <span>Users Management</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
      <li><a href="{{ backpack_url('user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
      <li><a href="{{ backpack_url('role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
      <li><a href="{{ backpack_url('permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
    </ul>
  </li>
@if(auth()->user()->hasAnyRole(ADMIN_ROLE, AIRPORT_TEAM_ROLE))
<li><a href='{{ backpack_url('tenant') }}'><i class='fa fa-tag'></i> <span>Tenants</span></a></li>
<li><a href='{{ backpack_url('sub-constructor') }}'><i class='fa fa-tag'></i> <span>Sub Constructors</span></a></li>
@endif