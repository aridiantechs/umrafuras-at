<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Country</th>
        <th>IATA</th>
        <th>Total Pax</th>
        <th>Entered</th>
        <th>Exited</th>
        <th>IN KSA</th>
        <th>After 1 day (Tomorrow)</th>
        <th>After 2 Days</th>
        <th>After 3 Days</th>
        <th>After 4 Days</th>
        <th>After 5 Days</th>
        <th>Not Entered Yet</th>
        <th>Category</th>
        <th>Reference</th>

    </tr>
    </thead>
    <tbody>
    <?php
    for ($i = 1; $i < 10; $i++) {
        echo '
                                <tr>
                                <td>' . $i . '</td>
                                <td>Pakistan</td>
                                <td>Test</td>
                                <td>45</td>                             
                                <td>25</td>                             
                                <td>12</td>                             
                                <td>56</td>                             
                                <td>23</td>                             
                                <td>45</td>                             
                                <td>54</td>                             
                                <td>45</td>                             
                                <td>121</td>                             
                                <td>1</td>                             
                                <td>B2C</td>                             
                                <td>Usman Khan</td>                             
                               
                                </tr> ';
    }
    ?>
    </tbody>
    <tr>
        <td colspan="3" style="text-align: center"> Total :</td>
        <td> 50</td>
        <td> 50</td>
        <td> 50</td>
        <td> 50</td>
        <td> 50</td>
        <td> 50</td>
        <td> 50</td>
        <td> 50</td>
        <td> 50</td>
        <td> 50</td>
        <td> -</td>
        <td> -</td>
    </tr>
</table>
