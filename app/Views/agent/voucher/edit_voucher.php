<link rel="stylesheet" type="text/css" href="<?= $template ?>plugins/jquery-step/jquery.steps.css">
<style>

    hr.hr-text {
        position: relative;
        border: none;
        height: 2px;
        background: #999;
    }

    hr.hr-text::before {
        content: attr(data-content);
        display: inline-block;
        background: #fff;
        font-weight: bold;
        font-size: 0.85rem;
        color: #999;
        border-radius: 30rem;
        padding: 0.2rem 2rem;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>
<?php

use App\Models\Main;
use App\Models\Crud;
use App\Models\Voucher;

$VouchersData = new Voucher();
$Crud = new Crud();
$session = session();
$id = $session->get('id');
$session = $session->get();

$date = date("d M, Y");


$data['LookupsOptions'] = $Crud->LookupOptions('room_types');
foreach ($data['LookupsOptions'] as $options) {
    $RoomTypes .= '<option value="' . $options['UID'] . '">' . $options['Name'] . '</option>';
}

$airports = new Main();
$data['airport'] = $airports->ListAirports();
$Airportshtml = '';
foreach ($data['airport'] as $option) {
    $Airportshtml .= '<option value="' . $option['UID'] . '" >' . $option['Code'] . ' - ' . $option['Name'] . ' - ' . $option['CountryName'] . '</option>';
    //print_r($data['airport']);
}
$Departure = '<img src = "' . $template . 'departures.png" alt="Departure Image" style="height: 100px;width: 150px;">';
$Arrival = '<img src = "' . $template . 'arrivals.png" alt="Arrival Image" style="height: 100px;width: 150px;">';
$airlines = new Main();
$data['airlines'] = $airlines->ListAirlines();

$AirLineshtml = '';
foreach ($data['airlines'] as $option) {
    $AirLineshtml .= '<option value="' . $option['UID'] . '" > ' . $option['FullName'] . '</option>';

}

/////Land Border Cities/////
$landbordercitieshtml = '';
$data['landbordercities'] = $Crud->LookupOptions('land_border_cities');
foreach ($data['landbordercities'] as $options) {
    $landbordercitieshtml .= '<option value="' . $options['UID'] . '">' . $options['Name'] . '</option>';
}


/////Land Borders/////
$landbordershtml = '';
$data['landborders'] = $Crud->LookupOptions('land_borders');
foreach ($data['landborders'] as $options) {
    $landbordershtml .= '<option value="' . $options['UID'] . '">' . $options['Name'] . '</option>';
}
/////Sea Ports/////
$seaportshtml = '';
$data['LookupsOptions'] = $Crud->LookupOptions('sea_ports');
foreach ($data['LookupsOptions'] as $options) {
    $seaportshtml .= '<option value="' . $options['UID'] . '">' . $options['Name'] . '</option>';
}
$JSCODE = $HotelByCitiesJSCode = $ZiaratByCitiesJSCode = '';

$CitiesHTML = Cities($VoucherData['Country'], $datatype = 'html', 0);


?>
<style>
    .AmountSpan {
        color: #dda420;
        font-size: 18px;
        font-weight: bold;
    }
</style>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-spacing">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                <div class="layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Edit Voucher (<?= $VoucherData['VoucherCode'] ?>) <span
                                                id="ExportPackage"> </span>
                                        <a class="btn btn_customized btn-sm float-right" style="margin-right: 5px;"
                                           href="<?= SeoUrl('exports/voucher/' . $VoucherData['UID'] . "-" . $VoucherData['VoucherCode']) ?>"
                                           target="_blank">Print Voucher</a>

                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <form enctype="multipart/form-data" class="validate" method="post" action="#"
                                  id="VoucherAddForm" name="VoucherAddForm">
                                <input type="hidden" name="ModifiedBy" id="ModifiedBy" value="<?= $id ?>">
                                <input type="hidden" name="ModifiedDate" id="ModifiedDate" value="<?= $date ?>">
                                <input type="hidden" name="VoucherType" id="VoucherType" value="B2B">

                                <input type="hidden" id="UID" name="UID" value="<?= $VoucherData['UID'] ?>">
                                <input type="hidden" id="PackageUID" name="PackageUID" value="0">
                                <input type="hidden" id="FlightAttachmentCount" name="FlightAttachmentCount" value="0">
                                <input type="hidden" id="RequestedAccomodationCount" name="RequestedAccomodationCount"
                                       value="<?= count($VoucherAccommmodationDatas) ?>">
                                <input type="hidden" id="ZiyaratCount" name="ZiyaratCount" value="0">
                                <input type="hidden" id="ZiyaratAttachmentCount" name="ZiyaratAttachmentCount"
                                       value="<?= count($VoucherZiyaratDetails) ?>">
                                <input type="hidden" id="TransportAttachmentCount" name="TransportAttachmentCount"
                                       value="<?= count($VoucherTransportDetails) ?>">
                                <input type="hidden" id="VoucherCode" name="VoucherCode" value="">
                                <input type="hidden" name="DomainID" id="DomainID" value="<?= $GetDomainID ?>">

                                <input type="hidden" name="VoucherArrivalDate" id="VoucherArrivalDate"
                                       value="<?php echo $VoucherData['ArrivalDate']; ?>">
                                <input type="hidden" name="ReturnDate" id="ReturnDate"
                                       value="<?php echo $VoucherData['ReturnDate']; ?>">


                                <input type="hidden" name="Temp[VoucherArrivalDate]"
                                       value="<?php echo $VoucherData['ArrivalDate']; ?>">

                                <input type="hidden" name="Temp[ReturnDate]"
                                       value="<?php echo $VoucherData['ReturnDate']; ?>">
                                <input type="hidden" name="VoucherAgentID" id="VoucherAgentID" value="<?=$VoucherData['AgentUID']?>">
                                <div id="VoucherSection">
                                    <h3>Basic</h3>
                                    <section>
                                        <div id="VoucherDetails">
                                            <div class="row" id="voucher_details">
                                                <div class="col-md-2">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Agent</label>
                                                        <?php
                                                        if ($session['account_type'] == "external_agent" || $session['account_type'] == "agent") {
                                                            echo '<select disabled class="form-control validate[required] text-input"  id="AgentID" name="AgentID" onChange="LoadAgentGirdByAgentID(this.value)"><option value="">Please Select</option>';
                                                            foreach ($AllAgents as $agent) {

                                                                $table = 'packages."Packages"';
                                                                $where = array("AgentUID" => $agent['UID']);
                                                                $Agents = $Crud->SingleRecord($table, $where);
                                                                if (isset($Agents['UID']) && $Agents['UID'] > 0) {
                                                                    $selected = (($VoucherData['AgentUID'] == $agent['UID']) ? 'selected' : '');
                                                                    echo ' <option value="' . $agent['UID'] . '"' . $selected . '>' . $agent['FullName'] . " (" . ucwords(str_replace("_", " ", $agent['Type'])) . ")" . '</option>  ';
                                                                }
                                                            }
                                                            echo '</select>';
                                                            echo '<input type="hidden" id="AgentID"  name="AgentID" value="' . $VoucherData['AgentUID'] . '">';
                                                            echo '<input type="hidden"  name="Temp[AgentID]" value="' . $VoucherData['AgentUID'] . '">';

                                                        } else {
                                                            echo '<select disabled class="form-control validate[required]" id="AgentID" name="AgentID" onChange="LoadAgentGirdByAgentID(this.value)"> <option value="">Please Select</option>';
                                                            foreach ($AllAgents as $agent) {
                                                                $selected = (($VoucherData['AgentUID'] == $agent['UID']) ? 'selected' : '');
                                                                echo ' <option value="' . $agent['UID'] . '"' . $selected . '>' . $agent['FullName'] . " (" . ucwords(str_replace("_", " ", $agent['Type'])) . ")" . '</option>  ';
                                                            }
                                                            echo '</select>';
                                                            echo '<input type="hidden" id="AgentID"  name="AgentID" value="' . $VoucherData['AgentUID'] . '">';
                                                            echo '<input type="hidden"  name="Temp[AgentID]" value="' . $VoucherData['AgentUID'] . '">';
//                                                            if ($AgentLogged) {
//                                                                echo '<input type="hidden" id="AgentID" name="AgentID" value="' . $session['id'] . '">
//                                                                <span class="form-control"  id="Agent" name="AgentName" placeholder="AgentName">' . $session['name'] . '</span>';
//                                                            } else {
//
//                                                            }
                                                        }
                                                        ?>

                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Country</label>
                                                        <select class="form-control validate[required]"
                                                                id="VoucherCountry"
                                                                name="VoucherCountry"
                                                                onChange="LoadCitiesDropdownagain(this.value)">
                                                            <option value="">Please Select</option>
                                                            <?= Countries("html", $VoucherData['Country']) ?>
                                                        </select><input type="hidden" name="Temp[VoucherCountry]"
                                                                        value="<?php echo $VoucherData['Country']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Arrival Type</label><br>
                                                        <select class="form-control validate[required]" id="ArrivalType"
                                                                name="ArrivalType">
                                                            <option value="Air" <?= (($VoucherData['ArrivalType'] == 'Air') ? 'selected' : '') ?>>
                                                                Air
                                                            </option>
                                                            <option value="Land" <?= (($VoucherData['ArrivalType'] == 'Land') ? 'selected' : '') ?>>
                                                                Land
                                                            </option>
                                                        </select><input type="hidden" name="Temp[ArrivalType]"
                                                                        value="<?php echo $VoucherData['ArrivalType']; ?>">
                                                    </div>
                                                </div>
                                                <!--                                                <div class="col-md-4">-->
                                                <!--                                                    <div class="form-group mb-3">-->
                                                <!--                                                        <label for="country">Arrival Date </label>-->
                                                <!--                                                        <input type="date" class="form-control mb-4"-->
                                                <!--                                                               id="VoucherArrivalDate" name="VoucherArrivalDate"-->
                                                <!--                                                               placeholder="Arrival Date" onchange="voucherdatefilter()"-->
                                                <!--                                                               value="-->
                                                <? //= $VoucherData['ArrivalDate'] ?><!--" -->
                                                <? //= (($VoucherData['CurrentStatus'] == 'Executed') ? 'readonly' : '') ?><!--
<!--                                                        <input type="hidden" name="Temp[VoucherArrivalDate]"-->
                                                <!--                                                               value="-->
                                                <?php //echo $VoucherData['ArrivalDate']; ?><!--">-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="col-md-4">-->
                                                <!--                                                    <div class="form-group mb-3">-->
                                                <!--                                                        <label for="country">Return Date</label><br>-->
                                                <!--                                                        <input type="date" class="form-control mb-4"-->
                                                <!--                                                               id="ReturnDate" name="ReturnDate"-->
                                                <!--                                                               placeholder="Return Date" onchange="voucherdatefilter()"-->
                                                <!--                                                               value="-->
                                                <? //= $VoucherData['ReturnDate'] ?><!--" -->
                                                <? //= (($VoucherData['CurrentStatus'] == 'Executed') ? 'readonly' : '') ?><!--
<!--                                                        <input type="hidden" name="Temp[ReturnDate]"-->
                                                <!--                                                               value="-->
                                                <?php //echo $VoucherData['ReturnDate']; ?><!--">-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Umrah Operator</label>
                                                        <select class="form-control validate[required]"
                                                                id="UmrahOperator"
                                                                name="UmrahOperator"
                                                                data-prompt-position="bottomLeft:20,35">
                                                            <?php
                                                            foreach ($Operators as $UmrahOperator) {
                                                                $selected = (($UmrahOperator['UID'] == $VoucherData['UmrahOperator']) ? 'selected' : '');
                                                                echo ' <option value="' . $UmrahOperator['UID'] . '"' . $selected . '>' . $UmrahOperator['CompanyName'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Arrival Return</label>
                                                        <input type="text"
                                                               class="form-control multidate validate[required,future[now]]"
                                                               name="ArrivalReturn" id="ArrivalReturn" readonly
                                                               placeholder="ArrivalReturnDates"
                                                               value="<?php echo $VoucherData['ArrivalDate']; ?> to <?php echo $VoucherData['ReturnDate']; ?>"
                                                               onchange="GetArrivalReturnDate();">

                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Umrah Visa</label><br>
                                                        <select class="form-control" id="Visa"
                                                                name="Visa"
                                                                data-prompt-position="bottomLeft:20,35">
                                                            <option value="">Please Select</option>
                                                            <option <?=( ($VoucherData['Visa'] == 'Yes')? 'selected' : '' )?> value="Yes">Yes</option>
                                                            <option <?=( ($VoucherData['Visa'] == 'No')? 'selected' : '' )?> value="No">No</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Reference/Remarks</label><br>
                                                        <textarea class="form-control mb-4"
                                                                  id="ReferenceRemarks" name="ReferenceRemarks"
                                                                  placeholder="Reference"><?= $VoucherData['Reference'] ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <h3> Pilgrims </h3>
                                    <section>
                                        <div id="Pilgrim">
                                            <div class="loadingimg"><img src="<?= $template ?>loading.gif"></div>
                                        </div>
                                    </section>
                                    <h3>Travel</h3>
                                    <section>
                                        <div id="FilghtsDetails">
                                            <h5>Travel's Details
                                                <a href="javascript:void(0);" id="AddFlightRows"
                                                   class="btn btn_customized btn-sm float-right"
                                                   style="margin-right: 10px;"
                                                   onclick="AddNewFlightAttachmentRows(0);">Add Ticket</a>
                                                <a href="javascript:void(0);" id="AddFlightRows"
                                                   class="btn btn_customized btn-sm float-right"
                                                   style="margin-right: 10px;"
                                                   onclick="AddNewFlightAttachmentRows(1);">Add Self Ticket</a>
                                                <!--<a href="javascript:void(0);" id="AddFlightRows" class="float-right"
                                                   style="margin-right: 10px;"
                                                   onclick="AddNewFlightAttachmentRows();"><span>  <i
                                                                class="fa fa-plus" title="Add More"></i></span></a>-->
                                            </h5>
                                            <hr>
                                            <div id="FlightR" name="FlightR">
                                                <?php

                                                $cnt = 0;

                                                foreach ($VoucherFlightsDetails as $VoucherFlightsDetail) {

                                                    echo '<input type="hidden" name="dlt_flight[' . $VoucherFlightsDetail['UID'] . ']" id="dlt_flight_' . $VoucherFlightsDetail['UID'] . '" value="">';

                                                    $cnt++;
                                                    $landbordersCitieshtml = $landbordersTohtml = '';
                                                    foreach ($data['airport'] as $option) {
                                                        $selected = (($VoucherFlightsDetail['SectorTo'] == $option['UID']) ? 'selected' : '');
                                                        $AirportsTohtml .= '<option value="' . $option['UID'] . '"' . $selected . ' >' . $option['Code'] . ' - ' . $option['Name'] . ' - ' . $option['CountryName'] . '</option>';
                                                    }
                                                    foreach ($data['airport'] as $option) {
                                                        $selected = (($VoucherFlightsDetail['SectorFrom'] == $option['UID']) ? 'selected' : '');
                                                        $AirportsFromhtml .= '<option value="' . $option['UID'] . '"' . $selected . ' >' . $option['Code'] . ' - ' . $option['Name'] . ' - ' . $option['CountryName'] . '</option>';
                                                    }
                                                    foreach ($data['landborders'] as $option) {
                                                        $selected = (($VoucherFlightsDetail['SectorTo'] == $option['UID']) ? 'selected' : '');
                                                        $landbordersTohtml .= '<option value="' . $option['UID'] . '"' . $selected . ' >' . $option['Name'] . '</option>';
                                                    }
                                                    foreach ($data['landbordercities'] as $option) {
                                                        $selected = (($VoucherFlightsDetail['SectorFrom'] == $option['UID']) ? 'selected' : '');
                                                        $landbordersCitieshtml .= '<option value="' . $option['UID'] . '"' . $selected . ' >' . $option['Name'] . '</option>';
                                                    }
                                                    foreach ($data['airlines'] as $option) {
                                                        $selected = (($VoucherFlightsDetail['Airline'] == $option['UID']) ? 'selected' : '');
                                                        $AirLinehtml .= '<option value="' . $option['UID'] . '"' . $selected . '  > ' . $option['FullName'] . '</option>';

                                                    }
                                                    if ($VoucherFlightsDetail['TravelType'] == 'Air') {
                                                        echo '   
                                                       <div id="FlightAttachmentCount' . $cnt . '" class="row">';
                                                        if ($VoucherFlightsDetail['TravelSelf'] == 0) {
                                                            echo '<div class="col-md-12"><hr data-content="Ticket" class="hr-text"></div>';

                                                        } else {
                                                            echo '<div class="col-md-12"><hr data-content="Self Ticket" class="hr-text"></div>';

                                                        }


                                                        echo '<input type="hidden" name="TravelSelf[]" value="' . $VoucherFlightsDetail['TravelSelf'] . '"><input type="hidden" id="Traveltype" name="Traveltype[]" value="Air">  <div class="col-md-2">  <div class="form-group mb-3" style="text-align: center">';
                                                        if ($VoucherFlightsDetail['FlightType'] == 'Departure') {
                                                            echo $Departure;
                                                        } else if ($VoucherFlightsDetail['FlightType'] == 'Return') {
                                                            echo $Arrival;
                                                        }
                                                        echo '<input type="hidden" id="FlightType" name="FlightType[]" value="' . $VoucherFlightsDetail['FlightType'] . '"></div> </div>
                  <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Sector<small id="coloredtext"> (From) </small></label>  <select class="form-control" id="SectorFrom"  name="SectorFrom[]"> <option value="">Please Select</option>' . $AirportsFromhtml . ' </select> </div> </div>
                  <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Sector<small id="coloredtext"> (To) </small></label>  <select class="form-control" id="SectorTo"  name="SectorTo[]"> <option value="">Please Select</option>' . $AirportsTohtml . ' </select> </div> </div>
                  <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Airline</label>  <select class="form-control" id="Airline"  name="Airline[]"> <option value="">Please Select</option>  ' . $AirLinehtml . '</select> </div> </div> 
                   <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Flight Number</label> <input type="text" class="form-control" id="Reference" name="Reference[]"  aria-describedby="emailHelp1"  placeholder="Flight Number" value="' . $VoucherFlightsDetail['Reference'] . '">  </div> </div> 
                   <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">PNR</label> <input type="text" class="form-control" id="PNR" name="PNR[]" aria-describedby="emailHelp1"  placeholder="PNR"value="' . $VoucherFlightsDetail['PNR'] . '"> </div> </div> 
                   <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Departure Date</label>  <input type="date" class="form-control validate[required,funcCall[checktraveldate]] voucherdatefilter"  id="DepartureDate' . $VoucherFlightsDetail['FlightType'] . '" name="DepartureDate[]"  aria-describedby="emailHelp1"  placeholder="Departure Date"value="' . $VoucherFlightsDetail['DepartureDate'] . '">  </div> </div> 
                   <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Departure Time</label> <input type="time" class="form-control" id="DepartureTime" name="DepartureTime[]" aria-describedby="emailHelp1" placeholder="Departure Time"value="' . $VoucherFlightsDetail['DepartureTime'] . '"> </div> </div> 
                  <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Arrival Date</label> <input type="date" class="form-control validate[required,funcCall[checktraveldate],funcCall[checktravelarrivaldate]] voucherdatefilter" id="ArrivalDate" name="ArrivalDate[]"  aria-describedby="emailHelp1" placeholder="Arrival Date"value="' . $VoucherFlightsDetail['ArrivalDate'] . '">  </div> </div> 
                  <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Arrival Time</label> <input type="time" class="form-control" id="ArrivalTime" name="ArrivalTime[]" aria-describedby="emailHelp1" placeholder="Arrival Time"value="' . $VoucherFlightsDetail['ArrivalTime'] . '"></div></div> 
                   <div class="col-md-1">  <label for="country"> </label> <br> <a   href="javascript:void(0);" onClick="RemoveFlightRow(' . $VoucherFlightsDetail['UID'] . ',' . $cnt . ')" id="removeButton" class="float-right" style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div> <div class = "col-md-12"><hr></div></div>          
                                                            ';
                                                    } else if ($VoucherFlightsDetail['TravelType'] == 'Land') {

                                                        echo '
                                                    <div id="FlightAttachmentCount' . $cnt . '" class="row">';
                                                        if ($VoucherFlightsDetail['TravelSelf'] == 0) {
                                                            echo '<div class="col-md-12"><hr data-content="' . (($cnt == 1) ? 'Departure' : 'Return') . ' Ticket" class="hr-text"></div>';

                                                        } else {
                                                            echo '<div class="col-md-12"><hr data-content="Self ' . (($cnt == 1) ? 'Departure' : 'Return') . ' Ticket" class="hr-text"></div>';

                                                        }
                                                        echo '<input type="hidden" name="TravelSelf[]" value="' . $VoucherFlightsDetail['TravelSelf'] . '"><input type="hidden" id="Traveltype" name="Traveltype[]" value="Land">
                                                              <input type="hidden" id="FlightType" name="FlightType[]" value="' . $VoucherFlightsDetail['FlightType'] . '"> ';
                                                        if ($cnt == 1) {
                                                            echo '<div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Border Cities</label>  <select class="form-control" id="SectorFrom"  name="SectorFrom[]"> <option value="">Please Select</option> ' . $landbordersCitieshtml . '  </select> </div> </div>
                                                            <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Borders</label>  <select class="form-control" id="SectorTo"  name="SectorTo[]"> <option value="">Please Select</option>' . $landbordersTohtml . ' </select> </div> </div> ';
                                                        } else {
                                                            echo ' <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Borders</label>  <select class="form-control" id="SectorTo"  name="SectorTo[]"> <option value="">Please Select</option>' . $landbordersTohtml . ' </select> </div> </div> 
                                                                    <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Border Cities</label>  <select class="form-control" id="SectorFrom"  name="SectorFrom[]"> <option value="">Please Select</option> ' . $landbordersCitieshtml . '  </select> </div> </div>';
                                                        }
                                                        echo '<div class="col-md-3">  <div class="form-group mb-3"> <label for="country">Ref Number</label> <input type="text" class="form-control" id="Reference" name="Reference[]"  aria-describedby="emailHelp1"  placeholder="Ref Number" value="' . $VoucherFlightsDetail['Reference'] . '">  </div> </div>
                                                            <div class="col-md-3">  <div class="form-group mb-3"> <label for="country">PNR</label> <input type="text" class="form-control" id="PNR" name="PNR[]" aria-describedby="emailHelp1"  placeholder="PNR" value="' . $VoucherFlightsDetail['PNR'] . '"> </div> </div> 
                                                            <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Departure Date</label>  <input type="date" class="form-control  validate[required,funcCall[checktraveldate]] voucherdatefilter"  id="DepartureDate" name="DepartureDate[]"  aria-describedby="emailHelp1"  placeholder="Departure Date" value="' . $VoucherFlightsDetail['DepartureDate'] . '">  </div> </div> 
                                                            <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Departure Time</label> <input type="time" class="form-control" id="DepartureTime" name="DepartureTime[]" aria-describedby="emailHelp1" placeholder="Departure Time" value="' . $VoucherFlightsDetail['DepartureTime'] . '"> </div> </div> 
                                                            <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Arrival Date</label> <input type="date" class="form-control validate[required,funcCall[checktraveldate],funcCall[checktravelreturndate]] voucherdatefilter" id="ArrivalDate" name="ArrivalDate[]"  aria-describedby="emailHelp1" placeholder="Arrival Date" value="' . $VoucherFlightsDetail['ArrivalDate'] . '">  </div> </div> 
                                                            <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Arrival Time</label> <input type="time" class="form-control" id="ArrivalTime" name="ArrivalTime[]" aria-describedby="emailHelp1" placeholder="Arrival Time" value="' . $VoucherFlightsDetail['ArrivalTime'] . '"></div></div> 
                                                             <div class="col-md-1">  <label for="country"> </label> <br> <a   href="javascript:void(0);" onClick="RemoveFlightRow(' . $VoucherFlightsDetail['UID'] . ',' . $cnt . ')" id="removeButton" class="float-right" style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div> <div class = "col-md-12"><hr></div></div>';

                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </section>
                                    <h3>Hotel</h3>
                                    <section>
                                        <div id="RequestedAccomodationDetails">
                                            <div id="HotelR" name="HotelR">
                                                <input type="hidden" name="AccomodationCity" id="AccomodationCity">
                                                <input type="hidden" name="Accomodationcnt" id="Accomodationcnt">
                                                <input type="hidden" name="totalaccomodationnightsvalue"
                                                       id="totalaccomodationnightsvalue">


                                                <h5>Accommodation Details
                                                    <small class="text-muted" id="totalaccomodationnights"></small>


                                                    <a href="javascript:void(0);" id="AddFlightRows"
                                                       class="btn btn_customized btn-sm float-right"
                                                       style="margin-right: 10px;"
                                                       onclick="AddRequestestedAccomodationAttachmentRow();">Add Package
                                                        Hotel</a>
                                                    <a href="javascript:void(0);" id="AddFlightRows"
                                                       class="btn btn_customized btn-sm float-right"
                                                       style="margin-right: 10px;"
                                                       onclick="AddSelfRequestestedAccomodationAttachmentRow();">Add
                                                        Self Hotel</a>
                                                </h5>
                                                <hr>
                                                <?php
                                                $EditRoomTypes = '';
                                                $data['LookupsOptions'] = $Crud->LookupOptions('room_types');
                                                foreach ($data['LookupsOptions'] as $options) {
                                                    $EditRoomTypes .= '<option value="' . $options['UID'] . '" >' . $options['Name'] . '</option>';
                                                }
                                                $count = 0;
                                                $cnt = 0;  //print_r($VoucherAccommmodationDatas);
                                                foreach ($VoucherAccommmodationDatas as $VoucherAccommmodationData) {

                                                    echo '<input value="" type="hidden" name="dlt_accomodation[' . $VoucherAccommmodationData['VoucherID'] . '_' . $VoucherAccommmodationData['City'] . '_' . $VoucherAccommmodationData['Hotel'] . '_' . $VoucherAccommmodationData['CheckIn'] . '_' . $VoucherAccommmodationData['CheckOut'] . '_' . $VoucherAccommmodationData['AccommodationBRN'] . ']" id="dlt_accomodation_' . $VoucherAccommmodationData['VoucherID'] . '_' . $VoucherAccommmodationData['City'] . '_' . $VoucherAccommmodationData['Hotel'] . '_' . $VoucherAccommmodationData['CheckIn'] . '_' . $VoucherAccommmodationData['CheckOut'] . '_' . $VoucherAccommmodationData['AccommodationBRN'] . '">';
                                                    $HotelID = $VoucherAccommmodationData['Hotel'];
                                                    $VoucherAccommmodationRoomTypes = $VouchersData->VoucherAccommodationRoomTypeDetails($VoucherAccommmodationData['VoucherID'], $VoucherAccommmodationData['City'], $VoucherAccommmodationData['Hotel'], $VoucherAccommmodationData['CheckIn'], $VoucherAccommmodationData['CheckOut'], $VoucherAccommmodationData['AccommodationBRN']);

                                                    /** Check Accommodation Activity Start*/
                                                    $AccommodationActivityWhere = array(
                                                            'VoucherID' => $VoucherAccommmodationData['VoucherID'],
                                                            'City' => $VoucherAccommmodationData['City'],
                                                            'Hotel' => $VoucherAccommmodationData['Hotel'],
                                                            'CheckIn' => $VoucherAccommmodationData['CheckIn'],
                                                            'CheckOut' => $VoucherAccommmodationData['CheckOut']
                                                    );
                                                    $CheckAccommodationActivity = $VouchersData->CheckVoucherAccommodationActivity( $AccommodationActivityWhere );
                                                    /** Check Accommodation Activity Ends */

                                                    if ($VoucherAccommmodationData['Self'] == 0) {
                                                        $cnt++;
                                                        $date1 = date_create($VoucherAccommmodationData['CheckIn']);
                                                        $date2 = date_create($VoucherAccommmodationData['CheckOut']);
                                                        $diff = date_diff($date1, $date2);
                                                        echo ' <div id="RequestedAccomodationCount' . $cnt . '" class="row accomodationclass">
                                                        <input type="hidden" name="AccommodationUID[]" id="AccommodationUID" value="' . $VoucherAccommmodationData['UID'] . '">
                                                        <div class="col-md-12"><hr id="datacontent' . $cnt . '" data-content="Package Hotel for ' . ($diff->d) . ' nights ' . '" class="hr-text"><input type="hidden" class="accommationnights" name="AccommationNights[]" id="AccommationNights' . $cnt . '" value="' . ($diff->d) . '"></div> 
                                                        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">City</label>  <input type="hidden" name="Self['.$cnt.']" value="0"><input type="hidden"  name="TempAccommodation[Self][]" value="0"><select class="form-control" id="City" onChange="LoadHotelsByCites(this.value,' . $cnt . ',' . $HotelID . ')"  name="City['.$cnt.']">' . $CitiesHTML . ' </select> <input type="hidden"  name="TempAccommodation[City][]" value="' . $VoucherAccommmodationData['City'] . '"></div>  </div>
                                                        <div class="col-md-3">  <div class="form-group mb-3"> <label for="country">Hotel</label>  <select class="form-control" id="Hotels_' . $cnt . '"  name="Hotels['.$cnt.']">   </select><input type="hidden"  name="TempAccommodation[Hotels][]" value="' . $VoucherAccommmodationData['Hotel'] . '">    </div> </div> 
                                                        <div class="col-md-2">   <div class="form-group mb-3">  <label for="country">Check-In</label>   <input type="date" class="form-control  validate[required,funcCall[checkindate]] voucherdatefilter" id="CheckIn' . $cnt . '" name="CheckIn['.$cnt.']"   aria-describedby="emailHelp1"  placeholder="Check Out" value="' . $VoucherAccommmodationData['CheckIn'] . '" ><input type="hidden"  name="TempAccommodation[CheckIn][]" value="' . $VoucherAccommmodationData['CheckIn'] . '">   </div>   </div>
                                                        <div class="col-md-2">   <div class="form-group mb-3">  <label for="country">Check-Out</label> <input type="date" class="form-control validate[required,funcCall[checkoutdate]] voucherdatefilter" id="CheckOut' . $cnt . '"  name="CheckOut['.$cnt.']" aria-describedby="emailHelp1"  placeholder="Check Out"  value="' . $VoucherAccommmodationData['CheckOut'] . '" onchange="GetNoOfDaysRate(\'RequestedAccomodationCount' . $cnt . '\',' . $cnt . ',0);"><input type="hidden"  name="TempAccommodation[CheckOut][]" value="' . $VoucherAccommmodationData['CheckOut'] . '">   </div>  </div>
                                                        <div class="col-md-2">   <div class="form-group mb-3">  <label for="country">BRN</label><select class="form-control validate[required]"  id="AccommodationBRN_' . $cnt . '"  name="AccommodationBRN['.$cnt.']">' . GetVoucherBrnList($VoucherAccommmodationData['VoucherID'], 'hotel', $VoucherAccommmodationData['AccommodationBRN']) . '</select> <input type="hidden"  name="TempAccommodation[AccommodationBRN][]" value="' . $VoucherAccommmodationData['AccommodationBRN'] . '">   </div>  </div>';
                                                        if(isset($CheckAccommodationActivity) && count($CheckAccommodationActivity) == 0){
                                                            echo'<div class="col-md-1"><label for="country">
                                                                <a name="removeButton" href="javascript:void(0);"
                                                                   onClick="RemoveAllAccomodationsRow(\'RequestedAccomodationCount' . $cnt . '\',' . $VoucherAccommmodationData['VoucherID'] . ',' . $VoucherAccommmodationData['City'] . ',' . $VoucherAccommmodationData['Hotel'] . ',\'' . $VoucherAccommmodationData['CheckIn'] . '\',\'' . $VoucherAccommmodationData['CheckOut'] . '\',\'' . $VoucherAccommmodationData['AccommodationBRN'] . '\')"
                                                                   id="removeButton" class="float-right"
                                                                   style="color: #dd0317;padding-left: 10px;"><span>
                                                                    <i class="fa fa-trash"
                                                                       title="Remove"></i></span></a>
                                                            </label></div>';
                                                        }

                                                        echo'<div class="col-md-12" id="RequestedAccomodationRoomType' . $cnt . '">';
                                                        ?>
                                                        <?php
                                                        $JSCODEVoucherAccommmodationRoomTypes = '';
                                                        $count1 = 0;
                                                        foreach ($VoucherAccommmodationRoomTypes as $VoucherAccommmodationRoomType) {

                                                            echo '<input value="" type="hidden" name="dlt_accomodation_room_type[' . $VoucherAccommmodationRoomType['UID'] . ']" id="dlt_accomodation_room_type_' . $VoucherAccommmodationRoomType['UID'] . '">';
                                                            $count1++;
                                                            $count++;
                                                            if (OptionName($VoucherAccommmodationRoomType['RoomType']) == 'Sharing') {
                                                                $NoOfBedsRooms = "No Of Beds";
                                                            } else {
                                                                $NoOfBedsRooms = "No Of Rooms";
                                                            }
                                                            echo '<div class="row" id="RequestedAccomodationRoomTypeCount' . $cnt . '_' . $count1 . '">
                                                            <div class="col-md-3"> <input type ="hidden" name ="AccomodationId[' . $cnt . '][]" id="AccomodationId_' . $cnt . '_' . $count1 . '" value ="' . $VoucherAccommmodationRoomType['UID'] . '"><div class="form-group mb-3">  <label for="country">Room Type</label>  <select class="form-control RoomTypeClass" id="RoomType_' . $cnt . '_' . $count1 . '"  name="RoomType[' . $cnt . '][]" onchange="GetRoomRate(\'RequestedAccomodationCount' . $cnt . '\',' . $cnt . ',\'RequestedAccomodationRoomTypeCount' . $cnt . '_' . $count1 . '\',' . $count1 . ');">   <option value=""> Please Select </option> ' . $EditRoomTypes . '  </select><input type="hidden"  name="TempAccommodation[RoomType][]" value="' . $VoucherAccommmodationRoomType['RoomType'] . '">  </div> </div>
                                                            <div class="col-md-2">   <div class="form-group mb-3">  <label for="country" id="noofroomsbeds' . $cnt . '_' . $count . '">' . $NoOfBedsRooms . '</label> <input type="number" class="form-control NoOfBeds NoOfBedsClass validate[required,funcCall[checknumberofbeds]]"   id="NoOfBeds_' . $cnt . '_' . $count1 . '"  name="NoOfBeds[' . $cnt . '][]" onchange="GetRoomRate(\'RequestedAccomodationCount' . $cnt . '\',' . $cnt . ',\'RequestedAccomodationRoomTypeCount' . $cnt . '_' . $count1 . '\',' . $count1 . ');"  aria-describedby="emailHelp1"  value="' . $VoucherAccommmodationRoomType['NoOfBeds'] . '" placeholder="No Of Beds"><input type="hidden"  name="TempAccommodation[NoOfBeds][]" value="' . $VoucherAccommmodationData['NoOfBeds'] . '">   </div>  </div>
                                                            <div class="col-md-3">  <label for="country">Amount</label>  <div class="form-group mb-3"> <input type ="hidden" name ="AmountPayable[' . $cnt . '][]" id="AmountPayableInput_' . $cnt . '_' . $count1 . '" value ="' . $VoucherAccommmodationRoomType['AmountPayable'] . '"> <span class="AmountSpan" id="AmountPayable_' . $cnt . '_' . $count1 . '"  name="AmountPayable[]">' . Money($VoucherAccommmodationRoomType['AmountPayable']) . '</span><input type="hidden"  name="TempAccommodation[AmountPayable][]" value="' . $VoucherAccommmodationRoomType['AmountPayable'] . '">  </div>  </div>';
                                                            ?>
                                                            <?php if ($count1 == 1) { ?>
                                                                <?php
                                                                echo '<div class="col-md-1 pt-3"
                                                                     id="AddRoomType<?= $cnt ?>">
                                                                    <label for="country"> </label> </br>
                                                                    <a name="removeButton"
                                                                       href="javascript:void(0);"
                                                                       id="removeButton"
                                                                       onclick="AddRequestestedAccomodationRoomTypeRow(' . $cnt . ',' . count($VoucherAccommmodationRoomTypes) . ')"><span>
                                                                           <i class="fa fa-plus" title="Add"></i></a>
                                                                </div>';
                                                                ?>
                                                            <?php } else { ?>
                                                                <?php
                                                                if(isset($CheckAccommodationActivity) && count($CheckAccommodationActivity) == 0){
                                                                    echo '<div class="col-md-1 pt-3">
                                                                    <label for="country"> </label> <br>
                                                                    <a name="removeButton"
                                                                       href="javascript:void(0);"
                                                                       id="removeButton"
                                                                       onclick="RemoveAccomodationsRoomTypeRow(\'RequestedAccomodationRoomTypeCount' . $cnt . '_' . $count1 . '\', ' . $VoucherAccommmodationRoomType['UID'] . ')"><span>
                                                                                    <i class="fa fa-trash"
                                                                                       title="Remove"
                                                                                       aria-hidden="true"></i>
                                                                                    <span class="sr-only">Remove</span></span></a>
                                                                </div>';
                                                                }

                                                                ?>
                                                            <?php } ?>
                                                            <?php
                                                            echo '</div>';
                                                            $JSCODEVoucherAccommmodationRoomTypes .= '$("#RoomType_' . $cnt . '_' . $count1 . '").val("' . $VoucherAccommmodationRoomType['RoomType'] . '");';
                                                        }
                                                        ?>
                                                        <?php
                                                        echo '<div class="col-md-12"> <hr> </div>
                                                    </div>
                                                    </div>
                                                    ';
                                                        $HotelByCitiesJSCode .= 'LoadHotelsByCites(' . $VoucherAccommmodationData['City'] . ',' . $cnt . ',' . $HotelID . ');';
                                                        $JSCODE .= '$("#RequestedAccomodationCount' . $cnt . ' #City").val("' . $VoucherAccommmodationData['City'] . '").select2();';
                                                        $JSCODE .= '$("#RequestedAccomodationCount' . $cnt . ' #Hotels_' . $cnt . '").val("' . $VoucherAccommmodationData['Hotel'] . '");';
                                                        //$JSCODE .= '$("#RequestedAccomodationCount' . $cnt . ' #RoomType").val("' . $VoucherAccommmodationData['RoomType'] . '").select2();';
                                                        $JSCODE .= $JSCODEVoucherAccommmodationRoomTypes;
                                                    } else {
                                                        $cnt++;
                                                        $date1 = date_create($VoucherAccommmodationData['CheckIn']);
                                                        $date2 = date_create($VoucherAccommmodationData['CheckOut']);

                                                        $diff = date_diff($date1, $date2);
                                                        echo '  
                                                    <div id="RequestedAccomodationCount' . $cnt . '" class="row accomodationclass">
                                                         <input type="hidden" name="AccommodationUID[]" id="AccommodationUID" value="' . $VoucherAccommmodationData['UID'] . '">
                                                        <div class="col-md-12"><hr id="datacontent' . $cnt . '" data-content="Self Hotel for ' . ($diff->d) . ' nights ' . '" class="hr-text"><input type="hidden" class="accommationnights" name="AccommationNights[]" id="AccommationNights' . $cnt . '" value="' . ($diff->d) . '"></div>
                                                        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">City</label>  <input type="hidden" name="Self['.$cnt.']" value="1"><input type="hidden"  name="TempAccommodation[Self][]" value="1"><select class="form-control" id="City" onChange="LoadSelfHotelsByCites(this.value,' . $cnt . ',' . $HotelID . ')"  name="City[' . $cnt . ']">' . $CitiesHTML . ' </select><input type="hidden"  name="TempAccommodation[City][]" value="' . $VoucherAccommmodationData['City'] . '"> </div>  </div>
                                                        <div class="col-md-3">  <div class="form-group mb-3"> <label for="country">Hotel</label>  <select class="form-control" id="Hotels_' . $cnt . '"  name="Hotels['.$cnt.']" onchange="GetHotelName(this.value,' . $cnt . ');">   </select><input type="hidden"  name="TempAccommodation[Hotels][]" value="' . $VoucherAccommmodationData['Hotel'] . '">    </div> </div> 
                                                        <div class="col-md-2">   <div class="form-group mb-3">  <label for="country">Check-In</label>   <input type="date" class="form-control validate[required,funcCall[checkindate]] voucherdatefilter" id="CheckIn' . $cnt . '" name="CheckIn['.$cnt.']"   aria-describedby="emailHelp1"  placeholder="Check Out" value="' . $VoucherAccommmodationData['CheckIn'] . '" ><input type="hidden"  name="TempAccommodation[CheckIn][]" value="' . $VoucherAccommmodationData['CheckIn'] . '">    </div>   </div>
                                                        <div class="col-md-2">   <div class="form-group mb-3">  <label for="country">Check-Out</label> <input type="date" class="form-control validate[required,funcCall[checkoutdate]] voucherdatefilter" id="CheckOut' . $cnt . '"  name="CheckOut['.$cnt.']" aria-describedby="emailHelp1"  placeholder="Check Out"  value="' . $VoucherAccommmodationData['CheckOut'] . '" onchange="GetNoOfDaysRate((\'RequestedAccomodationCount' . $cnt . '\',' . $cnt . ',1); ><input type="hidden"  name="TempAccommodation[CheckOut][]" value="' . $VoucherAccommmodationData['CheckOut'] . '">   </div>  </div>
                                                        <div class="col-md-2">   <div class="form-group mb-3"> <input type="hidden"  name="AccommodationBRN['.$cnt.']" value=""><input type="hidden"  name="TempAccommodation[AccommodationBRN][]" value="' . $VoucherAccommmodationData['AccommodationBRN'] . '">   </div>  </div>';
                                                        if(isset($CheckAccommodationActivity) && count($CheckAccommodationActivity) == 0){
                                                            echo'<div class="col-md-1"><label for="country">
                                                                <a name="removeButton" href="javascript:void(0);"
                                                                   onClick="RemoveAllAccomodationsRow(\'RequestedAccomodationCount' . $cnt . '\',' . $VoucherAccommmodationData['VoucherID'] . ',' . $VoucherAccommmodationData['City'] . ',' . $VoucherAccommmodationData['Hotel'] . ',\'' . $VoucherAccommmodationData['CheckIn'] . '\',\'' . $VoucherAccommmodationData['CheckOut'] . '\',\'' . $VoucherAccommmodationData['AccommodationBRN'] . '\')"
                                                                   id="removeButton" class="float-right"
                                                                   style="color: #dd0317;padding-left: 10px;"><span>
                                                                    <i class="fa fa-trash"
                                                                       title="Remove"></i></span></a>
                                                            </label></div>';
                                                        }
                                                        echo'<div class="col-md-12" id="RequestedAccomodationRoomType' . $cnt . '">';
                                                        ?>
                                                        <?php
                                                        $JSCODEVoucherAccommmodationRoomTypes = '';
                                                        $count1 = 0;
                                                        foreach ($VoucherAccommmodationRoomTypes as $VoucherAccommmodationRoomType) {

                                                            echo '<input value="" type="hidden" name="dlt_accomodation_room_type[' . $VoucherAccommmodationRoomType['UID'] . ']" id="dlt_accomodation_room_type_' . $VoucherAccommmodationRoomType['UID'] . '">';
                                                            $count1++;
                                                            $count++;
                                                            if (OptionName($VoucherAccommmodationRoomType['RoomType']) == 'Sharing') {
                                                                $NoOfBedsRooms = "No Of Beds";
                                                            } else {
                                                                $NoOfBedsRooms = "No Of Rooms";
                                                            }
                                                            echo '<div class="row" id="RequestedAccomodationRoomTypeCount' . $cnt . '_' . $count1 . '">
                                                            <div class="col-md-3"> <input type ="hidden" name ="AccomodationId[' . $cnt . '][]" id="AccomodationId_' . $cnt . '_' . $count1 . '" value ="' . $VoucherAccommmodationRoomType['UID'] . '"><div class="form-group mb-3">  <label for="country">Room Type</label>  <select class="form-control RoomTypeClass" id="RoomType_' . $cnt . '_' . $count1 . '"  name="RoomType[' . $cnt . '][]" onchange="GetRoomRate(\'RequestedAccomodationCount' . $cnt . '\',' . $cnt . ',\'RequestedAccomodationRoomTypeCount' . $cnt . '_' . $count1 . '\',' . $count1 . ');">   <option value=""> Please Select </option> ' . $EditRoomTypes . '  </select><input type="hidden"  name="TempAccommodation[RoomType][]" value="' . $VoucherAccommmodationRoomType['RoomType'] . '">  </div> </div>
                                                            <div class="col-md-2">   <div class="form-group mb-3">  <label for="country" id="noofroomsbeds' . $cnt . '_' . $count . '">' . $NoOfBedsRooms . '</label> <input type="number" class="form-control NoOfBeds NoOfBedsClass validate[required,funcCall[checknumberofbeds]]"   id="NoOfBeds_' . $cnt . '_' . $count1 . '"  name="NoOfBeds[' . $cnt . '][]" onchange="GetRoomRate(\'RequestedAccomodationCount' . $cnt . '\',' . $cnt . ',\'RequestedAccomodationRoomTypeCount' . $cnt . '_' . $count1 . '\',' . $count1 . ');"  aria-describedby="emailHelp1"  value="' . $VoucherAccommmodationRoomType['NoOfBeds'] . '" placeholder="No Of Beds"><input type="hidden"  name="TempAccommodation[NoOfBeds][]" value="' . $VoucherAccommmodationData['NoOfBeds'] . '">   </div>  </div>
                                                            <div class="col-md-2">  <label for="country"></label>  <div class="form-group mb-3"> <input type ="hidden" name ="AmountPayable[' . $cnt . '][]" id="AmountPayableInput_' . $cnt . '_' . $count1 . '" value ="' . $VoucherAccommmodationRoomType['AmountPayable'] . '"> <input type="hidden"  name="TempAccommodation[AmountPayable][]" value="' . $VoucherAccommmodationRoomType['AmountPayable'] . '">  </div>  </div>';
                                                            ?>
                                                            <?php if ($count1 == 1) { ?>
                                                                <?php
                                                                echo '<div class="col-md-1 pt-3"
                                                                     id="AddRoomType<?= $cnt ?>">
                                                                    <label for="country"> </label> </br>
                                                                    <a name="removeButton"
                                                                       href="javascript:void(0);"
                                                                       id="removeButton"
                                                                       onclick="AddSelfRequestestedAccomodationRoomTypeRow(' . $cnt . ',' . count($VoucherAccommmodationRoomTypes) . ')"><span>
                                                                           <i class="fa fa-plus" title="Add"></i></a>
                                                                </div>';
                                                                ?>
                                                            <?php } else { ?>
                                                                <?php
                                                                if(isset($CheckAccommodationActivity) && count($CheckAccommodationActivity) == 0){
                                                                    echo '<div class="col-md-1 pt-3">
                                                                    <label for="country"> </label> <br>
                                                                    <a name="removeButton"
                                                                       href="javascript:void(0);"
                                                                       id="removeButton"
                                                                       onclick="RemoveAccomodationsRoomTypeRow(\'RequestedAccomodationRoomTypeCount' . $cnt . '_' . $count1 . '\', ' . $VoucherAccommmodationRoomType['UID'] . ')"><span>
                                                                                    <i class="fa fa-trash"
                                                                                       title="Remove"
                                                                                       aria-hidden="true"></i>
                                                                                    <span class="sr-only">Remove</span></span>aaaaaaaaa</a>
                                                                </div>';
                                                                }

                                                                ?>
                                                            <?php } ?>
                                                            <?php
                                                            echo '</div>';
                                                            $JSCODEVoucherAccommmodationRoomTypes .= '$("#RoomType_' . $cnt . '_' . $count1 . '").val("' . $VoucherAccommmodationRoomType['RoomType'] . '");';
                                                        }
                                                        ?>
                                                        <?php
                                                        echo '<div class="col-md-12"> <hr> </div>
                                                    </div>
                                                    </div>
                                                    ';

                                                        $HotelByCitiesJSCode .= 'LoadSelfHotelsByCites(' . $VoucherAccommmodationData['City'] . ',' . $cnt . ',' . $HotelID . ');';
                                                        $JSCODE .= '$("#RequestedAccomodationCount' . $cnt . ' #City").val("' . $VoucherAccommmodationData['City'] . '").select2();';
                                                        $JSCODE .= '$("#RequestedAccomodationCount' . $cnt . ' #Hotels_' . $cnt . '").val("' . $VoucherAccommmodationData['Hotel'] . '");';
                                                        //$JSCODE .= '$("#RequestedAccomodationCount' . $cnt . ' #RoomType").val("' . $VoucherAccommmodationData['RoomType'] . '").select2();';
                                                        $JSCODE .= $JSCODEVoucherAccommmodationRoomTypes;
                                                    }


                                                }
                                                ?>
                                                <input type="hidden" name="ActualAccommodationCount"
                                                       value="<?php echo $cnt; ?>">
                                            </div>
                                        </div>

                                    </section>
                                    <h3> Transport</h3>
                                    <section>
                                        <div id="TransportDetailAdd">
                                            <div id="TransportR" name="TransportR">
                                                <h5>Transport Details
                                                    <!--<a href="javascript:void(0);" id="AddTransportRows"
                                                       class="float-right" style="margin-right: 10px;"
                                                       onclick="AddTransportAttachmentRow();"><span>
                                                        <i class="fa fa-plus" title="Add More"></i></span></a>-->
                                                    <a href="javascript:void(0);" id="AddFlightRows"
                                                       class="btn btn_customized btn-sm float-right"
                                                       style="margin-right: 10px;"
                                                       onclick="AddTransportAttachmentRow();">Add Package Transport</a>
                                                    <a href="javascript:void(0);" id="AddFlightRows"
                                                       class="btn btn_customized btn-sm float-right"
                                                       style="margin-right: 10px;"
                                                       onclick="AddSelfTransportAttachmentRow();">Add Self Transport</a>
                                                </h5>
                                                <hr>
                                                <?php
                                                $cnt = 0;
                                                foreach ($VoucherTransportDetails as $VoucherTransportDetail) {

                                                    echo '<input value="" type="hidden" name="dlt_transport[' . $VoucherTransportDetail['UID'] . ']" id="dlt_transport_' . $VoucherTransportDetail['UID'] . '">';
                                                    $cnt++;
                                                    $data['LookupsOptions'] = $Crud->LookupOptions('transport_sectors');
                                                    foreach ($data['LookupsOptions'] as $options) {
                                                        $selected = (($VoucherTransportDetail['Sectors'] == $options['UID']) ? 'selected' : '');
                                                        $Sectors .= '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['Name'] . '</option>';
                                                    }
                                                    foreach ($TransportData as $TransportUID => $thisType) {
                                                        $selected = (($VoucherTransportDetail['TransportTypeUID'] == $TransportUID) ? 'selected' : '');
                                                        $Transports .= '<option value="' . $TransportUID . '"' . $selected . '>' . $thisType . '</option>';
                                                    }
                                                    if ($VoucherTransportDetail['SelfTransport'] == 0) {
                                                        echo '
                                                    <div class="row" id="TransportAttachmentCount' . $cnt . '" >
                                                     <input type="hidden" name="TransportUID[]" id="TransportUID" value="' . $VoucherTransportDetail['UID'] . '">
                                                    <div class="col-md-12"><hr data-content="Package Transport" class="hr-text"></div>
                                                   <div class="col-md-2">  
                                                   <div class="form-group mb-2"> 
                                                   <label for="country">City</label>
                                                   <select class="form-control" id="TravelCity"   name="TravelCity[]">' . $CitiesHTML . ' </select> 
                                                   <input type="hidden"  name="TempAccommodation[TravelCity][]" value="' . $VoucherAccommmodationData['TravelCity'] . '">
                                                   </div>  
                                                   </div>
                                                   <div class="col-md-3">
                                                   <div class="form-group mb-3">
                                                   <label for="country">Travel Date</label>
                                                   <input type="date" class="form-control  validate[required,funcCall[transporttraveldate]] voucherdatefilter" id="TravelDate' . $cnt . '" name="TravelDate[]"
                                                   aria-describedby="emailHelp1"  placeholder="Check Out" value="' . $VoucherTransportDetail['TravelDate'] . '" >
                                                   <input type="hidden"  name="TempTravelDate[TravelDate][]" value="' . $VoucherTransportDetail['TravelDate'] . '">   
                                                   </div>   
                                                   </div>
                                                    <div class="col-md-2">
                                                     <input type="hidden" name="SelfTransport[]" value="0">
                                                     <input type="hidden"  name="TempTransport[SelfTransport][]" value="0">
                                                     
                                                        <div class="form-group mb-2"><label
                                                                    for="country">Sectors</label> <select
                                                                    class="form-control"
                                                                    id="TransportSectors_' . $cnt . '"
                                                                    name="TransportSectors[]">
                                                                <option value="">Please Select</option>
                                                                ' . $Sectors . ' </select>
                                                                <input type="hidden"  name="TempTransport[TransportSectors][]" value="' . $VoucherTransportDetail['Sectors'] . '"></div>
                                                    </div>
                                                     <div class="col-md-2">
                                                    <div class="form-group mb-2">
                                                        <label for="country">Travel Type</label><br>
                                                        
                                                        <select class="form-control validate[required]" id="TransportTravelType"
                                                                name="TransportTravelType[]">
                                                            <option value="">Please Select</option>
                                                            <option value="Arrival" ' . (($VoucherTransportDetail['TravelType'] == 'Arrival') ? 'selected' : '') . '>
                                                                Arrival
                                                            </option>
                                                            <option value="Departure" ' . (($VoucherTransportDetail['TravelType'] == 'Departure') ? 'selected' : '') . '>
                                                                Departure
                                                            </option>
                                                            <option value="Checkout" ' . (($VoucherTransportDetail['TravelType'] == 'Checkout') ? 'selected' : '') . '>
                                                                Checkout
                                                            </option>
                                                        </select><input type="hidden" name="TempTransport[TransportTravelType][]" value="' . $VoucherTransportDetail['TravelType'] . '">
                                                    </div>
                                                </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3"><label
                                                                    for="country">Transports</label> <select
                                                                    class="form-control" id="TransportType_' . $cnt . '"
                                                                    name="TransportType[]"
                                                                    onchange="TransportRates(this.value,' . $cnt . ')">
                                                                <option value="">Please Select</option>
                                                                ' . $Transports . ' </select>
                                                                <input type="hidden"  name="TempTransport[TransportType][]" value="' . $VoucherTransportDetail['TransportTypeUID'] . '"></div>
                                                    </div>
                                                      <div class="col-md-3">
                                                        <div class="form-group mb-3"><label for="country">
                                                                BRN</label><select class="form-control validate[required]"  name="TransportsBRN[]"
                                                                                        id="TransportsBRN_' . $cnt . '">' . GetVoucherBrnList($VoucherTransportDetail['VoucherUID'], 'transport', $VoucherTransportDetail['TransportsBRN']) . '</select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3"><label for="country">
                                                                No Of Pax</label><input type="text" class="form-control"
                                                                                        name="NoOfPax[]"
                                                                                        id="NoOfPax_' . $cnt . '"
                                                                                        value="' . $VoucherTransportDetail['NoOfPax'] . '">
                                                                                        <input type="hidden"  name="TempTransport[NoOfPax][]" value="' . $VoucherTransportDetail['NoOfPax'] . '">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3"><label for="country">
                                                                No Of Seats</label><input type="text" class="form-control"
                                                                                        name="NoOfSeats[]"
                                                                                        id="NoOfSeats_' . $cnt . '"
                                                                                        value="' . $VoucherTransportDetail['NoOfSeats'] . '"  oninput="TransportRateUpdate(' . $cnt . ');">
                                                                                        <input type="hidden"  name="TempTransport[NoOfSeats][]" value="' . $VoucherTransportDetail['NoOfSeats'] . '">
                                                        </div>
                                                    </div>
                                                  
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3"><label for="country">Transport
                                                                Rates</label><br><input type="hidden"
                                                                                        name="TransportsRates[]"
                                                                                        id="TransportRateValue_' . $cnt . '"
                                                                                        value="' . $VoucherTransportDetail['Rate'] . '"><span
                                                                    id="TransportsRates_' . $cnt . '" class="AmountSpan">' . Money($VoucherTransportDetail['Rate']) . '</span>
                                                                    <input type="hidden"  name="TempTransport[TransportRates][]" value="' . $VoucherTransportDetail['Rate'] . '">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1"><label for="country"> </label> <br> <a name="removeButton" href="javascript:void(0);" onClick="RemoveTransportRow(' . $VoucherTransportDetail['UID'] . ',' . $cnt . ');" id="removeButton" class="float-right"  style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div>
                                                    <div class="col-md-12">
                                                        <hr>
                                                    </div>
                                                </div>';
                                                        //$JSCODE .= 'LoadSelfHotelByCites(' . ($VoucherTransportDetail['TravelCity'] + 0) . ',' . $cnt . ');';
                                                        $JSCODE .= '$("#TransportAttachmentCount' . $cnt . ' #TravelCity").val("' . $VoucherTransportDetail['TravelCity'] . '").select2();';
                                                    } else {
                                                        echo '
                                                    <div class="row" id="TransportAttachmentCount' . $cnt . '" >
                                                    <input type="hidden" name="TransportUID[]" id="TransportUID" value="' . $VoucherTransportDetail['UID'] . '">
                                                    <div class="col-md-12"><hr data-content="Self Transport" class="hr-text"></div>
                                                    <div class="col-md-2">  
                                                   <div class="form-group mb-2"> 
                                                   <label for="country">City</label>
                                                   <select class="form-control" id="TravelCity"   name="TravelCity[]">' . $CitiesHTML . ' </select> 
                                                   <input type="hidden"  name="TempTransport[TravelCity][]" value="' . $VoucherAccommmodationData['TravelCity'] . '">
                                                   </div>  
                                                   </div>
                                                   <div class="col-md-3">
                                                   <div class="form-group mb-3">
                                                   <label for="country">Travel Date</label>
                                                   <input type="date" class="form-control  validate[required,funcCall[transporttraveldate]] voucherdatefilter" id="TravelDate' . $cnt . '" name="TravelDate[]"   aria-describedby="emailHelp1"  placeholder="Check Out" value="' . $VoucherTransportDetail['TravelDate'] . '" >
                                                   <input type="hidden"  name="TempTransport[TravelDate][]" value="' . $VoucherTransportDetail['TravelDate'] . '">   
                                                   </div>   
                                                   </div>
                                                    <div class="col-md-2">
                                                     <input type="hidden" name="SelfTransport[]" value="1">
                                                     <input type="hidden"  name="TempTransport[SelfTransport][]" value="1">
                                                        <div class="form-group mb-3"><label
                                                                    for="country">Sectors</label> <select
                                                                    class="form-control"
                                                                    id="TransportSectors' . $cnt . '"
                                                                    name="TransportSectors[]">
                                                                <option value="">Please Select</option>
                                                                ' . $Sectors . ' </select>
                                                                <input type="hidden"  name="TempTransport[TransportSectors][]" value="' . $VoucherTransportDetail['Sectors'] . '"></div>
                                                    </div>
                                                    <div class="col-md-2">
                                                    <div class="form-group mb-2">
                                                        <label for="country">Travel Type</label><br>
                                                          <select class="form-control validate[required]" id="TransportTravelType"
                                                                name="TransportTravelType[]">
                                                            <option value="">Please Select</option>
                                                            <option value="Arrival" ' . (($VoucherTransportDetail['TravelType'] == 'Arrival') ? 'selected' : '') . '>
                                                                Arrival
                                                            </option>
                                                            <option value="Departure" ' . (($VoucherTransportDetail['TravelType'] == 'Departure') ? 'selected' : '') . '>
                                                                Departure
                                                            </option>
                                                            <option value="Checkout" ' . (($VoucherTransportDetail['TravelType'] == 'Checkout') ? 'selected' : '') . '>
                                                                Checkout
                                                            </option>
                                                        </select><input type="hidden" name="TempTransport[TransportTravelType][]" value="' . $VoucherTransportDetail['TravelType'] . '">
                                                    </div>
                                                </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3"><label
                                                                    for="country">Transports</label> <select
                                                                    class="form-control" id="TransportType' . $cnt . '"
                                                                    name="TransportType[]"
                                                                    >
                                                                <option value="">Please Select</option>
                                                                ' . $Transports . ' </select>
                                                                <input type="hidden"  name="TempTransport[TransportType][]" value="' . $VoucherTransportDetail['TransportTypeUID'] . '"></div>
                                                    </div>
                                                      
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3"><label for="country">
                                                                No Of Pax</label><input type="text" class="form-control"
                                                                                        name="NoOfPax[]"
                                                                                        id="NoOfPax' . $cnt . '"
                                                                                        value="' . $VoucherTransportDetail['NoOfPax'] . '">
                                                                                        <input type="hidden"  name="TempTransport[NoOfPax][]" value="' . $VoucherTransportDetail['NoOfPax'] . '">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3"><label for="country">
                                                                No Of Seats</label><input type="text" class="form-control"
                                                                                        name="NoOfSeats[]"
                                                                                        id="NoOfSeats' . $cnt . '"
                                                                                        value="' . $VoucherTransportDetail['NoOfSeats'] . '">
                                                                                        <input type="hidden"  name="TempTransport[NoOfSeats][]" value="' . $VoucherTransportDetail['NoOfSeats'] . '">
                                                        </div>
                                                    </div>
                                                  
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-3"><input type="hidden"
                                                                                        name="TransportsRates[]"
                                                                                        id="TransportRateValue' . $cnt . '"
                                                                                        value="0">
                                                                                        <input type="hidden"  name="TempTransport[TransportRates][]" value="0">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3"><label for="country">
                                                                </label><input type="hidden" class="form-control"
                                                                                        name="TransportsBRN[]"
                                                                                        id="TransportsBRN' . $cnt . '"
                                                                                        value="' . $VoucherTransportDetail['TransportsBRN'] . '">
                                                                                        <input type="hidden"  name="TempTransport[TransportsBRN][]" value="' . $VoucherTransportDetail['TransportsBRN'] . '">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1"><label for="country"> </label> <br> <a name="removeButton" href="javascript:void(0);" onClick="RemoveTransportRow(' . $VoucherTransportDetail['UID'] . ',' . $cnt . ');" id="removeButton" class="float-right"  style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div>
                                                    <div class="col-md-12">
                                                        <hr>
                                                    </div>
                                                </div>';
                                                        //$JSCODE .= 'LoadSelfHotelByCites(' . ($VoucherTransportDetail['TravelCity'] + 0) . ',' . $cnt . ');';
                                                        $JSCODE .= '$("#TransportAttachmentCount' . $cnt . ' #TravelCity").val("' . $VoucherTransportDetail['TravelCity'] . '").select2();';
                                                    }
                                                }
                                                ?>
                                                <input type="hidden" name="ActualTransportCount"
                                                       value="<?php echo $cnt; ?>">
                                            </div>
                                        </div>
                                    </section>
                                    <h3> Ziyarat </h3>
                                    <section>
                                        <div id="Ziyarat">
                                            <div id="ZiyaratR" name="ZiyaratR">
                                                <h5>Ziyarat Details
                                                    <a href="javascript:void(0);" id="AddZiyaratRows"
                                                       class="float-right" style="margin-right: 10px;"
                                                       onclick="AddNewZiyarat();"><span>
                                                        <i class="fa fa-plus" title="Add More"></i></span></a>
                                                </h5>
                                                <hr>
                                                <?php $cnt = 0;
                                                foreach ($VoucherZiyaratDetails as $voucherZiyaratDetail) {

                                                    echo '<input value="" type="hidden" name="dlt_ziyarat[' . $voucherZiyaratDetail['UID'] . ']" id="dlt_ziyarat_' . $voucherZiyaratDetail['UID'] . '">';
                                                    $cnt++;
                                                    foreach ($TransportData as $TransportUID => $thisType) {
                                                        $selected = (($voucherZiyaratDetail['TransportTypeUID'] == $TransportUID) ? 'selected' : '');
                                                        $Transports .= '<option value="' . $TransportUID . '"' . $selected . '>' . $thisType . '</option>';
                                                    }
                                                    echo '                                                
                                                    <div class="row"  id="ZiyaratAttachmentCounts' . $cnt . '">
                                                <div class="col-md-2"> <div class="form-group mb-3"><label for="country">Location</label><select class="form-control" id="Cities"  name="ZiyaratCity[]" onChange="LoadZiyaratByCites(this.value,' . $cnt . ',' . $voucherZiyaratDetail['ZiyaratsUID'] . ')"> </select></div> </div>
                                                <div class="col-md-2"> <div class="form-group mb-3"><label  for="country">Ziyarat</label> <select class="form-control" id="Ziyarat' . $cnt . '" name="Ziyarat[]" ><option value="">Ziyarat</option></select> </div> </div>
                                                <div class="col-md-2"> <div class="form-group mb-3"><label for="country">Transports</label> <select class="form-control" id="TransportRateZiyrat' . $cnt . '" name="TransportRateZiyrat[]" onchange = "ZiyaratRatesUpdate(' . $cnt . ')"> <option value="">Please Select  </option> ' . $Transports . ' </select> </div> </div>
                                                <div class="col-md-2">  <div class="form-group mb-3"><label for="country">No Of Pax </label><input type="text" class="form-control validate[required,funcCall[checknumberofpax]] "  name ="ZiyaratNoOfPax[]" id="ZiyaratNoOfPax_' . $cnt . '" value ="' . $voucherZiyaratDetail['ZiyaratNoOfPax'] . '" onchange="ZiyaratRatesUpdate(' . $cnt . ')"></div> </div>
                                                <div class="col-md-3">  <div class="form-group mb-3"><label for="country">Transport Rates</label><br><input type="hidden" name="ZiyaratTransportsRates[]" id="ZiyaratTransportsRates" value="' . $voucherZiyaratDetail['Rate'] . '"> <span id="ZiyaratTransportsRatesSpan_' . $cnt . '" class="AmountSpan"> ' . Money($voucherZiyaratDetail['Rate']) . '</span> </div> </div>
                                                <div class="col-md-1">  <label for="country"> </label> <br> <a name="removeButton" href="javascript:void(0);" onClick="RemoveZiyarats(' . $voucherZiyaratDetail['UID'] . ',' . $cnt . ')" id="removeButton" class="float-right" style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div> <div class = "col-md-12"><hr></div>
                                                </div>
                                                    ';
                                                    $ZiaratByCitiesJSCode .= 'LoadZiyaratByCites(' . $voucherZiyaratDetail['ZiyaratCity'] . ',' . $cnt . ',' . $voucherZiyaratDetail['ZiyaratsUID'] . ');';
                                                }

                                                ?>

                                            </div>
                                        </div>
                                    </section>
                                    <h3> Extra</h3>
                                    <section>
                                        <div id="defaultAccordionThree">
                                            <div class="row" id="ServicesGrid">
                                            </div>
                                            <div class="" id="VoucherAddResponse"></div>
                                        </div>
                                    </section>
                                    <h3> Summary</h3>
                                    <section>
                                        <div id="Summary">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div id="SummaryGrid">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">-->
            <!--                <div class="" id="VoucherAddResponse"></div>-->
            <!--                <button type="button" class="btn btn_customized float-right mb-5" onclick="VoucherFormSubmit();">-->
            <!--                    Submit-->
            <!--                </button>-->
            <!--            </div>-->

        </div>
    </div>
</div>
<script>

    function GetArrivalReturnDate() {

        const ArrivalReturn = $("#ArrivalReturn").val();
        const words = ArrivalReturn.split(' to ');
        // alert(ArrivalReturn);
        // alert(words[0]);
        // alert(words[1]);
        $("#VoucherArrivalDate").val(words[0]);
        $("#ReturnDate").val(words[1]);


        // var ArrivalReturn = $("#ArrivalReturn").val();
        // dates = AjaxResponse("html/GetStartEndDates", "ArrivalReturn=" + ArrivalReturn);
        //
        // $("#VoucherArrivalDate").val(dates.StartDate);
        // $("#ReturnDate").val(dates.EndDate);
        voucherdatefilter();
        // SetReturnDate();
        // GetArrivalReturnDays();


    }

    localStorage.setItem('CitiesHTML', '<?=$CitiesHTML?>');
    CitiesHTML = localStorage.getItem('CitiesHTML');

    function AddNewZiyarat() {
        ZiyaratAttachmentCount = parseInt($("#ZiyaratAttachmentCount").val());

        HTML = DefaultZiyaratRowHTML(ZiyaratAttachmentCount);
        $("#ZiyaratR").append(HTML);
        $("#ZiyaratAttachmentCount").val(ZiyaratAttachmentCount + 1);
        DefaultScripts();
        return false;
    }


    function DefaultZiyaratRowHTML(cnt) {
        cnt = cnt + 1;
        var html;

        CountryCode = $("#VoucherCountry").val();
        //CountryCode = "SA";
        // console.log("DefaultZiyaratRowHTML running............");
        if (CitiesHTML == '') {
            cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + CountryCode);
            CitiesHTML = cities.html;
        }
        ZiyaratCities = '<select class="form-control HotelCities" id="ZiyaratCity_' + cnt + '" name="ZiyaratCity[]" onChange="LoadZiyaratByCites(this.value, ' + cnt + ')" ><option value="">City</option>' + CitiesHTML + '</select>'
        Ziyarats = '<select class="form-control" id="Ziyarat' + cnt + '" name="Ziyarat[]" ><option value="">Ziyarat</option></select>'
        Transports = '<?php foreach ($TransportData as $TransportUID => $thisType) {
            echo '<option value="' . $TransportUID . '">' . $thisType . '</option>';
        } ?> ';

        html = '<div class="row" id="ZiyaratAttachmentCount' + cnt + '" name="ZiyaratAttachmentCount">\n' +
            '<div class="col-md-2"> <div class="form-group mb-3"><label for="country">Location</label>' + ZiyaratCities + '</div> </div>\n' +
            '<div class="col-md-2"> <div class="form-group mb-3"><label  for="country">Ziyarat</label>' + Ziyarats + ' </div> </div>\n' +
            '<div class="col-md-2"> <div class="form-group mb-3"><label for="country">Transports</label> <select class="form-control" id="TransportRateZiyrat' + cnt + '" name="TransportRateZiyrat[]" onchange = "ZiyaratRatesUpdate(' + cnt + ')"> <option value="">Please Select  </option> ' + Transports + ' </select> </div> </div>' +
            '<div class="col-md-2">  <div class="form-group mb-3"><label for="country">No Of Pax </label><input type="text" class="form-control validate[required,funcCall[checknumberofpax]] "  name ="ZiyaratNoOfPax[]" id="ZiyaratNoOfPax_' + cnt + '" value ="" onchange="ZiyaratRatesUpdate(' + cnt + ');"></div> </div>' +
            '<div class="col-md-3">  <div class="form-group mb-3"><label for="country">Transport Rates</label><br> <input id="ZiyaratTransportsRates_' + cnt + '" type="hidden" name= "ZiyaratTransportsRates[]" value=""> <span id="ZiyaratTransportsRatesSpan_' + cnt + '" class="AmountSpan"> - </span> </div> </div>\n' +
            '<div class="col-md-1">  <label for="country"> </label> <br> <a name="removeButton" href="javascript:void(0);" onClick="RemoveZiyaratRow(' + cnt + ')" id="removeButton" class="float-right" style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div> <div class = "col-md-12"><hr></div> </div>';
        ' </div>';
        DefaultScripts();
        return html;
    }

    function ZiyaratRates(TransportsID, cnt) {
        var PackagesUID = $("#PackageUID").val();
        var Ziarat = $("#Ziyarat" + cnt).val();
        response = AjaxResponse("html/GetZiyaratRatesByPackageID", "Ziarat=" + Ziarat + "&PackagesUID=" + PackagesUID + "&TransportsID=" + TransportsID);
        $("#ZiyaratTransportsRatesSpan_" + cnt).html(response.html);
        $("#ZiyaratTransportsRates_" + cnt).val(response.rate);
        $("#ZiyaratNoOfPax_" + cnt).val(null);

    }

    function ZiyaratRatesUpdate(cnt) {
        var PackagesUID = $("#PackageUID").val();
        var TransportsID = $("#TransportRateZiyrat" + cnt).val();
        var NoOfPax = $("#ZiyaratNoOfPax_" + cnt).val();
        var Ziarat = $("#Ziyarat" + cnt).val();
        response = AjaxResponse("html/GetZiyaratRatesByPackageUpdate", "Ziarat=" + Ziarat + "&PackagesUID=" + PackagesUID + "&TransportsID=" + TransportsID + "&NoOfPax=" + NoOfPax);
        $("#ZiyaratTransportsRatesSpan_" + cnt).html(response.html);
        var rate = NoOfPax * response.rate;
        $("#ZiyaratTransportsRates_" + cnt).val(rate);

    }

    function LoadTravelCityDropdownHotel(country) {
        cnt = parseInt($("#TransportAttachmentCount").val());

        if (CitiesHTML == '') {
            cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + CountryCode);
            CitiesHTML = cities.html;
        }

        $("#TransportAttachmentCount" + cnt + " #TravelCity").html('<option value="">Please Select</option>' + CitiesHTML);

        DefaultScripts();
    }

    function AddTransportAttachmentRow() {
        TransportAttachmentCount = parseInt($("#TransportAttachmentCount").val());

        HTML = TransportAttachmentFormHTML(TransportAttachmentCount);
        $("#TransportR").append(HTML);
        $("#TransportAttachmentCount").val(TransportAttachmentCount + 1);
        CountryCode = $("#VoucherCountry").val();
        LoadTravelCityDropdownHotel(CountryCode);
        DefaultScripts();
        return false;
    }

    function AddSelfTransportAttachmentRow() {
        TransportAttachmentCount = parseInt($("#TransportAttachmentCount").val());

        HTML = SelfTransportAttachmentFormHTML(TransportAttachmentCount);
        $("#TransportR").append(HTML);
        $("#TransportAttachmentCount").val(TransportAttachmentCount + 1);
        CountryCode = $("#VoucherCountry").val();
        LoadTravelCityDropdownHotel(CountryCode);
        DefaultScripts();
        return false;
    }

    function TransportAttachmentFormHTML(cnt) {
        cnt = cnt + 1;
        var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;
        var html;
        BRN = '<?php echo GetVoucherBrnList(0, 'transport', 0); ?>';

        Sectors = '<?php $data['LookupsOptions'] = $Crud->LookupOptions('transport_sectors'); foreach ($data['LookupsOptions'] as $options) {
            echo '<option value="' . $options['UID'] . '">' . $options['Name'] . '</option>';
        }?>';
        Transports = '<?php foreach ($TransportData as $TransportUID => $thisType) {
            echo '<option value="' . $TransportUID . '">' . $thisType . '</option>';
        } ?> ';
        var mindate = $("#VoucherArrivalDate").val();
        var maxdate = $("#ReturnDate").val();

        html = ' <div class="row" id="TransportAttachmentCount' + cnt + '" name="TransportAttachmentCount">\n' +
            ' <div class="col-md-12"><hr data-content="Package Transport" class="hr-text"></div>\n' +
            '<div class="col-md-2"><div class="form-group mb-2"><label for="country">City</label><select class="form-control" id="TravelCity"   name="TravelCity[]"></select><input type="hidden"  name="TempTransport[TravelCity][]" ></div></div>\n' +
            '<div class="col-md-3"> <div class="form-group mb-3"><label for="country">Travel Date</label><input type="date" class="form-control  validate[required,funcCall[transporttraveldate]] voucherdatefilter" id="TravelDate" name="TravelDate[]"   aria-describedby="emailHelp1"  placeholder="Travel Date" min="' + mindate + '" max="' + maxdate + '" value="' + mindate + '"> <input type="hidden"  name="TempTransport[TravelDate][]" value=""></div> </div>\n' +
            '<div class="col-md-2"> <div class="form-group mb-3"><input type="hidden" name="SelfTransport[]" value="0"><input type="hidden"  name="TempTransport[SelfTransport][]" value="0"><label  for="country">Sectors</label> <select  class="form-control validate[required]" id="TransportSectors_' + cnt + '" name="TransportSectors[]">\n' +
            '<option value="">Please Select</option> ' + Sectors + ' </select><input type="hidden"  name="TempTransport[TransportSectors][]" value=""></div> </div>\n' +
            '<div class="col-md-2"><div class="form-group mb-2"><label for="country">Travel Type</label><br><select class="form-control validate[required]" id="TransportTravelType" name="TransportTravelType[]"><option value="">Please Select</option><option value="Arrival">Arrival</option><option value="Departure">Departure</option><option value="Checkout">Checkout</option></select><input type="hidden" name="TempTransport[TransportTravelType][]" value=""></div></div>\n' +
            '<div class="col-md-3"> <div class="form-group mb-3"><label for="country">Transports</label> <select class="form-control validate[required]" id="TransportType_' + cnt + '" name="TransportType[]"  onchange = "TransportRates(this.value,' + cnt + ')"> <option value="">Please Select  </option>' + Transports + ' </select><input type="hidden"  name="TempTransport[TransportType][]" value=""></div> </div>\n' +
            '<div class="col-md-3">  <div class="form-group mb-3"><label for="country">BRN</label><select class="form-control validate[required]"  name ="TransportsBRN[]" id="TransportsBRN_' + cnt + '">' + BRN + '</select><input type="hidden"  name="TempTransport[TransportsBRN][]" value=""></div> </div>\n' +
            '<div class="col-md-3">  <div class="form-group mb-3"><label for="country">No Of Pax </label><input type="text" class="form-control validate[required,funcCall[checknumberofpax]]"  name ="NoOfPax[]" id="NoOfPax_' + cnt + '" value ="' + CountPilgrim + '"><input type="hidden"  name="TempTransport[NoOfPax][]" value=""></div> </div>\n' +
            '<div class="col-md-3">  <div class="form-group mb-3"><label for="country">No Of Seats</label><input type="text" class="form-control validate[required ,funcCall[checknumberofseats]]"  name ="NoOfSeats[]" id="NoOfSeats_' + cnt + '" value ="" oninput="TransportRateUpdate(' + cnt + ');"><input type="hidden"  name="TempTransport[NoOfSeats][]" value=""></div> </div>\n' +
            '<div class="col-md-2">  <div class="form-group mb-3"><label for="country">Transport Rates</label><br><input type ="hidden" name ="TransportsRates[]" id="TransportRateValue_' + cnt + '" value =""><span id="TransportsRates_' + cnt + '" class="AmountSpan">-</span><input type="hidden"  name="TempTransport[TransportRates][]" value=""> </div> </div>\n' +
            '<div class="col-md-1">  <label for="country"> </label> <br> <a name="removeButton" href="javascript:void(0);" onClick="RemoveTransportAttachmentRow(' + cnt + ')" id="removeButton" class="float-right" style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div> <div class = "col-md-12"><hr></div> </div>';
        DefaultScripts();
        return html;

    }

    function TransportRateUpdate(cnt) {
        var PackagesUID = $("#PackageUID").val();
        var TransportID = $("#TransportType_" + cnt).val();
        var NoOfSeat = $("#NoOfSeats_" + cnt).val();
        response = AjaxResponse("html/GetTransportRatesByPackageUpdate", "TransportID=" + TransportID + "&PackagesUID=" + PackagesUID + "&NoOfSeat=" + NoOfSeat);
        // var PrintRate = NoOfSeat * response.rate;
        $("#TransportsRates_" + cnt).html(response.html);
        var rate = NoOfSeat * response.rate;
        $("#TransportRateValue_" + cnt).val(rate);


    }

    function SelfTransportAttachmentFormHTML(cnt) {
        cnt = cnt + 1;
        var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;
        var html;

        Sectors = '<?php $data['LookupsOptions'] = $Crud->LookupOptions('transport_sectors'); foreach ($data['LookupsOptions'] as $options) {
            echo '<option value="' . $options['UID'] . '">' . $options['Name'] . '</option>';
        }?>';
        Transports = '<?php foreach ($TransportData as $TransportUID => $thisType) {
            echo '<option value="' . $TransportUID . '">' . $thisType . '</option>';
        } ?> ';
        var mindate = $("#VoucherArrivalDate").val();
        var maxdate = $("#ReturnDate").val();


        html = ' <div class="row" id="TransportAttachmentCount' + cnt + '" name="TransportAttachmentCount">\n' +
            '<div class="col-md-12"><hr data-content="Self Transport" class="hr-text"></div>\n' +
            '<div class="col-md-2"><div class="form-group mb-2"><label for="country">City</label><select class="form-control" id="TravelCity"   name="TravelCity[]"></select><input type="hidden"  name="TempTransport[TravelCity][]" ></div></div>\n' +
            '<div class="col-md-3"> <div class="form-group mb-3"><label for="country">Travel Date</label><input type="date" class="form-control  validate[required,funcCall[transporttraveldate]] voucherdatefilter" id="TravelDate" name="TravelDate[]"   aria-describedby="emailHelp1"  placeholder="Travel Date" min="' + mindate + '" max="' + maxdate + '" value="' + mindate + '"> <input type="hidden"  name="TempTransport[TravelDate][]" value=""></div> </div>\n' +
            '<div class="col-md-2"> <div class="form-group mb-3"><input type="hidden" name="SelfTransport[]" value="1"><input type="hidden"  name="TempTransport[SelfTransport][]" value="1"><label  for="country">Sectors</label> <select  class="form-control validate[required]" id="TransportSectors_' + cnt + '" name="TransportSectors[]">\n' +
            '<option value="">Please Select</option> ' + Sectors + ' </select><input type="hidden"  name="TempTransport[TransportSectors][]" value=""></div> </div>\n' +
            '<div class="col-md-2"><div class="form-group mb-2"><label for="country">Travel Type</label><br><select class="form-control validate[required]" id="TransportTravelType" name="TransportTravelType[]"><option value="">Please Select</option><option value="Arrival">Arrival</option><option value="Departure">Departure</option><option value="Checkout">Checkout</option></select><input type="hidden" name="TempTransport[TransportTravelType][]" value="" ></div></div>\n' +
            '<div class="col-md-3"> <div class="form-group mb-3"><label for="country">Transports</label> <select class="form-control validate[required]" id="TransportType" name="TransportType[]"> <option value="">Please Select  </option>' + Transports + ' </select><input type="hidden"  name="TempTransport[TransportType][]" value=""></div> </div>\n' +
            '<div class="col-md-3">  <div class="form-group mb-3"><label for="country">No Of Pax </label><input type="text" class="form-control validate[required ,funcCall[checknumberofpax]]"  name ="NoOfPax[]" id="NoOfPax_' + cnt + '" value ="' + CountPilgrim + '"><input type="hidden"  name="TempTransport[NoOfPax][]" value=""></div> </div>\n' +
            '<div class="col-md-3">  <div class="form-group mb-3"><label for="country">No Of Seats</label><input type="text" class="form-control validate[required,funcCall[checknumberofseats]]"  name ="NoOfSeats[]" id="NoOfSeats_' + cnt + '" value =""><input type="hidden"  name="TempTransport[NoOfSeats][]" value=""></div> </div>\n' +
            '<div class="col-md-2">  <div class="form-group mb-3"><input type ="hidden" name ="TransportsRates[]" id="TransportRateValue_' + cnt + '" value ="0"><input type="hidden"  name="TempTransport[TransportRates][]" value=""></div> </div>\n' +
            '<div class="col-md-3">  <div class="form-group mb-3"><label for="country"></label><input type="hidden" class="form-control validate[required]"  name ="TransportsBRN[]" id="TransportsBRN_' + cnt + '" value ="0"><input type="hidden"  name="TempTransport[TransportsBRN][]" value=""></div> </div>\n' +
            '<div class="col-md-1">  <label for="country"> </label> <br> <a name="removeButton" href="javascript:void(0);" onClick="RemoveTransportAttachmentRow(' + cnt + ')" id="removeButton" class="float-right" style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div> <div class = "col-md-12"><hr></div> </div>';
        DefaultScripts();
        return html;

    }

    function TransportRates(TransportID, cnt) {
        var PackagesUID = $("#PackageUID").val();
        response = AjaxResponse("html/GetTransportRatesByPackageID", "TransportID=" + TransportID + "&PackagesUID=" + PackagesUID);
        $("#TransportsRates_" + cnt).html(response.html);
        $("#TransportRateValue_" + cnt).val(response.rate);


    }

    function RemoveTransportAttachmentRow(cnt) {

        TransportAttachmentCount = parseInt($("#TransportAttachmentCount").val());
        $('#TransportAttachmentCount' + cnt).remove();
        $("#TransportAttachmentCount").val(TransportAttachmentCount - 1);
    }

    function LoadZiyaratByCites(city, cnt, selected) {
        ziarat = AjaxResponse("html/GetZiaratDropdownByCity", "city=" + city + "&selected=" + selected);
        $("#ZiyaratR  #ZiyaratAttachmentCount" + cnt + " select#Ziyarat" + cnt).html('<option value="">Ziyarat</option>' + ziarat.html);
        $("select#Ziyarat" + cnt).html(ziarat.html);
    }

    function RemoveZiyaratRow(cnt) {
        ZiyaratAttachmentCount = parseInt($("#ZiyaratAttachmentCount").val());
        $('#ZiyaratAttachmentCount' + cnt).remove();
        $("#ZiyaratAttachmentCount").val(ZiyaratAttachmentCount - 1);
    }


    function AddNewFlightAttachmentRow(type) {
        FlightAttachmentCount = parseInt($("#FlightAttachmentCount").val());
        // var ArrivalType = $("#ArrivalType").val();
        if (type == 'Air') {
            HTML = FlightAttachmentFormHTML(FlightAttachmentCount);
        } else if (type == 'Land') {
            HTML = LandAttachmentFormHTML(FlightAttachmentCount);
        }
        $("#FlightR").append(HTML);
        $("#FlightAttachmentCount").val(FlightAttachmentCount + 1);
        DefaultScripts();
        return false;
    }


    function AddNewFlightAttachmentRows(self) {
        FlightAttachmentCount = parseInt($("#FlightAttachmentCount").val());
        var type = $("#ArrivalType").val();
        if (type == 'Air') {
            HTML = FlightAttachmentFormHTML(FlightAttachmentCount, self);
            $("#FlightR").html(HTML);
        } else if (type == 'Land') {
            HTML = LandAttachmentFormHTML(FlightAttachmentCount, self);
            $("#FlightR").html(HTML);
        }
        //$("#FlightR").html(HTML);
        $("#FlightAttachmentCount").val(FlightAttachmentCount + 1);
        DefaultScripts();
        return false;
    }


    function LoadAgentGirdByAgentID(id) {
        PilgrimHtml = AjaxResponse("html/GetVoucherPilgrimGrid", "id=" + id + "&vid=<?=$VoucherData['UID']?>");

        $("#Pilgrim").html(PilgrimHtml.html);
        $("#ServicesGrid").html(PilgrimHtml.services_html);
        $("#ExportPackage").html(PilgrimHtml.export_button);
        // $("#AgentID").val(id);
        $("#PackageUID").val(PilgrimHtml.package_id);
        $("#VoucherCode").val(PilgrimHtml.VoucherCode);


    }


    function FlightAttachmentFormHTML(cnt, self) {
        cnt = cnt + 1;
        var html;
        var html2;
        var finalhtml;
        var mindate = $("#VoucherArrivalDate").val();
        var maxdate = $("#ReturnDate").val();

        html = '';

        if (self == 0) {
            html += '<div class="col-md-12"><hr data-content="Ticket" class="hr-text"></div>\n';

        } else {
            html += '<div class="col-md-12"><hr data-content="Self Ticket" class="hr-text"></div>\n';

        }
        html +=
            '        <input type="hidden" name="TravelSelf[]" value="' + self + '"><input type="hidden" id="Traveltype" name="Traveltype[]" value="Air"><div class="col-md-2">  <div class="form-group mb-3" style="text-align:center"> <?=$Departure?><input type="hidden" id="FlightType" name="FlightType[]" value="Departure"></div> </div>\n' +
            '        <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Sector<small id="coloredtext"> (From) </small></label>  <select class="form-control" id="SectorFrom' + cnt + '"  name="SectorFrom[]"> <option value="">Please Select</option> <?=$Airportshtml?> </select> </div> </div>\n' +
            '        <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Sector<small id="coloredtext"> (To) </small></label>  <select class="form-control" id="SectorTo' + cnt + '"  name="SectorTo[]"> <option value="">Please Select</option> <?=$Airportshtml?> </select> </div> </div>\n' +
            '        <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Airline</label>  <select class="form-control" id="Airline"  name="Airline[]"> <option value="">Please Select</option> <?=$AirLineshtml?> </select> </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Flight Number</label> <input type="text" class="form-control" id="Reference" name="Reference[]"  aria-describedby="emailHelp1"  placeholder="Flight Number">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">PNR</label> <input type="text" class="form-control" id="PNR" name="PNR[]" aria-describedby="emailHelp1"  placeholder="PNR"> </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Departure Date</label>  <input type="date" class="form-control validate[required,funcCall[checktraveldate]]"  id="DepartureDateDeparture" name="DepartureDate[]" min="' + mindate + '" max="' + maxdate + '" value="' + mindate + '"  aria-describedby="emailHelp1"  placeholder="Departure Date">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Departure Time</label> <input type="time" class="form-control" id="DepartureTime" name="DepartureTime[]" aria-describedby="emailHelp1" placeholder="Departure Time"> </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Arrival Date</label> <input type="date" class="form-control validate[required,funcCall[checktraveldate],funcCall[checktravelarrivaldate]]" id="ArrivalDate" name="ArrivalDate[]" min="' + mindate + '" max="' + maxdate + '" value="' + maxdate + '"  aria-describedby="emailHelp1" placeholder="Arrival Date">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Arrival Time</label> <input type="time" class="form-control" id="ArrivalTime" name="ArrivalTime[]" aria-describedby="emailHelp1" placeholder="Arrival Time"></div></div>\n' +
            '        <div class="col-md-1">  <label for="country"> </label> </div>' +
            '        <div class = "col-md-12"><hr></div>\n';

        html2 = '';

        if (self == 0) {
            html2 += '<div class="col-md-12"><hr data-content="Ticket" class="hr-text"></div>\n';

        } else {
            html2 += '<div class="col-md-12"><hr data-content="Self Ticket" class="hr-text"></div>\n';

        }
        html2 +=
            '        <input type="hidden" name="TravelSelf[]" value="' + self + '"><input type="hidden" id="Traveltype" name="Traveltype[]" value="Air"><div class="col-md-2">  <div class="form-group mb-3" style="text-align:center"> <?=$Arrival?> <input type="hidden" id="FlightType" name="FlightType[]" value="Return"> </div> </div>\n' +
            '        <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Sector<small id="coloredtext"> (From) </small></label>  <select class="form-control validate[required]" id="SectorFromReturn' + cnt + '"  name="SectorFrom[]"> <option value="">Please Select</option> <?=$Airportshtml?> </select> </div> </div>\n' +
            '        <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Sector<small id="coloredtext"> (To) </small></label>  <select class="form-control validate[required]" id="SectorToReturn' + cnt + '"  name="SectorTo[]"> <option value="">Please Select</option> <?=$Airportshtml?> </select> </div> </div>\n' +
            '        <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Airline</label>  <select class="form-control validate[required]" id="AirlineReturn"  name="Airline[]"> <option value="">Please Select</option> <?=$AirLineshtml?> </select> </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Flight Number</label> <input type="text" class="form-control  validate[required]" id="ReferenceReturn" name="Reference[]"  aria-describedby="emailHelp1"  placeholder="Flight Number">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">PNR</label> <input type="text" class="form-control validate[required]" id="PNRReturn" name="PNR[]" aria-describedby="emailHelp1"  placeholder="PNR"> </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Departure Date</label>  <input type="date" class="form-control validate[required,funcCall[checktraveldate]]"  id="DepartureDateReturn" name="DepartureDate[]" min="' + mindate + '" max="' + maxdate + '" value="' + mindate + '"  aria-describedby="emailHelp1"  placeholder="Departure Date">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Departure Time</label> <input type="time" class="form-control" id="DepartureTime" name="DepartureTime[]" aria-describedby="emailHelp1" placeholder="Departure Time"> </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Arrival Date</label> <input type="date" class="form-control validate[required,funcCall[checktraveldate],funcCall[checktravelreturndate]]" id="ArrivalDateReturn" name="ArrivalDate[]" min="' + mindate + '" max="' + maxdate + '" value="' + maxdate + '"  aria-describedby="emailHelp1" placeholder="Arrival Date">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Arrival Time</label> <input type="time" class="form-control" id="ArrivalTime" name="ArrivalTime[]" aria-describedby="emailHelp1" placeholder="Arrival Time"></div></div>\n' +
            '        <div class="col-md-1">  <label for="country"> </label> <br> <a name="removeButton" href="javascript:void(0);" onClick="RemoveFlightAttachmentRow(' + cnt + ')" id="removeButton" class="float-right" style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div>' +
            '        <div class = "col-md-12"><hr></div>\n';
        //'        <div class="col-md-1">  <label for="country"> </label> <br> <a name="removeButton" href="javascript:void(0);" onClick="RemoveFlightAttachmentRow(' + cnt + ')" id="removeButton" class="float-right" style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div> <div class = "col-md-12"><hr></div></div></div>\n';

        DefaultScripts();
        finalhtml = '<div class="row" id="FlightAttachmentCount' + cnt + '" name="FlightAttachmentCount">' + html + html2 + '</div>';
        return finalhtml;
    }

    function LandAttachmentFormHTML(cnt, self) {

        cnt = cnt + 1;
        var html = '';
        var html2 = '';
        var finalhtml;
        var mindate = $("#VoucherArrivalDate").val();
        var maxdate = $("#ReturnDate").val();

        if (self == 0) {
            html += '<div class="col-md-12"><hr data-content="Departure Ticket" class="hr-text"></div>\n';

        } else {
            html += '<div class="col-md-12"><hr data-content="Self Departure Ticket" class="hr-text"></div>\n';

        }
        html +=
            '        <input type="hidden" name="TravelSelf[]" value="' + self + '"><input type="hidden" id="Traveltype" name="Traveltype[]" value="Land"> \n' +
            '        <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Border Cities</label>  <select class="form-control" id="SectorFrom' + cnt + '"  name="SectorFrom[]"> <option value="">Please Select</option> <?=$landbordercitieshtml?> </select> </div> </div>\n' +
            '        <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Port</label>  <select class="form-control" id="SectorTo' + cnt + '"  name="SectorTo[]"> <option value="">Please Select</option> <?=$landbordershtml?> </select> </div> </div>\n' +
            '        <div class="col-md-3">  <div class="form-group mb-3"> <label for="country">Ref Number</label> <input type="text" class="form-control" id="Reference" name="Reference[]"  aria-describedby="emailHelp1"  placeholder="Ref Number">  </div> </div>\n' +
            '        <div class="col-md-3">  <div class="form-group mb-3"> <label for="country">PNR</label> <input type="text" class="form-control" id="PNR" name="PNR[]" aria-describedby="emailHelp1"  placeholder="PNR"> </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Departure Date</label>  <input type="date" class="form-control"  id="DepartureDate" name="DepartureDate[]" min="' + mindate + '" max="' + maxdate + '" value="' + mindate + '"  placeholder="Departure Date">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Departure Time</label> <input type="time" class="form-control" id="DepartureTime" name="DepartureTime[]" aria-describedby="emailHelp1" placeholder="Departure Time"> </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Arrival Date</label> <input type="date" class="form-control" id="ArrivalDate" name="ArrivalDate[]"  min="' + mindate + '" max="' + maxdate + '" value="' + maxdate + '" placeholder="Arrival Date">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Arrival Time</label> <input type="time" class="form-control" id="ArrivalTime" name="ArrivalTime[]" aria-describedby="emailHelp1" placeholder="Arrival Time"></div></div>\n' +
            '        <div class = "col-md-12"><hr></div>\n';

        if (self == 0) {
            html2 += '<div class="col-md-12"><hr data-content="Return Ticket" class="hr-text"></div>\n';

        } else {
            html2 += '<div class="col-md-12"><hr data-content="Self Return Ticket" class="hr-text"></div>\n';

        }

        html2 +=
            '        <input type="hidden" id="Traveltype" name="Traveltype[]" value="Land"> <input type="hidden" name="TravelSelf[]" value="' + self + '"><input type="hidden" name="FlightType[]" value="Return">\n' +
            '        <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Borders</label>  <select class="form-control validate[required]" id="SectorTo' + cnt + '"  name="SectorTo[]"> <option value="">Please Select</option> <?=$landbordershtml?> </select> </div> </div>\n' +
            '        <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Border Cities</label>  <select class="form-control validate[required]" id="SectorFrom' + cnt + '"  name="SectorFrom[]"> <option value="">Please Select</option> <?= $landbordercitieshtml ?> </select> </div> </div>\n' +
            '        <div class="col-md-3">  <div class="form-group mb-3"> <label for="country">Ref Number</label> <input type="text" class="form-control" id="Reference" name="Reference[]"  aria-describedby="emailHelp1"  placeholder="Ref Number">  </div> </div>\n' +
            '        <div class="col-md-3">  <div class="form-group mb-3"> <label for="country">PNR</label> <input type="text" class="form-control" id="PNR" name="PNR[]" aria-describedby="emailHelp1"  placeholder="PNR"> </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Departure Date</label>  <input type="date" class="form-control validate[required]"  id="DepartureDate" name="DepartureDate[]"  min="' + mindate + '" max="' + maxdate + '"  value="' + mindate + '" placeholder="Departure Date">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Departure Time</label> <input type="time" class="form-control validate[required]" id="DepartureTime" name="DepartureTime[]" aria-describedby="emailHelp1" placeholder="Departure Time"> </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Arrival Date</label> <input type="date" class="form-control validate[required]" id="ArrivalDate" name="ArrivalDate[]"  min="' + mindate + '" max="' + maxdate + '" value="' + maxdate + '" placeholder="Arrival Date">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Arrival Time</label> <input type="time" class="form-control validate[required]" id="ArrivalTime" name="ArrivalTime[]" aria-describedby="emailHelp1" placeholder="Arrival Time"></div></div>\n' +
            '        <div class="col-md-1">  <label for="country"> </label> <br> <a name="removeButton" href="javascript:void(0);" onClick="RemoveFlightAttachmentRow(' + cnt + ')" id="removeButton" class="float-right" style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div>' +
            '        <div class = "col-md-12"><hr></div>\n';

        DefaultScripts();
        finalhtml = '<div class="row" id="FlightAttachmentCount' + cnt + '" name="FlightAttachmentCount">' + html + html2 + '</div>';
        return finalhtml;
    }

    function RemoveFlightAttachmentRow(cnt) {

        FlightAttachmentCount = parseInt($("#FlightAttachmentCount").val());
        $('#FlightAttachmentCount' + cnt).remove();
        $("#FlightAttachmentCount").val(FlightAttachmentCount - 1);
    }


    function AddRequestestedAccomodationAttachmentRow() {
        /* if($('#accommodation_self').is(':checked')){
             AddSelfRequestestedAccomodationAttachmentRow();
             return true;
         }*/
        RequestedAccomodationCount = parseInt($("#RequestedAccomodationCount").val());
        HTML = RequstedAccomodationAttachmentFormHTML(RequestedAccomodationCount);
        $("#HotelR").append(HTML);
        $("#RequestedAccomodationCount").val(RequestedAccomodationCount + 1);

        CountryCode = $("#VoucherCountry").val();
        LoadCitiesDropdownHotel(CountryCode);

        DefaultScripts();
        return false;
    }


    function AddSelfRequestestedAccomodationAttachmentRow() {
        RequestedAccomodationCount = parseInt($("#RequestedAccomodationCount").val());


        HTML = RequstedSelfAccomodationAttachmentFormHTML(RequestedAccomodationCount);
        $("#HotelR").append(HTML);
        $("#RequestedAccomodationCount").val(RequestedAccomodationCount + 1);

        CountryCode = $("#VoucherCountry").val();
        LoadCitiesDropdownHotel(CountryCode);

        DefaultScripts();
        return false;
    }


    function RequstedAccomodationAttachmentFormHTML(cnt) {
        cnt = cnt + 1;
        var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;
        var html;
        BRN = '<?php echo GetVoucherBrnList(0, 'hotel', 0); ?>';
        var mindate = $("#VoucherArrivalDate").val();
        var maxdate = $("#ReturnDate").val();

        html = '<div class="row accomodationclass" id="RequestedAccomodationCount' + cnt + '">\n' +
            '<div class="col-md-12"><hr id="datacontent' + cnt + '" data-content="Package Hotel" class="hr-text"><input type="hidden" class="accommationnights" name="AccommationNights[]" id="AccommationNights' + cnt + '"></div>\n' +
            '<div class="col-md-2">  <div class="form-group mb-3"> <label for="country">City</label>  <input type="hidden" name="Self[' + cnt + ']" value="0"><input type="hidden" name="TempAccommodation[Self][]" value="0"><select class="form-control" id="City" onChange="LoadHotelByCites(this.value,' + cnt + ')"  name="City[' + cnt + ']">  </select><input type="hidden"  name="TempAccommodation[City][]" value=""> </div>  </div>\n' +
            '<div class="col-md-3">  <div class="form-group mb-3"> <label for="country">Hotel</label>  <select class="form-control" id="Hotels_' + cnt + '"  name="Hotels[' + cnt + ']">   </select><input type="hidden"  name="TempAccommodation[Hotels][]" value="">    </div> </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country">Check-In</label>   <input type="date" class="form-control validate[required,funcCall[checkindate]]" data-rowid="' + cnt + '" id="CheckIn' + cnt + '" name="CheckIn[' + cnt + ']"   aria-describedby="emailHelp1"  placeholder="Check In" min="' + mindate + '" max="' + maxdate + '" value="' + mindate + '"><input type="hidden"  name="TempAccommodation[CheckIn][]" value="">   </div>   </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country">Check-Out</label> <input type="date" class="form-control validate[required,funcCall[checkoutdate]]" id="CheckOut' + cnt + '"  name="CheckOut[' + cnt + ']"   aria-describedby="emailHelp1"  placeholder="Check Out" onchange="GetNoOfDaysRate(\'RequestedAccomodationCount' + cnt + '\',' + cnt + ',0)"; min="' + mindate + '" max="' + maxdate + '" value="' + maxdate + '"><input type="hidden"  name="TempAccommodation[CheckOut][]" value="">   </div>  </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country">BRN</label> <select class="form-control validate[required]"  id="AccommodationBRN_' + cnt + '"  name="AccommodationBRN[' + cnt + ']">' + BRN + '</select><input type="hidden"  name="TempAccommodation[AccommodationBRN][]" value="">   </div>  </div>\n' +
            '<div class="col-md-1">  <label for="country"><a name="removeButton" href="javascript:void(0);" onClick="RemoveRequstedAccomodationAttachmentRow(' + cnt + ')" id="removeButton" class="float-right" style="color: #dd0317;padding-left: 10px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></label><div class="form-group mb-3"></div></div>\n' +
            '<div class="col-md-12" id="RequestedAccomodationRoomType' + cnt + '">\n' +
            '<div class="row" id="RequestedAccomodationRoomTypeCount' + cnt + '_' + cnt + '">\n' +
            '<div class="col-md-3"><input type="hidden" name="AccomodationId[' + cnt + '][]" id="AccomodationId_' + cnt + '"> <div class="form-group mb-3">  <label for="country">Room Type</label>  <select class="form-control RoomTypeClass" id="RoomType_' + cnt + '_' + cnt + '"  name="RoomType[' + cnt + '][]" onchange="GetRoomRate(\'RequestedAccomodationCount' + cnt + '\',' + cnt + ',\'RequestedAccomodationRoomTypeCount' + cnt + '_' + cnt + '\',' + cnt + ');">   <option value="">Please Select</option>  <?=$RoomTypes?>  </select><input type="hidden"  name="TempAccommodation[RoomType][]" value="">  </div> </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country" id="noofroomsbeds' + cnt + '_' + cnt + '">No Of Beds</label> <input type="number" class="form-control NoOfBeds NoOfBedsClass validate[required,funcCall[checknumberofbeds]]" min="1" max="' + CountPilgrim + '" value="' + CountPilgrim + '" required="required" id="NoOfBeds_' + cnt + '_' + cnt + '"  name="NoOfBeds[' + cnt + '][]"  onchange="GetRoomRate(\'RequestedAccomodationCount' + cnt + '\',' + cnt + ',\'RequestedAccomodationRoomTypeCount' + cnt + '_' + cnt + '\',' + cnt + ');"  aria-describedby="emailHelp1"  placeholder="No Of Beds"><input type="hidden"  name="TempAccommodation[NoOfBeds][]" value="">   </div>  </div>\n' +
            '<div class="col-md-3">  <label for="country">Amount</label>  <div class="form-group mb-3"> <input type ="hidden" name ="AmountPayable[' + cnt + '][]" id="AmountPayableInput_' + cnt + '_' + cnt + '" value =""> <span class="AmountSpan" id="AmountPayable_' + cnt + '_' + cnt + '"  name="AmountPayable[]"></span><input type="hidden" name="TempAccommodation[AmountPayable][]" value="">  </div>  </div>\n' +
            '<div class="col-md-1 pt-3" id="AddRoomType' + cnt + '">  <label for="country"> </label> </br> <a name="removeButton" href="javascript:void(0);"  id="removeButton" onclick="AddRequestestedAccomodationRoomTypeRow(' + cnt + ',' + cnt + ');"><span> <i class="fa fa-plus" title="Add"></i></a></div> \n' +
            '</div>\n' +
            '</div>\n' +
            '<div class="col-md-12"> <hr> </div>  </div>  </div> \n' +
            '</div> ';
        DefaultScripts();
        return html;

    }

    function RequstedSelfAccomodationAttachmentFormHTML(cnt) {
        cnt = cnt + 1;
        var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;
        var html;
        var mindate = $("#VoucherArrivalDate").val();
        var maxdate = $("#ReturnDate").val();

        html = '<div class="row accomodationclass" id="RequestedAccomodationCount' + cnt + '">\n' +
            '<div class="col-md-12"><hr id="datacontent' + cnt + '" data-content="Self Hotel" class="hr-text"><input type="hidden" class="accommationnights" name="AccommationNights[]" id="AccommationNights' + cnt + '"></div>\n' +
            '<div class="col-md-2">  <div class="form-group mb-3"> <label for="country">City</label>  <input type="hidden" name="Self[' + cnt + ']" value="1"><input type="hidden" name="TempAccommodation[Self][]" value="1"><select class="form-control" id="City" onChange="LoadSelfHotelByCites(this.value,' + cnt + ')"  name="City[' + cnt + ']">  </select><input type="hidden"  name="TempAccommodation[City][]" value=""> </div>  </div>\n' +
            '<div class="col-md-3">  <div class="form-group mb-3"> <label for="country">Hotel</label>  <select class="form-control" id="Hotels_' + cnt + '"  name="Hotels[' + cnt + ']" onchange="GetHotelName(this.value,' + cnt + ');">   </select><input type="hidden"  name="TempAccommodation[Hotels][]" value="">    </div> </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country">Check-In</label>   <input type="date" class="form-control  validate[required,funcCall[checkindate]]" data-rowid="' + cnt + '" id="CheckIn' + cnt + '" name="CheckIn[' + cnt + ']" min="' + mindate + '" max="' + maxdate + '" value="' + mindate + '"   aria-describedby="emailHelp1"  placeholder="Check Out"><input type="hidden"  name="TempAccommodation[CheckIn][]" value="">   </div>   </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country">Check-Out</label> <input type="date" class="form-control validate[required,funcCall[checkoutdate]]" id="CheckOut' + cnt + '"  name="CheckOut[' + cnt + ']" min="' + mindate + '" max="' + maxdate + '" value="' + maxdate + '"   aria-describedby="emailHelp1"  placeholder="Check Out" onchange="GetNoOfDaysRate(\'RequestedAccomodationCount' + cnt + '\',' + cnt + ',1)";><input type="hidden"  name="TempAccommodation[CheckOut][]" value="">   </div>  </div>\n' +
            '<div class="col-md-1">  <label for="country"><a name="removeButton" href="javascript:void(0);" onClick="RemoveRequstedAccomodationAttachmentRow(' + cnt + ')" id="removeButton" class="float-right" style="color: #dd0317;padding-left: 10px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></label><div class="form-group mb-3"></div></div>\n' +
            '<div class="col-md-12" id="RequestedAccomodationRoomType' + cnt + '">\n' +
            '<div class="row" id="RequestedAccomodationRoomTypeCount' + cnt + '_' + cnt + '">\n' +
            '<div class="col-md-3"><input type="hidden" name="AccomodationId[' + cnt + '][]" id="AccomodationId_' + cnt + '"> <div class="form-group mb-3">  <label for="country">Room Type</label>  <select class="form-control RoomTypeClass" id="RoomType_' + cnt + '_' + cnt + '"  name="RoomType[' + cnt + '][]">   <option value="">Please Select</option>  <?=$RoomTypes?>  </select><input type="hidden"  name="TempAccommodation[RoomType][]" value="">  </div> </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country" id="noofroomsbeds' + cnt + '_' + cnt + '">No Of Beds</label> <input type="number" class="form-control NoOfBeds NoOfBedsClass validate[required,funcCall[checknumberofbeds]]" min="1" max="' + CountPilgrim + '" value="' + CountPilgrim + '" required="required" id="NoOfBeds_' + cnt + '_' + cnt + '"  name="NoOfBeds[' + cnt + '][]"   aria-describedby="emailHelp1"  placeholder="No Of Beds"><input type="hidden"  name="TempAccommodation[NoOfBeds][]" value="">   </div>  </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country"></label><input type ="hidden" name ="AmountPayable[' + cnt + '][]" id="AmountPayableInput_' + cnt + '_' + cnt + '" value =""><input type="hidden" name="TempAccommodation[AmountPayable][]" value=""> <input type="hidden" class="form-control validate[required]" id="AccommodationBRN_' + cnt + '"  name="AccommodationBRN[]" aria-describedby="emailHelp1"  placeholder="BRN"><input type="hidden"  name="TempAccommodation[AccommodationBRN][]" value="">    </div>  </div>\n' +
            '<div class="col-md-1 pt-3" id="AddRoomType' + cnt + '">  <label for="country"> </label> </br> <a name="removeButton" href="javascript:void(0);"  id="removeButton" onclick="AddSelfRequestestedAccomodationRoomTypeRow(' + cnt + ',' + cnt + ');"><span> <i class="fa fa-plus" title="Add"></i></a></div> \n' +
            '</div>\n' +
            '</div>\n' +
            '<div class="col-md-12"> <hr> </div>  </div>  </div> \n' +
            '</div> ';
        DefaultScripts();
        return html;

    }

    function AddRequestestedAccomodationRoomTypeRow(cnt, count) {
        count = count + 1;
        var html;
        html = '<div class="row" id="RequestedAccomodationRoomTypeCount' + cnt + '_' + count + '">\n' +
            '<div class="col-md-3"> <input type ="hidden" name ="AccomodationId[' + cnt + '][]" id="AccomodationId_' + cnt + '_' + count + '"><div class="form-group mb-3">  <label for="country">Room Type</label>  <select class="form-control RoomTypeClass RoomType' + cnt + ' validate[required]" id="RoomType_' + cnt + '_' + count + '"  name="RoomType[' + cnt + '][]" onchange="GetRoomRate(\'RequestedAccomodationCount' + cnt + '\',' + cnt + ',\'RequestedAccomodationRoomTypeCount' + cnt + '_' + count + '\',' + count + ');">   <option value="">Please Select</option><?=$RoomTypes?></select>  </div> </div>\n' +
            '<div class="col-md-2">  <div class="form-group mb-3">  <label for="country" id="noofroomsbeds' + cnt + '_' + count + '">No Of Beds</label> <input type="number" class="form-control NoOfBeds' + cnt + ' NoOfBedsClass validate[required,funcCall[checknumberofbeds]]" min="1"  id="NoOfBeds_' + cnt + '_' + count + '"  name="NoOfBeds[' + cnt + '][]"  aria-describedby="emailHelp1"  placeholder="No Of Beds" oninput="GetRoomRate(\'RequestedAccomodationCount' + cnt + '\',' + cnt + ',\'RequestedAccomodationRoomTypeCount' + cnt + '_' + count + '\',' + count + ');">   </div>  </div>\n' +
            '<div class="col-md-3">  <label for="country">Amount</label>  <div class="form-group mb-3"> <input type ="hidden" name ="AmountPayable[' + cnt + '][]" id="AmountPayableInput_' + cnt + '_' + count + '" class="AmountPayable' + cnt + '"> <span class="AmountSpan AmountSpan' + cnt + '" id="AmountPayable_' + cnt + '_' + count + '"></span>  </div>  </div>\n' +
            '<div class="col-md-1 pt-3">  <label for="country"> </label> </br> <a name="removeButton" href="javascript:void(0);"  id="removeButton" onclick="RemoveNewAccomodationsRoomTypeRow(\'RequestedAccomodationRoomTypeCount' + cnt + '_' + count + '\');"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div>\n' +


            '</div>';
        $("#RequestedAccomodationRoomType" + cnt).append(html);
        $("#AddRoomType" + cnt).html('<label for="country"> </label> </br> <a name="removeButton" href="javascript:void(0);"  id="removeButton" onclick="AddRequestestedAccomodationRoomTypeRow(' + cnt + ',' + count + ');"><span> <i class="fa fa-plus" title="Add"></i></a>');
    }

    function AddSelfRequestestedAccomodationRoomTypeRow(cnt, count) {
        count = count + 1;
        var html;
        html = '<div class="row" id="RequestedAccomodationRoomTypeCount' + cnt + '_' + count + '">\n' +
            '<div class="col-md-3"> <input type ="hidden" name ="AccomodationId[' + cnt + '][]" id="AccomodationId_' + cnt + '_' + count + '"><div class="form-group mb-3">  <label for="country">Room Type</label>  <select class="form-control RoomTypeClass RoomType' + cnt + ' validate[required]" id="RoomType_' + cnt + '_' + count + '"  name="RoomType[' + cnt + '][]" onchange="GetRoomRate(\'RequestedAccomodationCount' + cnt + '\',' + cnt + ',\'RequestedAccomodationRoomTypeCount' + cnt + '_' + count + '\',' + count + ');">   <option value="">Please Select</option><?=$RoomTypes?></select>  </div> </div>\n' +
            '<div class="col-md-2">  <div class="form-group mb-3">  <label for="country" id="noofroomsbeds' + cnt + '_' + count + '">No Of Beds</label> <input type="number" class="form-control NoOfBeds' + cnt + ' NoOfBedsClass validate[required,funcCall[checknumberofbeds]]" min="1"  id="NoOfBeds_' + cnt + '_' + count + '"  name="NoOfBeds[' + cnt + '][]"  aria-describedby="emailHelp1"  placeholder="No Of Beds" oninput="GetRoomRate(\'RequestedAccomodationCount' + cnt + '\',' + cnt + ',\'RequestedAccomodationRoomTypeCount' + cnt + '_' + count + '\',' + count + ');">   </div>  </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country"></label><input type ="hidden" name ="AmountPayable[' + cnt + '][]" id="AmountPayableInput_' + cnt + '_' + cnt + '" value =""><input type="hidden" name="TempAccommodation[AmountPayable][]" value=""> <input type="hidden" class="form-control validate[required]" id="AccommodationBRN_' + cnt + '"  name="AccommodationBRN[]" aria-describedby="emailHelp1"  placeholder="BRN"><input type="hidden"  name="TempAccommodation[AccommodationBRN][]" value="">    </div>  </div>\n' +
            '<div class="col-md-1 pt-3">  <label for="country"> </label> </br> <a name="removeButton" href="javascript:void(0);"  id="removeButton" onclick="RemoveNewAccomodationsRoomTypeRow(\'RequestedAccomodationRoomTypeCount' + cnt + '_' + count + '\');"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div>\n' +


            '</div>';
        $("#RequestedAccomodationRoomType" + cnt).append(html);
        $("#AddRoomType" + cnt).html('<label for="country"> </label> </br> <a name="removeButton" href="javascript:void(0);"  id="removeButton" onclick="AddSelfRequestestedAccomodationRoomTypeRow(' + cnt + ',' + count + ');"><span> <i class="fa fa-plus" title="Add"></i></a>');
    }

    function RemoveAllAccomodationsRow(RequestedAccomodationCount, VoucherID, City, Hotel, CheckIn, CheckOut, AccommodationBRN) {
        if (confirm("Are You Want To Remove This Row?")) {
            $("input#dlt_accomodation_" + VoucherID + "_" + City + "_" + Hotel + "_" + CheckIn + "_" + CheckOut + "_" + AccommodationBRN + "").val(1);
            $('#' + RequestedAccomodationCount).remove();
        }

        /*if (confirm("Are You Want To Remove This Row?")) {
            response = AjaxResponse("form_process/remove_accomodations_attachments_all_row", "VoucherID=" + VoucherID + "&City=" + City + "&Hotel=" + Hotel + "&CheckIn=" + CheckIn + "&CheckOut=" + CheckOut + "&AccommodationBRN=" + AccommodationBRN);
            if (response.status == 'success') {
                $('#' + RequestedAccomodationCount).remove();
            }
        }*/
    }

    function RemoveAccomodationsRoomTypeRow(RequestedAccomodationRoomTypeCount, UID) {
        if (confirm("Are You Want To Remove This Row?")) {
            $("input#dlt_accomodation_room_type_" + UID + "").val(1);
            $('#' + RequestedAccomodationRoomTypeCount).remove();
        }

        /*if (confirm("Are You Want To Remove This Row?")) {
            response = AjaxResponse("form_process/remove_accomodations_attachments_row", "UID=" + UID);
            if (response.status == 'success') {
                $('#' + RequestedAccomodationRoomTypeCount).remove();
            }
        }*/
    }

    function RemoveNewAccomodationsRoomTypeRow(RequestedAccomodationRoomTypeCount) {
        $('#' + RequestedAccomodationRoomTypeCount).remove();
    }

    function RemoveRequstedAccomodationAttachmentRow(cnt) {

        RequestedAccomodationCount = parseInt($("#RequestedAccomodationCount").val());
        $('#RequestedAccomodationCount' + cnt).remove();
        $("#RequestedAccomodationCount").val(RequestedAccomodationCount - 1);
    }


    function VoucherFormSubmit() {

        var validate = $("form#VoucherAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        PlzWait('show');
        var FinishButton = $('ul[aria-label=Pagination]').children().find('a');
        $(FinishButton).each(function () {
            if ($(this).text() == 'Finish') {
                $(this).css('background', '#c82333');
                $(this).html('Plz Wait....');
                $(this).attr("disabled", true);
                $("a[href$='previous']").hide();
            }
        });

        var phpdata = new window.FormData($("form#VoucherAddForm")[0]);
        var response = AjaxUploadResponse("form_process/voucher_form_submit", phpdata);

        if (response.status == 'success') {
            GridMessages('VoucherAddForm', 'VoucherAddResponse', 'alert-success', response.message, 4000);
            $("a[href$='finish']").hide();
            setTimeout(function () {
                location.href = "<?=base_url('agent/all_voucher')?>";
                PlzWait('hide');
            }, 2000);
        } else {
            GridMessages('VoucherAddForm', 'VoucherAddResponse', 'alert-danger', response.message, 4000);
            PlzWait('hide');

            var FinishButton = $('ul[aria-label=Pagination]').children().find('a');
            $(FinishButton).each(function () {
                if ($(this).text() == 'Plz Wait....') {
                    $(this).css('background', '#515365');
                    $(this).html('Finish');
                    $(this).attr('disabled', false);

                    $("a[href$='previous']").show();
                }
            });
        }

    }

    function LoadCitiesDropdownHotel(country) {
        cnt = parseInt($("#RequestedAccomodationCount").val());

        if (CitiesHTML == '') {
            cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + CountryCode);
            CitiesHTML = cities.html;
        }

        // cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country + "&selected=");
        //Ziyaratcities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country + "&selected=");
        $("#RequestedAccomodationCount" + cnt + " #City").html('<option value="">Please Select</option>' + CitiesHTML);
        //$("#RequestedAccomodationDetails #Cities").html('<option value="">Please Select</option>' + CitiesHTML);
        DefaultScripts();
    }

    function LoadCitiesDropdownagain(country) {
        cnt = parseInt($("#RequestedAccomodationCount").val());
        if (CitiesHTML == '') {
            cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + CountryCode);
            CitiesHTML = cities.html;
        }

        // cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country + "&selected=");
        //Ziyaratcities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country + "&selected=");
        $("#RequestedAccomodationCount" + cnt + " #City").html('<option value="">Please Select</option>' + CitiesHTML);
        //$("#RequestedAccomodationDetails #Cities").html('<option value="">Please Select</option>' + CitiesHTML);
        //$("#RequestedAccomodationDetails #Cities").val(<?=$VoucherAccommmodationData['City']?>);

        $("#ZiyaratR #Cities").html('<option value="">Please Select</option>' + CitiesHTML);
        $("#ZiyaratR #Cities").val(<?=$voucherZiyaratDetail['ZiyaratCity']?>);

        DefaultScripts();
    }

    //function LoadHotelByCites(city, cnt) {
    //    hotels = AjaxResponse("html/GetHotelDropdownByCity", "city=" + city + "&selected=<?//=$VoucherAccommmodationData['Hotel']?>//");
    //    $("#Hotels_" + cnt).html('<option value="">Please Select</option>' + hotels.html);
    //    $("#Hotel_" + cnt).html('<option value="">Please Select</option>' + hotels.html);
    //    DefaultScripts();
    //}


    function LoadHotelByCites(city, cnt) {
        var PackagesUID = $("#PackageUID").val();
        hotels = AjaxResponse("html/GetHotelDropdownByCityByPackageId", "city=" + city + "&PackagesUID=" + PackagesUID);
        // $("#Hotels_" + cnt).html('<option value="">Please Select</option>' + hotels.html);
        $("#Hotels_" + cnt).html(hotels.html);
        DefaultScripts();
    }

    function LoadHotelsByCites(city, cnt, selected) {
        var PackagesUID = $("#PackageUID").val();
        hotels = AjaxResponse("html/GetHotelDropdownByCityByPackageId", "city=" + city + "&PackagesUID=" + PackagesUID + "&selected=" + selected);
        // $("#Hotels_" + cnt).html('<option value="">Please Select</option>' + hotels.html);
        $("#Hotels_" + cnt).html(hotels.html);
        DefaultScripts();
    }

    function LoadSelfHotelByCites(city, cnt) {
        hotels = AjaxResponse("html/GetSelfHotelDropdownByCity", "city=" + city + "&selected=<?=$VoucherAccommmodationData['Hotel']?>");
        //$("#Hotels_" + cnt).html(hotels.html);
        $("#Hotels_" + cnt).html(hotels.html);
        DefaultScripts();
    }


    function LoadSelfHotelsByCites(city, cnt, selected) {
        hotels = AjaxResponse("html/GetSelfHotelDropdownByCity", "city=" + city + "&selected=" + selected);
        $("#Hotels_" + cnt).html(hotels.html);
        //$("#Hotels_"+cnt).html(hotels.html);
        DefaultScripts();
    }

    function RoomtypeSelect(roomtype) {
        var AgentID = $("#AgentID").val();
        var HotelID = $("#Hotels").val();
        response = AjaxResponse("form_process/GetRoomTypePackageForVoucher", "roomtype=" + roomtype + "&AgentID=" + AgentID + "&HotelID=" + HotelID);
        if (response.status == 'success') {
            $("#AmountPayable").html(response.CurrentCharges)

        }
    }

    function GetRoomRate(parent, cnt, childparent, count) {
        var CheckIn = $("#CheckIn" + cnt).val();
        var CheckOut = $("#CheckOut" + cnt).val();
        var AgentID = $("#VoucherAddForm #AgentID").val();
        var HotelID = $("#" + parent + " #Hotels_" + cnt).val();
        /* var RoomType = $("#" + parent + " #RoomType").val();
         var RoomTypeName =$( "#" + parent + " #RoomType option:selected" ).text();
         if(RoomTypeName=='Sharing'){
             $('#noofroomsbeds' + cnt).text("No Of Beds");
         }else{
             $('#noofroomsbeds' + cnt).text("No Of Rooms");
         }*/
        var RoomType = $("#" + parent + " #" + childparent + " #RoomType_" + cnt + "_" + count).val();
        var RoomTypeName = $("#RoomType_" + cnt + "_" + count + " option:selected").text();
//alert(RoomTypeName);
        if (RoomTypeName == 'Sharing') {

            $('#noofroomsbeds' + cnt + "_" + count).text("No Of Beds");
        } else {

            $('#noofroomsbeds' + cnt + "_" + count).text("No Of Rooms");
        }
        // var CheckIn = $("#" + parent + " #CheckIn").val();
        // var CheckOut = $("#" + parent + " #CheckOut").val();
        //var NoOfBeds = $("#VoucherAddForm  #NoOfBeds_" + cnt).val(); // alert("#VoucherAddForm  #NoOfBeds_" + cnt);
        var NoOfBeds = $("#" + parent + " #" + childparent + " #NoOfBeds_" + cnt + "_" + count).val();
        response = AjaxResponse("form_process/GetRoomTypePackageForVoucher", "RoomType=" + RoomType + "&AgentID=" + AgentID + "&HotelID=" + HotelID + "&CheckIn=" + CheckIn + "&CheckOut=" + CheckOut + "&NoOfBeds=" + NoOfBeds);
        if (response.status == 'success') {
            $("#AmountPayable_" + cnt + "_" + count).html(response.CurrentCharges)
            $("#AmountPayableInput_" + cnt + "_" + count).val(response.CurrentChargesValue)

        }
    }


    function RemoveFlightRow(UID, cnt) {

        if (confirm("Are You Want To Remove This Row?")) {
            $("input#dlt_flight_" + UID).val(1);
            $('#FlightAttachmentCount' + cnt).remove();
        }
        /*if (confirm("Are You Want To Remove This Row?")) {
            response = AjaxResponse("form_process/remove_travel_attachments_row", "UID=" + UID);
            if (response.status == 'success') {
                $('#FlightAttachmentCount' + cnt).remove();
            }
        }*/
    }

    function RemoveTransportRow(UID, cnt) {

        if (confirm("Are You Want To Remove This Row?")) {
            $("input#dlt_transport_" + UID).val(1);
            $('#TransportAttachmentCount' + cnt).remove();
        }
        /*if (confirm("Are You Want To Remove This Row?")) {
            response = AjaxResponse("form_process/remove_transport_attachments_row", "UID=" + UID);
            if (response.status == 'success') {
                $('#TransportAttachmentCount' + cnt).remove();
            }
        }*/
    }

    function RemoveAccomodationRow(UID, cnt) {

        if (confirm("Are You Want To Remove This Row?")) {
            response = AjaxResponse("form_process/remove_accomodation_attachments_row", "UID=" + UID);
            if (response.status == 'success') {
                $('#RequestedAccomodationCount' + cnt).remove();
            }
        }
    }

    function RemoveZiyarats(UID, cnt) {

        if (confirm("Are You Want To Remove This Row?")) {
            $("input#dlt_ziyarat_" + UID).val(1);
            $('#ZiyaratAttachmentCounts' + cnt).remove();
        }
        /*if (confirm("Are You Want To Remove This Row?")) {
            response = AjaxResponse("form_process/remove_ziyarat_attachments_row", "UID=" + UID);
            if (response.status == 'success') {
                $('#ZiyaratAttachmentCounts' + cnt).remove();
            }
        }*/
    }

    setTimeout(function () {

        //LoadAgentGirdByAgentID(<?=$VoucherData['AgentUID']?>);
        LoadCitiesDropdownagain('<?=$VoucherData['Country']?>');
        <?=$JSCODE?>
        //AddNewFlightAttachmentRow();
        // GetRoomRate();
        //LoadAgentGirdByAgentID(<?//=$session['id']?>//);
        // var ArrivalType = $("#ArrivalType").val();
        //AddTransportAttachmentRow();
        //AddNewZiyarat();
        // LoadAgentGirdByAgentID();
        //AddRequestestedAccomodationAttachmentRow();
        //    LoadHotelByCites('<?=$VoucherAccommmodationData['City']?>');
        //  LoadZiyaratByCites('<?//=$voucherZiyaratDetail['ZiyaratCity']?>//');
        // alert( localStorage.getItem('CountryCode') );
        //alert(countrycode);

    }, 5000)

