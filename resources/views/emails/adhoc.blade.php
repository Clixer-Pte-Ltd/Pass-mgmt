<p>Dear {{ $account->name }},</p>


<div>
    {!! @$content->body !!}
</div>
@include('emails.signature')