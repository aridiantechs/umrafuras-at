<?php

use App\Models\Crud;

$Crud = new Crud();

$TotalNights = $TotalBeds = 0;

$VoucherAccommmodationDataHTML = '';
foreach ($VoucherAccommmodationDatas as $VoucherAccommmodationData) {
    $class = '';
    if ($VoucherAccommmodationData['Refund'] == 1) {
        $class = ' style="background-color: #F8D7DA" ';
    } else {
        $class = '';
    }
    $days = '-';
    $CheckIn = ($VoucherAccommmodationData['CheckIn']);
    $CheckOut = ($VoucherAccommmodationData['CheckOut']);
    if ($CheckIn != '' && $CheckIn != '') {
        $days = date_diff(date_create($CheckIn), date_create($CheckOut));
        $days = $days->days;
    }

    $hotel = $VoucherAccommmodationData['Hotel'];
    $table = 'packages."Hotels"';
    $where = array("UID" => $hotel);
    $Self = '';
    $PackageName = $PackageData['Name'];
    if ($VoucherAccommmodationData['Self'] == 1) {
        $table = 'packages."OtherHotels"';
        $Self = ' (Self)';
        $PackageName = '';
    }
    if(OptionName($VoucherAccommmodationData['RoomType']) == 'Sharing'){
        $quantity = " Bed";
    }else{
        $quantity = " Room";
    }



    $HotelName = $Crud->SingleRecord($table, $where);
    $TotalNights += $days;
    $TotalBeds += $VoucherAccommmodationData['NoOfBeds'];
    $VoucherAccommmodationDataHTML .= '       
    <tr '.$class.'>
        <td>' . $PackageName . '</td>
        <td>' . CityName($VoucherAccommmodationData['City']) . '</td>
        <td>' . $HotelName['Name'] . $Self . '</td>
        
        <td>' . DATEFORMAT($VoucherAccommmodationData['CheckIn']) . '</td>
        <td>' . DATEFORMAT($VoucherAccommmodationData['CheckOut']) . '</td>
        <td>' . $days . '</td>
        <td>' . $VoucherAccommmodationData['NoOfBeds'] . $quantity . '</td>
        <td>' . OptionName($VoucherAccommmodationData['RoomType']) . '</td>
        <td>' . ((isset($VoucherAccommmodationData['AccommodationBRN'])) ? $VoucherAccommmodationData['AccommodationBRN'] : '-') . '</td>
    </tr>';
}
?>
<table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
       width="100%">
    <tr>
        <td colspan="10" class="NoBorder"><strong>General Information About Service </strong></td>
    </tr>
    <thead>
    <tr>
        <th>Voucher Code</th>
        <th>Country</th>
        <th>Arrival Type</th>
        <th>Adults</th>
        <th>Children</th>
        <th>Infants</th>
        <th>No of Beds</th>
        <th>Arrival Date</th>
        <th>Departure Date</th>
        <th>Nights</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $AgentID = $VoucherData['AgentUID'];
    $table = 'main."Agents"';
    $where = array("UID" => $AgentID);
    $AgentName = $Crud->SingleRecord($table, $where);
    echo '
    <tr>
        <td>' . ((isset($VoucherData['VoucherCode'])) ? $VoucherData['VoucherCode'] : '-') . '</td>
        <td>' . ((isset($VoucherData['Country'])) ? CountryName($VoucherData['Country']) : '-') . '</td>
        <td>' . ((isset($VoucherData['ArrivalType'])) ? $VoucherData['ArrivalType'] : '-') . '</td>
        <td>' . ((isset($Adults)) ? $Adults : '-') . '</td>
        <td>' . ((isset($Childs)) ? $Childs : '-') . '</td>
        <td>' . ((isset($Infants)) ? $Infants : '-') . '</td>
        <td>' . (($TotalBeds > 0) ? 'N/A' : '-') . '</td>
        <td>' . ((isset($VoucherData['ArrivalDate'])) ? DATEFORMAT($VoucherData['ArrivalDate']) : '-') . '</td>
        <td>' . ((isset($VoucherData['ReturnDate'])) ? DATEFORMAT($VoucherData['ReturnDate']) : '-') . '</td>
        <td>' . (($TotalNights > 0) ? $TotalNights : '-') . '</td>
    </tr> '; ?>
    </tbody>
</table>

<?php
//print_r($pilgrims);
$pilgrimHTML = array();
$cnt = 1;
$PilgrimDomain = '';
foreach ($pilgrims as $pilgrim) {
    $PilgrimDomain = $pilgrim['WebsiteDomain'];
    $pilgrimHTML[$cnt] = '
        <tr>
            <td>' . $cnt . '</td>
            <td>' . $pilgrim['FirstName'] . ' ' . $pilgrim['LastName'] . '</td>
            <td>' . $pilgrim['PassportNumber'] . '</td>
            <td>' . DATA($pilgrim['VisaNumber']) . '</td>
            <td>' . DATEFORMAT($pilgrim['IssueDate']) . '</td>
        </tr>';
    $cnt++;
} ?>


<table class="table table-striped table-hover display nowrap cell-border" width="100%">
    <tr>
        <td colspan="2" class="NoBorder"><strong>Mutamer’s (Pilgrims) Detail</strong></td>
    </tr>
    <tr>
        <td width="49%" valign="top">
            <table class="table table-striped table-hover display nowrap cell-border GoldClass" cellspacing="0"
                   cellpadding="0" style="font-size: 50%;">
                <thead>
                <tr>
                    <th>Sr .#</th>
                    <th>Pilgrim Name</th>
                    <th>Passport</th>
                    <th>Visa No</th>
                    <th>Issue Date</th>
                </tr>
                </thead>
                <tbody><?php
                //print_r($pilgrims);
                for ($a = 1; $a <= count($pilgrimHTML); $a++) {
                    if ($a % 2 != 0) {
                        echo $pilgrimHTML[$a];
                    }
                }
                ?>
                </tbody>
            </table>
        </td>
        <td width="49%" valign="top">
            <table class="table table-striped table-hover display nowrap cell-border GoldClass" cellspacing="0"
                   cellpadding="0">
                <thead>
                <tr>s
                    <th>Sr .#</th>
                    <th>Pilgrim Name</th>
                    <th>Passport</th>
                    <th>Visa No</th>
                    <th>Issue Date</th>
                </tr>
                </thead>
                <tbody><?php
                //print_r($pilgrims);
                for ($a = 1; $a <= count($pilgrimHTML); $a++) {
                    if ($a % 2 == 0) {
                        echo $pilgrimHTML[$a];
                    }
                }
                ?>
                </tbody>
            </table>
        </td>
    </tr>
</table>

<table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
       width="100%">
    <tr>
        <td colspan="6" class="NoBorder"><strong>KSA Arrival Information</strong></td>
    </tr>
    <thead>
    <tr>
        <th>Sector From</th>
        <th>Sector To</th>

        <th>Flight Number</th>
        <th>Departure</th>
        <th>Arrival</th>
        <th>PNR</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($VoucherFlightsDetails as $voucherFlightsDetail) {
        if (count($voucherFlightsDetail) > 0) {
            $TravelSelf = '';
            if ($voucherFlightsDetail['TravelSelf'] == 1) {
                $TravelSelf = " (Self)";
            }
            if ($voucherFlightsDetail['FlightType'] != 'Return') {
                echo '
                <tr>
                    <td>' . AirportCode($voucherFlightsDetail['SectorFrom']) . ' - ' . AirportName($voucherFlightsDetail['SectorFrom']) . '</td>
                    <td>' . AirportCode($voucherFlightsDetail['SectorTo']) . ' - ' . AirportName($voucherFlightsDetail['SectorTo']) . $TravelSelf . '</td>
                    
                    <td>' . AirlineCode($voucherFlightsDetail['Airline']) . '  ' . $voucherFlightsDetail['Reference'] . '</td>
                    <td>' . DATEFORMAT($voucherFlightsDetail['DepartureDate']) . ' ' . date("g:i A", strtotime($voucherFlightsDetail['DepartureTime'])) . '</td>
                    <td>' . DATEFORMAT($voucherFlightsDetail['ArrivalDate']) . ' ' . date("g:i A", strtotime($voucherFlightsDetail['ArrivalTime'])) . '</td>
                    <td>' . $voucherFlightsDetail['PNR'] . '</td>       
                </tr>';
            }
        } else {
            echo ' 
            <tr>
                <td colspan="6" style="text-align: center">No record found</td>
            </tr>';
        }
    } ?>
    </tbody>
