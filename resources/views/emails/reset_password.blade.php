<h3>Hello!</h3>
<div>You are receiving this email because we received a password reset request for your account. Click the button below to reset your password:</div>
<div style="width: 40%; text-align: center">
    <a href="{{ $url }}" style="text-decoration: none; display: block">
        <button
            style="
        display: block;width: 140px;height:36px;border-radius: 5px;background-color: #3097d1;border: none;text-decoration: none;color: #fff;margin: 0 auto;cursor: pointer">Reset Password
        </button>
    </a>
</div>

<div>If you did not request a password reset, no further action is required.</div>

<div>If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser: <br>
    {{ $url }}
</div>

@include('emails.signature')
