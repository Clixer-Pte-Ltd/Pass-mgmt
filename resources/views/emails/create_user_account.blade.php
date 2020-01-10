<p>Dear Airport Pass Coordinator/Authorized Signatory,</p>
<div>Your Airport Pass Tracking Portal (APTP) account has been created. Please see attachments for the user guide on how to use the portal. Do note that this portal is a stand-alone pass management portal which is meant to help you track airport passes that are sponsored by your company. The APTP is not linked to the airport pass application portal. For airport pass application, please proceed to "http://www.changiairport.com/corporate/e-services/airport-pass-application.html" as per current practice.</div>
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
