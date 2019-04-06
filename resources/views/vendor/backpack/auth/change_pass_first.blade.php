@extends('backpack::layout_guest')

@section('after_styles')
    <style media="screen">
        .backpack-profile-form .required::after {
            content: ' *';
            color: red;
        }
    </style>
@endsection
@section('content')
    <div class="row" style="margin: auto; margin-top: 8%; width: 50%;">
        <div class="col-md-12">
            <h1 style="color: #ffffff">You must change password first</h1>
            <form class="form" action="{{ route('backpack.auth.account.password') }}" method="post">

                {!! csrf_field() !!}

                <div class="box padding-10">

                    <div class="box-body backpack-profile-form">

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->count())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            @php
                                $label = trans('backpack::base.old_password');
                                $field = 'old_password';
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <input autocomplete="new-password" required class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="" placeholder="{{ $label }}">
                        </div>

                        <div class="form-group">
                            @php
                                $label = trans('backpack::base.new_password');
                                $field = 'new_password';
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <input autocomplete="new-password" required class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="" placeholder="{{ $label }}">
                        </div>

                        <div class="form-group">
                            @php
                                $label = trans('backpack::base.confirm_password');
                                $field = 'confirm_password';
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <input autocomplete="new-password" required class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="" placeholder="{{ $label }}">
                        </div>

                        <div class="form-group m-b-0">

                            <button type="submit" class="btn btn-success"><span class="ladda-label"><i class="fa fa-save"></i> {{ trans('backpack::base.change_password') }}</span></button>
                            <a href="{{ backpack_url() }}" class="btn btn-default"><span class="ladda-label">{{ trans('backpack::base.cancel') }}</span></a>

                        </div>

                    </div>

                </div>

            </form>

        </div>
    </div>
@endsection
