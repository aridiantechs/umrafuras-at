<table id="MainRecords" style="width:100%">
    <thead>
    <tr>
        <td colspan="2"> <h3>Group Name : <?=$GroupData['FullName']?></h3></td>
        <td colspan="2"> <h3>Agent Name : <?=$GroupData['agentname']?></h3></td>
    </tr>
    <tr>
        <th>#</th>
        <th>Pilgrim Name</th>
        <th>MOFA Number</th>
        <th>Visa Number</th>
    </tr>
    </thead>
    <tbody>

    <?php
    $cnt = 0;
    if(count($records) > 0)
    {
    foreach ($records as $record) {
        $cnt++;
        echo '
        <tr>
            <td>' . $cnt . '</td>
             <td>' . $record['pilgrimname'] . '</td>
             <td>' . $record['mofanumber'] . '</td>
             <td>' . $record['visanumber'] . '</td>
      
        </tr>';
    }
    }
    else {
        echo '<tr><td style="text-align: center;" colspan="4">No Record Found...</td></tr>';
    }
    ?>
    </tbody>
</table>