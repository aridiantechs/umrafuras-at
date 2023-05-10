<?php

use App\Models\Crud;
use App\Models\Groups;

$Crud = new Crud();
$Groups = new Groups();

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

    if(OptionName($GroupAccommmodationData['RoomType']) == 'Sharing'){
        $quantity = " Bed";
    }else{
        $quantity = " Room";
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
        <td>' . $GroupAccommmodationData['BRNType'] . '</td>
        
        <td>' . DATEFORMAT($GroupAccommmodationData['CheckIn']) . '</td>
        <td>' . DATEFORMAT($GroupAccommmodationData['CheckOut']) . '</td>
        <td>' . $days . '</td>
        <td>' . $GroupAccommmodationData['NoOfBeds'] .  $quantity .'</td>
        <td>' . Money($GroupAccommmodationData['AmountPayable']) . '</td>
        
    </tr> ';

    $TotalGroupsRate += $GroupAccommmodationData['AmountPayable'];
}
?>
<table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
       width="100%">
    <tr>
        <td colspan="10" class="NoBorder"><strong>General Information About Group </strong></td>
    </tr>
    <thead>
    <tr>
         <th>Group Name</th>
        <th>WTU Code</th>
        <th>Package</th>
        <th>Adult</th>
        <th>Child</th>
        <th>Infant</th>
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
         <td>' . ((isset($GroupData['FullName'])) ? $GroupData['FullName'] : '-') . '</td>
        <td>' . ((isset($GroupData['WTUCode'])) ? $GroupData['WTUCode'] : '-') . '</td>
        <td>' . ((isset($PackageData['Name'])) ? $PackageData['Name'] : '-') . '</td>
        <td>' . ((isset($GroupData['NoOfPAX'])) ? $GroupData['NoOfPAX'] : '-') . '</td>
        <td>' . ((isset($GroupData['ChildPax'])) ? $GroupData['ChildPax'] : '-') . '</td>
        <td>' . ((isset($GroupData['InfantPax'])) ? $GroupData['InfantPax'] : '-') . '</td>
        <td>' . ((isset($GroupData['TransportType'])) ? $GroupData['TransportType'] : '-') . '</td>
        <td>' . ((isset($GroupData['ArrivalDate'])) ? DATEFORMAT($GroupData['ArrivalDate']) : '-') . '</td>
        <td>' . ((isset($GroupData['DepartureDate'])) ? DATEFORMAT($GroupData['DepartureDate']) : '-') . '</td>
        <td>' . ((isset($GroupData['Status'])) ? PROPER($GroupData['Status']) : '-') . '</td>
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
 //$NoOfPax = ((isset($GroupData['NoOfPAX'])) ? $GroupData['NoOfPAX'] : 0);
 $VisaRate = ((isset($GroupData['VisaRate'])) ? $GroupData['VisaRate'] : 0);
 $TotalVisaRate = $VisaRate ;
?>

<table class="table table-striped table-hover display nowrap cell-border" width="100%">
    <tr>
        <td colspan="1" class="NoBorder"><strong>Group’s (Pilgrims) Detail</strong></td>
        <td class="NoBorder" style="text-align: right"></td>
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
        <td colspan="8" class="NoBorder"><strong>Hotels Detail</strong></td>
    </tr>
    <thead>
    <tr>
        <th>City</th>
        <th>Hotel</th>
        <th>BRN Type</th>
        <th>Check-In</th>
        <th>Check-Out</th>
        <th>Nights</th>
        <th>Quantity</th>
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
        <th>BRN Type</th>
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
            <td>' . ((isset($GroupTransportData['BRNType'])) ? $GroupTransportData['BRNType'] : '-') . '</td>
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
        <td colspan="5"> <strong>Total</strong> </td>
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

<?php  if(isset($TotalVisaRate) && $TotalVisaRate > 0){
    $Adult = ( ( isset($GroupData['NoOfPAX']) && $GroupData['NoOfPAX'] != '' )? $GroupData['NoOfPAX'] : 0 );
    $Child = ( ( isset($GroupData['ChildPax']) && $GroupData['ChildPax'] != '' )? $GroupData['ChildPax'] : 0 );
    $Infant = ( ( isset($GroupData['InfantPax']) && $GroupData['InfantPax'] != '' )? $GroupData['InfantPax'] : 0 );
    $TotalPax = ( $Adult + $Child + $Infant );

    $AppliedVisaRate = $Groups->GetGroupPilgrimsAppliedVisaRate( $GroupData['UID'] );
    ?>
    <table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
           width="100%">
        <tr>
            <td colspan="5" class="NoBorder"><strong>Visa Details </strong></td>
        </tr>
        <thead>
        <tr>
            <th>Infants</th>
            <th>Childs</th>
            <th>Adults</th>
            <th>Total Pax</th>
            <th width="15%">Visa Rate</th>
        </tr>
        </thead>
        <tbody>
        <?php
        echo'<tr>
                    <td><b>'.$Adult.' * '.Money($AppliedVisaRate['Infant']).'</b></td>
                    <td><b>'.$Child.' * '.Money($AppliedVisaRate['Child']).'</b></td>
                    <td><b>'.$Infant.'  * '.Money($AppliedVisaRate['Adult']).'</b></td>
                    <td><b>'.$TotalPax.'</b></td>
                    <td><b>'.Money($TotalVisaRate).'</b></td>
                </tr>';
        ?>
        </tbody>
    </table>
<?php } ?>

<?php  if(isset($GroupData['RefundAmount']) && $GroupData['RefundAmount'] > 0){ ?>
    <table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
           width="100%">
        <thead>
        <tr>
            <td class="NoBorder"><strong>Refund Amounts</strong></td>
        </tr>
        <tr>
            <th>Refund</th>
            <th width="15%">Amount</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><strong>Total</strong></td>
            <td><strong><?=  Money($GroupData['RefundAmount']) ?></strong></td>
        </tr>
        </tbody>
    </table>
<?php } ?>

<?php
$RefundAmount = ((isset($GroupData['RefundAmount']) && $GroupData['RefundAmount'] != '') ? $GroupData['RefundAmount'] : 0);
 $GrandTotal = $TotalGroupsRate + $Total + $TotalZiyaratRate + $TotalServices + $TotalVisaRate + $RefundAmount ;
?>
<table class="table table-striped table-hover" width="100%">
    <tr>
        <td width="85%" rowspan="2" valign="top"><strong>Reference/Remarks</strong><br><?= nl2br($GroupData['Remarks']) ?></td>
        <td><strong>Grand Total</strong><br><strong><?=  Money($GrandTotal) ?></strong></td>
    </tr>
</table>


