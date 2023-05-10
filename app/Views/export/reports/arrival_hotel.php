<table id="ReportTable" class="table table-hover non-hover" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Country</th>
        <th>Agent Name</th>
        <th>BRN</th>
        <th>V. No</th>
        <th>HTL Category</th>
        <th>City</th>
        <th>HTL Name</th>
        <th>Room Type</th>
        <th>PAX</th>
        <th>Beds</th>
        <th>Nights</th>
        <th>Origin</th>
        <th>CHK In Date & Time</th>
        <th>PAX Mob. No</th>
        <th>Category</th>
        <th>Reference</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $cnt = 0;

    foreach ($records as $record) {
        $cnt++;
        echo '
        <tr>
         <td> ' . $cnt . '</td>
         <td> ' . $record['CountryName'] . '</td>
         <td> ' . $record['IATANAME'] . '</td>
         <td> ' . ((isset($record['BRN'])) ? $record['BRN'] : 'Cash') . '</td>
         <td> ' . $record['VoucherCode'] . '</td>
         <td> ' . $record['HotelCategory'] . '</td>
         <td> ' . $record['CityName'] . '</td>
         <td> ' . $record['HotelName'] . '</td>
         <td> ' . $record['RoomType'] . '</td>
         <td> ' . $record['TotalPex'] . '</td>
         <td> ' . $record['NoOfBeds'] . '</td>
         <td> ' . $record['Nights'] . '</td>
         <td> ' . $record['Origin'] . '</td>
         <td> ' . DATEFORMAT(explode(',', $record['ActualArrivalDate'])[0]) . ' ' . TIMEFORMAT(explode(',', $record['ActualArrivalTime'])[0]) . '</td>
         <td> ' . explode(',', $record['PaxMobileNo'])[0] . ' </td>
         <td> ' . ucfirst(str_replace("_", " ", $record['IATAType'])) . ' </td>
         <td> ' . $record['ReferenceName'] . ' </td>
         <td> N/A </td>        
       </tr>
        ';

    } ?>
    </tbody>
</table>
