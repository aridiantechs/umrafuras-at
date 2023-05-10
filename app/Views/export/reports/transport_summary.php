<?php

use App\Models\Crud;

$Crud = new Crud();
?>
<table id="ReportTable" class="table table-hover non-hover" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Sector</th>
        <th>No Of Vehicles</th>
        <th>Transport Type</th>
        <th>No Of Pax</th>
        <th>Total Seats</th>
        <th>Use Seats</th>
        <th>Loss</th>

    </tr>
    </thead>
    <tbody>
    <?php
    $cnt = 0;
    foreach ($records as $record) {
        $SQL = 'SELECT string_agg(Distinct "pilgrim"."meta"."Value" , \',\') as "NoofVehicle"  
      FROM "pilgrim"."meta" 
      WHERE "pilgrim"."meta"."Option" LIKE \'%check-out%vehicle-number\' 
      AND "pilgrim"."meta"."AllowReference" = ' . $record['UID'] . '
      GROUP BY "pilgrim"."meta"."SystemDate"';
        $ResultNoofVehicle = $Crud->ExecuteSQL($SQL);
        $SQL = 'select coalesce( (SELECT SUM( "T1"."Value") as "Value" FROM (
                        SELECT SUM( DISTINCT cast("pilgrim"."meta"."Value"  as int) ) as "Value"  
                        FROM "pilgrim"."meta" 
                        WHERE "pilgrim"."meta"."Option" LIKE \'%actual-no-of-seats\' 
                        AND "pilgrim"."meta"."AllowReference" = ' . $record['UID'] . '
                        GROUP BY "pilgrim"."meta"."SystemDate"
                    ) as "T1" ), 0) as "TotalUsedSeats"';
        $ResultTotalUsedSeats = $Crud->ExecuteSQL($SQL);
        $LossSeats = $record['NoOfSeats'] - $ResultTotalUsedSeats[0]['TotalUsedSeats'];
        $cnt++;
        echo '<tr>';
        echo '<td>' . $cnt . '</td>';
        echo '<td>' . ((isset($record['Sector'])) ? $record['Sector'] : '-') . '</td>';
        echo '<td>' . ((isset($ResultNoofVehicle[0]['NoofVehicle'])) ? $ResultNoofVehicle[0]['NoofVehicle'] : '-') . '</td>';
        echo '<td>' . ((isset($record['TypeOFTransport'])) ? $record['TypeOFTransport'] : '-') . '</td>';
        echo '<td>' . ((isset($record['TotalPax'])) ? $record['TotalPax'] : '-') . '</td>';
        echo '<td>' . ((isset($record['NoOfSeats'])) ? $record['NoOfSeats'] : '-') . '</td>';
        echo '<td>' . ((isset($ResultTotalUsedSeats[0]['TotalUsedSeats'])) ? $ResultTotalUsedSeats[0]['TotalUsedSeats'] : '-') . '</td>';
        echo '<td>' . ((isset($LossSeats)) ? $LossSeats : '-') . '</td>';

        echo '</tr>';
    }
    ?>
    </tbody>
</table>
