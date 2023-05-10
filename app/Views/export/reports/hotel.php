 <table id="ActualHotelRecord" class="table table-hover non-hover display nowrap"
       style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Country</th>
        <th>Agent Name</th>
        <th>BRN</th>
        <th>V. No</th>
        <th>City</th>
        <th>HTL Category</th>
        <th>Actual HTL Name</th>
        <th>Room Type</th>
        <th>Room No</th>
        <th>PAX</th>
        <th>Beds</th>
        <th>Actual Beds</th>
        <th>CHK In Date</th>
        <th>CHK Out Date</th>
        <th>Nights</th>
        <th>Actual CHK In Time</th>
        <th>Origin</th>
        <th>PAX MOB. No</th>
        <th>Category</th>
        <th>Reference</th>

    </tr>
    </thead>
    <tbody>
    <?php
    $cnt = 0;

    foreach ($records as $record) {
        $cnt++;
        $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], 'check-in-' . strtolower($record['CityName']) . '-status');
        echo '
                                <tr>
                                <td>' . $cnt . '</td>
                                <td>' . $record['CountryName'] . ' </td>
                                <td>' . $record['IATANAME'] . ' </td>
                                <td>' . ((isset($record['BRN'])) ? $record['BRN'] : 'Cash') . '</td>
                                <td>' . $record['VoucherCode'] . '</td>
                                <td>' . $record['CityName'] . '</td>
                                <td>' . $record['HotelCategory'] . ' </td>
                                <td>' . $record['HotelName'] . '</td>
                                <td>' . $record['RoomType'] . '</td>
                                <td>' . $record['RoomNo'] . '</td>
                                <td>' . $record['TotalPex'] . '</td>
                                <td>' . $record['NoOfBeds'] . '</td>
                                <td>' . $record['ActualBeds'] . '</td>
                                <td>' . $record['CheckIn'] . ' </td>
                                <td>' . $record['CheckOut'] . ' </td>
                                <td>' . $record['Nights'] . '</td>
                                <td>' . TIMEFORMAT(explode(',', $record['ActualArrivalTime'])[0]) . ' </td>
                                <td>' . ucwords(str_replace('-', ' ', $PilgrimLastActivity['LastActivity'])) . '</td>
                                <td>' . explode(',', $record['PaxMobileNo'])[0] . ' </td>
                                <td>' . ucfirst(str_replace("_", " ", $record['IATAType'])) . '</td>
                                <td>' . $record['ReferenceName'] . '</td>
                                   </tr> ';
    }
    ?>
    </tbody>
</table>