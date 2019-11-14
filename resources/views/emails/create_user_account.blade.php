<p>Dear Airport Pass Coordinator/Authorized Signatory,</p>
<div>You have been added into your company's list {{ $companyName }}.</div>
<div>Please create an account using the link below: </div>
<ul>
    <li>
        <a href="{{ $link }}">Create account</a>
    </li>
</ul>

<p>
    Please change your password after your first login.
</p>

@include('emails.signature')
