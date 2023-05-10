<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>BRN</th>
        <th>Hotel Name</th>
        <th>City</th>
        <th>Room No</th>
        <th>Actual Bed </th>
        <th>Used Bed </th>
        <th>Remaining Bed </th>
        <th>Check In Date</th>
        <th>Check Out Date</th>
        <th>Nights</th>
        <th>Status</th>

    </tr>
    </thead>
    <tbody>
    <?php
    for($cnt=1; $cnt<15;$cnt++) {
        echo '
                                <tr>
                                <td>'.$cnt.'</td>                             
                                <td>MQM0005191239:19283</td>                             
                                <td>Hilton</td> 
                                <td>Mecca</td> 
                                <td>5</td> 
                                <td>7</td> 
                                <td>4</td>                            
                                <td>3</td>                             
                                <td>1 Jul, 2021</td>                                                         
                                <td>8 Jul, 2021</td>                                                         
                                <td>7</td>                                                         
                                <td>Expire</td>                                                         
                                  
                                </tr> ';
    }
    ?>
    </tbody>
</table>
