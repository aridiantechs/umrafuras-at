<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Tranpsort Type</th>
        <th>Sector</th>
        <th>No of Vehicle</th>
        <th>Seats</th>
        <th>No Of PAX</th>

    </tr>
    </thead>
    <tbody>
    <?php
    $cnt=0;
    for($cnt = 0;$cnt < 10;$cnt++) {
        echo '
                                <tr>
                                <td>' . $cnt . '</td>
                                <td>BUS</td>
                                <td>JED - MAKKAH</td>
                                <td>5</td>
                                <td>98</td>
                                <td>75</td>
                                                                                    
                                  
                                </tr> ';
    }
    ?>
    </tbody>
</table>
