<?php

use App\Models\Crud;

$Crud = new Crud();

$GroupAccommmodationDataHTML = '';
$TotalGroupsRate = 0;
foreach ($GroupAccommmodationDatas as $GroupAccommmodationData) {
    $days = '-';
    $CheckIn = ($GroupAccommmodationData['CheckIn']);
    $CheckOut = ($GroupAccommmodationData['CheckOut']);
    if ($CheckIn != '' && $CheckIn != '') {
        $days = date_diff(date_create($CheckIn), date_create($CheckOut));
        $days = $days->days;
    }

    $hotel = $GroupAccommmodationData['Hotel'];
    $table = 'packages."Hotels"';
    $where = array("UID" => $hotel);
    $PackageName = $PackageData['Name'];
    if ($GroupAccommmodationData['Self'] == 1) {
        $table = 'packages."OtherHotels"';
        $PackageName = '';
    }
    $HotelName = $Crud->SingleRecord($table, $where);
    $GroupAccommmodationDataHTML .= '       
    <tr>
        <td>' . CityName($GroupAccommmodationData['City']) . '</td>
        <td>' . $HotelName['Name'] . '</td>
        
        <td>' . DATEFORMAT($GroupAccommmodationData['CheckIn']) . '</td>
        <td>' . DATEFORMAT($GroupAccommmodationData['CheckOut']) . '</td>
        <td>' . $days . '</td>
        <td>' . $GroupAccommmodationData['NoOfBeds'] . '</td>
        <td>' . OptionName($GroupAccommmodationData['RoomType']) . '</td>
        <td>' . Money($GroupAccommmodationData['AmountPayable']) . '</td>
        
    </tr> ';

    $TotalGroupsRate += $GroupAccommmodationData['AmountPayable'];
}
?>
<table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
       width="100%">
    <tr>
        <td colspan="8" class="NoBorder"><strong>General Information About Group </strong></td>
    </tr>
    <thead>
    <tr>
        <th>Group Code</th>
        <th>Group Name</th>
        <th>WTU Code</th>
        <th>Package</th>
        <th>No Of PAX</th>
        <th>Transport Type</th>
        <th>Arrival Date</th>
        <th>Departure Date</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
    echo '
    <tr>
         <td>' . ((isset($GroupData['UID'])) ? Code('UF/G/', $GroupData['UID']) : '-') . '</td>
        <td>' . ((isset($GroupData['FullName'])) ? $GroupData['FullName'] : '-') . '</td>
        <td>' . ((isset($GroupData['WTUCode'])) ? $GroupData['WTUCode'] : '-') . '</td>
        <td>' . ((isset($PackageData['Name'])) ? $PackageData['Name'] : '-') . '</td>
        <td>' . ((isset($GroupData['NoOfPAX'])) ? $GroupData['NoOfPAX'] : '-') . '</td>
        <td>' . ((isset($GroupData['TransportType'])) ? $GroupData['TransportType'] : '-') . '</td>
        <td>' . ((isset($GroupData['ArrivalDate'])) ? DATEFORMAT($GroupData['ArrivalDate']) : '-') . '</td>
        <td>' . ((isset($GroupData['DepartureDate'])) ? DATEFORMAT($GroupData['DepartureDate']) : '-') . '</td>
        <td>' . ((isset($GroupData['Status'])) ? ucwords($GroupData['Status']) : '-') . '</td>
    </tr> '; ?>
    </tbody>
</table>

