<table id="MainRecords"  style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Package Reg. ID</th>
        <th>Name</th>
        <th>Start Date</th>
        <th>Expiry Date</th>
        <th>Rate</th>
    </tr>
    </thead>
    <tbody><?php
    $cnt=0;
    if(count($packages) > 0) {
        foreach ($packages as $record) {
            $cnt++;
            echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                    <td>' . Code('UF/P/', $record['UID']) . '</td>
                                    <td>' . $record['Name'] . '</td>
                                    <td>' . $record['StartDate'] . '</td>
                                    <td>' . $record['ExpireDate'] . '</td>
                                    <td>' . $record['Fee'] . '</td>
                                    </tr>';
        }
    }else {
        echo '<tr><td style="text-align: center;" colspan="6">No Record Found...</td></tr>';
    }?>
    </tbody>
</table>