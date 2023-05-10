<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>EA Code</th>
        <th>Country</th>
        <th>Pilgrim ID </th>
        <th>Agent Name</th>
        <th>HTL Category</th>
        <th>Group Name</th>
        <th>Pilgrim Name </th>
        <th>Gender</th>
        <th>P/p No</th>
        <th>DOB</th>
        <th>Nationality</th>
        <th>City</th>

        <th>Category</th>
        <th>Pilgrim Status </th>
        <th>Reference </th>

    </tr>
    </thead>
    <tbody>
    <?php
    $cnt=0;
    foreach ($records as $record) {
        $cnt++;
        $Category = 'B2B';
        if ($record['IATAType'] == 'external_agent') {
            $Category = 'External Agent';
        }
        echo '
                                <tr>
                                <td>' . $cnt . '</td>
                                <td width="28px">' . Code('UF/A/', $record['AgentID']) . '</td>
                                  <td>' . $record['CountryName'] . '</td> 
                                <td>' . Code('UF/P/', $record['PilgrimID']) . '</td>
                                
                                <td>' . $record['AgentName'] . '</td>
                                 <td>' . $record['HotelCategory'] .'</td>            
                                <td>' . $record['GroupName'] . '</td>                               
                                <td>' . $record['PilgrimFullName'] .'</td>
                                <td>' . $record['Gender'] . '</td>
                                <td>' . $record['PassportNumber'] . '</td>
                                <td>' . DATEFORMAT($record['DOB']) . '</td>
                                <td>' . $record['Nationality'] . '</td>     
                                                
                                <td>' . $record['CityName'] . '</td> 
                                  
                                <td>'.$Category.'</td>                       
                                <td>' . $record['CurrentStatus'] .'</td>                       
                                <td>' . $record['ReferenceName'] .'</td>                       
                                </tr> ';
    }
    ?>
    </tbody>
</table>
