<table id="ReportTable" class="table table-hover non-hover display nowrap cell-border"
       style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Agent Reg. ID</th>
        <th>Full Name</th>
        <th>Contact Person</th>
        <th>Contact Number</th>
        <th>Email</th>
        <th>IATA</th>
        <th>Umrah Agreement</th>
        <th>Country</th>
        <th>City</th>
        <th>Website Domain</th>
    </tr>
    </thead>
    <tbody><?php
    $cnt = 0;
    foreach ($records as $record) {
        $cnt++;
        echo '
                                <tr>
                                    <td>' . $cnt . '</td>                                
                                    <td>' . Code('UF/A/', $record['UID']) . '</td> 
                                    <td>' . $record['FullName'] . ' ' . $record['LastName'] . '</td>
                                    <td>' . $record['ContactPersonName'] . '</td>
                                    <td>' . $record['PhoneNumber'] . '</td>
                                    <td>' . $record['Email'] . '</td>                            
                                    <td>' . $record['IATALicense'] . '</td>                              
                                    <td>' . $record['UmrahAgreement'] . '</td>
                                    <td>' . CountryName($record['CountryID']) . '</td>                    
                                    <td>' . CityName($record['CityID']) . '</td>
                                    <td>' . DomainName($record['WebsiteDomain']) . '</td>                        
                                
                                </tr>';
    }
    ?>
    </tbody>
</table>
