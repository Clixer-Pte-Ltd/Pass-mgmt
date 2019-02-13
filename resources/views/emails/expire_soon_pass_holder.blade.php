<p>Dear {{ $account->name }},</p>


<div>Pass holder will expire soon.</div>
<ul>
    @foreach($passHolders as $passHolder)
        <li>
            Pass holder name: {{ $passHolder->applicant_name }}
            <br>
            Date expire: {{ $passHolder->pass_expiry_date }}
            <br>
            Day rest: {{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($passHolder->pass_expiry_date)) }} days
            <br>
            Company name: {{ $passHolder->company->name }}
        </li>
    @endforeach
</ul>

<p>Thanks.</p>

<div>Regards,</div>
<div>CAG Pass Management Mailer</div>