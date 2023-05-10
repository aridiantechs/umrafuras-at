<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Country</th>
        <th>IATA Name</th>
        <th>Voucher No </th>
        <th>Actual Hotel</th>
        <th>Room No</th>
        <th>Check Out Date</th>
        <th>City</th>
        <th>Pax</th>
        <th>TPT Type</th>
        <th>Destination</th>

        <th>Category</th>
        <th>Reference  </th>
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
                                <td>Dummy IATA Name</td>
                                <td>434</td>
                                <td>Al Furas</td>
                                <td>85</td>
                                <td>13 Apr, 2021</td>
                                 <td>isb</td>
                                <td>13</td>
                                 <td>Bus</td>
                                <td>Isb</td>                             
                                                          
                                <td>B2C</td>                           
                                <td>Usman Khan</td>    
                                                          
                                 
                                </tr> ';
    }
    ?>
    </tbody>
</table>
