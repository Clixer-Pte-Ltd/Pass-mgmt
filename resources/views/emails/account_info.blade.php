<p>Dear {{ $account->name }},</p>


<div>We've just created new account for you.</div>
<div>Please check login info as below:</div>
<ul>
    <li>
        Email: {{ $account->email }}
    </li>
    <li>
        Password: {{ DEFAULT_PASSWORD }}
    </li>
    <li>
        Google Authenticator Key: {{ $account->google2fa_secret}}
    </li>
</ul>

<p>
    Please change password after first login.
</p>

<p>Thanks.</p>

<div>Regards,</div>
<div>CAG Pass Management Mailer</div>