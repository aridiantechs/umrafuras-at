<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>EA Code</th>
        <th>IATA</th>
        <th>Group Code</th>
        <th>Group Name</th>
        <th>PAX Name</th>
        <th>Passport No.</th>
        <th>Birth Date</th>
        <th>MOFA No</th>
        <th>VISA No.</th>
        <th>Entry Date</th>
        <th>Entry Time</th>
        <th>Entry Port</th>
        <th>TPT Mode</th>
        <th>Entry Carrier</th>
        <th>Flight No.</th>
        <th>Category</th>
        <th>Reference</th>

    </tr>
    </thead>
    <tbody>
    <?php
    $cnt = 0;
    foreach ($records as $record) {

        $cnt++;


        $Category = 'B2B';
        if ($record['IATAType'] == 'external_agent') {
            $Category = 'External Agent';
        }
        echo '
                                    <tr>
                                    <td>' . $cnt . '</td>
                                    <td>' . Code('UF/A/', $record['AgentID']) . '</td>
                                    <td>' . $record['IATANAME'] . '</td>
                                    <td>' . Code('UF/G/', $record['GroupID']) . '</td>
                                    <td>' . $record['GroupName'] . '</td>
                                    <td>' . $record['PilgrimFullName'] . '</td>
                                    <td>' . $record['PassportNumber'] . '</td>
                                    <td>' . DATEFORMAT($record['DOB']) . '</td>
                                    <td>' . $record['MOFANumber'] . '</td>
                                    <td>' . $record['VisaNo'] . '</td>
                                    <td>' . DATEFORMAT($record['EntryDate']) . '</td>
                                    <td>' . TIMEFORMAT($record['EntryTime']) . '</td>
                                    <td>' . $record['EntryPort'] . '</td>
                                    <td>' . $record['ArrivalMode'] . '</td>
                                    <td>' . $record['EntryCarrier'] . '</td>
                                    <td>' . $record['FlightNo'] . '</td>
                                    <td>' . $Category . '</td>

                                    <td>' . $record['ReferenceName'] . '</td>
                                      </tr> ';
    }
    ?>
    </tbody>
</table>
