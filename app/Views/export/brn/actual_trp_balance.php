<table id="ReportTable" class="table table-hover non-hover display nowrap "
       style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Booking Date</th>
        <th>BRN No</th>
        <th>Vehicle Type</th>
        <th>Booking ID</th>
        <th>QTY</th>
        <th>Seats</th>
        <?php
        foreach ($sectors as $sector) {
            echo '<th>' . $sector['Name'] . '</th><th>Remaining</th>';
        } ?>
        <th>Company Name</th>
        <th>System User</th>
    </tr>
    </thead>
    <tbody>
    <?php $cnt = 1;
    foreach ($records as $record){ ?>
        <tr>
            <td>1</td>
            <td><?= $record['BookingDate'] ?></td>
            <td><?= $record['BRNCode'] ?></td>
            <td><?= $record['VehicleType'] ?></td>
            <td><?= $record['BookingID'] ?></td>
            <td><?= $record['NoOfVehicles'];?></td>
            <td><?= $record['Seats'];?></td>

            <?php

            foreach ($sectors as $sector) {
                $NoOfSeats = (isset($record['sectors'][$sector['UID']]['NoOfSeats']) ? $record['sectors'][$sector['UID']]['NoOfSeats'] : '-');
                $BRNUsed = (isset($record['sectors'][$sector['UID']]['BRNUsed']) ? $record['sectors'][$sector['UID']]['BRNUsed'] : '-');
                $Seats=(isset($record['sectors'][$sector['UID']]['BRNUsed']) ? $record['Seats']-$record['sectors'][$sector['UID']]['BRNUsed'] : '-');
                echo '<td>' . $BRNUsed . '</td><td>' . $Seats . '</td>';
            } ?>
            <td><?= $record['PurchaseID'] ?></td>
            <td><?= $record['UserName'] ?></td>


        </tr>
        <?php $cnt++;
    } ?>

    </tbody>
</table