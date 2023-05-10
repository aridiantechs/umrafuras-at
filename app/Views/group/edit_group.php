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
use App\Models\Groups;

$Groups = new Groups();
$Crud = new Crud();
$session = session();
$id = $session->get('id');
$session = $session->get();
$date = date("d M, Y");

$data['LookupsOptions'] = $Crud->LookupOptions('room_types');
foreach ($data['LookupsOptions'] as $options) {

    $RoomTypes .= '<option value="' . $options['UID'] . '">' . $options['Name'] . '</option>';
}
$Departure = '<img src = "' . $template . 'departures.png" alt="Departure Image" style="height: 100px;width: 150px;">';
$Arrival = '<img src = "' . $template . 'arrivals.png" alt="Arrival Image" style="height: 100px;width: 150px;">';

$airports = new Main();
$data['airport'] = $airports->ListAirports();
$Airportshtml = '';
foreach ($data['airport'] as $option) {
    $Airportshtml .= '<option value="' . $option['UID'] . '" >' . $option['Code'] . ' - ' . $option['Name'] . ' - ' . $option['CountryName'] . '</option>';
    //print_r($data['airport']);
}

$airlines = new Main();
$data['airlines'] = $airlines->ListAirlines();

$AirLineshtml = '';
foreach ($data['airlines'] as $option) {
    $AirLineshtml .= '<option value="' . $option['UID'] . '" > ' . $option['FullName'] . '</option>';
}
/////Land Borders/////
$landbordershtml = '';
$data['LookupsOptions'] = $Crud->LookupOptions('land_borders');
foreach ($data['LookupsOptions'] as $options) {
    $landbordershtml .= '<option value="' . $options['UID'] . '">' . $options['Name'] . '</option>';
}
/////Sea Ports/////
$seaportshtml = '';
$data['LookupsOptions'] = $Crud->LookupOptions('sea_ports');
foreach ($data['LookupsOptions'] as $options) {
    $seaportshtml .= '<option value="' . $options['UID'] . '">' . $options['Name'] . '</option>';
}
$JSCODE = '';
$JSCODERequestedAccomodationDetails = '';
$JSCODETransportDetailAdd = '';

$records = $records[0];

