<?php
use App\Models\Crud;
use App\Models\Voucher;

$Crud = new Crud();
$Voucher = new Voucher();

$AccomodationRate = $TransportRate = $ZiyaratRate = $ServicesRate = 0;
$CheckIn = $VoucherData['ArrivalDate'];
$CheckOut = $VoucherData['ReturnDate'];
if ($CheckIn != '' && $CheckIn != '') {
    $days = date_diff(date_create($CheckIn), date_create($CheckOut));
    $days = $days->days;
}
?>

<!-- Basic Details -->
<table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
       width="100%">
    <tr>
        <td colspan="6" class="NoBorder"><strong>General Information About Voucher</strong></td>
    </tr>
    <thead>
    <tr>
        <th>Code</th>
        <th>Agent</th>
        <th>Country</th>
        <th>Arrival Type</th>
        <th>Arrival Date</th>
        <th>Departure Date</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $table = 'main."Agents"';
    $where = array("UID" => $AgentUID);
    $AgentData = $Crud->SingleRecord($table, $where);
    echo '
    <tr>
        <td>' . ((isset($VoucherData['VoucherCode'])) ? $VoucherData['VoucherCode'] : '-') . '</td>
        <td>' . ((isset($AgentData['UID'])) ? $AgentData['FullName'] : '-' ). '</td>
        <td>' . ((isset($VoucherData['Country'])) ? CountryName($VoucherData['Country']) : '-') . '</td>
        <td>' . ((isset($VoucherData['ArrivalType'])) ? $VoucherData['ArrivalType'] : '-') . '</td>
        <td>' . ((isset($VoucherData['ArrivalDate'])) ? DATEFORMAT($VoucherData['ArrivalDate']) : '-') . '</td>
        <td>' . ((isset($VoucherData['ReturnDate'])) ? DATEFORMAT($VoucherData['ReturnDate']) : '-') . '</td>
    </tr> '; ?>
    </tbody>
