<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Country</th>
        <th>Agent Name</th>
        <th>Voucher No</th>
        <th>Actl Hotel</th>
        <th>Room No</th>
        <th>Dep Date</th>
        <th>Dep Htl Time</th>
        <th>Flight Date</th>
        <th>Flight No</th>
        <th>Flight Time</th>
        <th>PAX</th>
        <th>Seats</th>
        <th>Airport</th>
        <th>Dep City</th>
        <th>TPT Type</th>
        <th>Vehicle Number</th>
        <th>Driver Name</th>
        <th>Driver Mob.</th>
        <th>TPT Company</th>
        <th>PAX Mob. No</th>
        <th>Category</th>
        <th>Reference</th>
        <th>System User</th>
        <th>Status</th>

    </tr>
    </thead>
    <tbody>
    <?php
    $PilgrimModel = new \App\Models\Pilgrims();
    $cnt = 0;
    foreach ($records as $record) {
        $PilgrimMetaRecords = $PilgrimModel->DeparturePilgrimLeaderMetaRecords($record['LeaderPilgrimUID']);
        $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], $PilgrimMetaRecords['Status'].'-status');
        $PilgrimCurrentActivity = PilgrimCurrentActivity($record['LeaderPilgrimUID'], $PilgrimMetaRecords['Status']);

        //echo '<pre>';print_r($PilgrimLastActivity);
        $ActivityUserName = UserNameByID($PilgrimLastActivity['ActivityRecords'][$PilgrimLastActivity['LastActivity'] . '-user-id']);
        $Category = 'B2B';
        if ($record['IATAType'] == 'external_agent') {
            $Category = 'External Agent';
        }
        $cnt++;
        echo '
                                <tr>
                                <td>' . $cnt . '</td>                          
                                <td>' . $record['CountryName'] . '</td>     
                                <td>' . $record['IATANAME'] . '</td>                             
                                <td>' . $record['VoucherCode'] . '</td>                           
                                <td>' . $PilgrimMetaRecords['ActualHotel'] . '</td>                             
                                <td>' . $PilgrimMetaRecords['RoomNo'] . '</td>                             
                                <td>' . DATEFORMAT($PilgrimMetaRecords['DepartureDate']) . '</td>                             
                                <td>' . TIMEFORMAT($PilgrimCurrentActivity['LastActivityRecordTime']) . '</td>                             
                                <td>' . DATEFORMAT($record['FlightDate']) . '</td>                             
                                <td>' . $record['FlightNo'] . '</td>                             
                                <td>' . TIMEFORMAT($record['FlightTime']) . '</td>                             
                                <td>' . $record['TotalPilgrim'] . '</td>                             
                                <td>' . $PilgrimMetaRecords['Seats'] . '</td>                         
                                <td>' . AirportName($record['SectorFrom']) . '</td>                             
                                <td>' . AirportCode($record['SectorFrom']) . '</td>                            
                                <td>' . $record['TransportType'] . '</td>                                  
                                <td>' . $PilgrimMetaRecords['VehicleNumber'] . '</td>                             
                                <td>' . $PilgrimMetaRecords['DriverName'] . '</td>                             
                                <td>' . $PilgrimMetaRecords['DriverMobileNumber'] . '</td>                          
                                <td>' . $PilgrimMetaRecords['TransportCompany'] . '</td>                              
                                <td>' . $PilgrimMetaRecords['PaxMobileNumber'] . '</td>                               
                                <td>' . ucfirst(str_replace("_", " ", $record['IATAType'])) . '</td>                             
                                <td>' . $record['ReferenceName'] . '</td>                             
                                <td>' . ((isset($ActivityUserName)) ? $ActivityUserName : '-') . '</td>                             
                                <td>' . ucwords(str_replace('-', ' ', $PilgrimMetaRecords['Status'])) . '</td>                             
                                </tr> ';
    }
    ?>
    </tbody>
</table>