$CitiesHTML = Cities($records['Country'], $datatype = 'html', 0);

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
                                    <h4>Edit Group <span id="ExportPackage"> </span>
                                        <a class="btn btn_customized btn-sm float-right" style="margin-right: 5px;"
                                           href="<?= SeoUrl('exports/groups/' . $records['UID'] . "-" . $records['FullName']) ?>"
                                           target="_blank">Export Group</a>

                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <form enctype="multipart/form-data" class="validate" method="post" action="#"
                                  id="GroupEditForm" name="GroupEditForm">
                                <input type="hidden" id="UID" name="UID" value="<?= $records['UID'] ?>">
                                <input type="hidden" name="CreatedBy" id="CreatedBy" value="<?= $id ?>">
                                <input type="hidden" name="CreatedDate" id="CreatedDate" value="<?= $date ?>">
                                <input type="hidden" id="PackageUID" name="PackageUID" value="0">
                                <input type="hidden" id="DomainID" name="DomainID" value="<?= $GetDomainID ?>">
                                <input type="hidden" id="FlightAttachmentCount" name="FlightAttachmentCount" value="0">
                                <input type="hidden" id="RequestedAccomodationCount" name="RequestedAccomodationCount"
                                       value="0">
                                <input type="hidden" id="ZiyaratCount" name="ZiyaratCount" value="0">
                                <input type="hidden" id="ZiyaratAttachmentCount" name="ZiyaratAttachmentCount"
                                       value="0">
                                <input type="hidden" id="TransportAttachmentCount" name="TransportAttachmentCount"
                                       value="0">
                                <input type="hidden" name="DomainID" id="DomainID" value="<?= $GetDomainID ?>">

                                <input type="hidden" name="ArrivalDate" id="ArrivalDate"
                                       value="<?= ((isset($records['ArrivalDate'])) ? $records['ArrivalDate'] : date("Y-m-d")) ?>">
                                <input type="hidden" name="DepartureDate" id="DepartureDate"
                                       value="<?= ((isset($records['DepartureDate'])) ? $records['DepartureDate'] : date("Y-m-d")) ?>">
                                <input type="hidden" name="GrandTotal" id="GrandTotal"
                                       value="<?= $records['TotalAmount'] ?>">
                                <input type="hidden" id="GroupSubmittedPackageUID" name="GroupSubmittedPackageUID"
                                       value="<?= $records['PackageID'] ?>">
                                <div id="GroupSection">
                                    <h3>Basic Details</h3>
                                    <section>
                                        <div id="VoucherDetails">
                                            <div class="row" id="voucher_details">
                                                <div class="col-md-2">
                                                    <div class="form-group mb-2">
                                                        <label for="country">Agent</label>
                                                        <?php
                                                        if ($session['account_type'] == "external_agent" || $session['account_type'] == "agent") {
                                                            echo '<select disabled class="form-control validate[required] text-input"  id="AgentID" name="AgentID" onChange="LoadAgentGirdByAgentID(this.value)"><option value="">Please Select</option>';
                                                            foreach ($AllAgents as $agent) {
                                                                $table = 'packages."Packages"';
                                                                $where = array("AgentUID" => $agent['UID']);
                                                                $Agents = $Crud->SingleRecord($table, $where);
                                                                if (isset($Agents['UID']) && $Agents['UID'] > 0) {
                                                                    $selected = (($records['AgentID'] == $agent['UID']) ? 'selected' : '');
                                                                    echo ' <option value="' . $agent['UID'] . '" ' . $selected . '>' . $agent['FullName'] . " (" . ucwords(str_replace("_", " ", $agent['Type'])) . ")" . '</option>  ';
                                                                }
                                                            }
                                                            echo '</select>';
                                                            echo '<input class="form-control" type="hidden" name="AgentID" id="AgentID" value="' . $records['AgentID'] . '">';
                                                        } else {
                                                            echo '<select disabled class="form-control validate[required] text-input" data-prompt-position="bottomLeft:20,35"  id="AgentID" name="AgentID" onChange="LoadAgentGirdByAgentID(this.value)"> <option value="">Please Select</option>';
                                                            foreach ($AllAgents as $agent) {
                                                                $table = 'packages."Packages"';
                                                                $where = array("AgentUID" => $agent['UID']);
                                                                $Agents = $Crud->SingleRecord($table, $where);
                                                                if (isset($Agents['UID']) && $Agents['UID'] > 0) {
                                                                    $selected = (($records['AgentID'] == $agent['UID']) ? 'selected' : '');
                                                                    echo '<option value="' . $agent['UID'] . '" ' . $selected . '>' . $agent['FullName'] . " (" . ucwords(str_replace("_", " ", $agent['Type'])) . ")" . '</option>  ';
                                                                }
                                                            }
                                                            echo '</select>';
                                                            echo '<input class="form-control" type="hidden" name="AgentID" id="AgentID" value="' . $records['AgentID'] . '">';
//                                                        if ($AgentLogged) {
//                                                            echo '
//                                                            <span class="form-control"  id="Agent" name="AgentName" placeholder="AgentName">' . $session['name'] . '</span>
//                                                            <input type="hidden" id="AgentID" name="AgentID" value="' . $session['id'] . '">';
//                                                        } else {
//
//                                                        }
                                                        } ?>

                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Country</label>
                                                        <select class="form-control validate[required]"
                                                                id="Country"
                                                                name="Country"
                                                                data-prompt-position="bottomLeft:20,35">
                                                            <option value="SA">Saudi Arabia</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Group Name </label>
                                                        <input type="text" class="form-control  validate[required] mb-4"
                                                               id="GroupName" name="GroupName"
                                                               placeholder="Group Name"
                                                               data-prompt-position="bottomLeft:20,20"
                                                               value="<?= $records['FullName'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mb-3">
                                                        <label for="country">WTU Code </label>
                                                        <input type="text" class="form-control validate[required] mb-4"
                                                               id="WTUCode" name="WTUCode"
                                                               placeholder="WTU Code"
                                                               data-prompt-position="bottomLeft:20,20"
                                                               value="<?= $records['WTUCode'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-3">
                                                                <label for="country">Adults</label>
                                                                <input value="<?= $records['NoOfPAX'] ?>" type="text"
                                                                       min="1"
                                                                       class="form-control  validate[required, custom[integer]] mb-4"
                                                                       id="NoOfPAX" name="NoOfPAX"
                                                                       placeholder="No Of PAX"
                                                                       data-prompt-position="bottomLeft:20,20">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-3">
                                                                <label for="country">Child</label>
                                                                <input value="<?= $records['ChildPax'] ?>" type="text"
                                                                       min="1"
                                                                       class="form-control validate[custom[integer]] mb-4"
                                                                       id="ChildPax" name="ChildPax"
                                                                       placeholder="Child PAX"
                                                                       data-prompt-position="bottomLeft:20,20">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-3">
                                                                <label for="country">Infant</label>
                                                                <input value="<?= $records['InfantPax'] ?>" type="text"
                                                                       min="1"
                                                                       class="form-control validate[custom[integer]] mb-4"
                                                                       id="InfantPax" name="InfantPax"
                                                                       placeholder="Infant PAX"
                                                                       data-prompt-position="bottomLeft:20,20">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mb-3">
                                                        <label for="country">BRN Type</label><br>
                                                        <select class="form-control"
                                                                id="GroupType"
                                                                name="GroupType"
                                                                data-prompt-position="bottomLeft:20,35">
                                                            <option value="">Please Select</option>
                                                            <option value="Actual" <?= (($records['GroupType'] == 'Actual') ? 'selected' : '') ?>>
                                                                Actual
                                                            </option>
                                                            <option value="Visa" <?= (($records['GroupType'] == 'Visa') ? 'selected' : '') ?>>
                                                                Visa
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Transport Type</label><br>
                                                        <select class="form-control validate[required]"
                                                                id="TransportType"
                                                                name="TransportType"
                                                                data-prompt-position="bottomLeft:20,35">
                                                            <option value="">Please Select</option>
                                                            <option value="Air" <?= (($records['TransportType'] == 'Air') ? 'selected' : '') ?> >
                                                                Air
                                                            </option>
                                                            <option value="Land" <?= (($records['TransportType'] == 'Land') ? 'selected' : '') ?> >
                                                                Land
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--                                                <div class="col-md-3">-->
                                                <!--                                                    <div class="form-group mb-3">-->
                                                <!--                                                        <label for="country">Arrival Date </label>-->
                                                <!--                                                        <input type="date" class="form-control  validate[required,future[now],funcCall[SetReturnDate]] mb-4"-->
                                                <!--                                                               id="ArrivalDate" name="ArrivalDate"-->
                                                <!--                                                               placeholder="Arrival Date"-->
                                                <!--                                                               data-prompt-position="bottomLeft:20,20" value="-->
                                                <? //=$records['ArrivalDate']?><!--">-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="col-md-3">-->
                                                <!--                                                    <div class="form-group mb-3">-->
                                                <!--                                                        <label for="country">Departure Date</label><br>-->
                                                <!--                                                        <input type="date" class="form-control  validate[required,future[#ArrivalDate],funcCall[GetArrivalReturnDays]] mb-4"-->
                                                <!--                                                               id="DepartureDate" name="DepartureDate"-->
                                                <!--                                                               placeholder="Return Date"-->
                                                <!--                                                               data-prompt-position="bottomLeft:20,20" value="-->
                                                <? //=$records['DepartureDate']?><!--">-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Arrival Return</label>
                                                        <input type="text"
                                                               class="form-control multidate validate[required,future[now]]"
                                                               name="ArrivalReturn" id="ArrivalReturn" readonly
                                                               placeholder="ArrivalReturnDates"
                                                               value="<?= ((isset($records['ArrivalDate'])) ? $records['ArrivalDate'] : date("Y-m-d")) ?> to <?= ((isset($records['DepartureDate'])) ? $records['DepartureDate'] : date("Y-m-d")) ?>"
                                                               onchange="GetArrivalReturnDate();">

                                                    </div>
                                                </div>
                                                <!--<div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Status</label><br>
                                                        <select class="form-control validate[required]" id="Status"
                                                                name="Status"
                                                                data-prompt-position="bottomLeft:20,35" >
                                                            <option value="">Please Select</option>
                                                            <option value="complete" <? /*=(($records['Status'] == 'complete') ? 'selected' : '')*/ ?>>Complete</option>
                                                            <option value="in-complete" <? /*=(($records['Status'] == 'in-complete') ? 'selected' : '')*/ ?>>In Complete</option>
                                                        </select>
                                                    </div>
                                                </div>-->
                                                <div class="col-md-3">
                                                    <!--                                                    <div class="form-group mb-3">-->
                                                    <!--                                                        <label for="country">Visa</label><br>-->
                                                    <!--                                                        <select class="form-control validate[required]" id="Visa"-->
                                                    <!--                                                                name="Visa"-->
                                                    <!--                                                                data-prompt-position="bottomLeft:20,35">-->
                                                    <!--                                                            <option value="">Please Select</option>-->
                                                    <!---->
                                                    <!--                                                        </select>-->
                                                    <!--                                                    </div>-->


                                                    <div class="form-group mb-3">
                                                        <label for="country"> Umrah Visa</label><br>
                                                        <select class="form-control" id="Visa"
                                                                name="Visa"
                                                                data-prompt-position="bottomLeft:20,35"
                                                                onchange="ValidateWTUCode(this.value);">
                                                            <option value="Yes" <?= ((isset($records['Visa']) && $records['Visa'] == 'Yes') ? 'selected' : '') ?>>
                                                                Yes
                                                            </option>
                                                            <option value="No" <?= ((isset($records['Visa']) && $records['Visa'] == 'No') ? 'selected' : '') ?>>
                                                                No
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Refund Amount</label><br>
                                                        <input value="<?= $records['RefundAmount'] ?>"
                                                               class="form-control validate[required]" type="number"
                                                               min="0" name="RefundAmount" id="RefundAmount">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Reference/Remarks</label><br>
                                                        <textarea class="form-control mb-4"
                                                                  id="Remarks" name="Remarks"
                                                                  placeholder="Remarks"><?= $records['Remarks'] ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>


                                    <h3>Hotel</h3>
                                    <section>
                                        <div id="RequestedAccomodationDetails">
                                            <div id="HotelR" name="HotelR">
                                                <input type="hidden" name="AccomodationCity" id="AccomodationCity">
                                                <input type="hidden" name="Accomodationcnt" id="Accomodationcnt">
                                                <h5>Hotel Details
                                                    <small class="text-muted" id="totalaccomodationnights"></small>
                                                    <a href="javascript:void(0);" id="AddFlightRows"
                                                       class="btn btn_customized btn-sm float-right"
                                                       style="margin-right: 10px;"
                                                       onclick="AddRequestestedAccomodationAttachmentRow();">Add Package
                                                        Hotel</a>

                                                </h5>
                                                <hr>
                                                <?php

                                                $cnt = 10000;
                                                $count = 0;
                                                foreach ($Hotels as $Hotel) {
                                                    $cnt++;
                                                    $CitiesH = Cities($records['Country'], $datatype = 'html', $Hotel['City']);
                                                    $RoomTypeName = OptionName($Hotel['RoomType']);
                                                    $GroupHotelID = $Hotel['UID'];
                                                    $GroupHotels = $Groups->ListGroupHotels($GroupHotelID);
                                                    /*
                                                    $GroupHotelID = $Hotel['id'];
                                                    SELECT * FROM "GroupHotelRooms" WHERE "GroupHotelID" = '$GroupHotelID'
                                                    */

                                                    if (trim($RoomTypeName) == 'Sharing') {
                                                        $RoomTypelabel = 'No Of Beds';
                                                    } else {
                                                        $RoomTypelabel = 'No Of Rooms';
                                                    }

                                                    $data['LookupsOptions'] = $Crud->LookupOptions('room_types');
                                                    $EditRoomTypes = '';
                                                    foreach ($data['LookupsOptions'] as $options) {
                                                        $selected = (($Hotel['RoomType'] == $options['UID']) ? 'selected' : '');
                                                        $EditRoomTypes .= '<option value="' . $options['UID'] . '" ' . $selected . '>' . $options['Name'] . '</option>';
                                                    }
                                                    ?>
                                                    <div class="row AccomodationCount<?= $cnt ?>"
                                                         id="RequestedAccomodationCount<?= $cnt ?>"
                                                         name="RequestedAccomodationCount">

                                                        <div class="col-md-12" style="margin-bottom: 15px !important;">
                                                            <hr id="datacontent<?= $cnt ?>" data-content="Package Hotel"
                                                                class="hr-text">
                                                            <input type="hidden" class="accommationnights"
                                                                   name="AccommationNights[]"
                                                                   id="AccommationNights<?= $cnt ?>"></div>
                                                        <!--<div class="col-md-12">
                                                            <label for="country"> </label>
                                                            <a name="removeButton" href="javascript:void(0);"
                                                               onClick="RemoveAccomodationsRow(<? /*= $Hotel['UID'] */ ?>,<? /*= $cnt */ ?>)"
                                                               id="removeButton" class="float-right"
                                                               style="background: #ecedee;    border-radius: 4px;width: 40px;height: 40px;text-align: center; color: #dd0317;padding-top: 10px;"><span>
                                                                    <i class="fa fa-trash"
                                                                       title="Remove"></i></span></a></div>-->
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3">
                                                                <label for="country">City</label>
                                                                <select class="form-control validate[required]"
                                                                        id="City"
                                                                        onChange="LoadHotelCites(this.value,<?= $cnt ?>)"
                                                                        name="City[<?= $cnt ?>]">  <?= $CitiesH ?></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group mb-3">
                                                                <label for="country">Hotel</label>
                                                                <select class="form-control validate[required]"
                                                                        id="Hotel_<?= $cnt ?>"
                                                                        name="Hotels[<?= $cnt ?>]"> </select></div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3">
                                                                <label for="country">BRN Type</label>
                                                                <select class="form-control validate[required]"
                                                                        id="BRNType_<?= $cnt ?>"
                                                                        name="BRNType[<?= $cnt ?>]">
                                                                    <option value="">Please Select</option>
                                                                    <option <?= ((isset($Hotel['BRNType']) && $Hotel['BRNType'] == 'Actual') ? 'selected' : '') ?>
                                                                            value="Actual">Actual
                                                                    </option>
                                                                    <option <?= ((isset($Hotel['BRNType']) && $Hotel['BRNType'] == 'Visa') ? 'selected' : '') ?>
                                                                            value="Visa">Visa
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3">
                                                                <label for="country">Check-In</label>
                                                                <input type="date"
                                                                       class="form-control validate[required,funcCall[checkindate]]"
                                                                       data-rowid="<?= $cnt ?>" id="CheckIn<?= $cnt ?>"
                                                                       name="CheckIn[<?= $cnt ?>]"
                                                                       aria-describedby="emailHelp1"
                                                                       placeholder="Check IN"
                                                                       value="<?= $Hotel['CheckIn'] ?>"></div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3">
                                                                <label for="country">Check-Out</label>
                                                                <input type="date"
                                                                       class="form-control validate[required,funcCall[checkoutdate]]"
                                                                       id="CheckOut<?= $cnt ?>"
                                                                       name="CheckOut[<?= $cnt ?>]"
                                                                       aria-describedby="emailHelp1"
                                                                       placeholder="Check Out"
                                                                       value="<?= $Hotel['CheckOut'] ?>"
                                                                       onchange="GetNoOfDaysRate('RequestedAccomodationCount<?= $cnt ?>',<?= $cnt ?>,0,<?= $count ?>)"
                                                                       ;></div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <label for="country">Total
                                                                <a name="removeButton" href="javascript:void(0);"
                                                                   onClick="RemoveAccomodationsRow(<?= $Hotel['UID'] ?>,<?= $cnt ?>)"
                                                                   id="removeButton" class="float-right"
                                                                   style="color: #dd0317;padding-left: 10px;"><span>
                                                                    <i class="fa fa-trash"
                                                                       title="Remove"></i></span></a>
                                                            </label>
                                                            <div class="form-group mb-3">
                                                                <input type="hidden"
                                                                       name="AmountPayable[<?= $cnt ?>]"
                                                                       id="AmountPayableInput_<?= $cnt ?>"
                                                                       value="<?= $Hotel['AmountPayable'] ?>">
                                                                <span class="AmountSpan"
                                                                      id="AmountPayable_<?= $cnt ?>"><?= Money($Hotel['AmountPayable']) ?></span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if (!empty($GroupHotels)) {

                                                            ?>
                                                            <div class="col-md-12"
                                                                 id="RequestedAccomodationRoomType<?= $cnt ?>">
                                                                <?php $JSCODERequestedAccomodationMultiDetails = '';
                                                                $count1 = 0;
                                                                foreach ($GroupHotels as $GroupHotel) {

                                                                    $count++;
                                                                    $count1++;
                                                                    $rate = 1;
                                                                    $days = 1;
                                                                    if ($Hotel['CheckIn'] != '' && $Hotel['CheckOut'] != '') {
                                                                        $days = date_diff(date_create($Hotel['CheckIn']), date_create($Hotel['CheckOut']));
                                                                        $days = $days->days;
                                                                    }

                                                                    $Query = 'SELECT "packages"."HotelsRate"."Rate" FROM "packages"."HotelsRate" WHERE "packages"."HotelsRate"."PackageUID" IN 
                                                                    ( SELECT "packages"."Packages"."UID" FROM "packages"."Packages" WHERE "packages"."Packages"."AgentUID" = ' . $records['AgentID'] . ' ) 
                                                                    AND "packages"."HotelsRate"."HotelUID" = ' . $Hotel['Hotel'] . ' AND "packages"."HotelsRate"."RoomTypeUID" = ' . $GroupHotel['RoomType'] . ' ';
                                                                    $rslt = $Crud->ExecuteSQL($Query);
                                                                    if (isset($rslt[0]['Rate'])) $rate = $rslt[0]['Rate'];

                                                                    ?>
                                                                    <div class="row"
                                                                         id="RequestedAccomodationRoomTypeCount<?= $cnt ?>_<?= $count1 ?>">
                                                                        <div class="col-md-3">
                                                                            <div class="form-group mb-3">
                                                                                <label for="country">Room Type</label>
                                                                                <select class="form-control RoomType<?= $cnt ?> validate[required]"
                                                                                        id="RoomType_<?= $cnt ?>_<?= $count1 ?>"
                                                                                        name="RoomType[<?= $cnt ?>][]"
                                                                                        onchange="GetRoomRate('RequestedAccomodationCount<?= $cnt ?>',<?= $cnt ?>,'RequestedAccomodationRoomTypeCount<?= $cnt ?>_<?= $count1 ?>',<?= $count1 ?>);">
                                                                                    <option value="">Please Select
                                                                                    </option> <?= $EditRoomTypes ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group mb-3">
                                                                                <label for="country"
                                                                                       id="noofroomsbeds<?= $cnt ?>_<?= $count ?>"><?= $RoomTypelabel; ?></label>
                                                                                <input type="number"
                                                                                       class="form-control NoOfBeds<?= $cnt ?> validate[required,funcCall[checknumberofbeds]]"
                                                                                       min="1"
                                                                                       id="NoOfBeds_<?= $cnt ?>_<?= $count1 ?>"
                                                                                       name="NoOfBeds[<?= $cnt ?>][]"
                                                                                       value="<?= $GroupHotel['RoomQTY'] ?>"
                                                                                       oninput="GetRoomRate('RequestedAccomodationCount<?= $cnt ?>',<?= $cnt ?>,'RequestedAccomodationRoomTypeCount<?= $cnt ?>_<?= $count1 ?>',<?= $count1 ?>);"
                                                                                       aria-describedby="emailHelp1"
                                                                                       placeholder="No Of Beds"></div>
                                                                        </div>
                                                                        <div class="col-md-3"><label
                                                                                    for="country">Amount</label>
                                                                            <div class="form-group mb-3">
                                                                                AmountPayable <input type="hidden"
                                                                                                     name="AmountHotelPayable[<?= $cnt ?>][]"
                                                                                                     id="AmountPayableInput_<?= $cnt ?>_<?= $count1 ?>"
                                                                                                     class="AmountPayable<?= $cnt ?>"
                                                                                                     value="<?= $GroupHotel['AmountPayable'] ?>">
                                                                                <span class="AmountSpan AmountSpan<?= $cnt ?>"
                                                                                      id="AmountPayable_<?= $cnt ?>_<?= $count1 ?>"><?= Money($GroupHotel['AmountPayable']); ?> / <?= $days; ?> Nights<br><small><?= Money($rate); ?> / Night</small></span>
                                                                            </div>
                                                                        </div>
                                                                        <?php if ($count1 == 1) { ?>
                                                                            <div class="col-md-1 pt-3"
                                                                                 id="AddRoomType<?= $cnt ?>">
                                                                                <label for="country"> </label> </br>
                                                                                <a name="removeButton"
                                                                                   href="javascript:void(0);"
                                                                                   id="removeButton"
                                                                                   onclick="AddRequestestedAccomodationRoomTypeRow(<?= $cnt ?>,<?= count($GroupHotels) ?>, <?= $Hotel['UID'] ?>);"><span>
                                                                           <i class="fa fa-plus" title="Add"></i></a>
                                                                            </div>
                                                                        <?php } else {
                                                                            ?>
                                                                            <div class="col-md-1 pt-3">
                                                                                <label for="country"> </label> <br>
                                                                                <a name="removeButton"
                                                                                   href="javascript:void(0);"
                                                                                   id="removeButton"
                                                                                   onclick="RemoveAccomodationsRoomTypeRow('RequestedAccomodationCount<?= $cnt ?>', <?= $cnt ?>,<?= $count1 ?>);"><span>
                                                                                    <i class="fa fa-trash"
                                                                                       title="Remove"
                                                                                       aria-hidden="true"></i>
                                                                                    <span class="sr-only">Remove</span></span></a>
                                                                            </div>
                                                                            <?php
                                                                        } ?>
                                                                    </div>
                                                                    <?php
                                                                    // $JSCODERequestedAccomodationMultiDetails .= 'GetRoomRate("RequestedAccomodationCount' . $cnt . '",' . $cnt . ',"RequestedAccomodationRoomTypeCount' . $cnt . '_' . $count1 . '",' . $count1 . ');';
                                                                    $JSCODERequestedAccomodationMultiDetails .= '$("#RoomType_' . $cnt . '_' . $count1 . '").val("' . $GroupHotel['RoomType'] . '");';
                                                                } ?>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <hr>
                                                            </div>

                                                            <?php

                                                        } else {

                                                            $count++;
                                                            ?>
                                                            <div class="col-md-12"
                                                                 id="RequestedAccomodationRoomType<?= $cnt ?>">
                                                                <div class="row"
                                                                     id="RequestedAccomodationRoomTypeCount<?= $cnt ?>_<?= $count ?>">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group mb-3">
                                                                            <label for="country">Room Type</label>
                                                                            <select class="form-control RoomType<?= $cnt ?> validate[required]"
                                                                                    id="RoomType_<?= $cnt ?>_<?= $count ?>"
                                                                                    name="RoomType[<?= $cnt ?>][]"
                                                                                    onchange="GetRoomRate('RequestedAccomodationCount<?= $cnt ?>',<?= $cnt ?>,'RequestedAccomodationRoomTypeCount<?= $cnt ?>_<?= $count ?>',<?= $count ?>);">
                                                                                <option value="">Please Select
                                                                                </option> <?= $EditRoomTypes ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group mb-3">
                                                                            <label for="country"
                                                                                   id="noofroomsbeds<?= $cnt ?>_<?= $count ?>"><?= $RoomTypelabel; ?></label>
                                                                            <input type="number"
                                                                                   class="form-control NoOfBeds<?= $cnt ?> validate[required,funcCall[checknumberofbeds]]"
                                                                                   min="1"
                                                                                   id="NoOfBeds_<?= $cnt ?>_<?= $count ?>"
                                                                                   name="NoOfBeds[<?= $cnt ?>][]"
                                                                                   value="<?= $Hotel['NoOfBeds'] ?>"
                                                                                   oninput="GetRoomRate('RequestedAccomodationCount<?= $cnt ?>',<?= $cnt ?>,'RequestedAccomodationRoomTypeCount<?= $cnt ?>_<?= $count ?>',<?= $count ?>);"
                                                                                   aria-describedby="emailHelp1"
                                                                                   placeholder="No Of Beds"></div>
                                                                    </div>
                                                                    <div class="col-md-3"><label
                                                                                for="country">Amount</label>
                                                                        <div class="form-group mb-3">
                                                                            <input type="hidden"
                                                                                   name="AmountHotelPayable[<?= $cnt ?>][]"
                                                                                   id="AmountPayableInput_<?= $cnt ?>_<?= $count ?>"
                                                                                   class="AmountPayable<?= $cnt ?>">
                                                                            <span class="AmountSpan AmountSpan<?= $cnt ?>"
                                                                                  id="AmountPayable_<?= $cnt ?>_<?= $count ?>"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1 pt-3"
                                                                         id="AddRoomType<?= $cnt ?>">
                                                                        <label for="country"> </label> </br>
                                                                        <a name="removeButton"
                                                                           href="javascript:void(0);" id="removeButton"
                                                                           onclick="AddRequestestedAccomodationRoomTypeRow(<?= $cnt ?>,<?= $count ?>, <?= $Hotel['UID'] ?>);"><span>
                                                                       <i class="fa fa-plus" title="Add"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <hr>
                                                            </div>
                                                            <?php
                                                        } ?>
                                                    </div>

                                                    <?php
                                                    $JSCODERequestedAccomodationDetails .= 'LoadHotelCites(' . $Hotel['City'] . ',' . $cnt . ',' . $Hotel['Hotel'] . ');';
                                                    //$JSCODERequestedAccomodationDetails .= 'GetRoomRate("RequestedAccomodationCount' . $cnt . '",' . $cnt . ',"RequestedAccomodationRoomTypeCount' . $cnt . '_' . $count . '",' . $count . ');';
                                                    $JSCODERequestedAccomodationDetails .= '$("#RequestedAccomodationCount' . $cnt . ' #City").val("' . $Hotel['City'] . '").select2();';
                                                    $JSCODERequestedAccomodationDetails .= '$("#RequestedAccomodationCount' . $cnt . ' #Hotel_' . $cnt . '").val("' . $Hotel['Hotel'] . '");';
                                                    $JSCODERequestedAccomodationDetails .= $JSCODERequestedAccomodationMultiDetails;

                                                } ?>

                                            </div>
                                        </div>

                                    </section>
                                    <h3> Transport</h3>
                                    <section>
                                        <div id="TransportDetailAdd">
                                            <div id="TransportR" name="TransportR">
                                                <h5>Transport Details
                                                    <a href="javascript:void(0);" id="AddFlightRows"
                                                       class="btn btn_customized btn-sm float-right"
                                                       style="margin-right: 10px;"
                                                       onclick="AddTransportAttachmentRow();">Add Transport</a>
                                                </h5>
                                                <hr>
                                                <?php $cnt = 10000;
                                                foreach ($Transports as $Transport) {
                                                    $cnt++;
                                                    $data['LookupsOptions'] = $Crud->LookupOptions('transport_sectors');
                                                    foreach ($data['LookupsOptions'] as $options) {
                                                        $selected = (($Transport['TransportSectors'] == $options['UID']) ? 'selected' : '');
                                                        $Sectors .= '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['Name'] . '</option>';
                                                    }
                                                    foreach ($TransportData as $TransportUID => $thisType) {
                                                        $selected = (($Transport['Transport'] == $TransportUID) ? 'selected' : '');
                                                        $Transports .= '<option value="' . $TransportUID . '"' . $selected . '>' . $thisType . '</option>';
                                                    } ?>
                                                    <div class="row" id="TransportAttachmentCount<?= $cnt ?>"
                                                         name="TransportAttachmentCount">
                                                        <div style="margin-bottom: 15px;" class="col-md-12">
                                                            <hr data-content="Package Transport" class="hr-text">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3"><input type="hidden"
                                                                                                name="SelfTransport[]"
                                                                                                value="0"><label
                                                                        for="country">Sectors</label> <select
                                                                        class="form-control validate[required]"
                                                                        id="TransportSectors_<?= $cnt ?>"
                                                                        name="TransportSectors[]">
                                                                    <option value="">Please Select
                                                                    </option> <?= $Sectors ?> </select></div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3"><label
                                                                        for="country">Transports</label> <select
                                                                        class="form-control validate[required]"
                                                                        id="Transport_<?= $cnt ?>" name="Transport[]"
                                                                        onchange="TransportRates(this.value,<?= $cnt ?>)">
                                                                    <option value="">Please Select
                                                                    </option><?= $Transports ?> </select></div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3">
                                                                <label for="country">BRN Type</label>
                                                                <select class="form-control validate[required]"
                                                                        id="TransportBRNType_<?= $cnt ?>"
                                                                        name="TransportBRNType[]">
                                                                    <option value="">Please Select</option>
                                                                    <option <?= ((isset($Transport['BRNType']) && $Transport['BRNType'] == 'Actual') ? 'selected' : '') ?>
                                                                            value="Actual">Actual
                                                                    </option>
                                                                    <option <?= ((isset($Transport['BRNType']) && $Transport['BRNType'] == 'Visa') ? 'selected' : '') ?>
                                                                            value="Visa">Visa
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3"><label for="country">No Of
                                                                    Pax </label><input type="text"
                                                                                       class="form-control validate[required,funcCall[checknumberofpax]] "
                                                                                       name="NoOfPax[]"
                                                                                       id="NoOfPax_<?= $cnt ?>"
                                                                                       value="<?= $Transport['NoOfPax'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3"><label for="country">No Of
                                                                    Seats</label><input type="text"
                                                                                        class="form-control validate[required ,funcCall[checknumberofseats]]"
                                                                                        name="NoOfSeats[]"
                                                                                        id="NoOfSeats_<?= $cnt ?>"
                                                                                        value="<?= $Transport['NoOfSeats'] ?>"
                                                                                        oninput="TransportRateUpdate(<?= $cnt ?>);">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3"><label for="country">Transport
                                                                    Amount
                                                                    <a name="removeButton"
                                                                       href="javascript:void(0);"
                                                                       onClick="RemoveGroupTransportRow(<?= $Transport['UID'] ?>,<?= $cnt ?>)"
                                                                       id="removeButton" class="float-right"
                                                                       style="padding-left: 10px;"><span> <i
                                                                                    class="fa fa-trash"
                                                                                    title="Remove"></i></span></a>
                                                                </label><br><input type="hidden"
                                                                                   name="TransportsRates[]"
                                                                                   id="TransportRateValue_<?= $cnt ?>"
                                                                                   value="<?= $Transport['TransportsRates'] ?>"><span
                                                                        id="TransportsRates_<?= $cnt ?>"
                                                                        class="AmountSpan"><?= Money($Transport['TransportsRates']) ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <hr>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $JSCODETransportDetailAdd .= 'TransportRateUpdate(' . $cnt . ');';

                                                } ?>
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
                                                <?php $cnt = 10000;
                                                foreach ($Ziyarats as $ziyarat) {
                                                    $cnt++;
                                                    foreach ($TransportData as $TransportUID => $thisType) {
                                                        $selected = (($ziyarat['ZiyaratTransport'] == $TransportUID) ? 'selected' : '');
                                                        $Transports .= '<option value="' . $TransportUID . '"' . $selected . '>' . $thisType . '</option>';
                                                    };
                                                    ?>
                                                    <div class="row ZiyaratCount<?= $cnt ?>" id="ZiyaratAttachmentCount"
                                                         name="ZiyaratAttachmentCount">
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3"><label
                                                                        for="country">Location</label><select
                                                                        class="form-control" id="Cities"
                                                                        name="ZiyaratCity[]"
                                                                        onChange="LoadZiyaratCites(this.value,<?= $cnt ?>,<?= $ziyarat['Ziyarat'] ?>)"> </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3"><label
                                                                        for="country">Ziyarat</label> <select
                                                                        class="form-control" id="Ziyarat_<?= $cnt ?>"
                                                                        name="Ziyarat[]">
                                                                    <option value="">Ziyarat</option>
                                                                </select></div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3"><label
                                                                        for="country">Transports</label> <select
                                                                        class="form-control validate[required]"
                                                                        id="ZiyaratTransport<?= $cnt ?>"
                                                                        name="ZiyaratTransport[]"
                                                                        onchange="ZiyaratRates(this.value,<?= $cnt ?>)">
                                                                    <option value="">Please Select
                                                                    </option> <?= $Transports ?> </select></div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3"><label for="country">No Of
                                                                    Pax </label><input type="text"
                                                                                       class="form-control validate[required,funcCall[checknumberofpax]] "
                                                                                       name="ZiyaratNoOfPax[]"
                                                                                       id="ZiyaratNoOfPax_<?= $cnt ?>"
                                                                                       value="<?= $ziyarat['ZiyaratNoOfPax'] ?>"
                                                                                       onchange="ZiyaratRatesUpdate(<?= $cnt ?>);">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group mb-3"><label for="country">Transport
                                                                    Amount</label><br> <input
                                                                        id="ZiyaratTransport_<?= $cnt ?>" type="hidden"
                                                                        name="ZiyaratTransportRate[]"
                                                                        value="<?= $ziyarat['TransportRateZiyrat'] ?>">
                                                                <span id="ZiyaratTransportsRatess_<?= $cnt ?>"
                                                                      class="AmountSpan"> <?= Money($ziyarat['TransportRateZiyrat']) ?> </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1"><label for="country"> </label> <br> <a
                                                                    name="removeButton" href="javascript:void(0);"
                                                                    onClick="RemoveGroupZiyarats(<?= $ziyarat['UID'] ?>,<?= $cnt ?>)"
                                                                    id="removeButton" class="float-right"
                                                                    style="padding: 25px;"><span> <i class="fa fa-trash"
                                                                                                     title="Remove"></i></span></a>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <hr>
                                                        </div>
                                                    </div>
                                                    <?php

                                                    $JSCODE .= 'LoadZiyaratCites(' . $ziyarat['ZiyaratCity'] . ',' . $cnt . ',' . $ziyarat['Ziyarat'] . ');';
                                                    $JSCODE .= '$("#ZiyaratAttachmentCount #Cities").val("' . $ziyarat['ZiyaratCity'] . '").select2();';
                                                    $JSCODE .= '$("#ZiyaratAttachmentCount #Ziyarat_' . $cnt . '").val("' . $ziyarat['Ziyarat'] . '");';
                                                    $JSCODE .= 'ZiyaratRatesUpdate(' . $cnt . ');';

                                                } ?>
                                            </div>
                                        </div>
                                    </section>
                                    <h3> Extra</h3>
                                    <section>
                                        <div id="defaultAccordionThree">
                                            <div class="row" id="ServicesGrid">
                                            </div>
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
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                <div class="" id="GroupEditResponse"></div>
            </div>

        </div>
    </div>
