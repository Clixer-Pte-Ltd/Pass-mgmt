<p>Dear Airport Pass Coordinator/Authorized Signatory,</p>
<div>You have been added into your company's list {{ $companyName }}.</div>
<div>Please create an account using the link below: </div>
<ul>
    <li>
        <a href="{{ $link }}">Create account</a>
    </li>
</ul>
<div>Follow the 3-steps below to successfully login to the portal.</div>
<ul>
    <li>
        <h4>Step 1:</h4>
        Using your Authenticator Tool Scan this code. Example:
        @if ($showPass)
            <div><img src="{{ $message->embed(public_path('images/qr_example.png')) }}"></div>
        @endif
        **We recommend Google Authenticator, it can be downloaded on Google Play Store or Apple App Store**
    </li>
    <li>
        <h4>Step 2:</h4>
        <p>Visit <a href="https://pass-mgmt.changiairport.com">https://pass-mgmt.changiairport.com</a> and log in using this credentials:</p>
        <p>
            Email: <a href="{{ $account->email }}">{{ $account->email }}</a><br>
        </p>
        <p>
            Please change your password after your first login.
        </p>
    </li>
    <li>
        <h4>Step 3:</h4>
        <p>
            You will be prompted to key in “One Time Password”.<br>
            To get the “One Time Password”, open up your authenticator tool on your mobile device to get the 6-digit “One Time Password” displayed.
        </p>
        @if ($showPass)
            <div><img src="{{ $message->embed(public_path('images/one_time_pass.jpg')) }}"></div>
        @endif
    </li>
</ul>



@include('emails.signature')
