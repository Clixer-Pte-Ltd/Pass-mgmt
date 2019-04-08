<p>Dear {{ $account->name }},</p>


<div>We've just created new account for you.</div>
<div>Please check login info as below:</div>
<ul>
    <li>
        Email: {{ $account->email }}
    </li>
    <li>
        Password: {{ $account->first_password }}
    </li>
    <li>
        Google Authenticator Key: {{ $account->google2fa_secret}}
    </li>
</ul>

<p>
    Please change password after first login.
</p>

@include('emails.signature')