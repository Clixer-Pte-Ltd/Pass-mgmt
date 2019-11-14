<p>Dear Airport Pass Coordinator/Authorized Signatory,</p>
@if ($companies->count() > 0)
    <div>This is the list of company(ies) that is/are not validated.</div>
    <br>
    <table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%; ">
        <tr style="background: #1975dc; color: #ffffff">
            <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">S/N</th>
            <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Company Name</th>
            <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Company Code</th>
            <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Expiry Date</th>
            <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Date of Creation</th>
        </tr>
        @php
            $i = 0;
        @endphp
        @foreach($companies as $company)
            <tr style="background: {{ $i%2 == 0 ?'#c3dbf7' : '#ffffff' }}; color: #000000">
                <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $company->id }}</td>
                <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $company->name }}</td>
                <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $company->uen }}</td>
                <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $company->tenancy_end_date }}</td>
                <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $company->created_at }}</td>
            </tr>
            @php
                $i++;
            @endphp
        @endforeach
    </table>
@else
    <div>Every Company have been validated.</div>
@endif

@include('emails.signature')
