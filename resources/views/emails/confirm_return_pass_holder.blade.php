<p>Dear CAG Admin,</p>


<div>Seek your confirmation on the return of the airport pass below: </div>
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
