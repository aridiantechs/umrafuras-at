<?php
use App\Models\Crud;

?>
<table id="ReportTable" class="table table-hover non-hover display nowrap "
       style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Booking Date</th>
        <th>BRN No</th>
        <th>Vehicle Type</th>
        <th>Booking ID</th>
        <th>Use ID</th>
        <th>Used Date</th>
        <th>QTY</th>
        <th>Seats</th>
        <?php
        foreach ($sectors as $sector) {
            echo '<th>' . $sector['Name'] . '</th>    <th>USE</th>';
        } ?>
        <th>Company Name</th>
        <th>User</th>
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
        <td>N/A</td>
        <td><?= $record['Useddate'] ?></td>
        <td><?= $record['NoOfVehicles']; ?></td>
        <td><?= $record['Seats']; ?></td>
        <?php
        foreach ($sectors as $sector) {
            $NoOfSeats = (isset($record['sectors'][$sector['UID']]['NoOfSeats']) ? $record['sectors'][$sector['UID']]['NoOfSeats'] : '-');
            $BRNUsed = (isset($record['sectors'][$sector['UID']]['BRNUsed']) ? $record['sectors'][$sector['UID']]['BRNUsed'] : '-');
            echo '<td>' . $NoOfSeats . '</td><td>' . $BRNUsed . '</td>';
        } ?>
        <td><?= $record['PurchaseID'] ?></td>
        <td><?= $record['UserName'] ?></td>
    </tr>
    </tbody><?php $cnt++;
    } ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="7">Total</td>
        <td>abc</td>
        <td>Seats</td>
        <?php
        foreach ($sectors as $sector) {
            echo '<td>Total SUM: ' . $sector['UID'] . '</td><td>Used SUM: ' . $sector['UID'] . '</td>';
        } ?>
        <td>Company Name</td>
        <td>User</td>
    </tr>
    </tfoot>
</table