<p>Dear {{ $account->name }},</p>


<div>Pass was renew.</div>
<ul>
    <li>
        Name: {{ $passHolder->applicant_name  }}
        <br>
        Date expire: {{ $passHolder->pass_expiry_date }}
    </li>
</ul>

<p>Thanks.</p>

<div>Regards,</div>
<div>CAG Pass Management Mailer</div>