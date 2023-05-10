<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Create Date</th>
        <th>Country</th>
        <th>Agent Name</th>
        <th>Sub Agent Name</th>
        <th>Create By</th>
        <th>Voucher Ref. ID</th>
        <th>Voucher No</th>
        <th>Adult</th>
        <th>Child</th>
        <th>Infant</th>
        <th>Total PAX</th>
        <th>Arrival</th>
        <th>Departure</th>
        <th>Total Nights</th>
        <th>Arrival Mode</th>
        <th>Status</th>
        <th>Category</th>
        <th>Reference</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $cnt = 0;
    foreach ($records as $record) {
        $cnt++;
        echo '
                                <tr>
                                <td>' . $cnt . '</td>
                                <td>' . DATEFORMAT($record['CreatedDate']) . '</td>
                                <td>' . $record['CountryName'] . ' </td>
                                <td>' . $record['AgentName'] . ' </td>
                                <td>' . $record['SubAgentName'] . ' </td>
                                <td>' . $record['UserCreatedBy'] . ' </td>
                                <td>' . Code('UF/V/', $record['UID']) . ' </td>
                                <td>' . $record['Adults'] . ' </td>
                                <td>' . $record['Child'] . ' </td>
                                <td>' . $record['Infant'] . ' </td>
                                <td>' . DATEFORMAT($record['ArrivalDate']) . ' </td>
                                <td>' . DATEFORMAT($record['DepartureDate']) . ' </td>
                                <td>' . $record['TotalNights'] . ' </td>
                                <td>N/A </td>
                                <td>N/A </td>
                                <td>' . ucfirst(str_replace("_", " ", $record['IATAType'])) . ' </td>
                                <td>' . $record['ReferenceName'] . ' </td>
                             
                                </tr> 
        ';
    }
    ?>
    </tbody>
</table>
