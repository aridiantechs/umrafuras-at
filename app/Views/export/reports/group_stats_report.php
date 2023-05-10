<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Country</th>
        <th>Agent Name </th>
        <th>HTL Category</th>
        <th>Group Code </th>
        <th>Group Name</th>
        <th>Pax</th>
        <th>V. Not Issue</th>
        <th>V. Issue</th>
        <th>Arrived</th>
        <th>CHK In Mecca</th>
        <th>CHK In Medina</th>
        <th>CHK In Jeddah</th>
        <th>Exited</th>
        <th>Category</th>
        <th>Reference</th>

    </tr>
    </thead>
    <tbody>
    <?php
    $cnt=0;
    $Pax=0;
    $VoucherNotIssued=0;
    $VoucherIssued=0;
    $Arrived=0;
    $CheckInMecca=0;
    $CheckInMedina=0;
    $CheckInJeddah=0;
    $Exit=0;
    foreach ($records as $record) {
        $cnt++;
        $Category='B2C';
        if($record['AgentUID']>0){
            $Category='B2B';
        }
        echo '
                                <tr>
                                <td>'.$cnt.'</td>
                                <td>'.$record['CountryName'].'</td>
                               
                                <td>'.$record['IATANAME'].'</td>
                                <td>'.((isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-').'</td>
                                <td>' .Code('UF/G/', $record['GroupCode']) . '</td>
                                <td>'.$record['GroupName'].'</td>
                                <td>'.$record['TotalPAX'].'</td>
                                 <td>'.$record['VoucherNotIssued'].'</td>                             
                                <td>'.$record['VoucherIssued'].'</td>                             
                                <td>'.$record['Arrived'].'</td>   
                                <td>'.$record['CheckInMecca'].'</td>   
                                <td>'.$record['CheckInMedina'].'</td>
                                <td>'.$record['CheckInJeddah'].'</td>                             
                                <td>'.$record['Exit'].'</td>                             
                                <td>' .  ucfirst(str_replace("_", " ", $record['IATAType'])). '</td>
                                <td>'.$record['ReferenceName'].'</td>                      
                                             
                                </tr> ';
        $Pax=$Pax+$record['TotalPAX'];
        $VoucherNotIssued=$VoucherNotIssued+$record['VoucherNotIssued'];
        $VoucherIssued=$VoucherIssued+$record['VoucherIssued'];
        $Arrived=$Arrived+$record['Arrived'];
        $CheckInMecca=$CheckInMecca+$record['CheckInMecca'];
        $CheckInMedina=$CheckInMedina+$record['CheckInMedina'];
        $CheckInJeddah=$CheckInJeddah+$record['CheckInJeddah'];
        $Exit=$Exit+$record['Exit'];
    }
    ?>
    </tbody>
    <tr>
        <td colspan="6" align="center"> Total : </td>
        <td> <?php echo $Pax; ?></td>
        <td> <?php echo $VoucherNotIssued; ?></td>
        <td> <?php echo $VoucherIssued; ?></td>
        <td><?php echo $Arrived; ?></td>
        <td><?php echo $CheckInMecca; ?></td>
        <td><?php echo $CheckInMedina; ?></td>
        <td><?php echo $CheckInJeddah; ?></td>
        <td><?php echo $Exit; ?></td>
        <td></td>
        <td></td>

    </tr>
</table>
