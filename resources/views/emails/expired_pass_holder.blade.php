<p>Dear {{ $account->name }},</p>


<div>Pass holder expired</div>
<ul>
    <li>
        Pass holder name: {{ $passHolder->applicant_name }}
        <br>
        Date expire: {{ $passHolder->pass_expiry_date }}
    </li>
</ul>

<p>Thanks.</p>

<div>Regards,</div>
<div>CAG Pass Management Mailer</div>