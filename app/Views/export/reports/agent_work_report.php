<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Country</th>
        <th>Agent Name</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Package</th>
        <th>Accommodation</th>
        <th>Self Accommodation</th>
        <th>Visa</th>
        <th>Without Visa</th>
        <th>Total PAX</th>
        <th>Category</th>
        <th>Reference</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $cnt=0;
    $count=0;
    $sumArray = array();;

    foreach ($records as $record) {
        $cnt++;
        $Category='B2C';

        $Category = 'B2C';
        if ($record['AgentUID'] > 0) {
            $Category = 'B2B';
        }
        $sumArray['Accommodation']+=$record['Accommodation'];
        $sumArray['SelfAccommodation']+=$record['SelfAccommodation'];
        $sumArray['Visa']+=$record['Visa'];
        $sumArray['NotVisa']+=$record['NotVisa'];
        $sumArray['TotalPax']+=$record['TotalPax'];
        echo '
                                <tr>
                                <td>'.$cnt.'</td>
                                <td>' . $record['CountryName'] . '</td>
                                <td>' . $record['AgentName'] . '</td>

                                <td>' .DATEFORMAT($record['StartDate']). '</td>                             
                                <td>' .DATEFORMAT($record['ExpireDate']). '</td>                             
                                <td>' . $record['PackageName'] . '</td>                             
                                <td>' . $record['Accommodation'] . '</td>                             
                                <td>' . $record['SelfAccommodation'] . '</td>                             
                                <td>' . $record['Visa'] . '</td>                             
                                <td>' . $record['NotVisa'] . '</td>                    
                                <td>' . $record['TotalPax'] . '</td> 
                                <td>' . $Category . '</td>
                                <td>'.$record['ReferenceName'].'</td>       
 
                                </tr> ';

    }
    ?>
    </tbody>
    <tr>
        <td  colspan="6" align="center"> Total : </td>

        <td><?php echo $sumArray['Accommodation'];?></td>
        <td><?php echo $sumArray['SelfAccommodation'];?> </td>
        <td><?php echo $sumArray['Visa'];?> </td>
        <td><?php echo $sumArray['NotVisa'];?> </td>
        <td><?php echo $sumArray['TotalPax'];?> </td>


        <td> - </td>
        <td> - </td>
    </tr>
</table>
