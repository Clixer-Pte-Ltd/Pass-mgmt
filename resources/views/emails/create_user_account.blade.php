<p>Dear {{ $account->name }},</p>


<div>Your company have just added you to company.</div>
<div>Please create account follow link: </div>
<ul>
    <li>
        <a href="{{ $link }}">Create account</a>
    </li>
</ul>

<p>
    Please change password after first login.
</p>

<p>Thanks.</p>

<div>Regards,</div>
<div>CAG Pass Management Mailer</div>