<?php

use App\Models\Crud;

$Crud = new Crud();

$GroupAccommmodationDataHTML = '';
$TotalGroupsRate = 0;
if (!empty($GroupAccommmodationDatas)) {

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
            <td>' . $GroupAccommmodationData['BRNType'] . '</td>            
            <td>' . DATEFORMAT($GroupAccommmodationData['CheckIn']) . '</td>
            <td>' . DATEFORMAT($GroupAccommmodationData['CheckOut']) . '</td>
            <td>' . $days . '</td>
            <td>' . $GroupAccommmodationData['MultiHotelHTML'] . '</td>
            
            <td>' . Money($GroupAccommmodationData['AmountPayable']) . '</td>            
        </tr> ';

        $TotalGroupsRate += $GroupAccommmodationData['AmountPayable'];
    }
}

?>
<?php
//echo "VISA". $VisaR;
//$NoOfPax = ((isset($GroupData['NoOfPAX'])) ? $GroupData['NoOfPAX'] : 0);
$VisaRate = ((isset($VisaR)) ? $VisaR : 0);
$TotalVisaRate = $VisaRate;
?>

<div class="card mb-4" style="border:solid 1px #f0f0f0; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);">
    <h6 class="p-2">General Information About Group </h6>
    <table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
           width="100%"  style="margin-bottom: 0px;">
        <thead>
        <tr>
            <th>Group Name</th>
            <th>WTU Code</th>
            <th>Package</th>
            <th>Adults</th>
            <th>Childs</th>
            <th>Infants</th>
            <th>Transport Type</th>
            <th>Arrival Date</th>
            <th>Departure Date</th>
            <!--<th>Visa Total</th>-->
<!--            <th>Refund Amount</th>-->
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // <td>' . ((isset($GroupData['RefundAmount'])) ? Money($GroupData['RefundAmount']) : '-') . '</td>
         //<td>' . Money($TotalVisaRate)  . '</td>
        echo '
        <tr>         
            <td>' . ((isset($GroupData['FullName'])) ? $GroupData['FullName'] : '-') . '</td>
            <td>' . ((isset($GroupData['WTUCode'])) ? $GroupData['WTUCode'] : '-') . '</td>
            <td>' . ((isset($Package)) ? $Package : '-') . '</td>
            <td>' . ((isset($GroupData['NoOfPAX'])) ? $GroupData['NoOfPAX'] : '-') . '</td>
            <td>' . ((isset($GroupData['ChildPax'])) ? $GroupData['ChildPax'] : '-') . '</td>
            <td>' . ((isset($GroupData['InfantPax'])) ? $GroupData['InfantPax'] : '-') . '</td>
            <td>' . ((isset($GroupData['TransportType'])) ? $GroupData['TransportType'] : '-') . '</td>
            <td>' . ((isset($GroupData['ArrivalDate'])) ? DATEFORMAT($GroupData['ArrivalDate']) : '-') . '</td>
            <td>' . ((isset($GroupData['DepartureDate'])) ? DATEFORMAT($GroupData['DepartureDate']) : '-') . '</td>
          
            
            <td>' . ((isset($GroupData['Status'])) ? ucwords($GroupData['Status']) : '-') . '</td>
        </tr>'; ?>
        </tbody>
    </table>
</div>

<div class="card mb-4" style="border:solid 1px #f0f0f0; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);">

    <h6 class="p-2">Hotels Detail</h6>
    <table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
           width="100%" style="margin-bottom: 0px;">
        <thead>
        <tr>
            <th>City</th>
            <th>Hotel</th>
            <th>BRN Type</th>
            <th>Check-In</th>
            <th>Check-Out</th>
            <th>Nights</th>
            <th>Quantity</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        <?= $GroupAccommmodationDataHTML ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="7"><strong> Total </strong></td>
            <td><strong><?= Money($TotalGroupsRate) ?></strong></td>
        </tr>
        </tfoot>
    </table>
    <?php //exit();?>
</div>

<div class="card mb-4" style="border:solid 1px #f0f0f0; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);">
    <h6 class="p-2">Transport Detail</h6>
    <table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
           width="100%">
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
        if (!empty($GroupTransportDatas)) {
            foreach ($GroupTransportDatas as $GroupTransportData) {
                //echo '<pre>';print_r($GroupTransportData);
                echo '       
            <tr>
                <td>' . OptionName($GroupTransportData['TransportSectors']) . '</td>        
                <td>' . $GroupTransportData['Transport'] . '</td>
                <td>' . ((isset($GroupTransportData['BRNType'])) ? $GroupTransportData['BRNType'] : '-') . '</td>
                <td>' . ((isset($GroupTransportData['NoOfPax'])) ? $GroupTransportData['NoOfPax'] : '-') . '</td>
                <td>' . ((isset($GroupTransportData['NoOfSeats'])) ? $GroupTransportData['NoOfSeats'] : '-') . '</td>
                <td>' . ((isset($GroupTransportData['TransportsRates'])) ? Money($GroupTransportData['TransportsRates']) : '-') . '</td>
            </tr>';
                $Total += $GroupTransportData['TransportsRates'];
            }
        } ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="5"><strong>Total</strong></td>
            <td><strong> <?= Money($Total) ?></strong></td>
        </tr>
        </tfoot>
    </table>
</div>

