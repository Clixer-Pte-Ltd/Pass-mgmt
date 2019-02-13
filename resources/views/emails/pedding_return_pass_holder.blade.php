<p>Dear {{ $account->name }},</p>


<div>Pass holder pendding return</div>
<ul>
    @foreach($passHolders as $pass)
    <li>
        Pass holder name: {{ $pass->applicant_name }}
        <br>
        Company name:  {{ $pass->company->name }}
    </li>
    <br>
    @endforeach

</ul>

<p>Thanks.</p>

<div>Regards,</div>
<div>CAG Pass Management Mailer</div>