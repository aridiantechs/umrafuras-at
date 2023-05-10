<table id="ReportTable" class="table table-hover non-hover display nowrap "
       style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Booking Date</th>
        <th>Expiry Date</th>
        <th>BRN No</th>
        <th>Booking ID</th>
        <th>City</th>
        <th>Hotel Name</th>
        <th>Rooms</th>
        <th>Beds</th>
        <th>CHK In Date</th>
        <th>CHK Out Date</th>
        <th>Nights</th>
        <th>Purchased By</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $cnt = 0;
    foreach ($HtlPurchase as $record) {

        $cnt++;
        ?>
        <tr>
                 <td><?=$cnt?></td>
                 <td><?=DATEFORMAT($record['GenerateDate'])?></td>
                 <td><?=DATEFORMAT($record['ExpireDate'])?></td>
                 <td><?=((isset($record['BRNCode'])) ? $record['BRNCode'] : '-')?></td>
                 <td><?= ((isset($record['PurchaseID'])) ? $record['PurchaseID'] : '-')?></td>
                 <td><?=((isset($record['CityName'])) ? $record['CityName'] : '-')?></td>
                 <td><?=( ( isset($record['HotelName']) )? $record['HotelName'] : '-' )?></td>
                 <td><?=((isset($record['Rooms'])) ? $record['Rooms'] : '-')?></td>
                 <td><?=((isset($record['Beds'])) ? $record['Beds'] : '-')?></td>
                 <td><?=((isset($record['ChechInDate'])) ? DATEFORMAT($record['ChechInDate']) : '-')?></td>
                 <td><?=((isset($record['CheckOutDate'])) ? DATEFORMAT($record['CheckOutDate']) : '-')?></td>
                 <td><?=((isset($record['TotalNights'])) ? $record['TotalNights'] : '-')?></td>
                 <td><?=( ( isset($record['PurchasedBy']) )? $record['PurchasedBy'] : '-' )?></td>

         </tr>
    <?php
    }
    ?>
    </tbody>
</table