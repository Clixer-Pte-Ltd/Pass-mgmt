<a href="{{ route('crud.user.show', $history->subject->id ?? 0) }}">{{ @$history->subject->name }} {{ $history->subject && $history->subject instanceof \App\Models\BackpackUser ? '('.getUserRole($history->subject) . ')' : ''  }}</a>