<table id="ReportTable" class="table table-hover non-hover display nowrap cell-border"
       style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>EA Code</th>
        <th>Country</th>
        <th>Pilgrim ID</th>
        <th>Agent Name</th>
        <th>HTL Category</th>
        <th>Group</th>
        <th>Pilgrim Name</th>
        <th>Gender</th>
        <th>P/p No</th>
        <th>DOB</th>
        <th>Nationality</th>
        <th>Relation</th>
        <th>City</th>
        <th>Embassy</th>
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
                                      <td>' . Code('UF/A/', $record['AgentID']) . '</td>
                                    <td>' . $record['CountryName'] . '</td>   
                                    <td width="28px">' . Code('UF/P/', $record['UID']) . '</td>
                                  
                                    <td>' . $record['AgentName'] . '</td>
                                    <td>' . $record['PackageName'] . '</td>
                                    <td>' . $record['GroupName'] . '</td>                               
                                    <td>' . $record['PilgrimFullName'] . '</td>
                                    <td>' . $record['Gender'] . '</td>
                                    <td>' . $record['PassportNumber'] . '</td>
                                    <td>' . DATEFORMAT($record['DOB']) . '</td>
                                    <td>' . $record['Nationality'] . '</td>
                                    <td>' . $record['Relation'] . '</td>                             
                                    <td>' . $record['CityName'] . '</td>   
                                    <td>' . $record['Embassy'] .'</td>     
                                    <td>' . $record['ReferenceName'] .'</td>               
                                    </tr> ';
    }
    ?>
    </tbody>
</table>
