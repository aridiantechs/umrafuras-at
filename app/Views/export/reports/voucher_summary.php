<table id="ReportTable" class="table table-hover non-hover display nowrap "
       style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Hotel Category</th>
        <th>Total Voucher</th>
        <th>Total PAX</th>
        <th>Total Nights</th>
        <th>Total Room</th>
        <th>Sharing</th>
    </tr>
    </thead>
    <tbody>
    <?php $cnt = 0;
    foreach ($records as $record) {
        $cnt++;

        echo '
                                                            <tr>
                                                            <td>' . $cnt . '</td>
                                                            <td>' . $record['Category'] . '</td>
                                                            <td>' . $record['Vouchers'] . '</td>
                                                            <td>' . $record['Pilgrims'] . '</td>
                                                            <td>' . $record['Nights'] . '</td>
                                                            <td>' . $record['Rooms'] . '</td>
                                                            <td>' . $record['Sharing'] . '</td>
                                                            </tr> ';
    }
    ?>

    </tbody>
</table