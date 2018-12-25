<p>Dear {{ $account->name }},</p>


<div>Your company was expired.</div>
<ul>
    <li>
        Pass holder name: {{ $company->name }}
        <br>
        Date expire: {{ $company->tenancy_end_date }}
    </li>
</ul>

<p>Thanks.</p>

<div>Regards,</div>
<div>CAG Pass Management Mailer</div>