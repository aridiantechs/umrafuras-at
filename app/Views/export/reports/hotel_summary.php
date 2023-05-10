<?php
//
//print_r($records);exit;
//
//?>

<table id="ReportTable" class="table table-hover non-hover" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>HTL Category</th>
        <th>City</th>
        <th>Actual HTL Name</th>
        <th>PAX</th><?php
        foreach ($room_types as $room_type) {
            echo '<th>' . $room_type['Name'] . '</th>';
        } ?>
        <th>Sharing PAX</th>
        <th>Total Rooms</th>
        <th>Nights</th>
        <th>Reference</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $cnt = 0;
    foreach ($records as $record) {
        $RoomsPilgrims = $SharingPilgrims = $totalNights = $totalRooms = 0;
        $cnt++;

        if (isset($record['RoomsPilgrims'])) {
            $RoomsPilgrims = $record['RoomsPilgrims'];
        }
        if (isset($record['SharingPilgrims'])) {
            $SharingPilgrims = $record['SharingPilgrims'];
        }

        echo '
        <tr>
        <td> '.$cnt.' </td>
        <td> '.$record['CategoryName'].' </td>
        <td> '.$record['CityName'].' </td>
        <td> '.$record['HotelName'].' </td>
        <td> '.($SharingPilgrims + $RoomsPilgrims).' </td>';
        foreach ($room_types as $room_type) {
            $totalNights += (isset($record['RoomTypes'][$room_type['UID']]['TotalNights']) ? $record['RoomTypes'][$room_type['UID']]['TotalNights'] : 0);
            if ($record['RoomTypeName'] != 'Sharing')
                $totalRooms += (isset($record['RoomTypes'][$room_type['UID']]['TotalBeds']) ? $record['RoomTypes'][$room_type['UID']]['TotalBeds'] : 0);
            echo'<td>'.(isset($record['RoomTypes'][$room_type['UID']]['TotalBeds']) ? $record['RoomTypes'][$room_type['UID']]['TotalBeds'] : '-').' </td>';
        }
        echo '
           <td>'.$record['SharingPilgrims'].'</td>
           <td>'.$totalRooms.'</td>
           <td>'.$totalNights.'</td>
           <td>'.$record['RefAgentName'].'</td>
         </tr>
        ';
    }
    ?>
    </tbody>
</table>
