<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Country</th>
        <th>Agent Name</th>
        <th>BRN</th>
        <th>Voucher No</th>
        <th>Chk in Date </th>
        <th>Chk in Time</th>
        <th>City</th>
        <th>Hotel Name</th>
        <th>Room Type</th>
        <th>PAX</th>
        <th>BEDS</th>
        <th>Nights</th>
        <th>Actl Hotel</th>
        <th>Room No</th>
        <th>Actl Bed</th>
        <th>Actl Arrvl Time</th>
        <th>Origin</th>
        <th>PAX Mob. No</th>
        <th>Category</th>
        <th>Reference</th>
        <th>System User</th>
        <th>Status</th>

    </tr>
    </thead>
    <tbody>
    <?php //print_r($records);
    $Pilgrims = new \App\Models\Pilgrims();
    $cnt=0;
    foreach ($records as $record) {
        $cnt++;
        $PilgrimMetaRecords = $Pilgrims->PilgrimMetaRecords( $record['LeaderPilgrimUID'] );
        //echo '<pre>';print_r($PilgrimMetaRecords);
        $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'],'allow-htl-mecca-status');
        //echo '<pre>';print_r($PilgrimLastActivity);

        $PilgrimCurrentActivity = PilgrimCurrentActivity($record['LeaderPilgrimUID'],'allow-htl-mecca');
        //echo '<pre>';print_r($PilgrimCurrentActivity);
        if ($PilgrimCurrentActivity['ActivityRecords']['allow-htl-mecca-actual-Hotel'] > 0) {
            $ActualHotel = HotelName($PilgrimCurrentActivity['ActivityRecords']['allow-htl-mecca-actual-Hotel'], 'Name', 1);
        } else {
            $ActualHotel = HotelName($PilgrimCurrentActivity['ActivityRecords']['allow-htl-mecca-package-Hotel'], 'Name', 0);
        }
        $ActivityUserName = UserNameByID($PilgrimCurrentActivity['LastActivitySystemUser']);
        $CheckInTime1=$PilgrimCurrentActivity['ActivityRecords']['allow-htl-mecca-actual-arrival-time'];
        if ($PilgrimCurrentActivity['ActivityRecords']['allow-htl-mecca-origin']=='medina') {
            $CheckInTime = date('H:i:s',strtotime($CheckInTime1. ' + 6 hours'));

        }elseif ($PilgrimCurrentActivity['ActivityRecords']['allow-htl-mecca-origin']=='yanbu'){
            $CheckInTime = date('H:i:s',strtotime($CheckInTime1. ' + 6 hours'));

        }elseif ($PilgrimCurrentActivity['ActivityRecords']['allow-htl-mecca-origin']=='jeddah'){

            $CheckInTime = date('H:i:s',strtotime($CheckInTime1. ' + 4 hours'));
        }

        echo '
                                <tr>
                                <td>'.$cnt.'</td>
                                <td>' . $record['CountryName'] . '</td> 
                                <td>' . $record['IATANAME'] . '</td> 
                                <td>'.( (isset($PilgrimCurrentActivity['ActivityRecords']['allow-htl-mecca-brn-no'])) ? BRNCode($PilgrimCurrentActivity['ActivityRecords']['allow-htl-mecca-brn-no']) : '-' ).'</td> 
                                <td>' . $record['VoucherCode'] . '</td> 
                                <td>'.( (isset($record['CheckINDate'])) ? DATEFORMAT($record['CheckINDate']) : '-' ).'</td>                              
                                <td>'.( (isset($CheckInTime)) ? TIMEFORMAT($CheckInTime) : '-' ).'</td>
                                <td>'.( (isset($record['CityName'])) ? $record['CityName'] : '-' ).'</td> 
                                <td>'.( (isset($record['HotelName'])) ? $record['HotelName'] : '-' ).'</td> 
                                <td>'.( (isset($record['RoomType'])) ? $record['RoomType'] : '-' ).'</td> 
                                <td>'.$record['TotalPilgrims'].'</td>                              
                                <td>'.((isset($record['NoOfBeds']))?$record['NoOfBeds']:'-').'</td> 
                                <td>'.((isset($record['Nights']))?$record['Nights']:'-').'</td>                             
                                <td>' . ((isset($ActualHotel)) ? $ActualHotel : '-') . '</td>                             
                                <td>'.( (isset($PilgrimCurrentActivity['ActivityRecords']['allow-htl-mecca-room-no'])) ? $PilgrimCurrentActivity['ActivityRecords']['allow-htl-mecca-room-no'] : '-' ).'</td>                             
                                <td>'.( (isset($PilgrimCurrentActivity['ActivityRecords']['allow-htl-mecca-no-of-bed'])) ? $PilgrimCurrentActivity['ActivityRecords']['allow-htl-mecca-no-of-bed'] : '-' ).'</td>                             
                                <td>'.( (isset($PilgrimCurrentActivity['ActivityRecords']['allow-htl-mecca-actual-arrival-time'])) ? TIMEFORMAT($PilgrimCurrentActivity['ActivityRecords']['allow-htl-mecca-actual-arrival-time']) : '-' ).'</td>                           
                                <td>'.( (isset($PilgrimCurrentActivity['ActivityRecords']['allow-htl-mecca-origin'])) ? $PilgrimCurrentActivity['ActivityRecords']['allow-htl-mecca-origin'] : '-' ).'</td>                             
                                <td>'.( (isset($PilgrimCurrentActivity['ActivityRecords']['allow-htl-mecca-contact-number'])) ? $PilgrimCurrentActivity['ActivityRecords']['allow-htl-mecca-contact-number'] : '-' ).'</td>                             
                                <td>' . ( (isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-' ) . '</td>
                                <td>'.( (isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-' ).'</td>    
                                <td>' . ((isset($ActivityUserName)) ? $ActivityUserName : '-') . '</td>
                                <td>'.( (isset($record['CurrentStatus'])) ? ucfirst(str_replace("status","",str_replace("-"," ",$record['CurrentStatus']))) : '-' ).'</td>
                                                          
                                 
                                </tr> ';
    }
    ?>
    </tbody>
</table>
