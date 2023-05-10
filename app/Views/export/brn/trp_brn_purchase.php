<table id="ReportTable" class="table table-hover non-hover display nowrap "
       style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Booking Date</th>
        <th>BRN No</th>
        <th>Booking ID</th>
        <th>Vehicle Type</th>
        <th>QTY</th>
        <th>Seats</th>
        <th>Arrival Date</th>
        <th>Company Name</th>
        <th>System User</th>
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
        <td> ' . $record['GenerateDate'] . '</td>
        <td> ' . ((isset($record['BRNCode'])) ? $record['BRNCode'] : '-') . '</td>
        <td> ' . ((isset($record['PurchaseID'])) ? $record['PurchaseID'] : '-') . '</td>
        <td> ' . ((isset($record['VehicleType'])) ? $record['VehicleType'] : '-') . '</td>
        <td> ' . $record['NoOfVehicles'] . '</td>
        <td> ' . ((isset($record['Seats'])) ? $record['Seats'] : '-') . '</td>
        <td> ' . ((isset($record['ChechInDate'])) ? $record['ChechInDate'] : '-') . '</td>
        <td> ' . ((isset($record['CompanyName'])) ? $record['CompanyName'] : '-') . '</td>
        <td> ' . ((isset($record['PurchasedBy'])) ? $record['PurchasedBy'] : '-') . '</td>             
        </tr>       
      
        ';
    }
    ?>
    </tbody>
</table