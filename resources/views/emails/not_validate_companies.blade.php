<p>Dear {{ $account->name }},</p>
@if ($companies->count() > 0)
    <div>List of company that was not validated</div>
    <ul>
    @foreach($companies as $company)
        <li>
            Company name: {{ $company->name }}
        </li>
    @endforeach
    </ul>
@else
    <div>Every Company have been validated.</div>
@endif

<p>Thanks.</p>

<div>Regards,</div>
<div>CAG Pass Management Mailer</div>