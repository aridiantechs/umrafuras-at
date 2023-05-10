<?php

use App\Models\Crud;
$Crud = new Crud();


?>
<table class="table table-striped table-hover no-border" width="100%">
    <tr>
        <td width="40%" valign="top">
            <?php
            $days = '';
            $days = date_diff(date_create($VoucherData['ArrivalDate']), date_create($VoucherData['ReturnDate']));
            $days = $days->days;
            ?>
            <strong>Voucher Code:</strong> <?= $VoucherData['VoucherCode']?><br>
            <strong>Arrival Date: </strong><?= DATEFORMAT($VoucherData['ArrivalDate'])?><br>
            <strong>Return Date:</strong> <?= DATEFORMAT($VoucherData['ReturnDate'])?><br>
            <strong>Total Nights:</strong> <?= $days ?> Nights<br>
        </td>
        <td width="40%" valign="top">
            <strong>Arrival Type:</strong> <?= $VoucherData['ArrivalType']?><br>
            <strong>Country: </strong><?= CountryName($VoucherData['Country'])?><br>
            <strong>Infants: </strong><?=$Infants?><br>
            <strong>Childs: </strong><?=$Childs?><br>
            <strong>Adults: </strong><?=$Adults?>
        </td>
        <td style="text-align: right">
            <img height="60"
                 src="data:image/gif;base64,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">
        </td>
    </tr>

</table>
<!---->
<!--<strong>General Information</strong>-->
<!--<table class="lgrid table">-->
<!--    <thead>-->
<!--    <tr>-->
<!--        <th>Agent</th>-->
<!--         <th>Voucher Code</th>-->
<!--        <th>Arrival Date</th>-->
<!--        <th>Return Date </th>-->
<!--        <th>Arrival Type</th>-->
<!--        <th>Country</th>-->
<!--    </tr>-->
<!--    </thead>-->
<!--    <tbody>-->
<!--    --><?php
//    $AgentID = $VoucherData['AgentUID'];
//    $table = 'main."Agents"';
//    $where = array("UID" => $AgentID);
//    $AgentName = $Crud->SingleRecord($table, $where);
//    echo '
//     <tr>
//        <td>'.$AgentName['FullName'].'</td>
//        <td>'.$VoucherData['VoucherCode'].'</td>
//        <td>'.DATEFORMAT($VoucherData['ArrivalDate']).'</td>
//        <td>'.DATEFORMAT($VoucherData['ReturnDate']).'</td>
//        <td>'.$VoucherData['ArrivalType'].'</td>
//        <td>'.CountryName($VoucherData['Country']).'</td>
//    </tr>
//    ';
//    ?>
<!---->
<!--    </tbody>-->
<!--</table>-->


<strong>Mutamer’s (Pilgrims) Detail</strong>
<table class="table lgrid">
    <thead>
    <tr>
        <th>Sr .#</th>
        <th>Pilgrim Code</th>
        <th>Pilgrim Name</th>
        <th>Age</th>
        <th>Passport</th>
        <th>Visa No</th>
        <th>Issue Date</th>
        <th>Expire Date</th>
    </tr>
    </thead>
    <tbody><?php
    //print_r($pilgrims);
    $cnt=1;
    foreach ($pilgrims as $pilgrim) {
        echo '
        <tr>
            <td>' . $cnt . '</td>
            <td>' . Code('UF/P/', $pilgrim['UID']) . '</td>
            <td>' . $pilgrim['FirstName'] . ' ' . $pilgrim['LastName'] . '</td>
            <td>' . AGE($pilgrim['DOB']) . '</td>
            <td>' . $pilgrim['PassportNumber'] . '</td>
            <td>' . DATA($pilgrim['VisaNumber']) . '</td>
            <td>' . DATEFORMAT($pilgrim['IssueDate']) . '</td>
            <td>' . DATEFORMAT($pilgrim['ExpireDate']) . '</td>
        </tr>';$cnt++;
    } ?>

    </tbody>
</table>

<strong>Travel Information </strong>
<table class="lgrid table">
    <thead>
    <tr>
        <th>Flight Type</th>
        <th>Sector To</th>
        <th>Sector From</th>
        <th>Airline</th>
        <th>Reference</th>
        <th>PNR</th>
        <th>Departure Date</th>
        <th>Departure Time</th>
        <th>Arrival Date</th>
        <th>Arrival Time</th>
     </tr>
    </thead>
    <tbody>
    <?php

    foreach ($VoucherFlightsDetails as $voucherFlightsDetail) {
        echo '
         <tr>
        <td>'.$voucherFlightsDetail['FlightType'].'</td>
        <td>'.AirportName($voucherFlightsDetail['SectorTo']).'</td>
        <td>'.AirportName($voucherFlightsDetail['SectorFrom']).'</td>
        <td>'.$voucherFlightsDetail['Airline'].'</td>
        <td>'.$voucherFlightsDetail['Reference'].'</td>
        <td>'.$voucherFlightsDetail['PNR'].'</td>
        <td>'.DATEFORMAT($voucherFlightsDetail['DepartureDate']).'</td>
        <td>'.$voucherFlightsDetail['DepartureTime'].'</td>
        <td>'.DATEFORMAT($voucherFlightsDetail['ArrivalDate']).'</td>
        <td>'.$voucherFlightsDetail['ArrivalTime'].'</td>
      
    </tr>
        ';
    }

    ?>
     </tbody>
