<table id="ReportTable" class="table table-hover non-hover" style="width:100%">
    <thead>
    <tr>
        <th>Sr. No</th>
        <th>Create Date</th>
        <th>Country</th>
        <th>Agent Name</th>
        <th>Sub Agent Name</th>
        <th>Voucher Ref. ID</th>
        <th>Voucher No</th>
        <th>Total PAX</th>
        <th>Changing Reason</th>
        <th>Changing Services</th>
        <th>No of Changes</th>
        <th>Warning</th>
        <th>Date</th>
        <th>Time</th>
        <th>Approved By</th>
        <th>Change ID</th>
        <th>Category</th>
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
                                <td>' . DATEFORMAT($record['CreatedDate']) . '</td>
                                <td>' . $record['CountryName'] . '</td>
                                <td>' . $record['AgentName'] . '</td>
                                <td>' . $record['SubAgentName'] . '</td>                                
                                <td>' . Code('UF/V/', $record['UID']) . '</td>
                                <td>' . $record['VoucherCode'] . '</td>                               
                                <td>' . $record['TotalPilgrim'] . '</td>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>' . $record['UserModifiedBy'] . '</td> 
                                <td>N/A</td>                                                                              
                                <td>' . ucfirst(str_replace("_", " ", $record['IATAType'])) . '</td>
                                <td>' . $record['ReferenceName'] . '</td>                             
      </tr> ';
    }
    ?>
    </tbody>
</table>
