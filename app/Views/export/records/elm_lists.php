<table id="MainRecords"  style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>EA Code</th>
        <th>EA Name</th>
        <th>Group Code</th>
        <th>Group Desc</th>
        <th>Pilgrim ID</th>
        <th>Name</th>
        <th>Birth Date</th>
        <th>Passport No</th>
        <th>MOI Number</th>
        <th>Visa No</th>
        <th>Entry Date</th>
        <th>Entry Time</th>
        <th>Entry Port</th>
        <th>Transport Mode</th>
        <th>Entry Carrier</th>
        <th>Flight No</th>
        <th>Package</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $cnt = 0;
    if(count($ELMDATA) > 0)
    {
    foreach ($ELMDATA as $ELMData) {
        $cnt++;
        echo '
                                 <tr>
                                 <td>' . $cnt . '</td>
                                 <td>' . $ELMData['EACode'] . '</td>
                                 <td>' . $ELMData['EAName'] . '</td>
                                 <td>' . $ELMData['GroupCode'] . '</td>
                                 <td>' . $ELMData['GroupDesc'] . '</td>
                                 <td>' . $ELMData['PilgrimID'] . '</td>
                                 <td>' . $ELMData['Name'] . '</td>
                                 <td>' . $ELMData['BirthDate'] . '</td>
                                 <td>' . $ELMData['PassportNo'] . '</td>
                                 <td>' . $ELMData['MOINumber'] . '</td>
                                 <td>' . $ELMData['VisaNo'] . '</td>
                                 <td>' . $ELMData['EntryDate'] . '</td>
                                 <td>' . $ELMData['EntryTime'] . '</td>
                                 <td>' . $ELMData['EntryPort'] . '</td>
                                 <td>' . $ELMData['TransportMode'] . '</td>
                                 <td>' . $ELMData['EntryCarrier'] . '</td>
                                 <td>' . $ELMData['FlightNo'] . '</td>
                                 <td>' . $ELMData['Package'] . '</td>
                                 </tr>
                                
                                 ';
    }
    }else{
        echo '<tr><td style="text-align: center;" colspan="18">No Record Found...</td></tr>';

    }

    ?>

    </tbody>
</table>