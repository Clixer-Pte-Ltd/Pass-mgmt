<p>Dear {{ $account->name }},</p>
<div>Welcome to Changi Airport Group.</div>
<div>You have become the admin of {{ $companyName }}</div>
<div>Please login to {{ route('backpack.dashboard') }}</div>

@include('emails.signature')
