<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Hotel Category</th>
        <th>City</th>
        <th>Hotel Name</th>
        <th>PAX</th><?php
        foreach ($room_types as $room_type) {
            echo '<th>' . $room_type['Name'] . '</th>';
        } ?>

    </tr>
    </thead>
    <tbody>
    <?php
    $cnt = 0;
    foreach ($records as $record) {
        $RoomTypes = array();
        $RoomsPilgrims = $SharingPilgrims = $totalNights = $totalRooms = 0;
        if (isset($record['RoomsPilgrims'])) {
            $RoomsPilgrims = $record['RoomsPilgrims'];
        }
        if (isset($record['SharingPilgrims'])) {
            $SharingPilgrims = $record['SharingPilgrims'];
        }

        $cnt++;

        echo '
        <tr>
        <td>  ' . $cnt . '</td>
        <td>  ' . $record['CategoryName'] . '</td>
        <td>  ' . $record['CityName'] . '</td>
        <td>  ' . $record['HotelName'] . '</td>
        <td>  ' . ($SharingPilgrims + $RoomsPilgrims) . '</td>';
        foreach ($room_types as $room_type) {
            $totalNights += (isset($record['RoomTypes'][$room_type['UID']]['TotalNights']) ? $record['RoomTypes'][$room_type['UID']]['TotalNights'] : 0);
            if ($record['RoomTypeName'] != 'Sharing')
                $totalRooms += (isset($record['RoomTypes'][$room_type['UID']]['TotalBeds']) ? $record['RoomTypes'][$room_type['UID']]['TotalBeds'] : 0);
            echo '<td>' . (isset($record['RoomTypes'][$room_type['UID']]['TotalBeds']) ? $record['RoomTypes'][$room_type['UID']]['TotalBeds'] : '-') . '</td>';
        }
        echo '</tr> ';

    }

    ?>
    </tbody>

</table>