<div class="card mb-4" style="border:solid 1px #f0f0f0; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);">
    <h6 class="p-2">Ziyarats</h6>
    <table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
           width="100%">
        <thead>
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
        $TotalZiyaratRate = 0;
        if (!empty($GroupZiyaratDatas)) {
            foreach ($GroupZiyaratDatas as $GroupZiyaratData) {
                echo '       
            <tr>
                <td>' . $GroupZiyaratData['Ziyarat'] . '</td>        
                <td>' . $GroupZiyaratData['ZiyaratCity'] . '</td>
                <td>' . ((isset($GroupZiyaratData['ZiyaratTransport'])) ? $GroupZiyaratData['ZiyaratTransport'] : '-') . '</td>
                <td>' . ((isset($GroupZiyaratData['ZiyaratNoOfPax'])) ? $GroupZiyaratData['ZiyaratNoOfPax'] : '-') . '</td>
                 <td>' . ((isset($GroupZiyaratData['TransportRateZiyrat'])) ? Money($GroupZiyaratData['TransportRateZiyrat']) : '-') . '</td>
            </tr>';
                $TotalZiyaratRate += (int)$GroupZiyaratData['TransportRateZiyrat'];
                //echo $GroupZiyaratData['ZiyaratName'] . ' (' . $GroupZiyaratData['CityName'] . ') in <strong>' . $GroupZiyaratData['TransportName'] . '</strong>; &nbsp;';
            }
        }
        ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4"><strong>Total</strong></td>
            <td><strong> <?= Money($TotalZiyaratRate) ?> </strong></td>
        </tr>
        </tfoot>
    </table>
</div>

<div class="card mb-4" style="border:solid 1px #f0f0f0; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);">
    <h6 class="p-2">Other Services</h6>
    <table class="table table-striped table-hover display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
           width="100%">
        <thead>
        <tr>
            <th>Service Name</th>
            <th width="15%">Amount</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $TotalServices = 0;
        if (!empty($GroupServicesDatas)) {
            foreach ($GroupServicesDatas as $GroupServicesData) {
                $ServiceRate = $GroupServicesData['ServiceID'];
                $table = 'packages."ServiceRate"';
                $where = array("UID" => $ServiceRate);
                $ServicesRate = $Crud->SingleRecord($table, $where);
                $rate = $ServicesRate['Rate'] * $GroupData['NoOfPAX'];
                echo '
            <tr>
                <td>' . OptionName($ServicesRate['ServiceUID']) . ' </td>
                <td>' . Money($rate) . ' </td>
            </tr>';
                $TotalServices += $rate;
            }
        } ?>
        </tbody>
        <tfoot>
        <tr>
            <td><strong>Total</strong></td>
            <td><strong><?= Money($TotalServices) ?></strong></td>
        </tr>
        </tfoot>
    </table>
</div>

<div class="card mb-4" style="border:solid 1px #f0f0f0; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);">
    <h6 class="p-2">Visa Total</h6>
    <table class="table table-striped table-hover display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
           width="100%">
        <thead>
        <tr>
            <th>Visa</th>
            <th width="15%">Amount</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td><strong>Total</strong></td>
            <td><strong><?= ((isset($TotalVisaRate) && $TotalVisaRate != '') ? Money($TotalVisaRate) : '-') ?></strong></td>
        </tr>
        </tfoot>
    </table>
</div>
<div class="card mb-4" style="border:solid 1px #f0f0f0; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);">
    <h6 class="p-2">Refunds Amounts</h6>
    <table class="table table-striped table-hover display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
           width="100%">
        <thead>
        <tr>
            <th>Refund</th>
            <th width="15%">Amount</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td><strong>Total</strong></td>
            <td><strong><?= ((isset($GroupData['RefundAmount'])) ? Money($GroupData['RefundAmount']) : '-') ?></strong></td>
        </tr>
        </tfoot>
    </table>
</div>

<div style="background:#f2f2f2;">
    <?php
    $RefundAmount = ((isset($GroupData['RefundAmount']) && $GroupData['RefundAmount'] != '') ? $GroupData['RefundAmount'] : 0);
    $WithRefundGrandTotal = $TotalGroupsRate + $Total + $TotalZiyaratRate + $TotalServices + $TotalVisaRate + $RefundAmount;
    $GrandTotal = $TotalGroupsRate + $Total + $TotalZiyaratRate + $TotalServices + $TotalVisaRate; ?>
    <table class="table table-striped table-hover" width="100%">
        <tr>
            <td width="85%">
                <div style="height: 130px;">
                    <strong style="font-size: 130%;">Reference/Remarks</strong><br><?= nl2br($GroupData['Remarks']) ?>
                </div>
            </td>
            <td style="line-height: 30px;">
<!--                <strong>Refund Amount</strong><br>-->
<!--                <strong style="font-size: 150%;">--><?//= ((isset($GroupData['RefundAmount'])) ? Money($GroupData['RefundAmount']) : '-') ?><!--</strong>-->
<!--                <hr>-->
                <strong>Grand Total</strong><br>
                <strong style="font-size: 200%;"><?= Money($WithRefundGrandTotal) ?></strong>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">

    $(document).ready( function (){
        var FormID = $(".widget-content").closest("form[id]").attr('id')
        var GrandTotal = "<?=$GrandTotal?>";
        $("form#"+FormID+" input#GrandTotal").val( GrandTotal );
    } );

</script>



