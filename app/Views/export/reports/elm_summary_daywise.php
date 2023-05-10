<table id="ReportTable" class="table table-hover non-hover" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Country</th>
        <th>Agent Name</th>
        <th>Date</th>
        <th>Arrvl JED</th>
        <th>Dep JED</th>
        <th>Arrvl MED</th>
        <th>Dep MED</th>
        <th>Arrvl Yanbu</th>
        <th>Dep Yanbu</th>
        <th>CHK In MAK</th>
        <th>CHK Out MAK</th>
        <th>CHK in MED</th>
        <th>CHK Out MED</th>
        <th>CHK in JED</th>
        <th>CHK Out JED</th>
        <th>Pax In MAK</th>
        <th>Pax In MED</th>
        <th>Pax In JED</th>
        <th>Category</th>
        <th>Reference</th>

    </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    if (count($records) > 0)
        foreach ($records as $recordDate => $record) {
            //print_r($record);
            foreach ($record as $elmrslt) {
                $PaxInMak = CKHBlank($elmrslt['keys']['check-in-mecca-status'], 0);
                $PaxInMed = CKHBlank($elmrslt['keys']['check-in-medina-status'], 0);
                $PaxInJed = CKHBlank($elmrslt['keys']['check-in-jeddah-status'], 0);
                echo '
                                        <tr>
                                            <td>' . $i . '</td>
                                            <td>' . $elmrslt['CountryName'] . '</td>
                                            <td>' . $elmrslt['AgentName'] . '</td>
                                            <td>' . DATEFORMAT($recordDate) . '</td>                             
                                            <td>' . CKHBlank($elmrslt['keys']['jeddah-arrival-status'], '-') . '</td>                             
                                            <td>' . CKHBlank($elmrslt['keys']['departure-jeddah-status'], '-') . '</td>                             
                                            <td>' . CKHBlank($elmrslt['keys']['medina-arrival-status'], '-') . '</td>                             
                                            <td>' . CKHBlank($elmrslt['keys']['departure-medina-status'], '-') . '</td>                            
                                            <td>' . CKHBlank($elmrslt['keys']['yanbu-arrival-status'], '-') . '</td>                             
                                            <td>' . CKHBlank($elmrslt['keys']['departure-yanbu-status'], '-') . '</td>                               
                                            <td>' . CKHBlank($elmrslt['keys']['check-in-mecca-status'], '-') . '</td>                      
                                            <td>' . CKHBlank($elmrslt['keys']['check-out-mecca-status'], '-') . '</td>                         
                                            <td>' . CKHBlank($elmrslt['keys']['check-in-medina-status'], '-') . '</td>                      
                                            <td>' . CKHBlank($elmrslt['keys']['check-out-medina-status'], '-') . '</td>                             
                                            <td>' . CKHBlank($elmrslt['keys']['check-in-jeddah-status'], '-') . '</td>                      
                                            <td>' . CKHBlank($elmrslt['keys']['check-out-jeddah-status'], '-') . '</td>                              
                                            <td>' . $PaxInMak . '</td>                    
                                            <td>' . $PaxInMed . '</td>                    
                                            <td>' . $PaxInJed . '</td>                    
                                            <td>' . $elmrslt['AgentCategory'] . '</td>
                                            <td>' . $elmrslt['ReferenceName'] . '</td>
                                        </tr> ';
                $i++;
            }
            //break;
        }
    ?>
    </tbody>

</table>
