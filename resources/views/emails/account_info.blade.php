<p>Dear {{ $account->name }},</p>


<div>We've just created new account for you.</div>
<div>Copy and paste the password for your first login.</div>
<div>Please refer to the login information below:</div>
<ul>
    <li>
        Email: {{ $account->email }}
    </li>
    @if ($showPass)
    <li>
        Password: {{ $account->first_password }}
    </li>
    <li>
        Google Authenticator Key:{{ $account->google2fa_secret}}
        <div><img src="{{ $message->embed($qrCode) }}"></div>
    </li>
    @endif
    <li>Please login to {{ route('backpack.dashboard') }}</li>
</ul>

<p>
    Please change password after your first login.
</p>

@include('emails.signature')
