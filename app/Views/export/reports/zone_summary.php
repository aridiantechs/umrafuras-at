<table id="ReportTable" class="table table-hover non-hover" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Country</th>
        <th>IATA </th>
        <th>No Of Pax</th>
        <th>With MOFA</th>
        <th>Without MOFA</th>
        <th>With Packages</th>
        <th>Self Accommodation</th>
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
                                <td>Dummy IATA Name</td>
                                <td>223</td>
                                <td>54</td>                             
                                <td>58</td>                             
                                <td>12</td>                             
                                <td>56</td>                            
                                 <td>Usman Khan</td>                             
                                 
                                </tr> ';
    }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3" style="text-align: center"> Total : </td>
        <td> 50</td>
        <td> 50</td>
        <td> 50</td>
        <td> 50</td>
        <td> 50</td>

        <td> -</td>

    </tr>
    </tfoot>
</table>