</table>
<!---->
<!--<strong>Return Flight from KSA</strong>-->
<!--<table class="lgrid table">-->
<!--    <thead>-->
<!--    <tr>-->
<!--        <th>Airport</th>-->
<!--        <th>Sector</th>-->
<!--        <th>Flight No</th>-->
<!--        <th>Dep Date</th>-->
<!--        <th>Dep Time</th>-->
<!--        <th>Arrival Date</th>-->
<!--        <th>Arrival Time</th>-->
<!--        <th>PNR</th>-->
<!--    </tr>-->
<!--    </thead>-->
<!--    <tbody>-->
<!--    <tr>-->
<!--        <td>Islamabad International</td>-->
<!--        <td>AK</td>-->
<!--        <td>356</td>-->
<!--        <td>2008/11/28</td>-->
<!--        <td>2008/12/28</td>-->
<!--        <td>2008/11/28</td>-->
<!--        <td>05:00 PM</td>-->
<!--        <td>36200</td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td>Turkey Airport</td>-->
<!--        <td>CD</td>-->
<!--        <td>6756</td>-->
<!--        <td>2009/10/09</td>-->
<!--        <td>2009/11/09</td>-->
<!--        <td>2009/10/09</td>-->
<!--        <td>03:00 PM</td>-->
<!--        <td>34536</td>-->
<!--    </tr>-->
<!--    </tbody>-->
<!--</table>-->

<strong>Accommodation Detail</strong>
<table class="table table-striped table-hover" width="100%">
    <thead>
    <tr>
         <th>City</th>
        <th>Hotel</th>
        <th>Check-In</th>
        <th>Check-Out</th>
        <th>Nights</th>
        <th>Room Type</th>
    </tr>
    </thead>
    <tbody>
    <?php

    foreach ($VoucherAccommmodationDatas as $VoucherAccommmodationData)
    {
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
        $HotelName = $Crud->SingleRecord($table, $where);

        echo'       
        <tr>
         <td>'.CityName($VoucherAccommmodationData['City']).'</td>
        <td>'.$HotelName['Name'].'</td>
        <td>'.DATEFORMAT($VoucherAccommmodationData['CheckIn']).'</td>
        <td>'.DATEFORMAT($VoucherAccommmodationData['CheckOut']).'</td>
        <td>'.$days.'</td>
        <td>'.OptionName($VoucherAccommmodationData['RoomType']).'</td>
    </tr>
        '; }
    ?>
    </tbody>
</table>

<strong>Transport Detail</strong>
<table class="lgrid table">
    <thead>
    <tr>
        <th>Sector</th>
        <th>Transport</th>
        <th>Rate</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($VoucherTransportDatas as $VoucherTransportData)
    {
        echo '       
        <tr>
        <td>'.OptionName($VoucherTransportData['Sectors']).'</td>
        <td>'.OptionName($VoucherTransportData['TransportTypeUID']).'</td>
        <td>'.Money($VoucherTransportData['Rate']).'</td>    
  
    </tr>
        ';
    }
    ?>
    </tbody>
</table>



<strong>Ziyarats Detail</strong>
<table class="lgrid table">
    <thead>
    <tr>
        <th>Location</th>
        <th>Ziyarat</th>
        <th>Transport</th>
        <th>Transport Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($VoucherZiyaratDatas as $VoucherZiyaratData)
    {
        $Ziaratid= $VoucherZiyaratData['ZiyaratsUID'];
        $table = 'packages."Ziyarats"';
        $where = array("UID" => $Ziaratid);
        $ZiyaratName = $Crud->SingleRecord($table, $where);
        echo '       
        <tr>
        <td>'.CityName($VoucherZiyaratData['ZiyaratCity']).'</td>
        <td>'.$ZiyaratName['Name'].'</td>
        <td>'.OptionName($VoucherZiyaratData['TransportTypeUID']).'</td>    
        <td>'.Money($VoucherZiyaratData['Rate']).'</td>    
  
    </tr>
        ';
    }
    ?>
    </tbody>
</table>

<strong>Other Services Detail</strong>
<table class="lgrid table">
    <thead>
    <tr>
        <th>Service Name</th>
        <th>Service Rate</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($VoucherServicesDatas as $VoucherServicesData)
    {
        $ServiceRate = $VoucherServicesData['ServiceID'];
        $table = 'packages."ServiceRate"';
        $where = array("UID" => $ServiceRate);
        $ServicesRate = $Crud->SingleRecord($table, $where);
        echo '       
        <tr>
         <td>'.OptionName($ServicesRate['ServiceUID']).'</td>
         <td>'.Money($ServicesRate['Rate']).'</td>
    </tr>
        ';
    }
    ?>
    </tbody>
</table>





<table class="lgrid table">
    <tr>
        <td><strong>Reference/Remarks</strong><br><?= nl2br($VoucherData['Reference']) ?></td>
    </tr>
</table>
