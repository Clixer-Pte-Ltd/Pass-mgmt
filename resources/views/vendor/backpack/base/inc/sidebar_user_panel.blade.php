<div class="user-panel" style="padding:5px; width: 30%; float:right; display: flex; justify-content: flex-end">
    <a class="image" href="{{ route('backpack.account.info') }}">
      <img src="{{ backpack_avatar_url(backpack_auth()->user()) }}" class="img-circle" alt="User Image">
    </a>
    <div class="info" style="position: static">
      <p><a href="{{ route('backpack.account.info') }}">{{ backpack_auth()->user()->name }} ({{ getUserRole(backpack_user()) }})</a></p>
      <small><small><a href="{{ route('backpack.account.info') }}"><span><i class="fa fa-user-circle-o"></i> {{ trans('backpack::base.my_account') }}</span></a> &nbsp;  &nbsp; <a href="{{ backpack_url('logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></small></small>
    </div>
</div>