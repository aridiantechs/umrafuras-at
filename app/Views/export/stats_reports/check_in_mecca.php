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
        <th>CHK Out Date</th>
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
    $cnt = 0; $pilgrims = array();
    foreach ($records as $record) {
        $pilgrims[]=$record['LeaderPilgrimUID'];
    }
    $pilgrims = array_count_values($pilgrims);
    $processedPilgrim = array();
    foreach ($records as $record) {

        $PilgrimMetaRecords = $Pilgrims->PilgrimMetaRecords($record['LeaderPilgrimUID']);
        //echo '<pre>';print_r($PilgrimMetaRecords);
        if($pilgrims[$record['LeaderPilgrimUID']]>1   ){
            /////////// macca 2 times
            if(in_array($record['LeaderPilgrimUID'], $processedPilgrim)){
                $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], 'check-in-mecca-status');
            } else {
                $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], 'check-in-mecca-status', 'ASC');
            }
            $processedPilgrim[] = $record['LeaderPilgrimUID'];
        } else {
            $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], 'check-in-mecca-status');
        }

        //echo '<pre>';print_r($PilgrimMetaRecords);
        //echo '<pre>'.$record['LeaderPilgrimUID'];print_r($PilgrimLastActivity);
        if ($PilgrimMetaRecords['check-in-mecca-actual-Hotel'] > 0) {
            $ActualHotel = HotelName($PilgrimMetaRecords['check-in-mecca-actual-Hotel'], 'Name', 1);
        } else {
            $ActualHotel = HotelName($PilgrimMetaRecords['check-in-mecca-package-Hotel'], 'Name', 0);
        }
        $Checkintime='';
        $Arrivalpos= strpos($PilgrimLastActivity['LastActivity'],"arrival");
        if($Arrivalpos>0){
            $Checkintime=date('H:i:s',strtotime($PilgrimLastActivity['LastActivityRecordTime']. ' + 4 hours'));

            // $Checkintime + 4hours
        }else{
            if($PilgrimLastActivity['LastActivity']=='check-out-medina'){
                $Checkintime = date('H:i:s',strtotime($PilgrimLastActivity['ActivityRecords']['check-out-medina-time']. ' + 6 hours'));
                // $Checkintime + 6hours
            }
        }
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
                                <td>' . ((isset($PilgrimMetaRecords['check-in-mecca-brn-no'])) ? BRNCode($PilgrimMetaRecords['check-in-mecca-brn-no']) : '-') . '</td>  
                                <td>' . $record['VoucherCode'] . '</td>
                                <td>' . $record['HotelCategory'] . '</td>
                              
                                <td>' . $record['HotelCityName'] . '</td>
                                <td>' . ((isset($ActualHotel)) ? $ActualHotel : '-') . '</td> 
                                <td>' . $record['RoomType'] . '</td>
                                 <td>' . ((isset($PilgrimMetaRecords['check-in-mecca-room-no'])) ? $PilgrimMetaRecords['check-in-mecca-room-no'] : '-') . '</td>                             

                                <td>' . $record['TotalPilgrim'] . '</td>   
                                  <td>' . ((isset($PilgrimMetaRecords['check-in-mecca-no-of-bed'])) ? $PilgrimMetaRecords['check-in-mecca-no-of-bed'] : '-') . '</td>                             

                                  <td>' . DATEFORMAT($record['CheckINDate']) . '</td>
                                <td>'.( (isset($Checkintime)) ? TIMEFORMAT($Checkintime) : '-' ).'</td>
                                   <td>' . ((isset($PilgrimMetaRecords['check-in-mecca-out-date'])) ? DATEFORMAT($PilgrimMetaRecords['check-in-mecca-out-date']) : '-') . '</td>
                                <td>' . $record['Nights'] . '</td>                          
                                <td>' . ((isset($PilgrimMetaRecords['check-in-mecca-actual-arrival-time'])) ? TIMEFORMAT($PilgrimMetaRecords['check-in-mecca-actual-arrival-time']) : '-') . '</td>                             
                                <td>' . ucwords(str_replace('-', ' ', $PilgrimLastActivity['LastActivity'])) . '</td>                             
                                <td>' . ((isset($PilgrimMetaRecords['check-in-mecca-contact-number'])) ? $PilgrimMetaRecords['check-in-mecca-contact-number'] : '-') . '</td>                           
                                <td>'.$Category.'</td>
                                <td>' . ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-') . '</td>    
                                <td>' . ((isset($ActivityUserName)) ? $ActivityUserName : '-') . '</td>
                                <td>Check In Mecca</td>    
                                
                                </tr> ';
        $pilgrims[] = $record['LeaderPilgrimUID'];
    }
    ?>
    </tbody>
</table>