</div>
<script>

    $(document).ready(function () {
        setTimeout(function () {
            var Arrival = "<?=(($records['ArrivalDate'] != '' && $records['ArrivalDate'] != null) ? $records['ArrivalDate'] : date("Y-m-d"))?>";
            var Departure = "<?=(($records['DepartureDate'] != '' && $records['DepartureDate'] != null) ? $records['DepartureDate'] : date("Y-m-d"))?>";

            $("#ArrivalDate").val(Arrival);
            $("#DepartureDate").val(Departure);
            $("#ArrivalReturn").val(Arrival + " to " + Departure);
        }, 1500);
    });

    function GetArrivalReturnDate() {

        const ArrivalReturn = $("#ArrivalReturn").val();
        const words = ArrivalReturn.split(' to ');
        // alert(ArrivalReturn);
        // alert(words[0]);
        // alert(words[1]);
        $("#ArrivalDate").val(words[0]);
        $("#DepartureDate").val(words[1]);


        // var ArrivalReturn = $("#ArrivalReturn").val();
        // dates = AjaxResponse("html/GetStartEndDates", "ArrivalReturn=" + ArrivalReturn);
        //
        // $("#VoucherArrivalDate").val(dates.StartDate);
        // $("#ReturnDate").val(dates.EndDate);
        SetReturnDate();
        GetArrivalReturnDays();


    }

    // function GetArrivalReturnDate() {
    //     var ArrivalReturn = $("#ArrivalReturn").val();
    //     // var VoucherArrivalDate = $("#VoucherArrivalDate").val();
    //
    //     // alert(VoucherArrivalDate);
    //     dates = AjaxResponse("html/GetStartEndDates", "ArrivalReturn=" + ArrivalReturn);
    //     // alert('Start Date : ' + dates.StartDate + ' End Date : ' + dates.EndDate);
    //
    //     $("#ArrivalDate").val(dates.StartDate);
    //     $("#DepartureDate").val(dates.EndDate);
    //
    //     SetReturnDate();
    //     GetArrivalReturnDays();
    //
    // }


    localStorage.setItem('CitiesHTML', '<?= $CitiesHTML ?>');
    CitiesHTML = localStorage.getItem('CitiesHTML');


    localStorage.setItem('Hotels', '<?= $Hotel['Hotel'] ?>');
    GroupHotels = localStorage.getItem('Hotels');

    setTimeout(function () {
        // var AgentID = $("#GroupEditForm #AgentID").val();
        LoadAgentGirdByAgentID(<?= $records['AgentID'] ?>);
        // var ArrivalType = $("#ArrivalType").val();
        CountryCode = $("#Country").val();
        LoadCitiesDropdownagain(CountryCode);
        //AddTransportAttachmentRow();
        //AddNewZiyarat();
        // LoadAgentGirdByAgentID();
        //AddRequestestedAccomodationAttachmentRow();
        <?= $JSCODE ?>
    }, 100)

    function LoadHotelCites(city, cnt, selected) {
        var PackagesUID = $("#PackageUID").val();
        hotels = AjaxResponse("html/GetHotelDropdownByCityByPackageId", "city=" + city + "&PackagesUID=" + PackagesUID + "&selected=" + selected);
        $("#Hotel_" + cnt).html('<option value="">Please Select</option>' + hotels.html);
        DefaultScripts();
    }


    function EditGroupFormSubmit() {

        var validate = $("form#GroupEditForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        var RefundAmount = $("form#GroupEditForm input#RefundAmount").val();
        var GrandTotal = $("form#GroupEditForm input#GrandTotal").val();

        if (isNaN(RefundAmount) || RefundAmount == '' || RefundAmount < 0) {
            $("#GroupEditResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Refund Amount!</strong> Plz Correctly Fill Input </div>');
        } else if (parseFloat(GrandTotal) < parseFloat(RefundAmount)) {
            alert("Refund Amount Must be less than Grand Total");
            return false;
        } else {

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

            var phpdata = new window.FormData($("form#GroupEditForm")[0]);
            var response = AjaxUploadResponse("form_process/group_form_submit", phpdata);

            if (response.status == 'success') {
                $("#GroupEditResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
                $("a[href$='finish']").hide();
                setTimeout(function () {
                    location.reload();
                    PlzWait('hide');
                }, 2000)
            } else {
                $("#GroupEditResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
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
    }

    function ValidateWTUCode(val) {
        if (val == 'No') {
            $("input#WTUCode").removeClass("form-control validate[required] mb-4");
            $("input#WTUCode").addClass("form-control mb-4");
        } else if (val == 'Yes') {
            $("input#WTUCode").addClass("form-control validate[required] mb-4");
        }
    }

    function AddNewZiyarat() {
        ZiyaratAttachmentCount = parseInt($("#ZiyaratAttachmentCount").val());

        HTML = DefaultZiyaratRowHTML(ZiyaratAttachmentCount);
        $("#ZiyaratR").append(HTML);
        currentcnt = ZiyaratAttachmentCount + 1;
        $("#ZiyaratAttachmentCount").val(currentcnt);


        DefaultScripts();
        return false;
    }


    function DefaultZiyaratRowHTML(cnt) {
        cnt = cnt + 1;
        var html;

        CountryCode = $("#Country").val();
        //CountryCode = "SA";
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + CountryCode);
        ZiyaratCities = '<select class="form-control HotelCities validate[required]" id="ZiyaratCity_' + cnt + '" name="ZiyaratCity[]" onChange="LoadZiyaratByCites(this.value, ' + cnt + ')" ><option value="">City</option>' + cities.html + '</select>'
        Ziyarats = '<select class="form-control validate[required]" id="Ziyarat_' + cnt + '" name="Ziyarat[]" ><option value="">Ziyarat</option></select>'
        Transports = '<?php foreach ($TransportData as $TransportUID => $thisType) {
            echo '<option value="' . $TransportUID . '">' . $thisType . '</option>';
        } ?> ';

        html = '<div class="row" id="ZiyaratAttachmentCount' + cnt + '" name="ZiyaratAttachmentCount">\n' +
            '                                                    <div class="col-md-2"> <div class="form-group mb-3"><label for="country">Location</label>' + ZiyaratCities + '</div> </div>\n' +
            '                                                    <div class="col-md-2"> <div class="form-group mb-3"><label  for="country">Ziyarat</label>' + Ziyarats + ' </div> </div>\n' +
            '                                                    <div class="col-md-2"> <div class="form-group mb-3"><label for="country">Transports</label> <select class="form-control validate[required]" id="ZiyaratTransport' + cnt + '" name="ZiyaratTransport[]" onchange = "ZiyaratRateForAddMore(this.value,' + cnt + ')"> <option value="">Please Select  </option> ' + Transports + ' </select> </div> </div>' +
            '                                                    <div class="col-md-2">  <div class="form-group mb-3"><label for="country">No Of Pax </label><input type="text" class="form-control validate[required,funcCall[checknumberofpax]] "  name ="ZiyaratNoOfPax[]" id="ZiyaratNoOfPax_' + cnt + '" value ="1" onchange="ZiyaratRatesUpdate(' + cnt + ');"></div> </div>' +
            '                                                    <div class="col-md-3">  <div class="form-group mb-3"><label for="country">Transport Amount</label><br> <input id="ZiyaratTransport_' + cnt + '" type="hidden" name= "ZiyaratTransportRate[]" value=""> <span id="ZiyaratTransportsRatess_' + cnt + '" class="AmountSpan"> - </span> </div> </div>\n' +
            '                                                    <div class="col-md-1">  <label for="country"> </label> <br> <a name="removeButton" href="javascript:void(0);" onClick="RemoveZiyaratRow(' + cnt + ')" id="removeButton" class="float-right" style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div> <div class = "col-md-12"><hr></div> </div>';
        ' </div>';
        DefaultScripts();
        return html;
    }


    function ZiyaratRates(TransportsID, cnt) {
        var PackagesUID = $("#PackageUID").val();
        var Ziarat = $("#Ziyarat_" + cnt).val();
        var NoOfPax = $("#ZiyaratNoOfPax_" + cnt).val();

        response = AjaxResponse("html/GetZiyaratRatesByPackageIDForGroupUpdate", "Ziarat=" + Ziarat + "&PackagesUID=" + PackagesUID + "&TransportsID=" + TransportsID + "&NoOfPax=" + NoOfPax);
        $("#ZiyaratTransportsRatess_" + cnt).html(response.html);
        $("#ZiyaratTransport_" + cnt).val(response.rate);


    }

    function ZiyaratRateForAddMore(TransportsID, cnt) {
        var PackagesUID = $("#PackageUID").val();
        var Ziarat = $("#Ziyarat_" + cnt).val();
        var NoOfPax = $("#ZiyaratNoOfPax_" + cnt).val();

        response = AjaxResponse("html/GetZiyaratRatesByPackageIDForGroup", "Ziarat=" + Ziarat + "&PackagesUID=" + PackagesUID + "&TransportsID=" + TransportsID + "&NoOfPax=" + NoOfPax);
        $("#ZiyaratTransportsRatess_" + cnt).html(response.html);
        $("#ZiyaratTransport_" + cnt).val(response.rate);
        //$("#ZiyaratNoOfPax_" + cnt).val(null);
    }

    function ZiyaratRatesUpdate(cnt) {
        var PackagesUID = $("#PackageUID").val();
        var TransportsID = $("#ZiyaratTransport" + cnt).val();
        var NoOfPax = $("#ZiyaratNoOfPax_" + cnt).val();
        var Ziarat = $("#Ziyarat_" + cnt).val();


        response = AjaxResponse("html/GetZiyaratRatesByPackageUpdate", "Ziarat=" + Ziarat + "&PackagesUID=" + PackagesUID + "&TransportsID=" + TransportsID + "&NoOfPax=" + NoOfPax);
        $("#ZiyaratTransportsRatess_" + cnt).html(response.html);
        var rate = NoOfPax * response.rate;
        $("#ZiyaratTransport_" + cnt).val(rate);

    }

    function AddTransportAttachmentRow() {
        TransportAttachmentCount = parseInt($("#TransportAttachmentCount").val());

        HTML = TransportAttachmentFormHTML(TransportAttachmentCount);
        $("#TransportR").append(HTML);
        $("#TransportAttachmentCount").val(TransportAttachmentCount + 1);
        DefaultScripts();
        return false;
    }


    function TransportAttachmentFormHTML(cnt) {
        cnt = cnt + 1;
        var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;
        var html;
        Sectors = '<?php $data['LookupsOptions'] = $Crud->LookupOptions('transport_sectors');
            foreach ($data['LookupsOptions'] as $options) {
                echo '<option value="' . $options['UID'] . '">' . $options['Name'] . '</option>';
            } ?>';
        Transports = '<?php foreach ($TransportData as $TransportUID => $thisType) {
            echo '<option value="' . $TransportUID . '">' . $thisType . '</option>';
        } ?> ';


        html = ' <div class="row" id="TransportAttachmentCount' + cnt + '" name="TransportAttachmentCount">\n' +
            ' <div style="margin-bottom:15px;" class="col-md-12"><hr data-content="Package Transport" class="hr-text"></div>\n' +
            ' <div class="col-md-2"> <div class="form-group mb-3"><input type="hidden" name="SelfTransport[]" value="0"><label  for="country">Sectors</label> <select  class="form-control validate[required]" id="TransportSectors_' + cnt + '" name="TransportSectors[]">\n' +
            ' <option value="">Please Select</option> ' + Sectors + ' </select></div> </div>\n' +
            ' <div class="col-md-2">  <div class="form-group mb-3"><label for="country">Transports</label> <select class="form-control validate[required]" id="Transport_' + cnt + '" name="Transport[]"  onchange = "TransportRates(this.value,' + cnt + ')"> <option value="">Please Select  </option>' + Transports + ' </select></div> </div>\n' +
            '<div class="col-md-2">  <div class="form-group mb-3"> <label for="country">BRN Type</label>  <select class="form-control validate[required]" id="TransportBRNType_' + cnt + '"  name="TransportBRNType[]"> <option value="">Please Select</option> <option value="Actual">Actual</option>  <option value="Visa">Visa</option>  </select>    </div> </div>\n' +
            ' <div class="col-md-2">  <div class="form-group mb-3"><label for="country">No Of Pax </label><input type="text" class="form-control validate[required,funcCall[checknumberofpax]] "  name ="NoOfPax[]" id="NoOfPax_' + cnt + '" value ="' + CountPilgrim + '"></div> </div>\n' +
            ' <div class="col-md-2">  <div class="form-group mb-3"><label for="country">No Of Seats</label><input type="text" class="form-control validate[required ,funcCall[checknumberofseats]]"  name ="NoOfSeats[]" id="NoOfSeats_' + cnt + '" value =""  oninput="TransportRateUpdate(' + cnt + ');"></div> </div>\n' +
            ' <div class="col-md-2">  <div class="form-group mb-3"><label for="country">Transport Amount <a name="removeButton" href="javascript:void(0);" onClick="RemoveTransportAttachmentRow(' + cnt + ')" id="removeButton" class="float-right" style="padding-left: 10px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></label><br><input type ="hidden" name ="TransportsRates[]" id="TransportRateValue_' + cnt + '" value =""><span id="TransportsRates_' + cnt + '" class="AmountSpan">-</span> </div> </div>\n' +
            '</div>';
        DefaultScripts();
        return html;

    }

    function TransportRateUpdate(cnt) {
        var PackagesUID = $("#PackageUID").val();
        var TransportID = $("#Transport_" + cnt).val();
        var NoOfSeat = $("#NoOfSeats_" + cnt).val();
        response = AjaxResponse("html/GetTransportRatesByPackageUpdate", "TransportID=" + TransportID + "&PackagesUID=" + PackagesUID + "&NoOfSeat=" + NoOfSeat);
        // var PrintRate = NoOfSeat * response.rate;
        $("#TransportsRates_" + cnt).html(response.html);
        var rate = NoOfSeat * response.rate;

        $("#TransportRateValue_" + cnt).val(rate);


    }

    function TransportRates(TransportID, cnt) {
        var PackagesUID = $("#PackageUID").val();
        var NoOfSeat = $("#NoOfSeats_" + cnt).val();
        response = AjaxResponse("html/GetTransportRatesByPackageIDForGroup", "TransportID=" + TransportID + "&PackagesUID=" + PackagesUID + "&NoOfSeat=" + NoOfSeat);
        $("#TransportsRates_" + cnt).html(response.html);
        var rate = NoOfSeat * response.rate;
        $("#TransportRateValue_" + cnt).val(rate);


    }

    function RemoveTransportAttachmentRow(cnt) {

        TransportAttachmentCount = parseInt($("#TransportAttachmentCount").val());
        $('#TransportAttachmentCount' + cnt).remove();
        $("#TransportAttachmentCount").val(TransportAttachmentCount - 1);
    }

    //
    // function LoadZiyaratByCites(city, cnt) {
    //     ziarat = AjaxResponse("html/GetZiaratDropdownByCity", "city=" + city);
    //     $("#ZiyaratR  #ZiyaratAttachmentCount" + cnt + " select#Ziyarat_" + cnt).html('<option value="">Ziyarat</option>' + ziarat.html);
    // }
    function LoadZiyaratByCites(city, cnt) {
        ziarat = AjaxResponse("html/GetZiaratDropdownByCity", "city=" + city + "&selected=");
        $("#ZiyaratR  #ZiyaratAttachmentCount" + cnt + " select#Ziyarat_" + cnt).html('<option value="">Ziyarat</option>' + ziarat.html);
        $("#ZiyaratR  #ZiyaratAttachmentCount select#Ziyarat_" + cnt).html(ziarat.html);
    }

    function LoadZiyaratCites(city, cnt, selected) {
        ziarat = AjaxResponse("html/GetZiaratDropdownByCity", "city=" + city + "&selected=" + selected);
        $("#ZiyaratR  #ZiyaratAttachmentCount" + cnt + " select#Ziyarat_" + cnt).html('<option value="">Ziyarat</option>' + ziarat.html);
        $("#ZiyaratR  #ZiyaratAttachmentCount select#Ziyarat_" + cnt).html(ziarat.html);
    }


    function RemoveZiyaratRow(cnt) {
        ZiyaratAttachmentCount = parseInt($("#ZiyaratAttachmentCount").val());
        $('#ZiyaratAttachmentCount' + cnt).remove();
        $("#ZiyaratAttachmentCount").val(ZiyaratAttachmentCount - 1);
    }

    function RemoveFlightAttachmentRow(cnt) {

        FlightAttachmentCount = parseInt($("#FlightAttachmentCount").val());
        $('#FlightAttachmentCount' + cnt).remove();
        $("#FlightAttachmentCount").val(FlightAttachmentCount - 1);
    }


    function LoadAgentGirdByAgentID(id) {
        PilgrimHtml = AjaxResponse("html/GetGroupPilgrimGrid", "id=" + id + "&GroupId=<?= $records['UID'] ?>" + "&Selectedvisa=<?= $records['Visa'] ?>");
        $("#ServicesGrid").html(PilgrimHtml.services_html);
        $("#ExportPackage").html(PilgrimHtml.export_button);
        $("#PackageUID").val(PilgrimHtml.package_id);
        // $("#Visa").html(PilgrimHtml.Visa);


    }


    function AddRequestestedAccomodationAttachmentRow() {
        RequestedAccomodationCount = parseInt($("#RequestedAccomodationCount").val());


        HTML = RequstedAccomodationAttachmentFormHTML(RequestedAccomodationCount);
        $("#HotelR").append(HTML);
        $("#RequestedAccomodationCount").val(RequestedAccomodationCount + 1);

        CountryCode = $("#Country").val();
        LoadCitiesDropdownagain(CountryCode);

        DefaultScripts();
        return false;
    }


    function RequstedAccomodationAttachmentFormHTML(cnt) {

        cnt = cnt + 1;
        var CountPilgrim = 0;
        var NoOfPAX = $("#NoOfPAX").val();
        var ChildPax = $("#ChildPax").val();
        var InfantPax = $("#InfantPax").val();

        NoOfPAX = ((parseInt(NoOfPAX) != '') ? parseInt(NoOfPAX) : 0);
        ChildPax = ((parseInt(ChildPax) != '') ? parseInt(ChildPax) : 0);
        InfantPax = ((parseInt(InfantPax) != '') ? parseInt(InfantPax) : 0);
        CountPilgrim = (parseInt(NoOfPAX) + parseInt(ChildPax) + parseInt(InfantPax));

        var html;
        var mindate = $("#ArrivalDate").val();
        var maxdate = $("#DepartureDate").val();
        html = '<div class="row" id="RequestedAccomodationCount' + cnt + '" name="RequestedAccomodationCount">\n' +
            '<div style="margin-bottom:15px;" class="col-md-12"><hr id="datacontent' + cnt + '" data-content="Package Hotel" class="hr-text"><input type="hidden" class="accommationnights" name="AccommationNights[]" id="AccommationNights' + cnt + '"></div>\n' +
            '<div class="col-md-2">  <div class="form-group mb-3"> <label for="country">City</label> <input type="hidden" name="Self[]" value="0"> <select class="form-control validate[required]" id="City" onChange="LoadHotelByCites(this.value,' + cnt + ')"  name="City[' + cnt + ']">  </select> </div>  </div>\n' +
            '<div class="col-md-3">  <div class="form-group mb-3"> <label for="country">Hotel</label>  <select class="form-control validate[required]" id="Hotel_' + cnt + '"  name="Hotels[' + cnt + ']">   </select>    </div> </div>\n' +
            '<div class="col-md-2">  <div class="form-group mb-3"> <label for="country">BRN Type</label>  <select class="form-control validate[required]" id="BRNType_' + cnt + '"  name="BRNType[' + cnt + ']"> <option value="">Please Select</option> <option value="Actual">Actual</option> <option value="Visa">Visa</option> </select>    </div> </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country">Check-In</label>   <input type="date" class="form-control hdatefrom validate[required,funcCall[checkindate]]" data-rowid="' + cnt + '" id="CheckIn' + cnt + '" name="CheckIn[' + cnt + ']"   aria-describedby="emailHelp1"  placeholder="Check IN" min="' + mindate + '" max="' + maxdate + '" value="' + mindate + '">   </div>   </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country">Check-Out</label> <input type="date" class="form-control hdateto validate[required,funcCall[checkoutdate]]" id="CheckOut' + cnt + '"  name="CheckOut[' + cnt + ']"  aria-describedby="emailHelp1"  placeholder="Check Out" min="' + mindate + '" max="' + maxdate + '" value="' + maxdate + '" onchange="GetNoOfDaysRate(\'RequestedAccomodationCount' + cnt + '\',' + cnt + ',0,' + cnt + ')";>   </div>  </div>\n' +
            '<div class="col-md-1">  <label for="country">Total <a name="removeButton" href="javascript:void(0);" onClick="RemoveRequstedAccomodationAttachmentRow(' + cnt + ')" id="removeButton" class="float-right" style="padding-left: 10px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></label>  <div class="form-group mb-3"> <input type ="hidden" name ="AmountPayable[' + cnt + ']" id="AmountPayableInput_' + cnt + '" value =""> <span class="AmountSpan" id="AmountPayable_' + cnt + '"></span>  </div>  </div>\n' +
            '<div class="col-md-12" id="RequestedAccomodationRoomType' + cnt + '">\n' +
            '<div class="row" id="RequestedAccomodationRoomTypeCount' + cnt + '_' + cnt + '">\n' +
            '<div class="col-md-3"> <div class="form-group mb-3">  <label for="country">Room Type</label>  <select class="form-control RoomType' + cnt + ' validate[required]" id="RoomType_' + cnt + '_' + cnt + '"  name="RoomType[' + cnt + '][]" onchange="GetRoomRate(\'RequestedAccomodationCount' + cnt + '\',' + cnt + ',\'RequestedAccomodationRoomTypeCount' + cnt + '_' + cnt + '\',' + cnt + ');">   <option value="">Please Select</option>  <?= $RoomTypes ?>  </select>  </div> </div>\n' +
            '<div class="col-md-3">   <div class="form-group mb-3">  <label for="country" id="noofroomsbeds' + cnt + '_' + cnt + '">No Of Beds</label> <input type="number" class="form-control NoOfBeds' + cnt + ' validate[required,funcCall[checknumberofbeds]]" min="1" max="' + CountPilgrim + '"  id="NoOfBeds_' + cnt + '_' + cnt + '"  name="NoOfBeds[' + cnt + '][]" value="' + CountPilgrim + '" oninput="GetRoomRate(\'RequestedAccomodationCount' + cnt + '\',' + cnt + ',\'RequestedAccomodationRoomTypeCount' + cnt + '_' + cnt + '\',' + cnt + ');"  aria-describedby="emailHelp1"  placeholder="No Of Beds">   </div>  </div>\n' +
            '<div class="col-md-3">  <label for="country">Amount</label>  <div class="form-group mb-3"> <input type ="hidden" name ="AmountHotelPayable[' + cnt + '][]" id="AmountPayableInput_' + cnt + '_' + cnt + '" class="AmountPayable' + cnt + '"> <span class="AmountSpan AmountSpan' + cnt + '" id="AmountPayable_' + cnt + '_' + cnt + '"></span>  </div>  </div>\n' +
            '<div class="col-md-1 pt-3" id="AddRoomType' + cnt + '">  <label for="country"> </label> </br> <a name="removeButton" href="javascript:void(0);"  id="removeButton" onclick="AddRequestestedAccomodationRoomTypeRow(' + cnt + ',' + cnt + ');"><span> <i class="fa fa-plus" title="Add"></i></a></div> \n' +
            '</div>\n' +
            '</div>\n' +
            '<div class="col-md-12"> <hr> </div>  </div>  </div> \n' +
            '</div> ';
        DefaultScripts();
        return html;

    }

    function AddRequestestedAccomodationRoomTypeRow(cnt, count, rowid) {
        count = count + 1;
        var html;
        html = '<div class="row" id="RequestedAccomodationRoomTypeCount' + cnt + '_' + count + '">\n' +
            '<div class="col-md-3"> <div class="form-group mb-3">  <label for="country">Room Type</label>  <select class="form-control RoomType' + cnt + ' validate[required]" id="RoomType_' + cnt + '_' + count + '"  name="RoomType[' + cnt + '][]" onchange="GetRoomRate(\'RequestedAccomodationCount' + cnt + '\',' + cnt + ',\'RequestedAccomodationRoomTypeCount' + cnt + '_' + count + '\',' + count + ');">   <option value="">Please Select</option><?= $RoomTypes ?></select>  </div> </div>\n' +
            '<div class="col-md-3">  <div class="form-group mb-3">  <label for="country" id="noofroomsbeds' + cnt + '_' + count + '">No Of Beds</label> <input type="number" class="form-control NoOfBeds' + cnt + ' validate[required,funcCall[checknumberofbeds]]" min="1"  id="NoOfBeds_' + cnt + '_' + count + '"  name="NoOfBeds[' + cnt + '][]"  aria-describedby="emailHelp1"  placeholder="No Of Beds" oninput="GetRoomRate(\'RequestedAccomodationCount' + cnt + '\',' + cnt + ',\'RequestedAccomodationRoomTypeCount' + cnt + '_' + count + '\',' + count + ');">   </div>  </div>\n' +
            '<div class="col-md-3">  <label for="country">Amount</label>  <div class="form-group mb-3"> <input type ="hidden" name ="AmountHotelPayable[' + cnt + '][]" id="AmountPayableInput_' + cnt + '_' + count + '" class="AmountPayable' + cnt + '"> <span class="AmountSpan AmountSpan' + cnt + '" id="AmountPayable_' + cnt + '_' + count + '"></span>  </div>  </div>\n' +
            '<div class="col-md-1 pt-3">  <label for="country"> </label> </br> <a name="removeButton" href="javascript:void(0);"  id="removeButton" onclick="RemoveAccomodationsRoomTypeRow(\'RequestedAccomodationCount' + cnt + '\', ' + cnt + ',' + count + ');"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div>\n' +


            '</div>';
        $("#RequestedAccomodationRoomType" + cnt).append(html);
        $("#AddRoomType" + cnt).html('<label for="country"> </label> </br> <a name="removeButton" href="javascript:void(0);"  id="removeButton" onclick="AddRequestestedAccomodationRoomTypeRow(' + cnt + ',' + count + ');"><span> <i class="fa fa-plus" title="Add"></i></a>');
    }

    function RemoveAccomodationsRoomTypeRow(parent, cnt, count) {
        if (confirm("Are You Want To Remove This Row?")) {
            $('#RequestedAccomodationRoomTypeCount' + cnt + '_' + count).remove();
            MultipleGetRoomRateDate(parent, cnt, count);
        }
    }

    function RemoveRequstedAccomodationAttachmentRow(cnt) {

        RequestedAccomodationCount = parseInt($("#RequestedAccomodationCount").val());
        $('#RequestedAccomodationCount' + cnt).remove();
        $("#RequestedAccomodationCount").val(RequestedAccomodationCount - 1);
        var total = 0
        $('.accommationnights').each(function () {
            var currentValue = parseInt($(this).val(), 10);
            if (!isNaN(currentValue)) {
                total += currentValue;
            }
        });
        if (total > 0) {
            $('#totalaccomodationnights').text(" For " + total + " Nights");
        } else {
            $('#totalaccomodationnights').text("");
        }

    }

    function LoadCitiesDropdownagain(country) {
        cnt = parseInt($("#RequestedAccomodationCount").val());

        CountryCode = $("#Country").val();
        var CitiesHTML = '';
        if (CitiesHTML == '') {
            cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + CountryCode);
            CitiesHTML = cities.html;
        }

        $("#RequestedAccomodationCount" + cnt + " #City").html('<option value="">Please Select</option>' + CitiesHTML);

        $("#ZiyaratR #Cities").html('<option value="">Please Select</option>' + CitiesHTML);
        //$("#ZiyaratR #Cities").val(<? //=$ziyarat['ZiyaratCity']?>//);

        DefaultScripts();
    }

    //
    // function LoadCitiesDropdownagain(country) {
    //     cnt = parseInt($("#RequestedAccomodationCount").val());
    //     //alert("#RequestedAccomodationCount" + cnt + " #City");
    //
    //     cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country);
    //     $("#RequestedAccomodationCount" + cnt + " #City").html('<option value="">Please Select</option>' + cities.html);
    //     DefaultScripts();
    // }

    // function LoadHotelByCites(city, cnt) {
    //     hotels = AjaxResponse("html/GetHotelDropdownByCity", "city=" + city);
    //     $("#Hotel_" + cnt).html('<option value="">Please Select</option>' + hotels.html);
    //     DefaultScripts();
    // }

    function LoadHotelByCites(city, cnt) {
        var PackagesUID = $("#PackageUID").val();
        hotels = AjaxResponse("html/GetHotelDropdownByCityByPackageId", "city=" + city + "&PackagesUID=" + PackagesUID);
        $("#Hotel_" + cnt).html('<option value="">Please Select</option>' + hotels.html);
        DefaultScripts();
    }


    function RoomtypeSelect(roomtype) {
        var AgentID = $("#AgentID").val();
        var HotelID = $("#Hotels").val();
        response = AjaxResponse("form_process/GetRoomTypePackage", "roomtype=" + roomtype + "&AgentID=" + AgentID + "&HotelID=" + HotelID);
        if (response.status == 'success') {
            $("#AmountPayable").html(response.CurrentCharges)

        }
    }

    function MultipleGetRoomRateDate(parent, cnt, count) {
        var CheckIn = $("#CheckIn" + cnt).val();
        var CheckOut = $("#CheckOut" + cnt).val();

        var AgentID = $("#GroupEditForm #AgentID").val();
        var HotelID = $("#" + parent + " #Hotel_" + cnt).val();

        var NoOfBedselements = document.getElementsByClassName("NoOfBeds" + cnt);
        var RoomTypeelements = document.getElementsByClassName("RoomType" + cnt);
        var AmountSpanelements = document.getElementsByClassName("AmountSpan" + cnt);
        var AmountPayableelements = document.getElementsByClassName("AmountPayable" + cnt);
        //var NoOfBeds = '';
        var NoOfBeds = '';
        var RoomType = '';
        for (var i = 0; i < NoOfBedselements.length; i++) {
            //names = NoOfBedselements[i].name;
            NoOfBeds = $("#" + NoOfBedselements[i].id).val();
            RoomType = $("#" + RoomTypeelements[i].id).val();

            //var RoomType = $("#" + parent +" #RequestedAccomodationRoomTypeCount"+cnt+"_"+count+"" + " #RoomType").val();
            //alert(RoomType+'-----'+NoOfBeds);
            if (AgentID > 0 && HotelID > 0 && RoomType > 0 && NoOfBeds > 0) {
                response = AjaxResponse("form_process/GetRoomTypePackageForGroup", "RoomType=" + RoomType + "&AgentID=" + AgentID + "&HotelID=" + HotelID + "&CheckIn=" + CheckIn + "&CheckOut=" + CheckOut + "&NoOfBeds=" + NoOfBeds);
                if (response.status == 'success') {
                    $("#" + AmountSpanelements[i].id).html(response.CurrentCharges)
                    $("#" + AmountPayableelements[i].id).val(response.Rate)


                }
                MultipleGetRoomRate(cnt);
            }
        }
    }

    function MultipleGetRoomRate(cnt) {
        var total = 0;
        $(".AmountPayable" + cnt).each(function () {
            quantity = parseInt($(this).val());
            if (!isNaN(quantity)) {
                total += quantity;
            }
        });
        $("#AmountPayable_" + cnt).html(total + " SAR")
        $("#AmountPayableInput_" + cnt).val(total)
    }

    function GetRoomRate(parent, cnt, childparent, count) {
//alert(count);
        var CheckIn = $("#CheckIn" + cnt).val();
        var CheckOut = $("#CheckOut" + cnt).val();

        var AgentID = $("#GroupEditForm #AgentID").val();
        var HotelID = $("#" + parent + " #Hotel_" + cnt).val();
        var RoomType = $("#" + parent + " #" + childparent + " #RoomType_" + cnt + "_" + count).val();
        var RoomTypeName = $("#RoomType_" + cnt + "_" + count + " option:selected").text();
//alert(RoomTypeName);
        if (RoomTypeName == 'Sharing') {

            $('#noofroomsbeds' + cnt + "_" + count).text("No Of Beds");
        } else {

            $('#noofroomsbeds' + cnt + "_" + count).text("No Of Rooms");
        }
        // var CheckIn = $("#" + parent + " #CheckIn"+ cnt).val();
        // var CheckOut = $("#" + parent + " #CheckOut"+ cnt).val();
        // var NoOfBeds = $("#GroupEditForm  #NoOfBeds_" + cnt).val();
        var NoOfBeds = $("#" + parent + " #" + childparent + " #NoOfBeds_" + cnt + "_" + count).val();
        if (AgentID > 0 && HotelID > 0 && RoomType > 0 && NoOfBeds > 0) {
            response = AjaxResponse("form_process/GetRoomTypePackageForGroup", "RoomType=" + RoomType + "&AgentID=" + AgentID + "&HotelID=" + HotelID + "&CheckIn=" + CheckIn + "&CheckOut=" + CheckOut + "&NoOfBeds=" + NoOfBeds);
            if (response.status == 'success') {
                $("#AmountPayable_" + cnt + "_" + count).html(response.CurrentCharges)
                $("#AmountPayableInput_" + cnt + "_" + count).val(response.Rate)


            }
            MultipleGetRoomRate(cnt);
        }

    }


</script>
<script src="<?= $template ?>plugins/jquery-step/jquery.steps.min.js"></script>

<script>


    function GroupFormSummary() {

        /*var validate = $("form#GroupAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }*/

        //var phpdata = new window.FormData($("form#GroupAddForm")[0]);
        var phpdata = $("form#GroupEditForm").serialize();
        response = AjaxRequest("form_process/group_form_submmary", phpdata, "SummaryGrid");


    }

    function changeminmaxdate() {
        var mindate = $("#ArrivalDate").val();
        var maxdate = $("#DepartureDate").val();
        $('.hdatefrom').attr('min', mindate);
        $('.hdateto').attr('max', maxdate);
    }

    //     function GroupValidation(currentIndex, newIndex){
    // //alert(currentIndex+"-"+newIndex);
    //         if (currentIndex == 0 && newIndex == 1) {
    //             changeminmaxdate();
    //         }
    //         if (currentIndex == 4 && newIndex == 5) {
    //             GroupFormSummary();
    //
    //         }
    //
    //
    //
    //         return true;
    //     }

    function GroupValidation(currentIndex, newIndex) {
        //alert(currentIndex+"-"+newIndex);
        if (newIndex < currentIndex) {
            $("form#GroupEditForm").validationEngine('hideAll');
            return true;
        }
        var validate = $("form#GroupEditForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        if (currentIndex == 0 && newIndex == 1) {
            changeminmaxdate();
            <?= $JSCODERequestedAccomodationDetails ?>
        }
        if (currentIndex == 1 && newIndex == 2) {
            <?= $JSCODETransportDetailAdd ?>
        }
        if (currentIndex == 4 && newIndex == 5) {
            GroupFormSummary();
        }

        return true;
    }

    $("#GroupSection").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: true,
        cssClass: 'pill wizard',
        onStepChanging: function (event, currentIndex, newIndex) {
            return GroupValidation(currentIndex, newIndex);

        },
        onFinished: function (event, currentIndex) {
            EditGroupFormSubmit();
        }
    });

    function RemoveAccomodationsRow(UID, cnt) {
        if (confirm("Are You Want To Remove This Row?")) {
            response = AjaxResponse("form_process/remove_group_accomodations_attachments_row", "UID=" + UID);
            if (response.status == 'success') {
                $('.AccomodationCount' + cnt).remove();
            }
        }
    }

    function RemoveGroupTransportRow(UID, cnt) {
        if (confirm("Are You Want To Remove This Row?")) {
            response = AjaxResponse("form_process/remove_group_transport_attachments_row", "UID=" + UID);
            if (response.status == 'success') {
                $('#TransportAttachmentCount' + cnt).remove();
            }
        }
    }

    function RemoveGroupZiyarats(UID, cnt) {
        if (confirm("Are You Want To Remove This Row?")) {
            response = AjaxResponse("form_process/remove_group_ziyarat_attachments_row", "UID=" + UID);
            if (response.status == 'success') {
                $('.ZiyaratCount' + cnt).remove();
            }
        }
    }

    $("form#HotelAddForm").on("submit", function (event) {
        event.preventDefault();
    });

    function SetReturnDate() {
        if ($("#ArrivalDate").val() != '') {
            var someDate = new Date($("#ArrivalDate").val());
            someDate.setDate(someDate.getDate() + 1); //number  of days to add, e.x. 15 days
            var mindate = someDate.toISOString().substr(0, 10);
            $("#DepartureDate").attr('min', mindate);
            var someDate = new Date($("#ArrivalDate").val());
            someDate.setDate(someDate.getDate() + 25); //number  of days to add, e.x. 15 days
            var maxdate = someDate.toISOString().substr(0, 10);
            $("#DepartureDate").attr('max', maxdate);
        } else {
            return false;
        }


    }

    function GetArrivalReturnDays() {

        var startDay = new Date($("#ArrivalDate").val());
        var endDay = new Date($("#DepartureDate").val());
        var millisBetween = endDay.getTime() - startDay.getTime();
        var days = millisBetween / (1000 * 3600 * 24);
        if (days < 8 || days > 25) return "Number of days between 8 to 25"

    }

    function checkindate(field, rules, i, options) {
        var rowid = field.data('rowid');
        var checkoutid = '#RequestedAccomodationCount' + rowid + ' #CheckOut' + rowid;
        if (Date.parse(field.val()) < Date.parse($("#ArrivalDate").val()) || Date.parse(field.val()) > Date.parse($("#DepartureDate").val())) return "Please enter date between " + $("#ArrivalDate").val() + " and " + $("#DepartureDate").val()
        $(checkoutid).attr('min', field.val());

    }

    function checkoutdate(field, rules, i, options) {
        if (Date.parse(field.val()) < Date.parse($("#ArrivalDate").val()) || Date.parse(field.val()) > Date.parse($("#DepartureDate").val())) return "Please enter date between " + $("#ArrivalDate").val() + " and " + $("#DepartureDate").val()
    }


    function checknumberofbeds(field, rules, i, options) {

        var TotalPax = 0;
        var NoOfPAX = $("#NoOfPAX").val();
        NoOfPAX = ((parseInt(NoOfPAX) != '') ? parseInt(NoOfPAX) : 0);
        var ChildPax = $("#ChildPax").val();
        ChildPax = ((parseInt(ChildPax) != '') ? parseInt(ChildPax) : 0);
        var InfantPax = $("#InfantPax").val();
        InfantPax = ((parseInt(InfantPax) != '') ? parseInt(InfantPax) : 0);

        TotalPax = (parseInt(NoOfPAX) + parseInt(ChildPax) + parseInt(InfantPax));
        // var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;

        if (parseInt(field.val()) > parseInt(TotalPax) || parseInt(field.val()) < 1) return "Please enter No Of Beds upto " + TotalPax
    }

    function checknumberofpax(field, rules, i, options) {

        var TotalPax = 0;
        var NoOfPAX = $("#NoOfPAX").val();
        NoOfPAX = ((parseInt(NoOfPAX) != '') ? parseInt(NoOfPAX) : 0);
        var ChildPax = $("#ChildPax").val();
        ChildPax = ((parseInt(ChildPax) != '') ? parseInt(ChildPax) : 0);
        var InfantPax = $("#InfantPax").val();
        InfantPax = ((parseInt(InfantPax) != '') ? parseInt(InfantPax) : 0);

        TotalPax = (parseInt(NoOfPAX) + parseInt(ChildPax) + parseInt(InfantPax));

        // var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;

        if (parseInt(field.val()) > parseInt(TotalPax) || parseInt(field.val()) < 1) return "Please enter No Of Pax upto " + TotalPax
    }

    function checknumberofseats(field, rules, i, options) {

        var TotalPax = 0;
        var NoOfPAX = $("#NoOfPAX").val();
        NoOfPAX = ((parseInt(NoOfPAX) != '') ? parseInt(NoOfPAX) : 0);
        var ChildPax = $("#ChildPax").val();
        ChildPax = ((parseInt(ChildPax) != '') ? parseInt(ChildPax) : 0);
        var InfantPax = $("#InfantPax").val();
        InfantPax = ((parseInt(InfantPax) != '') ? parseInt(InfantPax) : 0);

        TotalPax = (parseInt(NoOfPAX) + parseInt(ChildPax) + parseInt(InfantPax));

        // var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;
        if (parseInt(field.val()) > parseInt(TotalPax) || parseInt(field.val()) < 1) return "Please enter No Of Seats upto " + TotalPax
    }


    $(document).ready(function () {
        $("form#GroupEditForm").validationEngine('attach', {

            promptPosition: "bottomRight",
            scroll: false
        });
    });

    function GetNoOfDaysRate(RequestedAccomodationCount, cnt, self, count) {
        //GetRoomRate(RequestedAccomodationCount,cnt);
        MultipleGetRoomRateDate(RequestedAccomodationCount, cnt, count);

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
        } else {
            $('#totalaccomodationnights').text("");
        }

    }

</script>
