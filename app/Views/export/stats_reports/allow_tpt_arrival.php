<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>EA Code</th>
        <th>Country</th>
        <th>Agent Name</th>
        <th>V. No</th>
        <th>Pilgrim Name</th>
        <th>P/P No</th>
        <th>PAX</th>
        <th>Dep Date</th>
        <th>Dep Time</th>
        <th>Arrvl Date</th>
        <th>Arrvl Time</th>
        <th>Flight No</th>
        <th>Sector</th>
        <th>Destination</th>
        <th>TPT Type</th>
        <th>Airport</th>
        <th>Category</th>
        <th>Reference</th>

    </tr>

    </thead>
    <tbody>
    <?php
    $cnt = 0;
    $PilgrimModel = new \App\Models\Pilgrims();
    foreach ($records as $record) {
        $cnt++;
        $Category = 'B2B';
        if ($record['IATAType'] == 'external_agent') {
            $Category = 'External Agent';
        }
        $PilgrimID = $record['LeaderPilgrimUID'];
        $PilgrimMetaRecords = $PilgrimModel->ArrivalPilgrimLeaderMetaRecords($PilgrimID);
        echo '
                                <tr>
                                <td>' . $cnt . '</td>
                                 <td>' . Code('UF/A/', $record['AgentID']) . '</td>  
                                <td>' . $record['CountryName'] . '</td>
                                <td>' . $record['IATANAME'] . '</td>
                               
                                <td>' . $record['VoucherCode'] . '</td> 
                                
                                <td>' . $record['FullName'] . '</td>                             
                                <td>' . $record['PPNO'] . '</td>
                                <td>' . $record['TotalPilgrim'] . '</td>
                                <td>' . DATEFORMAT($record['DepartureDate']) . '</td>  
                                <td>' . $record['DepartureTime'] . '</td>  
                                <td>' . DATEFORMAT($record['ArrivalDate']) . '</td>
                                <td>' . $record['ArrivalTime'] . '</td>
                                <td>' . $record['FlightNo'] . '</td>                             
                                <td>' . $record['SectorFrom'] . ' - ' . $record['SectorTo'] . '</td>                             
                                <td>' . $record['SectorTo'] . '</td>                             
                                <td>' . $record['TypeOFTransport'] . '</td>   
                                <td>' . $record['SectorTo'] . '</td>           
                                <td>' . $Category . '</td>                             
                                <td>' . ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-') . '</td>             
                                  
                                </tr> ';
    }
    ?>
    </tbody>
</table>
