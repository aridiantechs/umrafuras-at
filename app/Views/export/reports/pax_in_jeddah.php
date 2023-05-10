<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Country</th>
        <th>Agent Name</th>
        <th>BRN</th>
        <th>V. No</th>
        <th>Hotel Category</th>

        <th>City</th>
        <th>Actl Hotel</th>
        <th>Room Type</th>
        <th>Room No</th>
        <th>PAX</th>
        <th>Actl BEDS</th>
        <th>Chk in Date</th>
        <th>Chk in Time</th>
        <th>Chk Out Date</th>
        <th>Nights</th>
        <th>Actl Arrival Time</th>
        <th>Origin</th>
        <th>PAX Mob. No</th>
        <th>Category</th>
        <th>Reference</th>
        <th>System User</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $Pilgrims = new \App\Models\Pilgrims();
    $cnt = 0;
    foreach ($records as $record) {

        $Checkintime = '';
        $cnt++;
        $sub_array = array();

        $PilgrimMetaRecords = $Pilgrims->PilgrimMetaRecords($record['LeaderPilgrimUID']);
        $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], 'check-in-jeddah-status');
        $PilgrimCurrentActivity = PilgrimCurrentActivity($record['LeaderPilgrimUID'], 'check-in-jeddah');
        if ($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-actual-Hotel'] > 0) {
            $ActualHotel = HotelName($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-actual-Hotel'], 'Name', 1);
        } else {
            $ActualHotel = HotelName($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-package-Hotel'], 'Name', 0);
        }

        $Arrivalpos = strpos($PilgrimLastActivity['LastActivity'], "arrival");
        if ($Arrivalpos > 0) {
            $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['LastActivityRecordTime'] . ' + 4 hours'));
        } else {
            if ($PilgrimLastActivity['LastActivity'] == 'check-out-medina') {
                $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['ActivityRecords']['check-out-medina-time'] . ' + 6 hours'));
            } elseif ($PilgrimLastActivity['LastActivity'] == 'check-out-mecca') {
                $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['ActivityRecords'][$PilgrimLastActivity['LastActivity'] . '-actual-arrival-time'] . ' + 6 hours'));
            }
        }

        $Category = 'B2B';
        if ($record['IATAType'] == 'external_agent') {
            $Category = 'External Agent';
        }
        $datetime1 = new DateTime($record['CheckINDate']);
        $datetime2 = new DateTime($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-out-date']);
        $difference = $datetime1->diff($datetime2);

        echo '
                                <tr>
                                    <td>' . $cnt . '</td>                                 
                                    <td>' . $record['CountryName'] . '</td>
                                    <td>' . $record['IATANAME'] . '</td> 
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-brn-no'])) ? BRNCode($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-brn-no']) : '-') . '</td>                            
                                    <td>' . $record['VoucherCode'] . '</td> 
                                     <td>' . ((isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-') . '</td>
                                   
                                    <td>' . $record['CityName'] . '</td> 
                                    <td>'.( (isset($ActualHotel)) ? $ActualHotel : '-' ).'</td>     
                                    <td>' . ((isset($record['RoomType'])) ? $record['RoomType'] : '-') . '</td>     
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-room-no'])) ? $PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-room-no'] : '-') . '</td>                                
                                    <td>' . $record['TotalPilgrim']. '</td>                                                                          
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-no-of-bed'])) ? $PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-no-of-bed'] : '-') . '</td> 
                                    <td>' . ((isset($record['CheckINDate'])) ? DATEFORMAT($record['CheckINDate']) : '-') . '</td>               
                                    <td>'.( (isset($Checkintime)) ? TIMEFORMAT($Checkintime) : '-' ).'</td>    
                                    <td>'.((isset($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-out-date'])) ? DATEFORMAT($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-out-date']) : '-').'</td>                                      
                                    <td>'.$difference->d.'</td>                                     
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-actual-arrival-time'])) ? TIMEFORMAT($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-actual-arrival-time']) : '-') . '</td>               
                                    <td>'.ucwords(str_replace('-',' ',$PilgrimLastActivity['LastActivity'])).'</td>         
                                    <td>' . ((isset($PilgrimMetaRecords['jeddah-arrival-contact-number'])) ? $PilgrimMetaRecords['jeddah-arrival-contact-number'] : '-') . '</td>             
                                    <td>'.$Category.'</td>             
                                    <td>' . ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-') . '</td>                                 
                                    <td>' . ((isset($record['SystemUser'])) ? $record['SystemUser'] : '-') . '</td>
                                    <td>Check In Jeddah</td>                                 
                                </tr> ';
    }
    ?>
    </tbody>
</table>
