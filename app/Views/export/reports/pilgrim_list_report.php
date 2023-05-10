<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Country</th>
        <!--                                <th>Pialgrim ID</th>-->
        <th>Agent Name</th>
        <th>Htl Category</th>

        <!--<th>IATA Group Code</th>-->
        <th>Voucher No</th>
        <th>Group Name</th>
        <th>PAX Name</th>
        <th>Gender</th>
        <th>P/P No</th>
        <th>D.O.B</th>
        <!--                                <th>Package</th>-->
        <th>Nationality</th>
        <th>City</th>
        <th>Category</th>
        <th>Status</th>
        <!--                                <th>Relation</th>-->
        <!--                                <th>Embassy</th>-->
        <th>Reference</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $cnt=0;
    foreach ($records as $record) {
        $Category='B2C';
        if($record['AgentUID']>0){
            $Category='B2B';
        }
        $cnt++;
        echo '
                                <tr>
                                <td>' . $cnt . '</td>
                                <td>' . $record['CountryName'] . '</td>
                                 <td>' . $record['IATANAME'] . '</td>
                                <td>'.$record['HotelCategory'].'</td>
                                 <td>' . $record['VoucherCode'] . '</td>
                                <td>' . $record['GroupName'] . '</td>
                                <td>' . $record['PilgrimFullName'] . '</td>
                                <td>' . $record['Gender'] . '</td>
                                <td>' . $record['PassportNumber'] . '</td>
                                <td>' . DATEFORMAT($record['DOB']) . '</td>
                               
                                <td>' . $record['Nationality'] . '</td>
                                <td>' . $record['CityName'] . '</td>
                                 <td>'.ucwords(str_replace('-',' ',$record['IATAType'])).'</td>
                                 <td>'.ucwords(str_replace('-',' ',$record['CurrentStatus'])).'</td>
                                 <td>' . $record['ReferenceName'] . '</td>
                                </tr> ';
    }
    ?>

    </tbody>
</table>
