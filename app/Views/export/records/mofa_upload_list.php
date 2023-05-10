<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<table id="MainRecords"
       style="width:100%">
    <thead>
    <tr>
        <th>Operator</th>
        <th>Ext Agent</th>
        <th>Group</th>
        <th>Print Date</th>
        <th>Pilgrim Name</th>
        <th>Pilgrim ID</th>
        <th>Age</th>
        <th>DOB</th>
        <th>Group Name</th>
        <th>Passport No</th>
        <th>MOFA No</th>
        <th>Issue Date Time</th>
        <th>Embassy</th>
        <th>PKG Code</th>
        <th>Relation</th>
        <th>Nationality</th>
        <th>Address</th>
        <th>Sub Agent Name</th>
        <th>MOI Number</th>
        <th>Insurance Policy ID</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(count($records) > 0) {
    foreach ($records as $record) { ?>
        <tr>
            <td> <?php echo $record['Operator']; ?></td>
            <td> <?php echo $record['ExtAgent']; ?></td>
            <td> <?php echo $record['Group']; ?></td>
            <td> <?php echo $record['PrintDate']; ?></td>
            <td> <?php echo $record['PilgrimName']; ?></td>
            <td> <?php echo $record['PilgrimID']; ?></td>
            <td> <?php echo $record['Age']; ?></td>
            <td> <?php echo $record['DOB']; ?></td>
            <td> <?php echo $record['GroupName']; ?></td>
            <td> <?php echo $record['PassportNo']; ?></td>
            <td> <?php echo $record['MOFANumber']; ?></td>
            <td> <?php echo $record['IssueDateTime']; ?></td>
            <td> <?php echo $record['Embassy']; ?></td>
            <td> <?php echo $record['PKGCode']; ?></td>
            <td> <?php echo $record['Relation']; ?></td>
            <td> <?php echo $record['Nationality']; ?></td>
            <td> <?php echo $record['Address']; ?></td>
            <td> <?php echo $record['SubAgentName']; ?></td>
            <td> <?php echo $record['MOINumber']; ?></td>
            <td> <?php echo $record['INSURANCE_POLICY_ID']; ?></td>
        </tr>
    <?php }
    }
    else
    {
        echo '<tr><td style="text-align: center;" colspan="20">No Record Found...</td></tr>';

    }
    ?>
    </tbody>
</table>