<table id="ReportTable" class="table table-hover non-hover display nowrap "
       style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Booking Date</th>
        <th>Expiry Date</th>
        <th>BRN No</th>
        <th>Booking ID</th>
        <th>Use ID</th>
        <th>Used Date</th>
        <th>City</th>
        <th>Hotel Name</th>
        <th>Room</th>
        <th>Beds</th>
        <th>Check In</th>
        <th>Check Out</th>
        <th>Nights</th>
        <th>User</th>
    </tr>
    </thead>
    <tbody>
    <?php $cnt = 0;
    foreach ($records as $record) {
        $cnt++;

        echo '
                                    <tr>
                                        <td>' . $cnt . '</td>
                                        <td>' . DATEFORMAT($record['GenerateDate']) . '</td>
                                        <td>' . DATEFORMAT($record['ExpireDate']) . '</td>
                                        <td>' . ((isset($record['BRNCode'])) ? $record['BRNCode'] : '-') . '</td>
                                        <td>' . ((isset($record['PurchaseID'])) ? $record['PurchaseID'] : '-') . '</td>
                                        <td>N/A</td>
                                        <td>N/A</td>
                                        <td>' . ((isset($record['CityName'])) ? $record['CityName'] : '-') . '</td>
                                        <td>' . $record['HotelName'] . '</td>
                                        <td>' . ((isset($record['Rooms'])) ? $record['Rooms'] : '-') . '</td>
                                        <td>' . ((isset($record['Beds'])) ? $record['Beds'] : '-') . '</td>
                                        <td>' . ((isset($record['ChechInDate'])) ? DATEFORMAT($record['ChechInDate']) : '-') . '</td>
                                        <td>' . ((isset($record['CheckOutDate'])) ? DATEFORMAT($record['CheckOutDate']) : '-') . '</td>
                                        <td>' . ((isset($record['TotalNights'])) ? $record['TotalNights'] : '-') . '</td>
                                        <td>' . $record['PurchasedBy'] . '</td>


                                    </tr> ';
    } ?>

    </tbody>
</table