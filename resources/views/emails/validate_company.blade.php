<p>Dear Airport Pass Coordinator/Authorized Signatory,</p>

<div>Please validate your company(ies).</div>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%; ">
    <tr style="background: #1975dc; color: #ffffff">
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">S/N</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Company Name</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Company Code</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Expiry Date</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Date of Creation</th>
    </tr>
    <tr style="background: #c3dbf7; color: #000000">
        <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $company->id }}</td>
        <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $company->name }}</td>
        <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $company->uen }}</td>
        <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $company->tenancy_end_date }}</td>
        <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $company->created_at }}</td>
    </tr>
</table>

<p>Click the this to validate your company:</p>
<br>
<a href="{{ $link }}">Validate company</a>

@include('emails.signature')
