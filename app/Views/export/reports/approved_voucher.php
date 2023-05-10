<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Voucher Reg. ID</th>
        <th>Voucher Code</th>
        <th>Created By</th>
        <th>Created Date</th>
        <th>Agent Name</th>
        <th>Sub Agent Name</th>
        <th>Arrival</th>
        <th>Return</th>
        <th>Total Nights</th>
        <th>Arrival Type</th>
        <th>Country</th>
        <th>Status</th>
        <th>Modified By</th>
        <th>Modified Date</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for($i=1;$i<10;$i++)
    {
        echo '
                                <tr>
                                <td>'.$i.'</td>
                                <td>123123435 </td>
                                <td>V/A/12312</td>
                                <td>Saad</td>
                                <td>20 Apr, 2021</td>                                           
                                 <td>Usman</td>                                            
                                <td>Ali</td>    
                                <td>2 Apr, 2021</td>                                            
                                <td>21 Apr, 2021</td>                                                
                                <td>22</td>                                            
                                <td>Bus</td>                                            
                                <td>Pakistan</td>                                            
                                <td>Executed</td>                                            
                                <td>Usman Khan</td>                             
                                <td>28 Jan, 2021</td>                             
                                 
                                </tr> ';
    }
    ?>
    </tbody>
</table>
