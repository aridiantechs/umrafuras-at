<table style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Agent Reg. ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Contact Number</th>
        <th>Country</th>
        <th>City</th>
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
                                    <td>' . Code('UF/A/', $record['UID']) . '</td>                                
                                    <td>' . $record['FullName'] . '</td>
                                    <td>' . $record['Email'] . '</td>
                                    <td>' . $record['PhoneNumber'] . '</td>
                                    <td>' . CountryName($record['Country']) . '</td>
                                    <td>' . CityName($record['City']) . '</td>                                 
                                </tr>';
    }}
    else{
        echo '<tr><td style="text-align: center;" colspan="7">No Record Found...</td></tr>';

    }?>
    </tbody>
</table>
