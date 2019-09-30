@php
    $routeShow = $history->subject ? route('crud.'.$history->subject->routeName.'.show', $history->subject->id) : '#';
    $dataHistory = $history->changes->toArray();
    $nameSubject = $history->subject->name ?? $history->subject->applicant_name
    ?? $dataHistory['attributes']['name'] ?? $dataHistory['attributes']['applicant_name'] ?? '';
@endphp
<a href="{{ $routeShow }}">{{ $nameSubject }} {{ $history->subject && $history->subject instanceof \App\Models\BackpackUser ? '('.getUserRole($history->subject) . ')' : ''  }}</a>