</table>
<!-- Pilgrims Details -->
<?php
$pilgrimHTML = array();
$cnt = 1;
foreach ($VoucherPilgrimsData as $pilgrim) {
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
        <td colspan="2" class="NoBorder"><strong>Voucher’s (Pilgrims) Detail</strong></td>
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
                if(count($pilgrimHTML) > 0){
                    for ($a = 1; $a <= count($pilgrimHTML); $a++) {
                        if ($a % 2 != 0) {
                            echo $pilgrimHTML[$a];
                        }
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
                if(count($pilgrimHTML) > 0){
                    for ($a = 1; $a <= count($pilgrimHTML); $a++) {
                        if ($a % 2 == 0) {
                            echo $pilgrimHTML[$a];
                        }
                    }
                }
                ?>
                </tbody>
            </table>
        </td>
    </tr>
</table>
<!-- Travel Details -->
<?php
if (count($FlightsData) > 0) {?>
    <table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
           width="100%">
        <tr>
            <td colspan="11" class="NoBorder"><strong>Travel's Details </strong></td>
        </tr>
        <thead>
        <tr>
            <th>Flight Type</th>
            <th>Sector (From)</th>
            <th>Sector (To)</th>
            <th>Airline</th>
            <th>Flight Number</th>
            <th>PNR</th>
            <th>Departure Date</th>
            <th>Departure Time</th>
            <th>Arrival Date</th>
            <th>Arrival Time</th>
            <th>Travel Type</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($FlightsData as $FD){

            echo ' <tr>         
                        <td>' . ((isset($FD['FlightType'])) ? $FD['FlightType'] : '-') . '</td>
                        <td>' . ((isset($FD['SectorFrom'])) ? AirportCode($FD['SectorFrom']) . '-' . AirportName($FD['SectorFrom']) : '-') . '</td>                           
                        <td>' . ((isset($FD['SectorTo'])) ? AirportCode($FD['SectorTo']) . '-' . AirportName($FD['SectorTo']) : '-') . '</td>
                        <td>' . ((isset($FD['Airline']) && $FD['Airline'] > 0) ? AirlineName($FD['Airline']) : 0) . '</td>
                        <td>' . ((isset($FD['Reference'])) ? $FD['Reference'] : '-') . '</td>
                        <td>' . ((isset($FD['PNR'])) ? $FD['PNR'] : '-') . '</td>
                        <td>' . ((isset($FD['DepartureDate'])) ? DATEFORMAT($FD['DepartureDate']) : '-') . '</td>
                        <td>' . ((isset($FD['DepartureTime'])) ? TIMEFORMAT($FD['DepartureTime']) : '-') . '</td>
                        <td>' . ((isset($FD['ArrivalDate'])) ? DATEFORMAT($FD['ArrivalDate']) : '-') . '</td>
                        <td>' . ((isset($FD['ArrivalTime'])) ? TIMEFORMAT($FD['ArrivalTime']) : '-') . '</td>
                        <td>' . ((isset($FD['TravelType'])) ? $FD['TravelType'] : '-') . '</td>          
                 </tr>';
        }
        ?>
        </tbody>
    </table>
<?php } ?>
<!-- Accommodation Details -->
<?php if(count($AccommmodationDetails) > 0){ ?>
    <table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
           width="100%">
        <tr>
            <td colspan="8" class="NoBorder"><strong>Accommodation Details </strong></td>
        </tr>
        <thead>
        <tr>
            <th>City</th>
            <th>Hotel</th>
            <th>Check-In</th>
            <th>Check-Out</th>
            <th>BRN</th>
            <th>Room Type</th>
            <th>Quantity</th>
            <th>Charges</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($AccommmodationDetails as $AD){

            $class = '';
            if ($AD['Refund'] == 1) {
                $class = ' style="background-color: #F8D7DA" ';
            }

            $table = 'packages."Hotels"';
            $where = array("UID" => $AD['Hotel']);
            $HotelData = $Crud->SingleRecord($table, $where);

            if (OptionName($AD['RoomType']) == 'Sharing') {
                $SharingType = " Bed";
            } else {
                $SharingType = " Room";
            }

            echo'<tr '.$class.'>
                    <td>'.CityName($AD['City']).'</td>
                    <td>'.$HotelData['Name'].'</td>
                    <td>'.DATEFORMAT($AD['CheckIn']).'</td>
                    <td>'.DATEFORMAT($AD['CheckOut']).'</td>
                    <td>'.((isset($AD['AccommodationBRN'])) ? $AD['AccommodationBRN'] : '-').'</td>
                    <td>'.OptionName($AD['RoomType']).'</td>
                    <td>'.$AD['NoOfBeds'] . $SharingType.'</td>
                    <td>'.Money($AD['AmountPayable']).'</td>
                </tr>';

            $AccomodationRate += $AD['AmountPayable'];

        }
        ?>
        </tbody>
    </table>
<?php } ?>

<!-- Transport Details -->
<?php if(count($TransportDetails) > 0){ ?>
    <table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
           width="100%">
        <tr>
            <td colspan="9" class="NoBorder"><strong>Transport's Details </strong></td>
        </tr>
        <thead>
        <tr>
            <th>City</th>
            <th>Travel Date</th>
            <th>Sectors</th>
            <th>Travel Type</th>
            <th>Transports</th>
            <th>BRN</th>
            <th>No Of Pax</th>
            <th>No Of Seats</th>
            <th>Rates</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($TransportDetails as $TD){
            $class = ''; $SelfTransport = '';
            if ($TD['Refund'] == 1) {
                $class = ' style="background-color: #F8D7DA" ';
            }
            if ($TD['SelfTransport'] == 1) {
                $SelfTransport = " (Self)";
            }

            echo '<tr ' . $class . '>
                    <td>' . CityName($TD['TravelCity']) . '</td>
                    <td>' . DATEFORMAT($TD['TravelDate']) . '</td>
                    <td>' . $TD['SectorName'] . $SelfTransport . '</td>
                    <td>' . $TD['TravelType'] . '</td>
                    <td>' . $TD['TransportTypeName'] . '</td>
                    <td>' . ((isset($TD['TransportsBRN'])) ? $TD['TransportsBRN'] : '-') . '</td>
                    <td>' . ((isset($TD['NoOfPax'])) ? $TD['NoOfPax'] : '-') . '</td>
                    <td>' . ((isset($TD['NoOfSeats'])) ? $TD['NoOfSeats'] : '-') . '</td>
                     <td>'.Money($TD['Rate']).'</td>
                </tr>';

            $TransportRate += $TD['Rate'];
        }
        ?>
        </tbody>
    </table>
<?php } ?>

<!-- Ziyarat Details -->
<?php if(count($ZiyaratDetails) > 0){ ?>
    <table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
           width="100%">
        <tr>
            <td colspan="5" class="NoBorder"><strong>Ziyarat Details </strong></td>
        </tr>
        <thead>
        <tr>
            <th>Location</th>
            <th>Ziyarat</th>
            <th>Transports</th>
            <th>No Of Pax</th>
            <th>Transport rate</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($ZiyaratDetails as $ZD){

            echo'<tr>
                <td>'.$ZD['CityName'].'</td>
                <td>'.$ZD['ZiyaratName'].'</td>
                <td>'.$ZD['TransportName'].'</td>
                <td>'.$ZD['ZiyaratNoOfPax'].'</td>
                <td>'.Money($ZD['Rate']).'</td>
            </tr>';

            $ZiyaratRate += $ZD['Rate'];
        }
        ?>
        </tbody>
    </table>
<?php } ?>

<!-- Services Details -->
<?php if(count($ServicesDetails) > 0){ ?>
<table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
       width="100%">
    <tr>
        <td colspan="2" class="NoBorder"><strong>Services </strong></td>
    </tr>
    <thead>
    <tr>
        <th>Name</th>
        <th width="20%">Charges</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($ServicesDetails as $SD){
        $class = ''; $ServicesData = array();
        if ($SD['Refund'] == 1) {
            $class = ' style="color: red" ';
        }
        $table = 'packages."ServiceRate"';
        $where = array("UID" => $SD['ServiceID']);
        $ServicesData = $Crud->SingleRecord($table, $where);
        $Rate = ($ServicesData['Rate'] * $days * count($pilgrimHTML));

        echo'<tr>
                <td>'.OptionName($ServicesData['ServiceUID']).'</td>
                <td>'.Money($Rate).'</td>
            </tr>';

        $ServicesRate += $Rate;
    }
    ?>
    </tbody>
</table>
<?php } ?>

<!-- Voucher Visa Rate Segments -->
<?php
$VoucherPilgrimsArray = $TypePilgrimRecord = array(); $TotalPax = 0;
if(isset($VoucherData['VisaRate']) && $VoucherData['VisaRate'] != '' && $VoucherData['VisaRate'] > 0){
    if(count($VoucherPilgrimsData) > 0){
            foreach( $VoucherPilgrimsData as $VPD ){
                $VoucherPilgrimsArray[] = $VPD['UID'];
                $TotalPax += 1;
            }
        }
    $TypePilgrimRecord = $Voucher->GetPilgrimTypeDetails( $VoucherPilgrimsArray );
    $AppliedVisaRate = $Voucher->GetVoucherPilgrimsAppliedVisaRate( $VoucherData['UID'] );
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
            <th width="20%">Visa Rate</th>
        </tr>
        </thead>
        <tbody>
        <?php
            echo'<tr>
                    <td><b>'.$TypePilgrimRecord['Infant'].' * '.Money($AppliedVisaRate['Infant']).'</b></td>
                    <td><b>'.$TypePilgrimRecord['Child'].' * '.Money($AppliedVisaRate['Child']).'</b></td>
                    <td><b>'.$TypePilgrimRecord['Adult'].'  * '.Money($AppliedVisaRate['Adult']).'</b></td>
                    <td><b>'.$TotalPax.'</b></td>
                    <td><b>'.Money($VoucherData['VisaRate']).'</b></td>
                </tr>';
        ?>
        </tbody>
    </table>
<?php } ?>

<!-- Grand Total -->
<?php
$VisaRate = ( (isset($VoucherData['VisaRate']) && $VoucherData['VisaRate'] != '' && $VoucherData['VisaRate'] > 0)? $VoucherData['VisaRate'] : 0 );
$GrandTotal = $AccomodationRate + $TransportRate + $ZiyaratRate + $ServicesRate + $VisaRate;
?>
<table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
       width="100%">
    <tr>
        <td colspan="2" class="NoBorder"><strong>Voucher Total Amount</strong></td>
    </tr>
    <thead>
    <tr>
        <th>Total</th>
        <th width="20%">Amount</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="text-align: right;"><b>Grand Total</b></td>
        <td><b><?=Money($GrandTotal)?></b></td>
    </tr>
    </tbody>
</table>