@extends('backpack::layout_guest')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Set up Google Authenticator</div>

                <div class="panel-body" style="text-align: center;">
                    <p>Set up your two factor authentication by scanning the barcode below. Alternatively, you can use the code {{ $secret }}</p>
                    <div>
                        <img src="{{ $QR_Image }}">
                    </div>
                    <p>You must set up your Google Authenticator app before continuing. You will be unable to login otherwise</p>
                    <div>
                        @if(session()->has(SESS_TENANT_2FA))
                            @if(session()->has(SESS_TENANT_MY_COMPANY))
                                <a href="{{ route('admin.tenant.my-company') }}"><button class="btn-primary">Complete Registration</button></a>                                    
                            @else
                                <a href="{{ route('crud.tenant.show', [session()->get(SESS_TENANT_2FA)]) }}"><button class="btn-primary">Complete Registration</button></a>
                            @endif
                        @else
                            @if(session()->has(SESS_SUB_CONSTRUCTOR_2FA))
                                <a href="{{ route('crud.sub-constructor.show', [session()->get(SESS_SUB_CONSTRUCTOR_2FA)]) }}"><button class="btn-primary">Complete Registration</button></a>
                            @else
                                <a href="/complete-registration"><button class="btn-primary">Complete Registration</button></a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection