<div class="table-responsive mb-4 mt-4">
    <table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
        <thead>
        <tr>
            <th>#</th>
            <th>EA Code</th>
            <th>Country</th>
            <th>Agent Name</th>
            <th>V. No</th>
            <th>Pilgrim Name</th>
            <th>P/P No</th>
            <th>PAX</th>
            <th>Seats</th>
            <th>Dep Date</th>
            <th>Dep Time</th>
            <th>Arrvl Date</th>
            <th>Arrvl Time</th>
            <th>Flight No</th>
            <th>Sector</th>
            <th>Destination</th>
            <th>TPT Type</th>
            <th>Vehicle No</th>
            <th>Driver Name</th>
            <th>Driver No</th>
            <th>TPT Company</th>
            <th>Airport</th>
            <th>Pax Mob. No</th>
            <th>Category</th>
            <th>Reference</th>
            <th>System User</th>
            <th>Status</th>

        </tr>
        </thead>
        <tbody>
        <?php
        $cnt=0;
        $PilgrimModel=new \App\Models\Pilgrims();
        foreach ($records as $record) {
            $cnt++;

            $PilgrimID = $record['LeaderPilgrimUID'];
            $PilgrimMetaRecords = $PilgrimModel->ArrivalPilgrimLeaderMetaRecords($PilgrimID);
            $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], $PilgrimMetaRecords['Status'] . '-status');
            $ActivityUserName = UserNameByID($PilgrimLastActivity['ActivityRecords'][$PilgrimLastActivity['LastActivity'] . '-user-id']);

            echo '
                                <tr>
                                <td>'.$cnt.'</td>
                                <td>' . Code('UF/A/', $record['AgentID']) . '</td> 
                                <td>' . $record['CountryName'] . '</td>
                                
                                <td>' . $record['IATANAME'] . '</td>
                                 <td>' . $record['VoucherCode'] . '</td> 
                                
                                <td>' . $record['FullName'] . '</td>                             
                                <td>' . $record['PPNO'] . '</td>
                                <td>'. $record['TotalPilgrim'] .'</td> 
                                <td>' . ((isset($PilgrimMetaRecords['Seats'])) ? $PilgrimMetaRecords['Seats'] : '-') . '</td> 
                                <td>' . DATEFORMAT($record['DepartureDate']) . '</td>  
                                <td>' . $record['DepartureTime'] . '</td>  
                                <td>' . DATEFORMAT($record['ArrivalDate']) . '</td>
                                <td>' . $record['ArrivalTime'] . '</td>
                               
                                <td>' . $record['FlightNo'] . '</td>                             
                                <td>' . $record['SectorFrom'].' - '.$record['SectorTo'] . '</td>                             
                                <td>' . ((isset($record['Destination'])) ? $record['Destination'] : '-') . '</td>
                                <td>' . $record['TypeOFTransport'] . '</td>
                                <td>'.$PilgrimMetaRecords['VehicleNumber'].'</td> 
                                 <td>'.$PilgrimMetaRecords['DriverName'].'</td>                               
                                <td>'.$PilgrimMetaRecords['DriverNumber'].'</td> 
                                                        
                                                        
                                <td>'.$PilgrimMetaRecords['TransportCompany'].'</td> 
                                <td>'. $record['SectorTo'] .'</td>    
                                <td>'.((isset($PilgrimMetaRecords['PilgrimMobile']))?$PilgrimMetaRecords['PilgrimMobile']:'-').'</td>    
                                                               
                                 <td>' . ucfirst(str_replace("_", " ", $record['IATAType'])) . '</td>                             
                                <td>' . ((isset($record['ReferenceName'])) ? $record['ReferenceName'] :'-') . '</td>             
                               <td>'. $ActivityUserName .'</td>    
                                <td>'.((isset($PilgrimMetaRecords['CurrentStatus'])) ?$PilgrimMetaRecords['CurrentStatus'] :'-').'</td>                            
                                 
                                </tr> ';
        }
        ?>
        </tbody>
    </table>
</div>
