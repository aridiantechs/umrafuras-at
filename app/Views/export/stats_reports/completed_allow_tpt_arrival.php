<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>EA Code</th>
        <th>Country</th>
        <th>Agent Name</th>

        <th>BRN</th>
        <th>V. No</th>
        <th>Pilgrim Name</th>
        <th>P/P No</th>
        <th>PAX</th>
        <th>No Of Seats</th>

        <th>Dep Date</th>
        <th>Dep Time</th>
        <th>Arrvl Date</th>
        <th>Arrvl Time</th>
        <th>Airport</th>
        <th>Flight No</th>
        <th>Sector</th>
        <th>Destination</th>
        <th>TPT Type</th>
        <th>Vehicle No</th>
        <th>Driver Name</th>
        <th>Driver Mob.</th>

        <th>TPT Company</th>
        <th>Pax Mob. No</th>
        <th>Category</th>
        <th>Reference</th>
        <th>System User</th>
        <th>Status</th>

    </tr>
    </thead>
    <tbody>
    <?php
    $cnt = 0;
    $Pilgrims = new \App\Models\Pilgrims();
    foreach ($records as $record) {
        $cnt++;
        $Category = 'B2B';
        if ($record['IATAType'] == 'external_agent') {
            $Category = 'External Agent';
        }
        $PilgrimID = $record['LeaderPilgrimUID'];
        //$PilgrimMetaRecords = $PilgrimModel->ArrivalPilgrimLeaderMetaRecords($PilgrimID);
        $PilgrimMetaRecords = $Pilgrims->PilgrimMetaRecords($record['LeaderPilgrimUID']);
        //echo '<pre>';print_r($PilgrimMetaRecords);
        $PilgrimCurrentActivity = PilgrimCurrentActivity($record['LeaderPilgrimUID'], str_replace("-status","",$record['Option']),  $record['RID']);
        //echo "<pre>";print_r($PilgrimCurrentActivity);

        echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                    <td>' . Code('UF/A/', $record['AgentID']) . '</td>   
                                    <td>' . $record['CountryName'] . '</td>
                                    <td>' . $record['IATANAME'] . '</td>
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-brn-no'])) ? BRNCode($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-brn-no']) : '-') . '</td>
                                    
                                    <td>' . $record['VoucherCode'] . '</td> 
                                    <td>' . $record['FullName'] . '</td>  
                                    <td>' . $record['PPNO'] . '</td>   
                                    <td>' . $record['TotalPilgrim'] . '</td>
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-no-of-seats'])) ? $PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-no-of-seats'] : '-') . '</td>
                                    <td>' . DATEFORMAT($record['DepartureDate']) . '</td>  
                                    <td>' . $record['DepartureTime'] . '</td>  
                                    <td>' . DATEFORMAT($record['ArrivalDate']) . '</td>
                                    <td>' . $record['ArrivalTime'] . '</td>
                                    <td>' . $record['SectorTo'] . '</td>      
                                    <td>' . $record['FlightNo'] . '</td>                             
                                    <td>' . $record['SectorFrom'] . ' - ' . $record['SectorTo'] . '</td>                             
                                    <td>' . ((isset($record['SectorTo'])) ? $record['SectorTo'] : '-') . '</td>                              
                                    <td>' . $record['TypeOFTransport'] . '</td>                             
                                     <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-vehicle-number'])) ? $PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-vehicle-number'] : '-') . '</td> 
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-driver-name'])) ? $PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-driver-name'] : '-') . '</td>                               
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-driver-contact-number'])) ? $PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-driver-contact-number'] : '-') . '</td> 
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-transport-company'])) ? OptionName($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-transport-company']) : '-') . '</td>                             
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-contact-number'])) ? $PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-contact-number'] : '-') . '</td>                            
                                    <td>' . $Category . '</td>                             
                                    <td>' . ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-') . '</td>             
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-user-id'])) ? UserNameByID($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-user-id']) : '-') . '</td>    
                                    <td>Allow TPT Arrival</td>
                                </tr> ';
    }
    ?>
    </tbody>
</table>
