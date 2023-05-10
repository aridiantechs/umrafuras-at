<table id="ReportTable" class="table table-hover non-hover" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Agent Name</th>
        <th>BRN</th>
        <th>V. No</th>
        <th>CHK Out Date</th>
        <th>CHK Out Time</th>
        <th>City</th>
        <th>Pick Up Point</th>
        <th>Actual Hotel</th>
        <th>Room No</th>
        <th>Pax</th>
        <th>Seats</th>
        <th>Actual Dep Time</th>
        <th>Sector</th>
        <th>Destination</th>
        <th>TPT Type</th>
        <th>Vehicle Number</th>
        <th>Driver Name</th>
        <th>Driver Mob. Number</th>
        <th>Pax Mob. No</th>
        <th>TPT Company</th>
        <th>Category</th>
        <th>Reference</th>

    </tr>
    </thead>
    <tbody>
    <?php
    $cnt=0;
    foreach ($records as $record) {
        $cnt++;

        echo '
        <tr>
        <td>  ' . $cnt . '   </td>
        <td>  ' . ((isset($record['IATANAME'])) ? $record['IATANAME'] : '') . '   </td>
        <td>  ' . ((isset($record['BRN'])) ? $record['BRN'] : 'Cash') . '   </td>
        <td>  ' . $record['VoucherCode'] . '   </td>       
        <td>  ' . ((isset($record['CheckOutDate'])) ? DATEFORMAT($record['CheckOutDate']) : '-') . '   </td>
        <td>  ' . ((isset($record['CheckOutTime'])) ? TIMEFORMAT($record['CheckOutTime']) : '-') . '   </td>
         <td>  ' . $record['CityName'] . '   </td>
         <td>  ' . ((isset($record['PickupPoint'])) ? $record['PickupPoint'] : '-') . '   </td>
         <td>  N/A   </td>
         <td>  ' . ((isset($record['RoomNo'])) ? $record['RoomNo'] : '-') . '   </td>
         <td>  ' . $record['TotalPax'] . '   </td>
         <td>  ' . $record['NoOfSeats'] . '   </td>
         <td>  ' . ((isset($record['ActualDepartureTime'])) ? TIMEFORMAT($record['ActualDepartureTime']) : '-') . '   </td>
         <td>  ' . $record['Sector'] . '   </td>
         <td>  ' . ((isset($record['TransportDestination'])) ? $record['TransportDestination'] : '-') . '   </td>
          <td>  ' . $record['TypeOFTransport'] . '   </td>
          <td>  ' . explode(',', $record['VehicleNumber'])[0] . '   </td>
          <td>  ' . explode(',', $record['DriverName'])[0] . '   </td>
          <td>  ' . explode(',', $record['DriverNumber'])[0] . '   </td>
          <td>  ' . explode(',', $record['PaxContactNumber'])[0] . '   </td>
          <td>  ' . explode(',', $record['TransportCompany'])[0] . '   </td>
          <td>  ' . ucfirst(str_replace("_", " ", $record['IATAType'])) . '   </td>
          <td>  ' . $record['ReferenceName'] . '   </td>
        </tr>
        ';

    }
    ?>
    </tbody>
</table>
