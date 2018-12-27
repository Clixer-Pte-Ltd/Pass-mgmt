<p>Dear {{ $account->name }},</p>


<div>Please validate your company.</div>
<ul>
    <li>
        Company name: {{ $company->name }}
        <br>
        Click the this to validate your company:
        <br>
        <a href="{{ $link }}">Validate company</a>
    </li>
</ul>

<p>Thanks.</p>

<div>Regards,</div>
<div>CAG Pass Management Mailer</div>