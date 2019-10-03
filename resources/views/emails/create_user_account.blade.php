<p>Dear Airport Pass Coordinator/Authorized Signatory</p>


<div>You have just been added to company  {{ $company }}</div>
<div>Please create account follow link: </div>
<ul>
    <li>
        <a href="{{ $link }}">Create account</a>
    </li>
</ul>

<p>
    Please change password after first login.
</p>

@include('emails.signature')
