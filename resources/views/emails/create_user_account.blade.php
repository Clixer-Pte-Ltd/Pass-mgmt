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
        <p>Click on the "Create Account" Link shown above.<br>

        You will reach https://pass-mgmt.changiairport.com, accept terms and conditions.<br>

        Create your account with the below email address:<br>
        Email: <a href="{{ $account->email }}">{{ $account->email }}</a><br>

        Insert your own desired password .<br>

        *New password must contain minimum 8 characters with 1 uppercase and lowercase, 1 symbol and 1 number*<br>
        </p>
    </li>
    <li>
        <h4>Step 2:</h4>
        <p>Using your Authenticator Tool, scan the QR Code on the web browser after you have successfully created the account. <b>Example is as below (below QR Code is a SAMPLE ONLY)</b>:</p>
        @if ($showPass)
            <div><img src="{{ $message->embed(public_path('images/qr_example.png')) }}"></div>
        @endif
        <p>
            **We recommend Google Authenticator, it can be downloaded on Google Play Store or Apple App Store**
        </p>
    </li>
    <li>
        <h4>Step 3:</h4>
        <p>
            You will be prompted to key in “One Time Password”.<br>
            To get the “One Time Password”, open up your authenticator tool on your mobile device to get the 6-digit “One Time Password” displayed.
        </p>
    </li>
</ul>

@include('emails.signature')
