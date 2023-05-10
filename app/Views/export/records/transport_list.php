<table id="MainRecords"  style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Transport Reg. ID</th>
        <th>Type</th>
        <th>Description</th>
        <th>Luggage Capacity</th>
        <th>PAX Details</th>
    </tr>
    </thead>
    <tbody><?php
    $cnt=0;
    if(count($records) > 0) {
    foreach ($records as $record) {
        $cnt++;
        echo '
                                <tr>
                                    <td>' . $cnt. '</td>
                                    <td>' . Code('UF/T/', $record['UID']) . '</td>
                                    <td>' .OptionName($record['Type']) . '</td>
                                    <td>' . $record['Description'] . '</td>
                                    <td>' . $record['LuggageCapacity'] . '</td>
                                    <td>' . $record['PAXDetail'] . '</td>
                                                             
                             
                                </tr>';
    } }
    else{
        echo '<tr><td style="text-align: center;" colspan="6">No Record Found...</td></tr>';

    }?>
    </tbody>
</table>