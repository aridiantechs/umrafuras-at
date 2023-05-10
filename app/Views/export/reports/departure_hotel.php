<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Country</th>
        <th>Agent Name</th>
        <th>V. No </th>
        <th>City</th>
        <th>Actl Hotel</th>
        <th>Room No</th>
        <th>Pax</th>
        <th>Seats</th>
        <th>CHK Out Date</th>
        <th>CHK Out Time</th>
        <th>Destination</th>
        <th>TPT Type</th>
        <th>Vehicle No</th>
        <th>Driver Name</th>
        <th>Driver Mob.</th>
        <th>PAX Mob. No</th>
        <th>TPT Company</th>
        <th>Category</th>
        <th>Reference  </th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $cnt=0;
    foreach ($records as $record) {
        $cnt++;
        echo
        '
        <tr>
        <td>'.$cnt.'</td>
        <td>'.$record['CountryName'].'</td>
        <td>'.$record['IATANAME'].'</td>
        <td>'.$record['VoucherCode'].'</td>
        <td>'.$record['hotelcity'].'</td>
        <td>'.$record['ActualHotel'].'</td>
        <td>'.$record['RoomNo'].'</td>
        <td>'.$record['TotalPilgrim'].'</td>
        <td>'.$record['Seats'].'</td>
        <td>'.$record['CheckOutDate'].'</td>
        <td>'.$record['CheckOutTime'].'</td>
        <td>'.$record['TransportDestination'].'</td>
        <td>'.$record['TypeOFTransport'].'</td>
        <td>'.$record['VehicleNumber'].'</td>
        <td>'.$record['DriverName'].'</td>
        <td>'.$record['DriverMobileNumber'].'</td>
        <td>'.explode(',', $record['PaxContactNumber'])[0].'</td>
        <td>'.$record['TransportCompany'].'</td>
        <td>'.ucfirst(str_replace("_", " ", $record['IATAType'])).'</td>
        <td>'.$record['ReferenceName'].'</td>
        <td>N/A</td>
        </tr>
        
        ';
    }
    ?>
    </tbody>
</table>
