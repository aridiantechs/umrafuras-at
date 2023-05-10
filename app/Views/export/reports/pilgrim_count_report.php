<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>EA Code</th>
        <th>Country</th>
        <th>Agent Name</th>
        <th>HTL Category</th>
        <th>Create Date</th>
        <th>Group Code</th>
        <th>Group Name</th>
        <th>Adult</th>
        <th>Child</th>
        <th>Infant</th>
        <th>Total</th>
        <th>Category</th>
        <th>Reference</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $cnt = 0;
    $count = 0;
    $Adults = 0;
    $Child = 0;
    $Infant = 0;
    foreach ($records as $record) {
        $cnt++;
        $Category = 'B2C';
        if ($record['AgentUID'] > 0) {
            $Category = 'B2B';
        }
        echo '
                                <tr>
                                <td>' . $cnt . '</td>
                                <td>' . Code('UF/A/', $record['AgentID']) . '</td>     
                                <td>' . $record['CountryName'] . '</td>
                                <td>' . $record['IATANAME'] . '</td>
                                <td>' . ((isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-') . '</td>
                                 <td>' . DATEFORMAT($record['GroupCRDATE']) . '</td>
                                <td>' . Code('UF/G/', $record['GroupCode']) . '</td>
                                <td>' . $record['GroupName'] . '</td>
                                <td>' . $record['Adults'] . '</td>
                                <td>' . $record['Child'] . '</td>
                                <td>' . $record['Infant'] . '</td>
                                <td>' . $record['TotalPilgrim'] . '</td>
                                <td>' . ucfirst(str_replace("_", " ", $record['IATAType'])) . '</td>
                                <td>' . $record['ReferenceName'] . '</td>
                                </tr> ';
        $Adults = $Adults + $record['Adults'];
        $Child = $Child + $record['Child'];
        $Infant = $Infant + $record['Infant'];
    }
    ?>
    </tbody>
    <tr>
        <td colspan="8">Total</td>
        <td><?php echo $Adults; ?></td>
        <td><?php echo $Child; ?></td>
        <td><?php echo $Infant; ?></td>
        <td><?php echo $Adults + $Child + $Infant; ?></td>
    </tr>
</table>
