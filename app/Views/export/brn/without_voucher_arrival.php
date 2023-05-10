<table id="ReportTable" class="table table-hover non-hover display nowrap cell-border"
       style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>EA Code</th>
        <th>Country</th>
        <th>Agent Name</th>
        <th>Group Code</th>
        <th>Group Name</th>
        <th>Pax</th>
        <th>PPT No</th>
        <th>DOB</th>
        <th>MOFA Number</th>
        <th>Visa No</th>
        <th>Entry Date</th>
        <th>Entry Time</th>
        <th>Entry Port</th>
        <th>Arrival Mode</th>
        <th>Entry Carrier</th>
        <th>Flight No</th>
        <th>Category</th>
        <th>Reference</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $cnt = 0;

    foreach ($Pilgrimslist as $Pilgrimlist) {

        $cnt++;
        echo
            '
                           <tr>
                           <td>' . $cnt . ' </td>
                           <td>' . Code('UF/EA/', $Pilgrimlist['AgentUID']) . ' </td>
                           <td>' . $Pilgrimlist['CountryName'] . ' </td>
                           <td>' . $Pilgrimlist['AgentName'] . ' </td>
                           <td>' . $Pilgrimlist['GroupName'] . ' </td>
                           <td>' . Code('UF/G/', $Pilgrimlist['GroupUID']) . ' </td>
                           <td>' . $Pilgrimlist['FirstName'] . ' </td>
                           <td>' . $Pilgrimlist['PassportNumber'] . ' </td>
                           <td>' . DATEFORMAT($Pilgrimlist['DOB']) . ' </td>
                           <td>' . $Pilgrimlist['MOFAPilgrimID'] . ' </td>
                           <td>' . $Pilgrimlist['VisaNo'] . ' </td>
                           <td>' . DATEFORMAT($Pilgrimlist['EntryDate']) . ' </td>
                           <td>' . TIMEFORMAT($Pilgrimlist['EntryTime']) . ' </td>
                           <td>' . $Pilgrimlist['EntryPort'] . ' </td>
                           <td>' . $Pilgrimlist['TransportMode'] . ' </td>
                           <td>' . $Pilgrimlist['EntryCarrier'] . ' </td>
                           <td>' . $Pilgrimlist['FlightNo'] . ' </td>
                           <td>' . ((isset($Pilgrimlist['AgentType'])) ? ucfirst(str_replace("_", " ", $Pilgrimlist['AgentType'])) : '-') . '</td>
                           <td>' . $Pilgrimlist['ReferenceName'] . ' </td>
                   

                            </tr>

                           ';
    }
    ?>
    </tbody>
</table>
