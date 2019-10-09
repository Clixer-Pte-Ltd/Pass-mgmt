<p>Dear {{ $account->name }},</p>


<div>We've just created new account for you.</div>
<div>Copy and Paste the password for first login.</div>
<div>Please check login info as below:</div>
<ul>
    <li>
        Email: {{ $account->email }}
    </li>
    @if ($showPass)
    <li>
        Password: {{ $account->first_password }}
    </li>
    <li>
        Google Authenticator Key:
        <div><img src="{{ $message->embed($qrCode) }}"></div>
    </li>
    @endif
</ul>

<p>
    Please change password after first login.
</p>

@include('emails.signature')
