<p>Dear Airport Pass Coordinator/Authorized Staff,</p>

<div>Your Airport Pass Tracking Portal (APTP) account has been created. Please see attachments for the user guide on how to use the portal. Do note that this portal is a stand-alone pass management portal which is meant to help you track airport passes that are sponsored by your company. The APTP is not linked to the airport pass application portal. For airport pass application, please proceed to "<a href="http://www.changiairport.com/corporate/e-services/airport-pass-application.html">http://www.changiairport.com/corporate/e-services/airport-pass-application.html</a>" as per current practice.
</div>
<div>Please see your log-in information below and access the APTP at the following link, "<a href="https://pass-mgmt.changiairport.com">https://pass-mgmt.changiairport.com</a>":</div>
<ul>
    <li>
        Email: {{ $account->email }}
    </li>
    @if ($showPass)
    <li>
        Password: {{ $account->first_password }}
    </li>
    <li>
        Google Authenticator Key:{{ $account->google2fa_secret}}
        <div><img src="{{ $qrCode }}"></div>
    </li>
    @endif
</ul>
<div>You may wish to copy and paste the password above to facilitate your first log-in. Please change your password after the first log-in.</div>

@include('emails.signature')
