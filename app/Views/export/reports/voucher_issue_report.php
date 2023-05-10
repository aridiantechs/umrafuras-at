<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Create Date</th>
        <th>Country</th>
        <th>Agent Name</th>
        <th>Voucher Ref.ID</th>
        <th>V. No</th>
        <th>Issue Date</th>
        <th>Issue Time</th>
        <th>HTL Category</th>
        <th>HTL Name</th>

        <th>PAX</th>
        <th>No Of beds</th>
        <th>MAK Nights</th>
        <th>MED Nights</th>
        <th>JED Nights</th>
        <th>TOTAL Nights</th>

        <th>TPT Type</th>
        <th>Category</th>
        <th>Reference</th>



    </tr>
    </thead>
    <tbody>
    <?php
    $cnt=0;
    foreach ($records as $record) {
        $cnt++;
        echo '
                                <tr>
                                <td>'.$cnt.'</td>
                                <td>'.DATEFORMAT($record['CreatedDate']).'</td>
                                <td>'.$record['CountryName'].'</td>
                                <td>'.$record['AgentName'].'</td>
                                <td>'.Code('UF/V/', $record['UID']).'</td>
                                <td>'.$record['VoucherCode'].'</td>
                                <td>'.DATEFORMAT($record['CreatedDate']).'</td>
                                <td>N/A</td>
                                <td>'.$record['HotelCategory'].'</td>
                                <td>'.$record['HotelName'].'</td>
                                <td>'.$record['TotalPilgrim'].'</td>
                                <td>'.$record['NoOfBeds'].'</td>
                                <td>'.$record['MeccaNights'].'</td>
                                <td>'.$record['MedinaNights'].'</td>
                                <td>'.$record['JeddahNights'].'</td>
                                <td>'.$record['TotalNights'].'</td>
                                <td>'.$record['TypeOFTransport'].'</td>
                                <td>'.ucfirst(str_replace("_", " ", $record['IATAType'])).'</td>
                                <td>'.$record['ReferenceName'].'</td>
                            
                                </tr> ';
    }
    ?>
    </tbody>
</table>
