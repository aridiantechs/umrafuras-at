<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Create Date</th>
        <th>Country</th>
        <th>City</th>
        <th>Voucher #</th>
        <th>Group Name</th>
        <th>Package(pdf)</th>
        <th>Gender</th>
        <th>PAX NAme</th>
        <th>P/P No</th>
        <th>D.O.B</th>
        <th>Age</th>
        <th>nationality</th>
        <th>Relation</th>
        <th>Contact #</th>
        <th>Email</th>

        <th>BPO ID</th>
        <th>Web Reference</th>
        <th>Approved By</th>
        <th>Current Status</th>

    </tr>
    </thead>
    <tbody>
    <?php
    for($i=1;$i<10;$i++)
    {
        echo '
                                <tr>
                                <td>'.$i.'</td>
                                <td>654</td>
                                <td>Al Farhad Group</td>
                                <td>Farid Paracha</td>
                                <td>Male</td>
                                <td>1978</td>
                                <td>13 Apr, 1971</td>
                                <td>13</td>
                                <td>Son</td>
                                <td>Pakistan</td>                             
                                <td>Islamabad</td>                             
                                <td>Pakistani</td>  
                                <td>Son</td>
                                <td>Pakistan</td>                             
                                <td>Islamabad</td>                             
                                <td>Pakistani</td>                              
                                <td>Diamond Package</td>                             
                                <td>ali@gmail.com</td> 
                                <td>Dummy BPO ID</td> 
                                 <td>Usman Khan</td>                             
                                  
                                </tr> ';
    }
    ?>
    </tbody>
</table>
