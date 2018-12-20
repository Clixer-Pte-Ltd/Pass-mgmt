<p>Dear {{ $account->name }},</p>


<div>Pass holder will expire soon.</div>
<ul>
    <li>
        Pass holder name: {{ $passHolder->applicant_name }}
        <br>
        Date expire: {{ $passHolder->pass_expiry_date }}
        <br>
        Day rest: {{ $dayRest }} days
    </li>
</ul>

<p>Thanks.</p>

<div>Regards,</div>
<div>CAG Pass Management Mailer</div>