<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Origin Country</th>
        <th>Arrival Date</th>
        <th>Flight No</th>
        <th>Arrival Time </th>
        <th>PAX</th>
        <th>TPT Type</th>
        <th>Airport</th>
        <th>Arrival Mode</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $cnt =0;
    foreach ($records as $record) {
        $cnt++;
        echo
        '
        <tr>
        <td> '.$cnt.'</td>
        <td> '.$record['CountryName'].'</td>
        <td> '.$record['ArrivalDate'].'</td>
        <td> '.$record['FlightNo'].'</td>
        <td> '.$record['ArrivalTime'].'</td>
        <td> '.$record['TotalPex'].'</td>
        <td> '.$record['TypeOFTransport'].'</td>
        <td> '.$record['Airport'].'</td>
        <td> '.$record['TravelType'].'</td>
        </tr>
        
        ';

    }
    ?>
    </tbody>
</table>
