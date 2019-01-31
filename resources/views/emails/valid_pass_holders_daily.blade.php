<p>Dear {{ $account->name }},</p>


<div>
    <ul>
        @foreach($passHolders as $pass)
            <li><b>Name: </b>{{ $pass->applicant_name }}  <b>Nric: </b>{{ $pass->nric }}
                <b>Pass Expiry Date: </b>{{ $pass->pass_expiry_date }} <b>Company: </b>{{ $pass->company->name }}</li>
        @endforeach
    </ul>
</div>
<p>Thanks.</p>

<div>Regards,</div>
<div>CAG Pass Management Mailer</div>