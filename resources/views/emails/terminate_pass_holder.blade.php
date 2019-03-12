<p>Dear Airport Pass Coordinator/Authorized Signatory</p>

<div>Pass has been terminated.</div>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%; ">
    <tr style="background: #1975dc; color: #ffffff">
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">S/N</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Name</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Pass#</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Expiry Date</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Last Update</th>
    </tr>
    <tr style="background: #c3dbf7; color: #000000">
        <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $passHolder->id }}</td>
        <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $passHolder->applicant_name }}</td>
        <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $passHolder->nric }}</td>
        <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $passHolder->pass_expiry_date }}</td>
        <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $passHolder->updated_at }}</td>
    </tr>
</table>

@include('emails.signature')