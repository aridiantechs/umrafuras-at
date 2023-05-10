<table id="ReportTable" class="table table-hover non-hover" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Country</th>
        <th>Agent Name</th>
        <th>V. No</th>
        <th>City</th>
        <th>Actual Hotel</th>
        <th>Room No</th>
        <th>Dep Date</th>
        <th>Dep Hotel Time</th>
        <th>Airport</th>
        <th>Flight No</th>
        <th>Flight Time</th>
        <th>Pax</th>
        <th>Seats</th>
        <th>TPT Type</th>
        <th>Vehicle Number</th>
        <th>Driver Name</th>
        <th>Driver Mob. Number</th>
        <th>Pax Mob. No</th>
        <th>TPT Company</th>
        <th>Category</th>
        <th>Reference</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $cnt=0;
    foreach ($records as $record) {
        $cnt++;
        echo '
        <tr>
        <td> '.$cnt.' </td>
        <td> '.$record['CountryName'].' </td>
        <td> '.$record['IATANAME'].' </td>
        <td> '.$record['VoucherCode'].' </td>
        <td> '.$record['HotelCity'].' </td>
        <td> '.$record['ActualHotel'].' </td>
        <td> '.$record['RoomNo'].' </td>
        <td> '.$record['DepartureDate'].' </td>
        <td> '.$record['DepartureHotelTime'].' </td>
        <td> '.$record['AirPort'].' </td>
        <td> '.$record['FlightNo'].' </td>
        <td> '.$record['DepartureTime'].' </td>
        <td> '.$record['TotalPilgrim'].' </td>
        <td> '.$record['Seats'].' </td>
        <td> '.$record['TypeOFTransport'].' </td>
        <td> '.$record['VehicleNumber'].' </td>
        <td> '.$record['DriverName'].' </td>
        <td> '.$record['DriverContactNumber'].' </td>
        <td> '.$record['LeaderPilgrimContactNumber'].' </td>
        <td> '.$record['TransportCompany'].' </td>
        <td> '.ucfirst(str_replace("_", " ", $record['IATAType'])).' </td>
        <td> '.$record['ReferenceName'].' </td>
        <td> N/A </td>
        </tr>      
      
        ';
    }
    ?>
    </tbody>
</table>