</table>

<table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
       width="100%">
    <tr>
        <td colspan="9" class="NoBorder"><strong>Accommodation Detail</strong></td>
    </tr>
    <thead>
    <tr>
        <th>Package</th>
        <th>City</th>
        <th>Hotel</th>
        <th>Check-In</th>
        <th>Check-Out</th>
        <th>Nights</th>
        <th>Quantity</th>
        <th>Room Type</th>
        <th>BRN</th>
    </tr>
    </thead>
    <tbody>
    <?= $VoucherAccommmodationDataHTML ?>
    </tbody>
</table>

<table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
       width="100%">
    <tr>
        <td colspan="5" class="NoBorder"><strong>Transport Detail</strong></td>
    </tr>
    <thead>
    <tr>
        <th>Travel Date</th>
        <th>Sector</th>
        <th>Transport</th>
        <th>No Of Pax</th>
        <th>No Of Seats</th>
        <th>BRN</th>
    </tr>
    </thead>
    <tbody>
    <?php

    foreach ($VoucherTransportDatas as $VoucherTransportData) {
        $class = '';
        if ($VoucherTransportData['Refund'] == 1) {
             $class = ' style="background-color: #F8D7DA" ';
        } else {
            $class = '';
        }
        $SelfTransport = '';
        if ($VoucherTransportData['SelfTransport'] == 1) {
            $SelfTransport = " (Self)";
        }
        echo '       
        <tr '.$class.'>
            <td>' . DATEFORMAT($VoucherTransportData['TravelDate']) . '</td>
            <td>' . $VoucherTransportData['SectorName'] . $SelfTransport . '</td>
            
            <td>' . $VoucherTransportData['TransportTypeName'] . '</td>
            <td>' . ((isset($VoucherTransportData['NoOfPax'])) ? $VoucherTransportData['NoOfPax'] : '-') . '</td>
            <td>' . ((isset($VoucherTransportData['NoOfSeats'])) ? $VoucherTransportData['NoOfSeats'] : '-') . '</td>
            <td>' . ((isset($VoucherTransportData['TransportsBRN'])) ? $VoucherTransportData['TransportsBRN'] : '-') . '</td>
        </tr>';
    }
    ?>
    </tbody>
</table>

<table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
       width="100%">
    <thead>
    <tr>
        <th class="NoBorder">Ziyarats</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            <?php
            foreach ($VoucherZiyaratDatas as $VoucherZiyaratData) {
                $class = '';
                if ($VoucherZiyaratData['Refund'] == 1) {
                    $class = ' style="color: red" ';
                } else {
                    $class = '';
                }
                echo '<span '.$class.'> '.$VoucherZiyaratData['ZiyaratName'].'.(' . $VoucherZiyaratData['CityName'] . ') in <strong>' . $VoucherZiyaratData['TransportName'] . '</strong>&nbsp;</span> ';
            } ?>
        </td>
    </tr>
    </tbody>
</table>

<table class="table table-striped table-hover display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
       width="100%">
    <thead>
    <tr>
        <th class="NoBorder">Other Services</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            <?php
            foreach ($VoucherServicesDatas as $VoucherServicesData) {
                $class = '';
                if ($VoucherServicesData['Refund'] == 1) {
                    $class = ' style="color: red" ';
                } else {
                    $class = '';
                }
                $ServiceRate = $VoucherServicesData['ServiceID'];
                $table = 'packages."ServiceRate"';
                $where = array("UID" => $ServiceRate);
                $ServicesRate = $Crud->SingleRecord($table, $where);
                echo '<span  '.$class.'>'.OptionName($ServicesRate['ServiceUID']) . ' &nbsp;,</span>';
            }
            ?>
        </td>
    </tr>
    </tbody>
</table>

