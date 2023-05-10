<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Country</th>
        <th>Agent Name</th>
        <th>BRN</th>
        <th>V. No</th>
        <th>HTL Category</th>
        <th>City</th>
        <th>Actl Hotel</th>
        <th>Room Type</th>
        <th>Room No</th>
        <th>Pax</th>

        <th>Actl Beds</th>
        <th>CHK In Date</th>
        <th>CHK In Time</th>
        <th>Check Out Date</th>
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
    $Grand = array();
    foreach ($records as $record) {

        $PilgrimMetaRecords = $Pilgrims->PilgrimMetaRecords($record['LeaderPilgrimUID']);
        $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], 'check-in-medina-status');
        //echo '<pre>';print_r($PilgrimMetaRecords);
        //echo '<pre>';print_r($PilgrimLastActivity);
        if ($PilgrimMetaRecords['check-in-medina-actual-Hotel'] > 0) {

            $ActualHotel = HotelName($PilgrimMetaRecords['check-in-medina-actual-Hotel'], 'Name', 1);
        } else {
            $ActualHotel = HotelName($PilgrimMetaRecords['check-in-medina-package-Hotel'], 'Name', 0);
        }
        $Checkintime = '';
        $Arrivalpos = strpos($PilgrimLastActivity['LastActivity'], "arrival");
        if ($Arrivalpos > 0) {
            $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['LastActivityRecordTime'] . ' + 4 hours'));

            // $Checkintime + 4hours
        } else {
            if ($PilgrimLastActivity['LastActivity'] == 'check-out-mecca') {
                $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['ActivityRecords']['check-out-mecca-time'] . ' + 6 hours'));
                // $Checkintime + 6hours
            }
        }
        //echo $Checkintime;
        $Category = 'B2B';
        if ($record['IATAType'] == 'external_agent') {
            $Category = 'External Agent';
        }

        $ActivityUserName = UserNameByID($PilgrimLastActivity['ActivityRecords'][$PilgrimLastActivity['LastActivity'] . '-user-id']);

        $Grand['TotalPax'] += $record['TotalPilgrim'];
        $Grand['TotalBeds'] += $PilgrimMetaRecords['check-in-medina-no-of-bed'];
        $Grand['TotalNights'] += $record['Nights'];

        $cnt++;
        echo '
                                <tr>
                                <td>' . $cnt . '</td>
                                <td>' . $record['CountryName'] . '</td>
                                <td>' . $record['IATANAME'] . '</td>
                                <td>' . ((isset($PilgrimMetaRecords['check-in-medina-brn-no'])) ? BRNCode($PilgrimMetaRecords['check-in-medina-brn-no']) : '-') . '</td>  
                                <td>' . $record['VoucherCode'] . '</td>                        
                                <td>' . $record['HotelCategory'] . '</td>
                            
                                <td>' . $record['HotelCityName'] . '</td>
                                <td>' . ((isset($ActualHotel)) ? $ActualHotel : '-') . '</td> 
                                <td>' . $record['RoomType'] . '</td>
                                <td>' . ((isset($PilgrimMetaRecords['check-in-medina-room-no'])) ? $PilgrimMetaRecords['check-in-medina-room-no'] : '-') . '</td>                             

                                <td>' . $record['TotalPilgrim'] . '</td>
                                <td>' . ((isset($PilgrimMetaRecords['check-in-medina-no-of-bed'])) ? $PilgrimMetaRecords['check-in-medina-no-of-bed'] : '-') . '</td>                             
                                <td>' . DATEFORMAT($record['CheckINDate']) . '</td>
                                <td>' . ((isset($Checkintime)) ? TIMEFORMAT($Checkintime) : '-') . '</td>
                                <td>' . ((isset($PilgrimMetaRecords['check-in-medina-out-date'])) ? DATEFORMAT($PilgrimMetaRecords['check-in-medina-out-date']) : '-') . '</td>
                                <td>' . $record['Nights'] . '</td>                             

                                <td>' . ((isset($PilgrimMetaRecords['check-in-medina-actual-arrival-time'])) ? TIMEFORMAT($PilgrimMetaRecords['check-in-medina-actual-arrival-time']) : '-') . '</td>                             
                                <td>' . ucwords(str_replace('-', ' ', $PilgrimLastActivity['LastActivity'])) . '</td>                             
                                <td>' . ((isset($PilgrimMetaRecords['check-in-medina-contact-number'])) ? $PilgrimMetaRecords['check-in-medina-contact-number'] : '-') . '</td>                           
                                <td>' . $Category . '</td>
                                <td>' . ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-') . '</td>    
                                <td>' . ((isset($ActivityUserName)) ? $ActivityUserName : '-') . '</td>
                                <td>Check In Medina</td>    
                                
                                </tr> ';
    }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="10"></td>
        <td><?= $Grand['TotalPax'] ?></td>
        <td><?= $Grand['TotalBeds'] ?></td>
        <td colspan="3"></td>
        <td><?= $Grand['TotalNights'] ?></td>
        <td colspan="7"></td>
    </tr>

    </tfoot>
</table>
