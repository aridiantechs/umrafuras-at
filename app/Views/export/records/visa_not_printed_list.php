<table id="MainRecords"style="width:100%">
    <thead>
    <tr>
        <th width="10">#</th>
        <th>Agent</th>
        <th>Group</th>
        <th width="90">MOFA Pilgrim ID</th>
        <th>Full Name</th>
        <th width="70">Nationality</th>
        <th width="100">Passport Number</th>
        <th width="90">MOFA Number</th>
    </tr>
    </thead>
    <tbody><?php
    $Cnt =1;
    if(count($records) > 0) {
    foreach ($records as $record) {
        echo '
                                <tr>
                                    <td>'.$Cnt.'</td>                                 
                                    <td>' . $record['AgentFullName'] . '</td>
                                    <td>' . trim($record['GroupFullName']) . '</td>
                                    <td>' . $record['MOFAPilgrimID'] . '</td>
                                    <td>' . $record['FirstName'] . '</td>
                                    <td>' . $record['Nationality'] . '</td>
                                    <td>' . $record['PassportNumber'] . '</td>
                                    <td>' . $record['PassportNumber'] . '</td>
                                  
                                </tr>';
        $Cnt++;
    }}
    else
    {
        echo '<tr><td style="text-align: center;" colspan="8">No Record Found...</td></tr>';
    }?>
    </tbody>
</table>