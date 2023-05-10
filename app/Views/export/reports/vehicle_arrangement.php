<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Travel Date</th>
        <th>City</th>
        <th>Pick up Location</th>
        <th>Pick up Time</th>
        <th>PAX</th>
        <th>Transport Type</th>
        <th>No Of Vehicles</th>
        <th>Drop off location</th>
    </tr>
    </thead>
    <tbody>
    <?php $cnt = 1;
    foreach ($records as $record) {
        echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                    <td>' . DATEFORMAT($record['TravelDate']) . '</td>
                                    <td>' . $record['CityName'] . '</td>
                                    <td>' . $record['PickupLocation'] . '</td>
                                    <td>' . $record['PickupTime'] . '</td>
                                    <td>' . $record['NoOfPax'] . '</td>
                                    <td>' . $record['TransportName'] . '</td>
                                    <td>' . $record['TotalVehicals'] . '</td>
                                    <td>' . $record['DropOffLocation'] . '</td>
                                </tr>';
        $cnt++;
    }
    ?>
    </tbody>
</table>
