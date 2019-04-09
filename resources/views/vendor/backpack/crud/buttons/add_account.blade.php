<a class="btn btn-success grad-success" data-toggle="modal" data-target="#modal-return-{{ $entry->id }}"><i
            class="fa fa-user"></i> Add More Account</a>
<div class="modal modal-default fade" id="modal-return-{{ $entry->id }}" datasqstyle="{'bottom':null}"
     datasqbottom="40" style="bottom: 40px; display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add account company </h4>
            </div>
            <div class="modal-body">

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_add_account_1" data-toggle="tab"><i class="fa fa-users"></i>New Account</a></li>
                        @if (backpack_user()->hasAnyRole([CAG_ADMIN_ROLE, COMPANY_CO_ROLE]) && !is_null($entry->asAccounts))
                            <li><a href="#tab_add_account_2" data-toggle="tab"><i class="fa fa-users"></i>Select AS</a></li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_add_account_1">
                            <form class="col-md-12 p-t-10" role="form" method="POST"
                                  action="{{ route('backpack.auth.add.account') }}" style="background: #ffffff; padding: 5px;">
                                @csrf
                                <div class="row">
                                    <div class="box no-padding no-border">
                                        <div class="box-body register">
                                            {!! csrf_field() !!}
                                            {{--name--}}
                                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                <p class="text-left">
                                                    <label class="control-label">{{ trans('backpack::base.name') }}</label>
                                                </p>
                                                <div class="input_register name_register">
                                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                                    @if ($errors->has('name'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            {{--email--}}
                                            <div class="form-group{{ $errors->has(backpack_authentication_column()) ? ' has-error' : '' }}">
                                                <p class="text-left"><label
                                                            class="control-label">{{ config('backpack.base.authentication_column_name') }}</label>
                                                </p>

                                                <div class='input_register email_register'>
                                                    <input type="{{ backpack_authentication_column()=='email'?'email':'text'}}"
                                                           class="form-control"
                                                           name="{{ backpack_authentication_column() }}"
                                                           value="{{ old(backpack_authentication_column()) }}">

                                                    @if ($errors->has(backpack_authentication_column()))
                                                        <span class="help-block">
                                            <strong>{{ $errors->first(backpack_authentication_column()) }}</strong>
                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            {{--role--}}
                                            <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                                                <p class="text-left"><label for="select-role">Role Account</label></p>
                                                <div class="form-group input_register role_register">
                                                    <select class="form-control" name='role' id="select-role"
                                                            style="padding-left: 30px; margin-left: 30px; width: 95%">
                                                        <option value="{{ COMPANY_CO_ROLE_ID }}">{{ COMPANY_CO_ROLE }}</option>
                                                        <option value="{{ COMPANY_AS_ROLE_ID }}">{{ COMPANY_AS_ROLE }}</option>
                                                        <option value="{{ COMPANY_VIEWER_ROLE_ID }}">{{ COMPANY_VIEWER_ROLE }}</option>
                                                    </select>
                                                </div>
                                                @if ($errors->has('role'))
                                                    <span class="help-block">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                                @endif
                                            </div>

                                            {{--company id--}}
                                            @if(session()->has(SESS_NEW_ACC_FROM_TENANT))
                                                <input type="hidden" name="tenant_id"
                                                       value="{{ session()->get(SESS_NEW_ACC_FROM_TENANT) }}">
                                            @endif
                                            @if(session()->has(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR))
                                                <input type="hidden" name="sub_constructor_id"
                                                       value="{{ session()->get(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR) }}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-block btn-primary">
                                            Add account
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if (backpack_user()->hasAnyRole([CAG_ADMIN_ROLE, COMPANY_CO_ROLE]) && !is_null($entry->asAccounts))
                            <div class="tab-pane" id="tab_add_account_2">
                                <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('admin.tenant.account.add-user-as') }}" style="background: #ffffff">
                                    @csrf
                                    <input name="tenant_id" value="{{ $entry->id }}" hidden>
                                    <div class="row">
                                        <div class="box no-padding no-border">
                                            <select name="user_as_ids[]" style="width: 100%"
                                                    class="select2_add_accounts form-control select2_multiple"
                                                    multiple>
                                                @foreach (App\Models\BackpackUser::role(COMPANY_AS_ROLE)->get() as $user)
                                                    @if (!$entry->getAllAccounts()->contains('id', $user->id))
                                                        <option class="option_add_account" value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <a class="btn btn-xs btn-default select_all" style="margin-top:5px;"><i
                                                        class="fa fa-check-square-o"></i> {{ trans('backpack::crud.select_all') }}
                                            </a>
                                            <a class="btn btn-xs btn-default clear" style="margin-top: 5px;"><i
                                                        class="fa fa-times"></i> {{ trans('backpack::crud.clear') }}</a>

                                        </div>
                                        <div class="box-footer">
                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-block btn-primary">
                                                Add account
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>

            <div class="modal-footer">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@push('crud_show_company_styles')
    <!-- include select2 css-->
    <link href="{{ asset('vendor/adminlte/bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
          rel="stylesheet" type="text/css"/>
@endpush
@push('crud_show_company_scripts')
    <!-- include select2 js-->
    <script>
        jQuery(document).ready(function ($) {
            let errors = @json($errors->all());
            if (errors.length) {
                $("#modal-return-{{ $entry->id }}").modal('show');
            }
        });
    </script>
    @if (backpack_user()->hasAnyRole([CAG_ADMIN_ROLE, COMPANY_CO_ROLE]))
        <script src="{{ asset('vendor/adminlte/bower_components/select2/dist/js/select2.min.js') }}"></script>
        <script>
            jQuery(document).ready(function ($) {
                // trigger select2 for each untriggered select2_multiple box
                $('.select2_add_accounts').each(function (i, obj) {
                    if (!$(obj).hasClass("select2-hidden-accessible")) {
                        var $obj = $(obj).select2({
                            theme: "bootstrap"
                        });

                        var options = $(".option_add_account").map(function() {
                            return $(this).attr("value");
                        }).get();
                        $(obj).parent().find('.clear').on("click", function () {
                            $obj.val([]).trigger("change");
                        });
                        $(obj).parent().find('.select_all').on("click", function () {
                            $obj.val(options).trigger("change");
                        });
                    }
                });
            });
        </script>
    @endif
@endpush
