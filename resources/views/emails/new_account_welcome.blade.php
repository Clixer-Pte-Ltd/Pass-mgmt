<p>Dear {{ $account->name }},</p>


<div>Welcome to Changi Airport Group Application Pass Tracking Portal.</div>
<div>You have become the admin of {{ @$company->name }}</div>

@include('emails.signature')
