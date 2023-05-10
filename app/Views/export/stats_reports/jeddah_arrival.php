<table id="ReportTable" class="table table-hover non-hover" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Pilgrim ID </th>
        <th>Group Name</th>
        <th>Pilgrim Name </th>
        <th>Gender</th>
        <th>P/P No</th>
        <th>DOB</th>
        <th>Relation</th>
        <th>Country</th>
        <th>City</th>
        <th>Nationality</th>
        <th>Package</th>
        <th>Email</th>
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
                                <td>654</td>
                                <td>Al Farhad Group</td>
                                <td>Farid Paracha</td>
                                <td>Male</td>
                                <td>1978</td>
                                <td>13 Apr, 1971</td>
                                <td>Son</td>
                                <td>Pakistan</td>                             
                                <td>Islamabad</td>                             
                                <td>Pakistani</td>                             
                                <td>Diamond Package</td>                             
                                <td>ali@gmail.com</td> 
                                 <td>Usman Khan</td>                             
                                  
                                </tr> ';
    }
    ?>
    </tbody>
</table>
