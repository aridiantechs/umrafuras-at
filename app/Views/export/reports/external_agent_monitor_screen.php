<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Country</th>
        <th>EA Code</th>
        <th>IATA </th>
        <th>Total Pax</th>
        <th>Travel Voucher not Issued</th>
        <th>Travel Voucher Issued</th>
        <th>Entered</th>
        <th>Exited</th>
        <th>IN KSA</th>
        <th>Not Yet Arrived</th>
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
                                 <td>Pakistan</td>
                                <td>Dummy EA Name</td>
                                <td>Test</td>                              
                                <td>45</td>                             
                                <td>25</td>                             
                                <td>12</td>                        
                                <td>121</td>                             
                                <td>1</td>                             
                                <td>58</td>                             
                                <td>5</td>                             
                                <td>B2C</td>                             
                                <td>Usman Khan</td>                             
                                 
                                </tr> ';
    }
    ?>
    </tbody>
    <tr>
        <td colspan="4" style="text-align: center"> Total : </td>
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
