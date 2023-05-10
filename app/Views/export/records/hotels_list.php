<table id="MainRecords" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Reference</th>
        <th>Name</th>
        <th>Category</th>
        <th>Country</th>
        <th>City</th>
        <th>Address</th>
        <th>Telephone No</th>
    </tr>
    </thead>
    <tbody><?php
    $cnt = 0;
    if(count($records) > 0) {
    foreach ($records as $record) {
        $cnt++;
        echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                    <td>' . Code("UF/H/", $record['UID']) . '</td>
                                    <td>' . $record['Name'] . '</td>
                                    <td>' . OptionName($record['Category']) . '</td>
                                    <td>' . CountryName($record['CountryID']) . '</td>
                                    <td>' . CityName($record['CityID']) . '</td>
                                    <td>' . $record['Address'] . '</td>
                                    <td>' . $record['TelephoneNumber'] . '</td>
                                 
                                </tr>';
    }
    }else {
        echo '<tr><td style="text-align: center;" colspan="8">No Record Found...</td></tr>';
    } ?>
    </tbody>
</table>