<table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
       width="100%">
    <tr>
        <td colspan="6" class="NoBorder"><strong>Return Flight from KSA</strong></td>
    </tr>
    <thead>
    <tr>
        <th>Sector From</th>
        <th>Sector To</th>
        <th>Flight Number</th>
        <th>Departure</th>
        <th>Arrival</th>
        <th>PNR</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($VoucherFlightsDetails as $voucherFlightsDetail) {
        if (count($voucherFlightsDetail) > 0) {
            if ($voucherFlightsDetail['FlightType'] != 'Departure') {
                $TravelSelf = '';
                if ($voucherFlightsDetail['TravelSelf'] == 1) {
                    $TravelSelf = "(Self)";
                }
                echo '
                <tr>
                    <td>' . AirportCode($voucherFlightsDetail['SectorFrom']) . ' - ' . AirportName($voucherFlightsDetail['SectorFrom']) . '</td>
                    <td>' . AirportCode($voucherFlightsDetail['SectorTo']) . ' - ' . AirportName($voucherFlightsDetail['SectorTo']) . $TravelSelf . '</td>
                    
                    <td>' . AirlineCode($voucherFlightsDetail['Airline']) . ' ' . $voucherFlightsDetail['Reference'] . '</td>
                    <td>' . DATEFORMAT($voucherFlightsDetail['DepartureDate']) . ' ' . date("g:i A", strtotime($voucherFlightsDetail['DepartureTime'])) . '</td>
                    <td>' . DATEFORMAT($voucherFlightsDetail['ArrivalDate']) . ' ' . date("g:i A", strtotime($voucherFlightsDetail['ArrivalTime'])) . '</td>
                    <td>' . $voucherFlightsDetail['PNR'] . '</td>       
                </tr>';
            }
        } else {
            echo ' 
            <tr>
                <td colspan="6" style="text-align: center">No record found </td>
            </tr>';
        }
    } ?>
    </tbody>
</table>

<table class="table table-striped table-hover" width="100%">
    <tr>
        <td><strong>Reference/Remarks</strong><br><?= nl2br($VoucherData['Reference']) ?></td>
    </tr>
</table>

<table class="table table-striped table-hover" width="100%">
    <tr>
        <td><strong>Terms And Conditions</strong><br><?= nl2br($VoucherSettings['Description']) ?></td>
    </tr>
</table>
<?php

//$VocuherUrduImage = $path . 'template/Final-Hotel-Voucher-Urdu.jpg';
//echo '<div style="margin-top: 10px; margin-bottom: 30px; text-align: right"><img src="' . $VocuherUrduImage . '" height="250px" style="text-align: right"/></div>';

$Domain = $PilgrimDomain;
$table = 'websites."Settings"';
$where = array("DomainID" => $Domain);
$Settings = $Crud->ListRecords($table, $where);
$Key = array();
foreach ($Settings as $setting) {
    $Key[$setting['Key']] = $setting['Description'];
}

echo '<table  class="table table-striped table-hover no-border" width="100%">
    <tr>';
if ($Key['contact_number_1_description'] && $Key['contact_number_1'] != '') {
    echo '<td width="50%" valign="top" style="text-align: center">
           <strong>' . $Key['contact_number_1_description'] . '  </strong>' . $Key['contact_number_1'] . '<br>
        </td>';
}
if ($Key['contact_number_2_description'] && $Key['contact_number_2'] != '') {
    echo ' <td width="50%" valign="top" style="text-align: center">
           <strong>' . $Key['contact_number_2_description'] . '   </strong>' . $Key['contact_number_2'] . '<br>
        </td>
        </tr>
         ';
}
if ($Key['contact_number_3_description'] && $Key['contact_number_3'] != '') {
    echo ' <tr><td width="50%" valign="top" style="text-align: center">
            <strong>' . $Key['contact_number_3_description'] . '   </strong>' . $Key['contact_number_3'] . '<br>
        </td> ';
}
if ($Key['contact_number_4_description'] && $Key['contact_number_4'] != '') {
    echo '<td width="50%" valign="top" style="text-align: center">
            <strong>' . $Key['contact_number_4_description'] . '   </strong>' . $Key['contact_number_4'] . '<br>
        </td> </tr>';
}
echo ' </table>';

?>


