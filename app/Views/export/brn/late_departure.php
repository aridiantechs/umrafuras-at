<table id="ReportTable" class="table table-hover non-hover display nowrap "
       style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Country</th>
        <th>Agent Name</th>
        <th>HTL Category</th>
        <th>V. No</th>
        <th>Group Code</th>
        <th>Group Name</th>
        <!--<th>City</th>
        <th>Actual Hotel</th>
        <th>Room No</th>-->
        <th>Pilgrim ID</th>
        <th>Name</th>
        <th>PPT No</th>
        <th>Nationality</th>
        <th>Mofa No</th>
        <th>Visa No</th>
        <th>MOI No</th>
        <th>Entry Date</th>
        <th>Entry Time</th>
        <th>Dep Date</th>
        <th>Days</th>
        <th>Category</th>
        <th>Reference</th>
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
                                <td>'.$cnt.'</td>
                                <td>' . $record['CountryName'] . '</td>                              
                                                            
                                <td>' . $record['IATANAME'] . '</td>
                                <td>' . $record['HotelCategory'] . '</td>
                                
                                <td>' . $record['VoucherCode'] . '</td>
                                <td>' . Code('UF/G/', $record['GroupID']) . '</td> 
                                <td>' . $record['GroupName'] . '</td> 
                                <td>' . Code('UF/P/', $record['PilgrimID']) . '</td>
                                <td>' . $record['PilgrimFullName'] . '</td> 
                                <td>' . $record['PassportNumber'] . '</td>                            
                                <td>' . $record['Nationality'] . '</td>                                                          
                                <td>' . $record['MOFANumber'] . '</td>                                                         
                                <td>' . $record['VisaNo'] . '</td> 
                                <td>' . $record['MOINumber'] . '</td>                                                         
                                <td>' . DATEFORMAT($record['EntryDate']) . '</td>                                                         
                                <td>' . TIMEFORMAT($record['EntryTime']) . '</td>                                                         
                                <td>' . DATEFORMAT($record['DepartureDate']) . '</td>                                                         
                                <td>' . $record['Days'] . '</td>                                                       
                                <td>' . ucfirst(str_replace("_"," ",$record['IATAType'])). '</td>
                                <td>' . $record['ReferenceName'] . '</td>
                                                                           
                                  </tr> ';
    }
    ?>

    </tbody>
</table