</script>
<script src="<?= $template ?>plugins/jquery-step/jquery.steps.min.js"></script>

<script>
    $("#VoucherSection").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: true,
        cssClass: 'pill wizard',
        onStepChanging: function (event, currentIndex, newIndex) {

            if (newIndex == 1) {
                LoadAgentGirdByAgentID(<?=$VoucherData['AgentUID']?>);
            } else if (newIndex == 3) {
                <?=$HotelByCitiesJSCode?>
            } else if (newIndex == 5) {
                <?=$ZiaratByCitiesJSCode?>
            }

            return VoucherValidation(currentIndex, newIndex);

        },
        onFinished: function (event, currentIndex) {
            VoucherFormSubmit();
        }
    });

    function ApplyPilramValidation() {
        var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;
        //alert("Total P:" + CountPilgrim);
        RequestedAccomodationCount = $("#RequestedAccomodationCount").val();
        for (a = 1; a <= RequestedAccomodationCount; a++) {
            //$("#RequestedAccomodationCount" + a + " #NoOfBeds_" + a).addClass('validate[required, custom[max[' + CountPilgrim + ']]]');
            //$("#RequestedAccomodationCount" + a + " #NoOfBeds_" + a).attr('data-errormessage', 'Please fill value upto ' + CountPilgrim);
            $("#RequestedAccomodationCount" + a + " #NoOfBeds_" + a).attr('min', 1);
            $("#RequestedAccomodationCount" + a + " #NoOfBeds_" + a).attr('max', CountPilgrim);
            $("#RequestedAccomodationCount" + a + " #NoOfBeds_" + a).attr('required', 'required');
        }

        $("form#VoucherAddForm").validationEngine('hideAll');
    }

    function ValidateAccomodationForm() {
        var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;
        var chk = 0;
        /* $("#RequestedAccomodationDetails input.NoOfBeds").each(function (obj) {
             inputid = $(this).attr('id');
             inputvalue = this.value;
             if (parstInt(inputvalue) > parstInt(CountPilgrim) || parstInt(inputvalue) < 1) {

                 $("#RequestedAccomodationDetails #" + inputid).css('background-color', 'rgb(255,0,0,.2)');
                 chk = 1;

             } else {
                 $("#RequestedAccomodationDetails #" + inputid).css('background-color', 'transparent');

             }


         });*/

        $('.accomodationclass').each(function (i, obj) {
            var RequestedAccomodationCountid = $(this).attr('id');
            ///selected option text
            var totelTypes = $('#' + RequestedAccomodationCountid + ' .RoomTypeClass').length;
            var total_beds = 0;
            for (var a = 0; a < totelTypes; a++) {

                var NoofBed = $('#' + RequestedAccomodationCountid + ' .NoOfBedsClass:eq(' + a + ')').val();
                var RoomType = $('#' + RequestedAccomodationCountid + ' .RoomTypeClass:eq(' + a + ') option:selected').text();
                console.log(RequestedAccomodationCountid);
                //console.log("A = " + a);
                //console.log("Input " + a + " = " + NoofBed);
                //console.log("Select " + a + " = " + RoomType);
                if (RoomType == 'Double Bed') {
                    total_beds += parseInt(NoofBed) * 2;
                } else if (RoomType == 'Quad Bed') {
                    total_beds += parseInt(NoofBed) * 4;
                } else if (RoomType == 'Quint Bed') {
                    total_beds += parseInt(NoofBed) * 5;
                } else if (RoomType == 'Sharing') {
                    total_beds += parseInt(NoofBed) * 1;
                } else if (RoomType == 'Single Bed') {
                    total_beds += parseInt(NoofBed) * 1;
                } else if (RoomType == 'Triple Bed') {
                    total_beds += parseInt(NoofBed) * 3;
                }
            }

            if( parseInt(CountPilgrim) > 1 ){

                if (total_beds > CountPilgrim) {
                    chk = 1;
                    $('#' + RequestedAccomodationCountid).css('background-color', '#FFB0CA');
                    return false;
                } else {
                    chk = 0;
                    $('#' + RequestedAccomodationCountid).css('background-color', 'white');
                    return true;
                }

            }else{

                chk = 0;
                $('#' + RequestedAccomodationCountid).css('background-color', 'white');
                return true;
            }

            // var RoomType = $('#' + RequestedAccomodationCountid + ' .RoomTypeClass option:nth-child(2)').text();
            // //Get a value by class
            // console.log(RequestedAccomodationCountid);
            // console.log(RoomType);
            // $('#' + RequestedAccomodationCountid + ' .NoOfBedsClass').each(function (obj) {
            //     var NoOfBeds = $(this).val();
            //     console.log(NoOfBeds);
            // });

        });

        if (chk == 1) {
            return false;
        } else {
            return true;
        }

    }

    function VoucherValidation(currentIndex, newIndex) {
        //alert("Current: " + currentIndex + " | New: " + newIndex);
        if (newIndex < currentIndex) {
            $("form#VoucherAddForm").validationEngine('hideAll');
            return true;
        }

        var validate = $("form#VoucherAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        //alert("Current: " + currentIndex + " | New: " + newIndex);
        //$("form#VoucherAddForm").validationEngine('hideAll');
        if (currentIndex == 1 && newIndex == 2) {
            ////// Pilrim  to Travel
            var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;
            if (CountPilgrim > 0) {

                return true;
            } else {
                return false;
            }
        } else if (currentIndex == 2 && newIndex == 3) {
            ////// travel to Accomodation
            ApplyPilramValidation();
        } else if (currentIndex == 3 && newIndex == 4) {
            ////// Accomodation to transport
            var startDay = new Date($("#VoucherArrivalDate").val());
            var endDay = new Date($("#ReturnDate").val());
            var millisBetween = endDay.getTime() - startDay.getTime();
            var days = millisBetween / (1000 * 3600 * 24);

            if (parseInt($('#totalaccomodationnightsvalue').val()) > parseInt(days)) {
                //alert('AAA');
                //return false;
            }
            return ValidateAccomodationForm();
        } else if (currentIndex == 6 && newIndex == 7) {
            VoucherFormSummary();
        } else {
            /*var validate = $("form#VoucherAddForm").validationEngine('validate');
            if (validate == false) {
                return false;
            }*/
        }
        return true;

    }

    function VoucherFormSummary() {

        var phpdata = $("form#VoucherAddForm").serialize();
        response = AjaxRequest("form_process/voucher_form_submmary", phpdata, "SummaryGrid");


    }

    function GetHotelName(hotel, hotelindex) {
        if (hotel == 'Other') {

            $("#AccomodationCity").val($("#RequestedAccomodationCount" + hotelindex + " #City").val());
            $("#Accomodationcnt").val(hotelindex);
            LoadModal('package/hotel/self_main_form', 0, 'modal-xl');

        }


    }

    $("form#HotelAddForm").on("submit", function (event) {
        event.preventDefault();
    });

    function HotelFormSubmit() {

        var validate = $("form#HotelAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        var phpdata = new window.FormData($("form#HotelAddForm")[0]);
        response = AjaxUploadResponse("form_process/self_hotel_form_submit", phpdata);

        if (response.status == 'success') {
            $("#HotelAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            LoadSelfHotelByCites($("#AccomodationCity").val(), $("#Accomodationcnt").val());
            //alert("#RequestedAccomodationCount"+$("#Accomodationcnt").val());
            //alert("#Hotel_"+$("#Accomodationcnt").val());
            //alert(response.record_id);
            $("#RequestedAccomodationCount" + $("#Accomodationcnt").val() + " " + "#Hotel_" + $("#Accomodationcnt").val()).val(response.record_id).select2();
            $('#MainForm').modal('hide');
            $('#HotelAddForm')[0].reset();
            /*setTimeout(function () {
                location.href = "<?=base_url('package/hotel')?>";
            }, 2000)*/
        } else {
            $("#HotelAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }

    //,funcCall[checktraveldate]
    function checktraveldate(field, rules, i, options) {
        //var match = field.val().match(dateFormat)
        //console.log(match)


        if (Date.parse(field.val()) < Date.parse($("#VoucherArrivalDate").val()) || Date.parse(field.val()) > Date.parse($("#ReturnDate").val()))
            return "Please enter date between " + $("#VoucherArrivalDate").val() + " and " + $("#ReturnDate").val()

    }

    function checktravelarrivaldate(field, rules, i, options) {

        if (Date.parse(field.val()) < Date.parse($("#DepartureDateDeparture").val())) return "Please enter date greater than or equal to " + $("#DepartureDateDeparture").val()

    }

    function checktravelreturndate(field, rules, i, options) {

        if (Date.parse(field.val()) < Date.parse($("#DepartureDateReturn").val())) return "Please enter date greater than or equal to " + field.val()

    }


    function checkindate(field, rules, i, options) {
        var rowid = field.data('rowid');
        var checkoutid = '#RequestedAccomodationCount' + rowid + ' #CheckOut' + rowid;
        if (Date.parse(field.val()) < Date.parse($("#VoucherArrivalDate").val()) || Date.parse(field.val()) > Date.parse($("#ReturnDate").val())) return "Please enter date between " + $("#VoucherArrivalDate").val() + " and " + $("#ReturnDate").val()
        $(checkoutid).attr('min', field.val());
    }

    function checkoutdate(field, rules, i, options) {
        if (Date.parse(field.val()) < Date.parse($("#VoucherArrivalDate").val()) || Date.parse(field.val()) > Date.parse($("#ReturnDate").val())) return "Please enter date between " + $("#VoucherArrivalDate").val() + " and " + $("#ReturnDate").val()
    }

    function checknumberofbeds(field, rules, i, options) {
        var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;
        //if (parseInt(field.val()) > parseInt(CountPilgrim) || parseInt(field.val()) < 1) return "Please enter No Of Beds upto " + CountPilgrim
    }

    function checknumberofpax(field, rules, i, options) {
        var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;
        if (parseInt(field.val()) > parseInt(CountPilgrim) || parseInt(field.val()) < 1) return "Please enter No Of Pax upto " + CountPilgrim
    }

    function checknumberofseats(field, rules, i, options) {
        var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;
        if (parseInt(field.val()) > parseInt(CountPilgrim) || parseInt(field.val()) < 1) return "Please enter No Of Seats upto " + CountPilgrim
    }

    function transporttraveldate(field, rules, i, options) {
        var rowid = field.data('rowid');
        var checkoutid = '#TransportAttachmentCount' + rowid + ' #TravelDate' + rowid;
        if (Date.parse(field.val()) < Date.parse($("#VoucherArrivalDate").val()) || Date.parse(field.val()) > Date.parse($("#ReturnDate").val())) return "Please enter date between " + $("#VoucherArrivalDate").val() + " and " + $("#ReturnDate").val()
        $(checkoutid).attr('min', field.val());
    }

    function GetNoOfDaysRate(RequestedAccomodationCount, cnt, self) {

        GetRoomRate(RequestedAccomodationCount, cnt);

        var startDay = new Date($("#CheckIn" + cnt).val());
        var endDay = new Date($("#CheckOut" + cnt).val());
        var millisBetween = endDay.getTime() - startDay.getTime();
        var days = millisBetween / (1000 * 3600 * 24);

        var selfstr = 'Package Hotel';
        if (self == 1) {
            var selfstr = 'Self Hotel';
        }
        document.getElementById("datacontent" + cnt).setAttribute('data-content', selfstr + ' for ' + parseInt(days) + ' nights');
        $("#AccommationNights" + cnt).val(days);

        var total = 0
        $('.accommationnights').each(function () {
            var currentValue = parseInt($(this).val(), 10);
            if (!isNaN(currentValue)) {
                total += currentValue;
            }
        });
        if (total > 0) {
            $('#totalaccomodationnights').text(" For " + total + " Nights");
            $('#totalaccomodationnightsvalue').val(total);
        } else {
            $('#totalaccomodationnights').text("");
            $('#totalaccomodationnightsvalue').val('');
        }
    }

    $(document).ready(function () {
        var total = 0
        $('.accommationnights').each(function () {
            var currentValue = parseInt($(this).val(), 10);
            if (!isNaN(currentValue)) {
                total += currentValue;
            }
        });
        if (total > 0) {
            $('#totalaccomodationnights').text(" For " + total + " Nights");
            $('#totalaccomodationnightsvalue').val(total);
        } else {
            $('#totalaccomodationnights').text("");
            $('#totalaccomodationnightsvalue').val('');
        }
        voucherdatefilter();
    });

    function voucherdatefilter() {
        var mindate = $("#VoucherArrivalDate").val();
        var maxdate = $("#ReturnDate").val();
        $('input.voucherdatefilter').attr('min', mindate);
        $('input.voucherdatefilter').attr('max', maxdate);
    }

    function pilgrimleaderchecked(pid) {
        if ($("#leader" + pid).is(':checked')) {
            $("#todo-" + pid).prop('checked', true);
        }

    }

    function pilgrimlistchecked(pid) {

        if ($("#todo-" + pid).is(':checked')) {

        } else {
            $("#leader" + pid).prop('checked', false);
        }
    }
</script>

