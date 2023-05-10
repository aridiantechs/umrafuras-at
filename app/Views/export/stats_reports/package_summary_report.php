<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Package Name</th>
        <th>Total Voucher</th>
        <th>Total PAX</th>
        <th>Total Nights</th>
        <th>Total Room</th>
        <th>Sharing</th>

    </tr>
    </thead>
    <tbody>
    <?php
    for($cnt = 0;$cnt < 10;$cnt++) {
        echo '
                                <tr>
                                <td>' . $cnt . '</td>
                                <td>Diamond Package</td>
                                <td>50</td>
                                <td>500</td>
                                <td>21</td>
                                <td>5</td>
                                <td>5</td>                                                      
                                  
                                </tr> ';
    }
    ?>
    </tbody>
</table>
