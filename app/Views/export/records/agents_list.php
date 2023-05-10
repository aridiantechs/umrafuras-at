<table style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Agent Reg. ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Contact Person</th>
        <th>Contact Number</th>
        <th>Country</th>
        <th>City</th>
    </tr>
    </thead>
    <tbody><?php
    $cnt = 0;
    if(count($records) > 0)
    {
        foreach ($records as $record) {
            $cnt++;        echo '
                                <tr>
                                    <td>' . $cnt . '</td>                                
                                    <td>' . Code('UF/A/', $record['UID']) . '</td>                                
                                    <td>' . $record['FullName'] . ' ' . $record['LastName'] . '</td>
                                    <td>' . $record['Email'] . '</td>
                                    <td>' . $record['ContactPersonName'] . '</td>
                                    <td>' . $record['PhoneNumber'] . '</td>
                                    <td>' . CountryName($record['CountryID']) . '</td>
                                    <td>' . CityName($record['CityID']) . '</td>                                  
                                </tr>';
        }
    }
    else {
        echo '<tr><td style="text-align: center;" colspan="8">No Record Found...</td></tr>';
    }

    ?>
    </tbody>
</table>