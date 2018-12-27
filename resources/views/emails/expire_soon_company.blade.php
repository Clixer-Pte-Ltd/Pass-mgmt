<p>Dear {{ $account->name }},</p>


<div>Your company will expire soon.</div>
<ul>
    <li>
        Company name: {{ $company->name }}
        <br>
        Date expire: {{ $company->tenancy_end_date }}
        <br>
        Day rest: {{ $dayRest }} days
    </li>
</ul>

<p>Thanks.</p>

<div>Regards,</div>
<div>CAG Pass Management Mailer</div>