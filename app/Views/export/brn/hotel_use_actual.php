<table id="ReportTable" class="table table-hover non-hover display nowrap "
       style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Booking Date</th>
        <th>BRN No</th>
        <th>Booking ID</th>
        <th>Use ID</th>
        <th>Used Date</th>
        <th>City</th>
        <th>Hotel Name</th>
        <th>Room Used</th>
        <th>Bed Used</th>
        <th>Check In</th>
        <th>Check Out</th>
        <th>Nights</th>
        <th>System User</th>
    </tr>
    </thead>
    <tbody>
    <?php
    print_r($records);
    $cnt = 0;
    foreach ($records as $record) {
        $cnt++;
        echo '
    <tr>
    <td> ' . $cnt . '</td>
    <td> ' . $record['BookingDate'] . '</td>
    <td> ' . $record['BRNCode'] . '</td>
    <td> ' . ((isset($record['BookingID'])) ? $record['BookingID'] : '-') . '</td>
    <td> ' . ((isset($record['PurchasedBy'])) ? $record['PurchasedBy'] : '-') . '</td>
    <td> ' . ((isset($record['Useddate'])) ? $record['Useddate'] : '-') . '</td>
    <td> ' . $record['CityName'] . '</td>
    <td> ' . ((isset($record['HotelName'])) ? $record['HotelName'] : '-') . '</td>
    <td> ' . ((isset($record['RoomUsed'])) ? $record['RoomUsed'] : '-') . '</td>
    <td> ' . ((isset($record['BedUsed'])) ? $record['BedUsed'] : '-') . '</td>
    <td> ' . ((isset($record['CheckIn'])) ? $record['CheckIn'] : '-') . '</td>
    <td> ' . ((isset($record['CheckOut'])) ? $record['CheckOut'] : '-') . '</td>
    <td> ' . ((isset($record['Nights'])) ? $record['Nights'] : '-') . '</td>
    <td> ' . ((isset($record['UserName'])) ? $record['UserName'] : '-') . '</td>
    </tr>
    ';
    }
    ?>


    </tbody>
</table>