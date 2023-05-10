<table id="ReportTable" class="table table-hover non-hover display nowrap "
       style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Booking Date</th>
        <th>BRN No</th>
        <th>Booking ID</th>
        <th>Vehicle Type</th>
        <th>Sector</th>
        <th>Seat Loss</th>
        <th>Company Name</th>
    </tr>
    </thead>
    <tbody>

    <?php
    foreach ($records as $record) {

        $cnt++;
        echo '
        <tr>
        <td>' . $cnt . '</td>
        <td>' . $record['BookingDate'] . '</td>
        <td>' . $record['BRNCode'] . '</td>
        <td>' . $record['BookingID'] . '</td>
        <td>' . $record['VehicleType'] . '</td>
        <td>' . $record['SectorName'] . '</td>
        <td>' . $record['SeatLoss'] . '</td>
        <td>' . $record['CompanyName'] . '</td>
        </tr>
        ';
    }


    ?>

    </tbody>
</table