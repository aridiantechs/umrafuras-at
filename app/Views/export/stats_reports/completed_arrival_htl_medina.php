<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Country</th>
        <th>IATA</th>
        <th>Voucher No</th>
        <th>Chk in Date </th>
        <th>Chk in Time</th>
        <th>City</th>
        <th>Hotel Name</th>
        <th>Room Type</th>
        <th>PAX</th>
        <th>BEDS</th>
        <th>Nights</th>
        <th>Origin</th>
        <th>Category</th>
        <th>Reference</th>

    </tr>
    </thead>
    <tbody>
    <?php
    $Pilgrims = new \App\Models\Pilgrims();
    $cnt=0;
    foreach ($records as $record) {
        $cnt++;
        $PilgrimMetaRecords = $Pilgrims->PilgrimMetaRecords( $record['PilgrimUID'] );
        echo '
                                <tr>
                                <td>'.$cnt.'</td>
                                <td>' . $record['CountryName'] . '</td> 
                                <td>' . $record['IATANAME'] . '</td> 
                                 <td>' . $record['VoucherCode'] . '</td> 
                                <td>'.( (isset($record['CheckINDate'])) ? DATEFORMAT($record['CheckINDate']) : '-' ).'</td>                              
                                <td>N/A</td> 
                                <td>N/A</td> 
                                <td>'.( (isset($record['HotelName'])) ? $record['HotelName'] : '-' ).'</td> 
                                <td>'.( (isset($record['RoomType'])) ? $record['RoomType'] : '-' ).'</td> 
                                <td>'.$record['FullName'].'</td>                              
                                <td>'.((isset($record['NoOfBeds']))?$record['NoOfBeds']:'-').'</td> 
                                <td>'.((isset($record['Nights']))?$record['Nights']:'-').'</td>                             
                                    <td>N/A</td>                             
                                 <td>' . ( (isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-' ) . '</td>
                                <td>'.( (isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-' ).'</td>    
                                                            
                                 
                                </tr> ';
    }
    ?>
    </tbody>
</table>