<?php
//print_r($pilgrims);
$pilgrimHTML = array();
$cnt = 1;
foreach ($pilgrims as $pilgrim) {
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
<?php
$NoOfPax = ((isset($GroupData['NoOfPAX'])) ? $GroupData['NoOfPAX'] : 0);
$VisaRate = ((isset($VisaR['Value'])) ? $VisaR['Value'] : 0);
$TotalVisaRate = $NoOfPax * $VisaRate ;
?>

<table class="table table-striped table-hover display nowrap cell-border" width="100%">
    <tr>
        <td colspan="1" class="NoBorder"><strong>Group’s (Pilgrims) Detail</strong></td>
        <td class="NoBorder" style="text-align: right"><strong><?=((isset($GroupData['Visa'])) ? OptionName($GroupData['Visa']) : '-')?> Rate : <?=Money($TotalVisaRate)?></strong></td>
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
        <td colspan="7" class="NoBorder"><strong>Hotels Detail</strong></td>
    </tr>
    <thead>
    <tr>
        <th>City</th>
        <th>Hotel</th>
        <th>Check-In</th>
        <th>Check-Out</th>
        <th>Nights</th>
        <th>No of Beds</th>
        <th>Room Type</th>
        <th width="15%">Amount</th>
    </tr>
    </thead>
    <tbody>
    <?= $GroupAccommmodationDataHTML ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="7"><strong> Total </strong> </td>
        <td> <strong><?=Money($TotalGroupsRate)?></strong> </td>
    </tr>
    </tfoot>
</table>

<table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
       width="100%">
    <tr>
        <td colspan="4" class="NoBorder"><strong>Transport Detail</strong></td>
    </tr>
    <thead>
    <tr>
        <th>Sector</th>
        <th>Transport</th>
        <th>No Of Pax</th>
        <th>No Of Seats</th>
        <th width="15%">Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $Total = 0;
    foreach ($GroupTransportDatas as $GroupTransportData) {

        echo '       
        <tr>
            <td>' . $GroupTransportData['SectorName'] . '</td>        
            <td>' . $GroupTransportData['TransportTypeName'] . '</td>
            <td>' . ((isset($GroupTransportData['NoOfPax'])) ? $GroupTransportData['NoOfPax'] : '-') . '</td>
            <td>' . ((isset($GroupTransportData['NoOfSeats'])) ? $GroupTransportData['NoOfSeats'] : '-') . '</td>
            <td>' . ((isset($GroupTransportData['TransportsRates'])) ? Money($GroupTransportData['TransportsRates']) : '-') . '</td>
        </tr>';
        $Total += $GroupTransportData['TransportsRates'];
    }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="4"> <strong>Total</strong> </td>
        <td><strong> <?=Money($Total)?></strong> </td>
    </tr>
    </tfoot>
</table>

<table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
       width="100%">
    <thead>
    <tr>
        <td colspan="5" class="NoBorder"><strong>Ziyarats</strong></td>
    </tr>
    <tr>
        <th>Name</th>
        <th>City</th>
        <th>Transport Type</th>
        <th>No Of Pax</th>
        <th width="15%">Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $TotalZiyaratRate =0;
    foreach ($GroupZiyaratDatas as $GroupZiyaratData) {
        echo '       
        <tr>
            <td>' . $GroupZiyaratData['ZiyaratName'] . '</td>        
            <td>' . $GroupZiyaratData['CityName'] . '</td>
            <td>' . ((isset($GroupZiyaratData['TransportName'])) ? $GroupZiyaratData['TransportName'] : '-') . '</td>
            <td>' . ((isset($GroupZiyaratData['ZiyaratNoOfPax'])) ? $GroupZiyaratData['ZiyaratNoOfPax'] : '-') . '</td>
             <td>' . ((isset($GroupZiyaratData['TransportRateZiyrat'])) ? Money($GroupZiyaratData['TransportRateZiyrat']) : '-') . '</td>
        </tr>';
        $TotalZiyaratRate += $GroupZiyaratData['TransportRateZiyrat'];
//                echo $GroupZiyaratData['ZiyaratName'] . ' (' . $GroupZiyaratData['CityName'] . ') in <strong>' . $GroupZiyaratData['TransportName'] . '</strong>; &nbsp;';
    } ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="4"> <strong>Total</strong> </td>
        <td> <strong> <?=Money($TotalZiyaratRate)?> </strong></td>
    </tr>
    </tfoot>
</table>

<table class="table table-striped table-hover display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
       width="100%">
    <thead>
    <tr>
        <td colspan="2" class="NoBorder"><strong>Other Services</strong></td>
    </tr>
    <tr>
        <th>Service Name</th>
        <th width="15%">Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $TotalServices = 0;
    foreach ($GroupServicesDatas as $GroupServicesData) {
        $ServiceRate = $GroupServicesData['ServiceID'];
        $table = 'packages."ServiceRate"';
        $where = array("UID" => $ServiceRate);
        $ServicesRate = $Crud->SingleRecord($table, $where);
        $rate = $ServicesRate['Rate'] * $GroupData['NoOfPAX'];
        echo ' <tr>
        <td>'.OptionName($ServicesRate['ServiceUID']). ' </td>
        <td>'.Money($rate). ' </td>
        ';
        $TotalServices += $rate;

    }
    ?>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td> <strong>Total</strong> </td>
        <td> <strong> <?=Money($TotalServices)?> </strong></td>
    </tr>
    </tfoot>
</table>

<?php
$GrandTotal = $TotalGroupsRate + $Total + $TotalZiyaratRate + $TotalServices + $TotalVisaRate ;
?>
<table class="table table-striped table-hover" width="100%">
    <tr>
        <td width="85%"><strong>Reference/Remarks</strong><br><?= nl2br($GroupData['Remarks']) ?></td>
        <td><strong>Grand Total</strong><br><strong><?=  Money($GrandTotal) ?></strong></td>
    </tr>
</table>


