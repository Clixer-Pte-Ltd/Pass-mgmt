<p>Dear Airport Pass Coordinator/Authorized Staff,</p>

<div>The tenancy contract of the following company/companies under sponsorship of your company has expired. Please update us at "CAS_APO_APTP@certisgroup.com" if you have signed a new contract with the following company/companies and if not, please ensure all passes are returned to Pass Office as soon as possible.</div>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%; ">
    <tr style="background: #1975dc; color: #ffffff">
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">S/N</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Company Name</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Company Code</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Expiry Date</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Date of Creation</th>
    </tr>
    @foreach($companies as $company)
        <tr style="background: #c3dbf7; color: #000000">
            <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $company->id }}</td>
            <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $company->name }}</td>
            <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $company->uen }}</td>
            <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $company->tenancy_end_date }}</td>
            <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $company->created_at }}</td>
        </tr>
    @endforeach

</table>

@include('emails.signature')
