<table style=" border: 1px solid black; border-collapse: collapse; font-size: 0.5em">
    <thead>
    <tr>
        @foreach($headings as $head)
            <th style=" border: 1px solid black; border-collapse: collapse; padding: 2px; text-align: left;">{{ $head }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        <tr>
            @foreach($item as $column => $value)
                <td style=" border: 1px solid black; border-collapse: collapse;  padding: 2px;">{{ $value }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>