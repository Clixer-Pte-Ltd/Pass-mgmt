<p>Dear Airport Pass Coordinator/Authorized Staff,</p>

<div>Please note that the following airport pass/passes sponsored by your company will be expiring in 4 weeks' time.</div>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%; ">
    <tr style="background: #1975dc; color: #ffffff">
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">S/N</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Name</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Pass#</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Expiry Date</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Last Update</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Company</th>
    </tr>
    @php
        $i = 0;
    @endphp
    @foreach($passHolders as $passHolder)
        <tr style="background: {{ $i%2 == 0 ?'#c3dbf7' : '#ffffff' }}; color: #000000">
            <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $passHolder->id }}</td>
            <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $passHolder->applicant_name }}</td>
            <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $passHolder->nric }}</td>
            <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $passHolder->pass_expiry_date }}</td>
            <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ $passHolder->updated_at }}</td>
            <td style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">{{ @$passHolder->company->companyable->name }}</td>
        </tr>
        @php
            $i++;
        @endphp
    @endforeach
</table>
<p>As the sponsor of this/these Airport Pass/Passes, you are required to retrieve the pass/passes from the passholder upon expiry of the pass and/or when the pass is no longer needed for work reasons. CAG as the Issuing Authority for airport passes reserves the rights to take the necessary actions that it deems fit which includes, but are not limited to, the cancellation of your airport pass account and withdrawal of all airport pass sponsored by your company.
</p>
@include('emails.signature')
