<?php

use App\Models\Crud;

$Crud = new Crud();
$Query = 'SELECT 
        pilgrim."master"."FirstName",
        pilgrim."master"."LastName", 
        pilgrim."master"."PassportNumber", 
        pilgrim."master"."RegistrationDate", 
        pilgrim."travel"."VisaNo"
        FROM pilgrim."master" 
        LEFT JOIN pilgrim."travel" ON pilgrim."travel"."PilgrimID"  = pilgrim."master"."UID"
        WHERE pilgrim."master"."UID" IN (' . $pilgrims . ')';
$rsltpilgrim = $Crud->ExecuteSQL($Query);
$Query = 'SELECT 
            "main"."LookupsOptions"."Name",
            "packages"."ServiceRate"."Rate"
            FROM "packages"."ServiceRate"
            INNER JOIN "main"."LookupsOptions" ON "main"."LookupsOptions"."UID"= "packages"."ServiceRate"."ServiceUID"
            WHERE "packages"."ServiceRate"."UID" IN (' . $ServicesIDs . ')';
$rsltservices = $Crud->ExecuteSQL($Query);
$GroupAccommmodationDataHTML = '';
$TotalVoucherRate = 0;
$days = '-';
$CheckIn = $VoucherData['ArrivalDate'];
$CheckOut = $VoucherData['ReturnDate'];
if ($CheckIn != '' && $CheckIn != '') {
    $days = date_diff(date_create($CheckIn), date_create($CheckOut));
    $days = $days->days;
}

?>


