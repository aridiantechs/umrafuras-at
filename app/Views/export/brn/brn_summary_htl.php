<table id="ReportTable" class="table table-hover non-hover display nowrap "
       style="width:100%">
    <thead>
    <tr>
        <th rowspan="2">#</th>
        <th rowspan="2">City</th>
        <th rowspan="2">Hotel Name</th>
        <th colspan="5" style="text-align: center">Visa</th>
        <th colspan="5" style="text-align: center">Actual</th>
    </tr>
    <tr>
        <th>BRN</th>
        <th>Rooms</th>
        <th>Beds</th>
        <th>Use</th>
        <th>Loss</th>
        <th>BRN</th>
        <th>Rooms</th>
        <th>Beds</th>
        <th>Use</th>
        <th>Loss</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $cnt = 0;
    foreach ($records as $record) {
        $cnt++;
        echo '
        <tr>
        <td>  ' . $cnt . '</td>
        <td>  ' . $record['CityName'] . '</td>
        <td>  ' . $record['HotelName'] . '</td>
        <td>  ' . $record['VisaBRN'] . '</td>
        <td>  ' . ((isset($record['VisaRooms'])) ? $record['VisaRooms'] : '-') . '</td>
        <td>  ' . ((isset($record['VisaBeds'])) ? $record['VisaBeds'] : '-') . '</td>
        <td>  ' . ((isset($record['VisaBRNUse'])) ? $record['VisaBRNUse'] : '-') . '</td>
        <td>  ' . ((isset($record['VisaBRNLoss'])) ? $record['VisaBRNLoss'] : '-') . '</td>
        <td>  ' . ((isset($record['ActualBRN'])) ? $record['ActualBRN'] : '-') . '</td>
        <td>  ' . ((isset($record['ActualRooms'])) ? $record['ActualRooms'] : '-') . '</td>
        <td>  ' . ((isset($record['ActualBeds'])) ? $record['ActualBeds'] : '-') . '</td>
        <td>  ' . ((isset($record['ActualBRNUse'])) ? $record['ActualBRNUse'] : '-') . '</td>
        <td>  ' . ((isset($record['ActualBRNLoss'])) ? $record['ActualBRNLoss'] : '-') . '</td>
        </tr>
         
        ';
    }    ?>

    </tbody>
</table>