<p>Dear Airport Pass Coordinator/Authorized Signatory</p>


<div>Need your confirmation on the below passholder pass:has </div>
<ul>
    @if (@$isListPass)
        <li>
            List Pass Holder confirm link
            <br>
            <a href="{{ $link }}">Confirm link</a>
        </li>
    @else
        <li>
            Pass holder name: {{ $passHolder->applicant_name }}
            <br>
            <a href="{{ $link }}">Confirm link</a>
        </li>
    @endif

</ul>

@include('emails.signature')
