<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>BRN/Cash</th>
        <th>City</th>
        <th>Hotel</th>

        <th>Date</th>
        <th>Room No</th>
        <th>Bed Loss</th>

    </tr>
    </thead>
    <tbody>
    <?php $cnt = 0;
    foreach ($records as $record) {
        $cnt++;

        echo '
                                    <tr>
                                    <td>' . $cnt . '</td>
                                    <td>' . ((isset($record['BRNCode'])) ? $record['BRNCode'] : 'Cash') . '</td>

                                    <td>' . $record['City'] . ' </td>
                                    <td>' . $record['Hotel'] . ' </td>

                                    <td>' . $record['CheckInDate'] . '</td>
                                    <td>' . $record['RoomNumber'] . '</td>
                                    <td>' . $record['BedLoss'] . ' </td>

                                    </tr> ';
    } ?>
    </tbody>
</table>