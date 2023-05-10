<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Package</th>
        <th>Visa & Transport</th>
        <th>Visa & Hotel</th>
        <th>Only Visa</th>
        <th>Hotel</th>
        <th>Transport</th>
        <th>Services</th>
        <th>Total PAX</th>

    </tr>
    </thead>
    <tbody>
    <?php
    for($cnt = 0;$cnt < 10;$cnt++) {
        echo '
                                <tr>
                                <td>' . $cnt . '</td>
                                <td>50</td>
                                <td>20</td>
                                <td>10</td>
                                <td>5</td>
                                <td>10</td>
                                <td>50</td>
                                <td>15</td>
                                <td>100</td>
                                                                                    
                                  
                                </tr> ';
    }
    ?>
    </tbody>
</table>
