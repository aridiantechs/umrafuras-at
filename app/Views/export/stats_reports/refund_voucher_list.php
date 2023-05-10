<table id="ReportTable" class="table table-hover non-hover" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Create Date</th>
        <th>Country</th>
        <th>Agent Name </th>
        <th>Voucher Ref. ID</th>
        <th>Voucher No</th>
        <th>Total PAX</th>
        <th>Refund Reason </th>
        <th>Refund Services</th>
        <th>Warning</th>
        <th>Date</th>
        <th>Time</th>
        <th>Refund ID</th>
        <th>Approved by</th>
        <th>Category</th>
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
                                <td>6541</td>
                                <td>Dummy Reasons</td>
                                <td>5</td>
                                <td>4</td>
                                <td>5</td>
                                 <td>Dummy Reasons</td>
                                <td>5</td>
                                <td>5</td>
                                <td>4</td>
                                <td>5</td>
                                <td>13 Apr, 2021</td>
                                <td>10:00 AM</td>
                                <td>6542</td>                             
                                 <td>Usman Khan</td>                             
                                  
                                </tr> ';
    }
    ?>
    </tbody>
</table>
