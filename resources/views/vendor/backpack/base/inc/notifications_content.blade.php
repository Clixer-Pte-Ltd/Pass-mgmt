@if ($notificationsSystem->count())
    @foreach($notificationsSystem as $notificaton)
        <div style="background: red; color: #ffffff; border-radius: 5px; padding: 5px">{{ $notificaton->content }}</div>
    @endforeach
@endif
