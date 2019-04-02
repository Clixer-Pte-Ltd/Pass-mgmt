<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error import</title>
</head>
<body>
    @if ($failures->count())
        <h1>Error validate</h1>
        <table style="width:100%; border: 1px solid black; border-collapse: collapse; background: rgba(255,0,0,0.27); color: #1d170f">
            <tr>
                <th style="border: 1px solid black; border-collapse: collapse;">Row</th>
                <th style="border: 1px solid black; border-collapse: collapse;">Attribute</th>
                <th style="border: 1px solid black; border-collapse: collapse;">Errors</th>
                <th style="border: 1px solid black; border-collapse: collapse;">Values</th>
            </tr>
            @foreach($failures as $failure)
                <tr>
                    <td style="border: 1px solid black; border-collapse: collapse;">{{ $failure->row() }}</td>
                    <td style="border: 1px solid black; border-collapse: collapse;">{{ $failure->attribute() }}</td>
                    <td style="border: 1px solid black; border-collapse: collapse;">
                        @foreach($failure->errors() as $error)
                            {{ $error }}
                            <br>
                        @endforeach
                    </td>
                    <td style="border: 1px solid black; border-collapse: collapse;">
                        @foreach($failure->values() as $key => $value)
                            {{ $key . ' : ' . $value }}
                            <br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </table>
    @endif

    @if (count($errors))
        <h1>Error data</h1>
        @foreach($errors as $error)
            <p style="color: red">{!! $error !!}</p>
        @endforeach
    @endif
</body>
</html>