<div class="card mb-4" style="border:solid 1px #f0f0f0; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);">
    <h6 class="p-2">General Information About Voucher </h6>
    <table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
           width="100%" ` style="margin-bottom: 0px;">
        <thead>
        <tr>
            <th>Agent</th>
            <th>Country</th>
            <th>Arrival Type</th>

            <th>Arrival Date</th>
            <th>Return Date</th>

        </tr>
        </thead>
        <tbody>
        <?php

        echo '
        <tr>         
            <td>' . ((isset($VoucherData['AgentUID'])) ? AgentName($VoucherData['AgentUID']) : '-') . '</td>
            <td>' . ((isset($VoucherData['Country'])) ? CountryName($VoucherData['Country']) : '-') . '</td>
           
            <td>' . ((isset($VoucherData['ArrivalType'])) ? $VoucherData['ArrivalType'] : '-') . '</td>
            <td>' . ((isset($VoucherData['ArrivalDate'])) ? DATEFORMAT($VoucherData['ArrivalDate']) : '-') . '</td>
            <td>' . ((isset($VoucherData['ReturnDate'])) ? DATEFORMAT($VoucherData['ReturnDate']) : '-') . '</td>
          
        </tr>'; ?>
        </tbody>
    </table>

    <?php
    //print_r($pilgrims);
    $pilgrimHTML = array();
    $cnt = 1;
    foreach ($rsltpilgrim as $pilgrim) {
        $pilgrimHTML[$cnt] = '
        <tr>
            <td>' . $cnt . '</td>
            <td>' . $pilgrim['FirstName'] . ' ' . $pilgrim['LastName'] . '</td>
            <td>' . $pilgrim['PassportNumber'] . '</td>
            <td>' . DATA($pilgrim['VisaNo']) . '</td>
            <td>' . DATEFORMAT($pilgrim['RegistrationDate']) . '</td>
        </tr>';
        $cnt++;
    } ?>

    <table class="table table-striped table-hover display nowrap cell-border" width="100%">
        <tr>
            <td colspan="1" class="NoBorder"><strong>Voucher’s (Pilgrims) Detail</strong></td>
            <td class="NoBorder" style="text-align: right"><strong></strong></td>
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
            <td width="49%" valign="top" style="vertical-align: top !important;">
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
    <h6 class="p-2">Travel's Details </h6>
    <table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
           width="100%" ` style="margin-bottom: 0px;">
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
        if (isset($FlightsData)) {

            $FlightDescription = $FlightsData['FlightType'];
            //echo '<pre>';print_r($FlightsData);exit();
            if (!empty($FlightDescription[0])) {
                for ($a = 0; $a < count($FlightDescription); $a++) {
                    echo '
        <tr>         
            <td>' . ((isset($FlightsData['FlightType'][$a])) ? $FlightsData['FlightType'][$a] : '-') . '</td>
            <td>' . ((isset($FlightsData['SectorFrom'][$a])) ? AirportCode($FlightsData['SectorFrom'][$a]) . '-' . AirportName($FlightsData['SectorFrom'][$a]) : '-') . '</td>
           
            <td>' . ((isset($FlightsData['SectorTo'][$a])) ? AirportCode($FlightsData['SectorTo'][$a]) . '-' . AirportName($FlightsData['SectorTo'][$a]) : '-') . '</td>
            <td>' . ((isset($FlightsData['Airline'][$a])) ? AirlineName($FlightsData['Airline'][$a]) : 0) . '</td>
            <td>' . ((isset($FlightsData['Reference'][$a])) ? $FlightsData['Reference'][$a] : '-') . '</td>
            <td>' . ((isset($FlightsData['PNR'][$a])) ? $FlightsData['PNR'][$a] : '-') . '</td>
            <td>' . ((isset($FlightsData['DepartureDate'][$a])) ? DATEFORMAT($FlightsData['DepartureDate'][$a]) : '-') . '</td>
            <td>' . ((isset($FlightsData['DepartureTime'][$a])) ? TIMEFORMAT($FlightsData['DepartureTime'][$a]) : '-') . '</td>
            <td>' . ((isset($FlightsData['ArrivalDate'][$a])) ? DATEFORMAT($FlightsData['ArrivalDate'][$a]) : '-') . '</td>
            <td>' . ((isset($FlightsData['ArrivalTime'][$a])) ? TIMEFORMAT($FlightsData['ArrivalTime'][$a]) : '-') . '</td>
            <td>' . ((isset($FlightsData['TravelType'][$a])) ? $FlightsData['TravelType'][$a] : '-') . '</td>
          
        </tr>';
                }
            }
        }
        ?>
        </tbody>
    </table>
    <h6 class="p-2">Accommodation Details </h6>
    <table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
           width="100%" ` style="margin-bottom: 0px;">
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
        //echo'<pre>';print_r($AccommodationsData);
        if (isset($AccommodationsData)) {

            $AccommodationCity = ((isset($AccommodationsData['City']) && count($AccommodationsData['City']) > 0) ? $AccommodationsData['City'] : array());
            foreach( $AccommodationsData['City'] as $a => $TemValue ){

                $AccommodationRoomType = (isset($AccommodationsData['RoomType'][$a])) ? $AccommodationsData['RoomType'][$a] : array();
                $AccommodationNoOfBeds = (isset($AccommodationsData['NoOfBeds'][$a]) ? $AccommodationsData['NoOfBeds'][$a] : array());
                $AccommodationAmountPayable = (isset($AccommodationsData['AmountPayable'][$a]) ? $AccommodationsData['AmountPayable'][$a] : array());
                $AccommodationAccomodationId = (isset($AccommodationsData['AccomodationId'][$a]) ? $AccommodationsData['AccomodationId'][$a] : array());

                for ($room = 0; $room < count($AccommodationRoomType); $room++) {

                    $AccommodationData = array();
                    if (OptionName($AccommodationRoomType[$room]) == 'Sharing') {
                        $Rtype = 'Rooms';
                    } else {
                        $Rtype = 'Beds';
                    }
                    if (isset($AccommodationAmountPayable[$room])) {
                        $TotalVoucherRate += (int)$AccommodationAmountPayable[$room];
                    }

                    echo '
                     <tr>         
                        <td>' . ((isset($AccommodationsData['City'][$a])) ? CityName($AccommodationsData['City'][$a]) : '-') . '</td>
                        <td>' . ((isset($AccommodationsData['Hotels'][$a])) ? HotelName($AccommodationsData['Hotels'][$a], 'Name', $AccommodationsData['Self'][$a]) : '-') . '</td>
                        <td>' . ((isset($AccommodationsData['CheckIn'][$a])) ? DATEFORMAT($AccommodationsData['CheckIn'][$a]) : '-') . '</td>
                        <td>' . ((isset($AccommodationsData['CheckOut'][$a])) ? DATEFORMAT($AccommodationsData['CheckOut'][$a]) : '-') . '</td>
                        <td>' . ((isset($AccommodationsData['AccommodationBRN'][$a])) ? $AccommodationsData['AccommodationBRN'][$a] : '-') . '</td>
                        <td>' . ((isset($AccommodationRoomType[$room])) ? OptionName($AccommodationRoomType[$room]) : '-') . '</td>
                        <td>' . ((isset($AccommodationNoOfBeds[$room])) ? $AccommodationNoOfBeds[$room] . ' ' . $Rtype : '-') . '</td>
                        <td>' . ((isset($AccommodationAmountPayable[$room])) ? Money($AccommodationAmountPayable[$room]) : '-') . '</td>
                     </tr>';

                }

            }

            /*for ($a = 0; $a < count($AccommodationCity); $a++) {

                $AccommodationRoomType = (isset($AccommodationsData['RoomType'][$a + 1])) ? $AccommodationsData['RoomType'][$a + 1] : array();
                $AccommodationNoOfBeds = (isset($AccommodationsData['NoOfBeds'][$a + 1]) ? $AccommodationsData['NoOfBeds'][$a + 1] : array());
                $AccommodationAmountPayable = (isset($AccommodationsData['AmountPayable'][$a + 1]) ? $AccommodationsData['AmountPayable'][$a + 1] : array());
                $AccommodationAccomodationId = (isset($AccommodationsData['AccomodationId'][$a + 1]) ? $AccommodationsData['AccomodationId'][$a + 1] : array());


                for ($room = 0; $room < count($AccommodationRoomType); $room++) {

                    $AccommodationData = array();
                    if (OptionName($AccommodationRoomType[$room]) == 'Sharing') {
                        $Rtype = 'Rooms';
                    } else {
                        $Rtype = 'Beds';
                    }
                    if (isset($AccommodationAmountPayable[$room])) {
                        $TotalVoucherRate += (int)$AccommodationAmountPayable[$room];
                    }

                    echo '
                     <tr>         
                        <td>' . ((isset($AccommodationsData['City'][$a])) ? CityName($AccommodationsData['City'][$a]) : '-') . '</td>
                        <td>' . ((isset($AccommodationsData['Hotels'][$a])) ? HotelName($AccommodationsData['Hotels'][$a], 'Name', $AccommodationsData['Self'][$a]) : '-') . '</td>
                        <td>' . ((isset($AccommodationsData['CheckIn'][$a])) ? DATEFORMAT($AccommodationsData['CheckIn'][$a]) : '-') . '</td>
                        <td>' . ((isset($AccommodationsData['CheckOut'][$a])) ? DATEFORMAT($AccommodationsData['CheckOut'][$a]) : '-') . '</td>
                        <td>' . ((isset($AccommodationsData['AccommodationBRN'][$a])) ? $AccommodationsData['AccommodationBRN'][$a] : '-') . '</td>
                        <td>' . ((isset($AccommodationRoomType[$room])) ? OptionName($AccommodationRoomType[$room]) : '-') . '</td>
                        <td>' . ((isset($AccommodationNoOfBeds[$room])) ? $AccommodationNoOfBeds[$room] . ' ' . $Rtype : '-') . '</td>
                        <td>' . ((isset($AccommodationAmountPayable[$room])) ? Money($AccommodationAmountPayable[$room]) : '-') . '</td>
                     </tr>';


                }


            }*/
        }

        ?>
        </tbody>
    </table>
    <h6 class="p-2">Transport's Details </h6>
    <table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
           width="100%" ` style="margin-bottom: 0px;">
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
        if (isset($Transports)) {

            $TransportSectors = $Transports['TransportSectors'];

            if (!empty($TransportSectors[0])) {
                for ($a = 0; $a < count($TransportSectors); $a++) {
                    $TotalVoucherRate += $Transports['TransportRates'][$a];
                    echo '
                            <tr>         
                                <td>' . ((isset($Transports['TravelCity'][$a])) ? CityName($Transports['TravelCity'][$a]) : '-') . '</td>
                                <td>' . ((isset($Transports['TravelDate'][$a])) ? DATEFORMAT($Transports['TravelDate'][$a]) : '-') . '</td>
                               
                                <td>' . ((isset($Transports['TransportSectors'][$a])) ? OptionName($Transports['TransportSectors'][$a]) : '-') . '</td>
                                <td>' . ((isset($Transports['TravelType'][$a])) ? $Transports['TravelType'][$a] : 0) . '</td>
                                <td>' . ((isset($Transports['TransportType'][$a])) ? TransportName($Transports['TransportType'][$a]) : '-') . '</td>
                                <td>' . ((isset($Transports['TransportsBRN'][$a])) ? $Transports['TransportsBRN'][$a] : '-') . '</td>
                                <td>' . ((isset($Transports['NoOfPax'][$a])) ? $Transports['NoOfPax'][$a] : '-') . '</td>
                                <td>' . ((isset($Transports['NoOfSeats'][$a])) ? $Transports['NoOfSeats'][$a] : '-') . '</td>
                                <td>' . ((isset($Transports['TransportRates'][$a])) ? Money($Transports['TransportRates'][$a]) : '0') . '</td>
                               
                              
                            </tr>';

                }
            }
        }
        ?>
        </tbody>
    </table>
    <h6 class="p-2">Ziyarat Details </h6>
    <table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
           width="100%" ` style="margin-bottom: 0px;">
        <thead>
        <tr>
            <th>Location</th>
            <th>Ziyarat</th>
            <th>Transports</th>
            <th>No Of Pax</th>
            <th>Transport Rates</th>

        </tr>
        </thead>
        <tbody>
        <?php
        if (isset($Ziyarats)) {
            $ZiyaratCity = $Ziyarats['ZiyaratCity'];
            if (!empty($ZiyaratCity[0])) {
                for ($a = 0; $a < count($ZiyaratCity); $a++) {
                    $ZiyaratData = array();
                    $TotalVoucherRate += $Ziyarats['ZiyaratTransportsRates'][$a];

                    echo '
                            <tr>         
                                <td>' . ((isset($Ziyarats['ZiyaratCity'][$a])) ? CityName($Ziyarats['ZiyaratCity'][$a]) : '-') . '</td>
                                <td>' . ((isset($Ziyarats['Ziyarat'][$a])) ? ZiyaratName($Ziyarats['Ziyarat'][$a]) : '-') . '</td>
                                <td>' . ((isset($Ziyarats['TransportRateZiyrat'][$a])) ? TransportName($Ziyarats['TransportRateZiyrat'][$a]) : '-') . '</td>
                                <td>' . ((isset($Ziyarats['ZiyaratNoOfPax'][$a])) ? $Ziyarats['ZiyaratNoOfPax'][$a] : '-') . '</td>
                                <td>' . ((isset($Ziyarats['ZiyaratTransportsRates'][$a])) ? Money($Ziyarats['ZiyaratTransportsRates'][$a]) : '-') . '</td>
                               
                            </tr>';

                }
            }
        }
        ?>

        </tbody>
    </table>
    <h6 class="p-2">Services </h6>
    <table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
           width="100%" ` style="margin-bottom: 0px;">
        <thead>
        <tr>
            <th>Name</th>
            <th>Charges</th>

        </tr>
        </thead>
        <tbody>
        <?php
        //echo'<pre>';print_r($ServicesIDs);exit;

        //echo'<pre>';print_r($ServicesIDs);exit;
        if (!empty($rsltservices)) {
            foreach ($rsltservices as $services) {
                $Values = array();
                $TotalVoucherRate += $services['Rate'] * $days * count($pilgrimHTML);
                echo '<tr>         
                            <td>' . $services['Name'] . '</td>
                            <td>' . Money($services['Rate'] * $days * count($pilgrimHTML)) . '</td>
                            
                           
                        </tr>';
            }
        }
        ?>

        </tbody>
    </table>
</div>
<div style="background:#f2f2f2;">

    <table class="table table-striped table-hover" width="100%">
        <tr>
            <td width="85%">
                <div style="height: 130px;">
                    <strong style="font-size: 130%;"></strong><br>
                </div>
            </td>
            <td style="line-height: 30px;">
                <!--                <strong>Refund Amount</strong><br>-->
                <!--                <strong style="font-size: 150%;">-->
                <? //= ((isset($GroupData['RefundAmount'])) ? Money($GroupData['RefundAmount']) : '-') ?><!--</strong>-->
                <!--                <hr>-->
                <strong>Grand Total</strong><br>
                <strong style="font-size: 200%;"><?= Money($TotalVoucherRate) ?></strong>
            </td>
        </tr>
    </table>
</div>
<div id="VoucherAddResponse"></div>

<script type="text/javascript">

    $(document).ready(function () {
        var FormID = $(".widget-content").closest("form[id]").attr('id')
        var GrandTotal = "<?= $GrandTotal ?>";
        $("form#" + FormID + " input#GrandTotal").val(GrandTotal);
    });






</script>



