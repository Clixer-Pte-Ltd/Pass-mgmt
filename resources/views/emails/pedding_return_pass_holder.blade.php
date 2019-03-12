<p>Dear Airport Pass Coordinator/Authorized Signatory</p>

<div>List pass holder pendding return</div>
<br>
<table style="font-family: arial, sans-serif; border-collapse: collapse; width: 100%; ">
    <tr style="background: #1975dc; color: #ffffff">
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">S/N</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Name</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Pass#</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Expiry Date</th>
        <th style=" border: 1px solid #dddddd; text-align: left; padding: 8px;">Last Update</th>
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
        </tr>
        @php
            $i++;
        @endphp
    @endforeach
</table>
<p>As the sponsor of this/these Airport Pass/es, you are required to retrieve the pass/es from the passholder upon expiry of the pass and/or when the pass is no longer needed for the purpose it was issued.<br>
    Failure to return the expired airport pass constitutes a breach of the Letter of Undertaking which you signed on behalf of the company.  CAG as the Issuing Authority for airport pass reserves the right to take necessary actions it deems fit which includes, but not limited to cancellation of your airport pass account and withdrawal of all airport pass sponsored by your company. <br>
    ManagerAviation Security ManagerChangi Airport Group (S) Pte Ltd
</p>
@include('emails.signature')