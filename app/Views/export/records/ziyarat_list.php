<table id="MainRecords" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Ziyarat Reg. ID</th>
        <th>Image</th>
        <th>Name</th>
        <th>City</th>
    </tr>
    </thead>
    <tbody><?php
    $cnt=0;
    if(count($ziyarats) > 0) {
    foreach ($ziyarats as $record) {
        $cnt++;
        echo '
                                <tr>
                                    <td>' . $cnt. '</td>
                                    <td>' . Code('UF/Z/', $record['UID']) . '</td>
                                    <td><img src="'.$path.'home/load_file/'.$record['CoverImage'].'" class="Image" alt="Hotel Image" width="100""></td>
                                    <td>' . $record['Name'] . '</td>
                                    <td>' . CityName($record['CityID']) . '</td>
                                 
                                </tr>';
    } }
    else{
        echo '<tr><td style="text-align: center;" colspan="5">No Record Found...</td></tr>';
    }?>
    </tbody>
</table>