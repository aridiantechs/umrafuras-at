<table id="ReportTable" class="table table-hover non-hover" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>IATA </th>
        <th>Voucher No</th>
        <th>Changing Reason</th>
        <th>No Of Changes</th>
        <th>Warning</th>
        <th>Read</th>
        <th>Date</th>
        <th>Time</th>
        <th>Change ID</th>
        <th>Reference</th>

    </tr>
    </thead>
    <tbody>
    <?php
    for($i=1;$i<10;$i++)
    {
        echo '
                                <tr>
                                <td>'.$i.'</td>
                                <td>Dummy IATA Name</td>
                                <td>23423</td>
                                <td>Random</td>                             
                                <td>5</td>                             
                                <td>12</td>                             
                                <td>56</td>                             
                                <td>06 Apr, 2021</td>                             
                                <td>03:00 pm</td>                             
                                <td>93</td>                            
                                <td>Usman Khan</td>                             
                                 
                                </tr> ';
    }
    ?>
    </tbody>
</table>
