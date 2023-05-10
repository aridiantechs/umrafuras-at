<table id="MainRecords" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Pilgrim Reg. ID</th>
        <th>Agent</th>
        <th>Group</th>
        <th>Full Name</th>
        <th>DOB</th>
        <th>DOB In Years</th>
        <th>Passport Number</th>
        <th>Country</th>
    </tr>
    </thead>
    <tbody><?php
    if(count($records) > 0) {
    foreach ($records as $record) {
        echo '
                                <tr>
                                    <td>' . $record['UID'] . '</td>  
                                    <td>' . Code('UF/P/', $record['UID']) . '</td>                              
                                    <td>' . $record['AgentName'] . '</td>
                                    <td>' . $record['GroupName'] . '</td>
                                    <td>' . $record['FirstName'] . '</td>
                                    <td>' . $record['DOB'] . '</td>
                                    <td>' . $record['DOBInYears'] . '</td>
                                    <td>' . $record['PassportNumber'] . '</td>
                                    <td>' . $record['Country'] . '</td>
                                </tr>';
    } }
    else{
        echo '<tr><td style="text-align: center;" colspan="9">No Record Found...</td></tr>';

    }?>
    </tbody>
</table>