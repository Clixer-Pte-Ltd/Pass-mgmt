@if ($crud->hasAccess('update'))
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
                <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('backpack.auth.add.account') }}" style="background: #ffffff">
                    <div class="modal-body">
                        @csrf
                        <div class="box-body register">
                            {!! csrf_field() !!}
                            {{--name--}}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <p class="text-left"><label class="control-label">{{ trans('backpack::base.name') }}</label></p>
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
                                <p class="text-left"><label class="control-label">{{ config('backpack.base.authentication_column_name') }}</label></p>

                                <div class='input_register email_register'>
                                    <input type="{{ backpack_authentication_column()=='email'?'email':'text'}}" class="form-control" name="{{ backpack_authentication_column() }}" value="{{ old(backpack_authentication_column()) }}">

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
                            @if(session()->has('tenant'))
                                <input type="hidden" name="tenant_id" value="{{ session()->get('tenant') }}">
                            @endif
                            @if(session()->has('sub_constructor'))
                                <input type="hidden" name="sub_constructor_id"
                                       value="{{ session()->get('sub_constructor') }}">
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-block btn-primary">
                            Add account
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endif


