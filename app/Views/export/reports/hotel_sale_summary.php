<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Hotel Category</th>
        <th>City</th>
        <th>Actual Hotel Name</th>
        <th>Total PAX</th>
        <th>Single</th>
        <th>Double</th>
        <th>Triple</th>
        <th>Quad</th>
        <th>Quint</th>
        <th>Sharing</th>
        <th>Total Rooms</th>
        <th>Total Nights</th>

        <th>Reference</th>

    </tr>
    </thead>
    <tbody>
    <?php
    for($cnt = 0;$cnt < 10;$cnt++) {
        echo '
                                <tr>
                                <td>' . $cnt . '</td>
                                <td>5 Star</td>
                                <td>MAKKAH</td>
                                <td>50</td>
                                <td>21</td>
                                  <td>MAKKAH</td>
                                <td>50</td>
                                <td>21</td>
                                  <td>MAKKAH</td>
                                                                    <td>MAKKAH</td>

                                <td>50</td>
                                <td>21</td>
                                                                <td>21</td>

                                <td>5</td>
                                                                                    
                                  
                                </tr> ';
    }
    ?>
    </tbody>
</table>
