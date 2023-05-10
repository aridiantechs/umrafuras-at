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

    .trashcss {
        color: #ffc107;
        font-size: 20px;
        float: right;
        margin-left: 60px;
        margin-right: 29px;
    }
    .plusInonBtn {
        color: #ffc107;
        font-size: 23px;
        float: right;
        margin-left: 60px;
        margin-right: 20px;
    }
</style>
<?php

use App\Models\Main;
use App\Models\Crud;

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
$data['LookupsOptions'] = $Crud->LookupOptions('title_options');
$titledata = '';
foreach ($data['LookupsOptions'] as $options) {
    $titledata .= '<option value="' . $options['UID'] . '">' . $options['Name'] . '</option>';

}
//print_r($relations);
$relationdata = '';
foreach ($relations as $key => $value) {
    $relationdata .= '<option value="' . $key . '">' . $value . '</option>';
}
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
                                    <h4>Add Bulk Pilgrims <span id="ExportPackage"> </span>

                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <form enctype="multipart/form-data" class="validate" method="post" action="#"
                                  id="GroupAddForm" name="GroupAddForm">
                                <input type="hidden" id="UID" name="UID" value="0">
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
                                <input type="hidden" name="GrandTotal" id="GrandTotal" value="0">
                                <input type="hidden" name="ArrivalDate" id="ArrivalDate" value=" ">
                                <input type="hidden" name="DepartureDate" id="DepartureDate" value=" ">
                                <div id="VoucherSection">
                                    <h3>Basic Details</h3>
                                    <section>
                                        <div id="VoucherDetails">
                                            <div class="row" id="voucher_details">
                                                <div class="col-md-2">
                                                    <div class="form-group mb-2">
                                                        <label for="country">Agent</label>
                                                        <?php
                                                        if ($session['account_type'] == "external_agent" || $session['account_type'] == "agent") {
                                                            echo '<select class="form-control validate[required] text-input"  id="AgentID" name="AgentID" onChange="LoadAgentGirdByAgentID(this.value)"><option value="">Please Select</option>';
                                                            foreach ($AllAgents as $agent) {
                                                                $table = 'packages."Packages"';
                                                                $where = array("AgentUID" => $agent['UID']);
                                                                $Agents = $Crud->SingleRecord($table, $where);
                                                                if (isset($Agents['UID']) && $Agents['UID'] > 0) {
                                                                    echo ' <option value="' . $agent['UID'] . '">' . $agent['FullName'] . " (" . ucwords(str_replace("_", " ", $agent['Type'])) . ")" . '</option>  ';
                                                                }
                                                            }
                                                            echo '</select>';
                                                        } else {
                                                            echo '<select class="form-control validate[required] text-input" data-prompt-position="bottomLeft:20,35"  id="AgentID" name="AgentID" onChange="LoadAgentGirdByAgentID(this.value)"> <option value="">Please Select</option>';
                                                            foreach ($AllAgents as $agent) {
                                                                $table = 'packages."Packages"';
                                                                $where = array("AgentUID" => $agent['UID']);
                                                                $Agents = $Crud->SingleRecord($table, $where);
                                                                if (isset($Agents['UID']) && $Agents['UID'] > 0) {
                                                                    echo ' <option value="' . $agent['UID'] . '">' . $agent['FullName'] . " (" . ucwords(str_replace("_", " ", $agent['Type'])) . ")" . '</option>  ';
                                                                }
                                                            }
                                                            echo '</select>';
//                                                            if ($AgentLogged) {
//                                                                echo '
//                                                            <span class="form-control"  id="Agent" name="AgentName" placeholder="AgentName">' . $session['name'] . '</span>
//                                                            <input type="hidden" id="AgentID" name="AgentID" value="' . $session['id'] . '">';
//                                                            } else {
//
//                                                            }
                                                        } ?>

                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Country</label>
                                                        <select class="form-control validate[required]"
                                                                id="Country"
                                                                name="Country"
                                                                data-prompt-position="bottomLeft:20,35"
                                                        >
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
                                                               data-prompt-position="bottomLeft:20,20">
                                                    </div>
                                                </div>
                                                <!--                                                <div class="col-md-2">-->
                                                <!--                                                    <div class="form-group mb-3">-->
                                                <!--                                                        <label for="country">WTU Code </label>-->
                                                <!--                                                        <input type="text" class="form-control  validate[required] mb-4"-->
                                                <!--                                                               id="WTUCode" name="WTUCode"-->
                                                <!--                                                               placeholder="WTU Code"-->
                                                <!--                                                               data-prompt-position="bottomLeft:20,20">-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <div class="col-md-2">
                                                    <div class="form-group mb-3">
                                                        <label for="country">No Of PAX </label>
                                                        <input type="number" min="1"
                                                               class="form-control  validate[required] mb-4"
                                                               id="NoOfPAX" name="NoOfPAX"
                                                               placeholder="No Of PAX"
                                                               data-prompt-position="bottomLeft:20,20">
                                                    </div>
                                                </div>
                                                <!--                                                <div class="col-md-2">-->
                                                <!--                                                    <div class="form-group mb-3">-->
                                                <!--                                                        <label for="country">Transport Type</label><br>-->
                                                <!--                                                        <select class="form-control validate[required]"-->
                                                <!--                                                                id="TransportType"-->
                                                <!--                                                                name="TransportType"-->
                                                <!--                                                                data-prompt-position="bottomLeft:20,35">-->
                                                <!--                                                            <option value="">Please Select</option>-->
                                                <!--                                                            <option value="Air">Air</option>-->
                                                <!--                                                            <option value="Land">Land</option>-->
                                                <!--                                                        </select>-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="col-md-2">-->
                                                <!--                                                    <div class="form-group mb-3">-->
                                                <!--                                                        <label for="country">Arrival Date </label>-->
                                                <!--                                                        <input type="date"-->
                                                <!--                                                               class="form-control validate[required,future[now],funcCall[SetReturnDate]] mb-4"-->
                                                <!--                                                               id="ArrivalDate" name="ArrivalDate"-->
                                                <!--                                                               placeholder="Arrival Date"-->
                                                <!--                                                               data-prompt-position="bottomLeft:20,20">-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="col-md-2">-->
                                                <!--                                                    <div class="form-group mb-3">-->
                                                <!--                                                        <label for="country">Departure Date</label><br>-->
                                                <!--                                                        <input type="date"-->
                                                <!--                                                               class="form-control  validate[required,future[#ArrivalDate],funcCall[GetArrivalReturnDays]] mb-4"-->
                                                <!--                                                               id="DepartureDate" name="DepartureDate"-->
                                                <!--                                                               placeholder="Return Date"-->
                                                <!--                                                               data-prompt-position="bottomLeft:20,20">-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Arrival Departure</label>
                                                        <input type="text"
                                                               class="form-control multidate validate[required,future[now]]"
                                                               name="ArrivalReturn" id="ArrivalReturn" readonly
                                                               placeholder="ArrivalReturnDates" value=""
                                                               onchange="GetArrivalReturnDate();">

                                                    </div>
                                                </div>
                                                <!--<div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Status</label><br>
                                                        <select class="form-control validate[required]" id="Status"
                                                                name="Status"
                                                                data-prompt-position="bottomLeft:20,35">
                                                            <option value="in-complete">In Complete</option>
                                                            <option value="complete">Complete</option>

                                                        </select>
                                                    </div>
                                                </div>-->
                                                <div class="col-md-2">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Visa</label><br>
                                                        <select class="form-control validate[required]" id="Visa"
                                                                name="Visa"
                                                                data-prompt-position="bottomLeft:20,35">
                                                            <option value="">Please Select</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Refund Amount</label><br>
                                                        <input value="0" class="form-control validate[required]"
                                                               type="number" min="0" name="RefundAmount"
                                                               id="RefundAmount">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Reference/Remarks</label><br>
                                                        <textarea class="form-control mb-4"
                                                                  id="Remarks" name="Remarks"
                                                                  placeholder="Remarks"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <h3>Pilgrims </h3>
                                    <section>
                                        <div id="PersonalDetails">
                                            <div class="row">
                                                <div class="col-lg-12 mx-auto">
                                                    <div class="info" id="bulkpilgrim">

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <!--                                    <h3>Hotel</h3>
                                                                        <section>
                                                                            <div id="RequestedAccomodationDetails">
                                                                                <div id="HotelR" name="HotelR">
                                                                                    <input type="hidden" name="AccomodationCity" id="AccomodationCity">
                                                                                    <input type="hidden" name="Accomodationcnt" id="Accomodationcnt">
                                                                                    <h5>Accommodation Details
                                                                                        <small class="text-muted" id="totalaccomodationnights"></small>

                                                                                        <a href="javascript:void(0);" id="AddFlightRows"
                                                                                           class="btn btn_customized btn-sm float-right"
                                                                                           style="margin-right: 10px;"
                                                                                           onclick="AddRequestestedAccomodationAttachmentRow();">Add Package
                                                                                            Hotel</a>
                                                                                    </h5>
                                                                                    <hr>
                                                                                </div>
                                                                            </div>

                                                                        </section>-->

                                    <!--                                    <h3> Transport</h3>
                                                                        <section>
                                                                            <div id="TransportDetailAdd">
                                                                                <div id="TransportR" name="TransportR">
                                                                                    <h5>Transport Details
                                                                                      <a href="javascript:void(0);" id="AddFlightRows"
                                                                                           class="btn btn_customized btn-sm float-right"
                                                                                           style="margin-right: 10px;"
                                                                                           onclick="AddTransportAttachmentRow();">Add Package Transport</a>
                                                                                      </h5>
                                                                                    <hr>
                                                                                </div>
                                                                            </div>
                                                                        </section>-->
                                    <!-- <h3> Ziyarat </h3>
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
                                             </div>
                                         </div>
                                     </section>-->
                                    <!--                                    <h3> Extra</h3>
                                                                        <section>
                                                                            <div id="defaultAccordionThree">
                                                                                <div class="row" id="ServicesGrid">
                                                                                </div>
                                                                            </div>
                                                                        </section>-->
                                    <!-- <h3> Summary</h3>
                                     <section>
                                         <div id="Summary">
                                             <div class="row">
                                                 <div class="col-12">
                                                     <div id="SummaryGrid">
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </section>-->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                <div class="" id="GroupAddResponse"></div>
            </div>

        </div>
    </div>
</div>
<script>

    function GetArrivalReturnDate() {

        const ArrivalReturn = $("#ArrivalReturn").val();
        const words = ArrivalReturn.split(' to ');
        $("#ArrivalDate").val(words[0]);
        $("#DepartureDate").val(words[1]);

        // GetArrivalReturnDate();

    }


    function GroupFormSubmit() {

        var validate = $("form#GroupAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        var RefundAmount = $("form#GroupAddForm input#RefundAmount").val();
        var GrandTotal = $("form#GroupAddForm input#GrandTotal").val();

        if (isNaN(RefundAmount) || RefundAmount == '' || RefundAmount < 0) {
            $("#GroupAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Refund Amount!</strong> Plz Correctly Fill Input </div>');
        } else if (parseFloat(GrandTotal) < parseFloat(RefundAmount)) {
            alert("Refund Amount Must be less than Grand Total");
            return false;
        } else {
            var phpdata = new window.FormData($("form#GroupAddForm")[0]);
            var response = AjaxUploadResponse("form_process/group_bulk_pilgrim_form_submit-----", phpdata);

            if (response.status == 'success') {
                $("#GroupAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
                setTimeout(function () {
                    location.reload();
                }, 2000)
            } else {
                $("#GroupAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
            }
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
            '                                                    <div class="col-md-2"> <div class="form-group mb-3"><label for="country">Transports</label> <select class="form-control validate[required]" id="ZiyaratTransport' + cnt + '" name="ZiyaratTransport[]" onchange = "ZiyaratRates(this.value,' + cnt + ')"> <option value="">Please Select  </option> ' + Transports + ' </select> </div> </div>' +
            '                                                    <div class="col-md-2">  <div class="form-group mb-3"><label for="country">No Of Pax </label><input type="text" class="form-control validate[required,funcCall[checknumberofpax]] "  name ="ZiyaratNoOfPax[]" id="ZiyaratNoOfPax_' + cnt + '" value ="" onchange="ZiyaratRatesUpdate(' + cnt + ');"></div> </div>' +
            '                                                    <div class="col-md-3">  <div class="form-group mb-3"><label for="country">Transport Rates</label><br> <input id="ZiyaratTransport_' + cnt + '" type="hidden" name= "ZiyaratTransportRate[]" value=""> <span id="ZiyaratTransportsRatess_' + cnt + '" class="AmountSpan"> - </span> </div> </div>\n' +
            '                                                    <div class="col-md-1">  <label for="country"> </label> <br> <a name="removeButton" href="javascript:void(0);" onClick="RemoveZiyaratRow(' + cnt + ')" id="removeButton" class="float-right" style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div> <div class = "col-md-12"><hr></div> </div>';
        ' </div>';
        DefaultScripts();
        return html;
    }

    function ZiyaratRatesUpdate(cnt) {
        var PackagesUID = $("#PackageUID").val();
        var TransportsID = $("#ZiyaratTransport" + cnt).val();
        var NoOfPax = $("#ZiyaratNoOfPax_" + cnt).val();
        var Ziarat = $("#Ziyarat_" + cnt).val();
        response = AjaxResponse("html/GetZiyaratRatesByPackageUpdate", "Ziarat=" + Ziarat + "&PackagesUID=" + PackagesUID + "&TransportsID=" + TransportsID + "&NoOfPax=" + NoOfPax);
        $("#ZiyaratTransportsRatess_" + cnt).html(response.html);
        var rate = NoOfPax * response.rate;
        $("#ZiyaratTransportsRates_" + cnt).val(rate);

    }

    function ZiyaratRates(TransportsID, cnt) {
        var PackagesUID = $("#PackageUID").val();
        var Ziarat = $("#Ziyarat_" + cnt).val();
        response = AjaxResponse("html/GetZiyaratRatesByPackageIDForGroup", "Ziarat=" + Ziarat + "&PackagesUID=" + PackagesUID + "&TransportsID=" + TransportsID);
        $("#ZiyaratTransportsRatess_" + cnt).html(response.html);
        $("#ZiyaratTransport_" + cnt).val(response.rate);
        $("#ZiyaratNoOfPax_" + cnt).val(null);


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
        Sectors = '<?php $data['LookupsOptions'] = $Crud->LookupOptions('transport_sectors'); foreach ($data['LookupsOptions'] as $options) {
            echo '<option value="' . $options['UID'] . '">' . $options['Name'] . '</option>';
        }?>';
        Transports = '<?php foreach ($TransportData as $TransportUID => $thisType) {
            echo '<option value="' . $TransportUID . '">' . $thisType . '</option>';
        } ?> ';


        html = ' <div class="row" id="TransportAttachmentCount' + cnt + '" name="TransportAttachmentCount">\n' +
            ' <div class="col-md-12"><hr data-content="Package Transport" class="hr-text"></div>\n' +
            ' <div class="col-md-2"> <div class="form-group mb-3"><input type="hidden" name="SelfTransport[]" value="0"><label  for="country">Sectors</label> <select  class="form-control validate[required]" id="TransportSectors_' + cnt + '" name="TransportSectors[]">\n' +
            ' <option value="">Please Select</option> ' + Sectors + ' </select></div> </div>\n' +
            ' <div class="col-md-2"> <div class="form-group mb-3"><label for="country">Transports</label> <select class="form-control validate[required]" id="Transport_' + cnt + '" name="Transport[]"  onchange = "TransportRates(this.value,' + cnt + ')"> <option value="">Please Select  </option>' + Transports + ' </select></div> </div>\n' +
            '<div class="col-md-2">  <div class="form-group mb-3"> <label for="country">BRN Type</label>  <select class="form-control validate[required]" id="TransportBRNType_' + cnt + '"  name="TransportBRNType[]"> <option value="">Please Select</option> <option value="Actual">Actual</option> <option value="Visa">Visa</option>  </select>    </div> </div>\n' +
            ' <div class="col-md-2">  <div class="form-group mb-3"><label for="country">No Of Pax </label><input type="text" class="form-control validate[required,funcCall[checknumberofpax]] "  name ="NoOfPax[]" id="NoOfPax_' + cnt + '" value ="' + CountPilgrim + '"></div> </div>\n' +
            ' <div class="col-md-2">  <div class="form-group mb-3"><label for="country">No Of Seats</label><input type="text" class="form-control validate[required ,funcCall[checknumberofseats]]"  name ="NoOfSeats[]" id="NoOfSeats_' + cnt + '" value ="" oninput="TransportRateUpdate(' + cnt + ');"></div> </div>\n' +
            ' <div class="col-md-2">  <div class="form-group mb-3"><label for="country">Transport Rates <a name="removeButton" href="javascript:void(0);" onClick="RemoveTransportAttachmentRow(' + cnt + ')" id="removeButton" class="float-right" style="padding-left: 10px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></label><br><input type ="hidden" name ="TransportsRates[]" id="TransportRateValue_' + cnt + '" value =""><span id="TransportsRates_' + cnt + '" class="AmountSpan">-</span> </div> </div>\n' +
            ' <div class="col-md-1">  <label for="country"> </label> <br> </div> <div class = "col-md-12"><hr></div> </div>';
        DefaultScripts();
        return html;

    }

    function TransportRates(TransportID, cnt) {
        var PackagesUID = $("#PackageUID").val();
        response = AjaxResponse("html/GetTransportRatesByPackageIDForGroup", "TransportID=" + TransportID + "&PackagesUID=" + PackagesUID);
        $("#TransportsRates_" + cnt).html(response.html);
        $("#TransportRateValue_" + cnt).val(response.rate);

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

    function RemoveTransportAttachmentRow(cnt) {

        TransportAttachmentCount = parseInt($("#TransportAttachmentCount").val());
        $('#TransportAttachmentCount' + cnt).remove();
        $("#TransportAttachmentCount").val(TransportAttachmentCount - 1);
    }

    function LoadZiyaratByCites(city, cnt) {
        ziarat = AjaxResponse("html/GetZiaratDropdownByCity", "city=" + city);
        $("#ZiyaratR  #ZiyaratAttachmentCount" + cnt + " select#Ziyarat_" + cnt).html('<option value="">Ziyarat</option>' + ziarat.html);
    }

    function RemoveZiyaratRow(cnt) {
        ZiyaratAttachmentCount = parseInt($("#ZiyaratAttachmentCount").val());
        $('#ZiyaratAttachmentCount' + cnt).remove();
        $("#ZiyaratAttachmentCount").val(ZiyaratAttachmentCount - 1);
    }


    function LoadAgentGirdByAgentID(id) {
        PilgrimHtml = AjaxResponse("html/GetVoucherPilgrimGrid", "id=" + id + "&vid=0");
        $("#ServicesGrid").html(PilgrimHtml.services_html);
        $("#ExportPackage").html(PilgrimHtml.export_button);
        // $("#AgentID").val(id);
        $("#PackageUID").val(PilgrimHtml.package_id);
        $("#VoucherCode").val(PilgrimHtml.VoucherCode);
        $("#Visa").html(PilgrimHtml.Visa);

    }

    function RemoveFlightAttachmentRow(cnt) {

        FlightAttachmentCount = parseInt($("#FlightAttachmentCount").val());
        $('#FlightAttachmentCount' + cnt).remove();
        $("#FlightAttachmentCount").val(FlightAttachmentCount - 1);
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
        var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;
        var html;
        var mindate = $("#ArrivalDate").val();
        var maxdate = $("#DepartureDate").val();
        html = '<div class="row" id="RequestedAccomodationCount' + cnt + '" name="RequestedAccomodationCount">\n' +
            '<div style="margin-bottom:15px;" class="col-md-12"><hr id="datacontent' + cnt + '" data-content="Package Hotel" class="hr-text"><input type="hidden" class="accommationnights" name="AccommationNights[]" id="AccommationNights' + cnt + '"></div>\n' +
            '<div class="col-md-2">  <div class="form-group mb-3"> <label for="country">City</label> <input type="hidden" name="Self[]" value="0"> <select class="form-control validate[required]" id="City" onChange="LoadHotelByCites(this.value,' + cnt + ')"  name="City[' + cnt + ']">  </select> </div>  </div>\n' +
            '<div class="col-md-3">  <div class="form-group mb-3"> <label for="country">Hotel</label>  <select class="form-control validate[required]" id="Hotel_' + cnt + '"  name="Hotels[' + cnt + ']">   </select>    </div> </div>\n' +
            '<div class="col-md-2">  <div class="form-group mb-3"> <label for="country">BRN Type</label>  <select class="form-control validate[required]" id="BRNType_' + cnt + '"  name="BRNType[' + cnt + ']"> <option value="">Please Select</option> <option value="Actual">Actual</option> <option value="Visa">Visa</option>  </select>    </div> </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country">Check-In</label>   <input type="date" class="form-control hdatefrom validate[required,funcCall[checkindate]]" data-rowid="' + cnt + '" id="CheckIn' + cnt + '" name="CheckIn[' + cnt + ']"   aria-describedby="emailHelp1"  placeholder="Check IN" min="' + mindate + '" max="' + maxdate + '" value="' + mindate + '">   </div>   </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country">Check-Out</label> <input type="date" class="form-control hdateto validate[required,funcCall[checkoutdate]]" id="CheckOut' + cnt + '"  name="CheckOut[' + cnt + ']"  aria-describedby="emailHelp1"  placeholder="Check Out" min="' + mindate + '" max="' + maxdate + '" value="' + maxdate + '" onchange="GetNoOfDaysRate(\'RequestedAccomodationCount' + cnt + '\',' + cnt + ',0,' + cnt + ')";>   </div>  </div>\n' +
            '<div class="col-md-1">  <label for="country">Total <a name="removeButton" href="javascript:void(0);" onClick="RemoveRequstedAccomodationAttachmentRow(' + cnt + ')" id="removeButton" class="float-right" style="padding-left: 10px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></label>  <div class="form-group mb-3"> <input type ="hidden" name ="AmountPayable[' + cnt + ']" id="AmountPayableInput_' + cnt + '" value =""> <span class="AmountSpan" id="AmountPayable_' + cnt + '"></span>  </div>  </div>\n' +
            '<div class="col-md-12" id="RequestedAccomodationRoomType' + cnt + '">\n' +
            '<div class="row" id="RequestedAccomodationRoomTypeCount' + cnt + '_' + cnt + '">\n' +
            '<div class="col-md-3"> <div class="form-group mb-3">  <label for="country">Room Type</label>  <select class="form-control RoomType' + cnt + ' validate[required]" id="RoomType_' + cnt + '_' + cnt + '"  name="RoomType[' + cnt + '][]" onchange="GetRoomRate(\'RequestedAccomodationCount' + cnt + '\',' + cnt + ',\'RequestedAccomodationRoomTypeCount' + cnt + '_' + cnt + '\',' + cnt + ');">   <option value="">Please Select</option>  <?=$RoomTypes?>  </select>  </div> </div>\n' +
            '<div class="col-md-3">   <div class="form-group mb-3">  <label for="country" id="noofroomsbeds' + cnt + '_' + cnt + '">No Of Beds</label> <input type="number" class="form-control NoOfBeds' + cnt + ' validate[required,funcCall[checknumberofbeds]]" min="1" max="' + CountPilgrim + '"  id="NoOfBeds_' + cnt + '_' + cnt + '"  name="NoOfBeds[' + cnt + '][]" value="' + CountPilgrim + '" oninput="GetRoomRate(\'RequestedAccomodationCount' + cnt + '\',' + cnt + ',\'RequestedAccomodationRoomTypeCount' + cnt + '_' + cnt + '\',' + cnt + ');"  aria-describedby="emailHelp1"  placeholder="">   </div>  </div>\n' +
            '<div class="col-md-3">  <label for="country">Charges</label>  <div class="form-group mb-3"> <input type ="hidden" name ="AmountHotelPayable[' + cnt + '][]" id="AmountPayableInput_' + cnt + '_' + cnt + '" class="AmountPayable' + cnt + '"> <span class="AmountSpan AmountSpan' + cnt + '" id="AmountPayable_' + cnt + '_' + cnt + '"></span>  </div>  </div>\n' +
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
            '<div class="col-md-3"> <div class="form-group mb-3">  <label for="country">Room Type</label>  <select class="form-control RoomType' + cnt + ' validate[required]" id="RoomType_' + cnt + '_' + count + '"  name="RoomType[' + cnt + '][]" onchange="GetRoomRate(\'RequestedAccomodationCount' + cnt + '\',' + cnt + ',\'RequestedAccomodationRoomTypeCount' + cnt + '_' + count + '\',' + count + ');">   <option value="">Please Select</option><?=$RoomTypes?></select>  </div> </div>\n' +
            '<div class="col-md-3">  <div class="form-group mb-3">  <label for="country" id="noofroomsbeds' + cnt + '_' + count + '">No Of Beds</label> <input type="number" class="form-control NoOfBeds' + cnt + ' validate[required,funcCall[checknumberofbeds]]" min="1"  id="NoOfBeds_' + cnt + '_' + count + '"  name="NoOfBeds[' + cnt + '][]"  aria-describedby="emailHelp1"  placeholder="No Of Beds" oninput="GetRoomRate(\'RequestedAccomodationCount' + cnt + '\',' + cnt + ',\'RequestedAccomodationRoomTypeCount' + cnt + '_' + count + '\',' + count + ');">   </div>  </div>\n' +
            '<div class="col-md-3">  <label for="country">Charges</label>  <div class="form-group mb-3"> <input type ="hidden" name ="AmountHotelPayable[' + cnt + '][]" id="AmountPayableInput_' + cnt + '_' + count + '" class="AmountPayable' + cnt + '"> <span class="AmountSpan AmountSpan' + cnt + '" id="AmountPayable_' + cnt + '_' + count + '"></span>  </div>  </div>\n' +
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

    function RequstedBulkPilgrimFormHTML() {

        var html = '';
        var titledata = '<?php echo $titledata;?>';
        var countrydata = '<?php echo Countries('html') ?>';
        var paxtotal = $("#NoOfPAX").val();
        var relation = '<?php echo $relationdata;?>';
        var changenationality = '';
        var changecity = '';
        var count = 0;
        for (let i = 1; i <= paxtotal; i++) {
            count++;
            if (i == 1) {
                changenationality = 'onchange="changenationality(this.value);"';
                changecity = 'onchange="changecity(this.value);"';

            }

            html += '<div class="row">\n' +
                // '<div class="col-xl-2 col-lg-12 col-md-4"><div class="upload mt-4 pr-md-4"><input type="file" id="input-file-max-fs" name="Pilgrim[UploadFile][]" id="UploadFile" class="dropify" style="height: 166px;"/><p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i>Upload Picture</p></div></div>\n' +
                '<div class="col-xl-12 col-lg-12 col-md-8 mt-md-0 mt-4">\n' +
                '<div class="form">\n' +
                '<div class="row">\n' +
                '<div class="col-md-3"><div class="form-group"><label for="country">Title</label><select class="form-control" id="Title" name="Pilgrim[Title][]"> <option value="">Please Select</option>' + titledata + '</select></div></div>\n' +
                '<div class="col-md-3"><div class="form-group"><label for="address">FirstName</label><input type="text" class="form-control mb-4  validate[required]" id="FirstName" name="Pilgrim[FirstName][]" placeholder="First Name"></div></div>\n' +
                '<div class="col-md-3"><div class="form-group"><label for="location">Middle Name</label><input type="text" class="form-control mb-4  validate[required]" id="MiddleName" name="Pilgrim[MiddleName][]" placeholder="Middle Name"></div></div>\n' +
                '<div class="col-md-3"><div class="form-group"><label for="location">Last Name</label><input type="text" class="form-control mb-4  validate[required]" id="LastName" name="Pilgrim[LastName][]" placeholder="Last Name"></div></div>\n' +
                // '<div class="col-md-3"><div class="form-group"><label for="location">Gender</label><select class="form-control" id="Gender" name="Pilgrim[Gender][]"><option value="">Please Select</option><option value="Male">Male</option><option value="Female">Female</option></select></div></div>\n' +
                '</div>\n' +
                '<div class="row">\n' +
                '<div class="col-md-3"><div class="form-group"><label for="phone">Passport Number </label><input type="text" class="form-control mb-4  validate[required]" id="PassportNumber" name="Pilgrim[PassportNumber][]" placeholder="Passport Number"></div></div>\n' +
                '<div class="col-md-3"><div class="form-group"><label for="email">Passport Issue Date</label><input type="date" class="form-control mb-4" id="PassportIssueDate" name="Pilgrim[PassportIssueDate][]" placeholder="Passport Issue Date"></div></div>\n' +
                '<div class="col-md-3"><div class="form-group"><label for="email">Passport Expiry Date</label><input type="date" class="form-control mb-4" id="PassportExpiryDate" name="Pilgrim[PassportExpiryDate][]" placeholder="Passport Expiry Date"></div></div>\n' +
                '<div class="col-md-3"><div class="form-group"><label for="email">Nationality</label><select class="form-control" id="Nationality' + i + '" name="Pilgrim[Nationality][]" ' + changenationality + '><option value="">Please Select</option>' + countrydata + '</select></div></div>\n' +
                '</div>\n' +
                '<div class="row">\n' +
                // '<div class="col-md-3"><div class="form-group"><label for="phone">Relation </label><select class="form-control" id="Relation" name="Pilgrim[Relation][]"><option value="">Please Select</option>' + relation + '</select></div></div>\n' +
                '<div class="col-md-3"><div class="form-group"><label for="phone">CitizenShip Number</label><input type="text" class="form-control mb-4  validate[required]" id="CitizenShipNumber" name="Pilgrim[CitizenShipNumber][]" placeholder="CitizenShip Number"></div></div>\n' +
                '<div class="col-md-3"><div class="form-group"><label for="email">Issue Date</label><input type="date" class="form-control mb-4" id="IssueDate" name="Pilgrim[IssueDate][]" placeholder=" Issue Date"></div></div>\n' +
                '<div class="col-md-3"><div class="form-group"><label for="email">Expiry Date</label><input type="date" class="form-control mb-4" id="ExpiryDate" name="Pilgrim[ExpiryDate][]" placeholder=" Expiry Date"></div></div>\n' +
                '<div class="col-md-3"><div class="form-group"><label for="email">DOB</label><input type="date" class="form-control mb-4" id="DOB" name="Pilgrim[DOB][]" placeholder="DOB"></div></div>\n' +
                // '<div class="col-md-3"><div class="form-group"><label for="email">Country</label><select class="form-control" id="Countries' + i + '" name="Pilgrim[Countries][]" onChange="LoadCitiesDropdown(this.value,' + i + ')"><option value="">Please Select</option>' + countrydata + '</select></div></div>\n' +
                // '<div class="col-md-3"><div class="form-group"><label for="City">City</label><select class="form-control" id="City_' + i + '" name="Pilgrim[City][]" ' + changecity + '></select></div></div>\n' +
                '</div>\n' +
                '<div class="row">\n' +
                '<div class="col-md-3"><div class="form-group"><label for="phone">Passport 1st Page </label><input type="file"  name="Pilgrim[PassportFile][]" id="PassportFile"/></div></div>\n' +
                '<div class="col-md-3"><div class="form-group"><label for="phone">CitizenShip Card</label><input type="file"  name="Pilgrim[CitizenShipCard][]" id="CitizenShipCard"/></div></div>\n' +
                '<div class="col-md-3"><div class="form-group"><label for="email">Visa</label><input type="file"  name="Pilgrim[Visa][]" id="Visa"/></div></div>\n' +
                '<div class="col-md-3"><div class="form-group"><label for="email">Ticket</label><input type="file"  name="Pilgrim[Ticket][]" id="Ticket"/></div></div>\n' +
                '<div class="col-md-3"><div class="form-group"><label for="City">Vaccination Certificate  </label><span><a  id="appendbtn"><i class="fa fa-plus fa-fw plusInonBtn" onclick="data('+count+')"  aria-hidden="true"></i> </a> </span><input type="file"  name="Pilgrim[VaccinationCertificate][]" id="VaccinationCertificate"/></div></div>\n' +
                '</div>\n' +
                '<div class="row" id="addTraveler_'+count+'"></div> \n</div>\n ' +
                '</div>\n' +
                '</div>\n' +
                '<div class="col-md-12"><hr style="border-top: 1px solid black"></div>';
        }
        //alert('AA');
        DefaultScripts();
        $('#bulkpilgrim').html(html);
        $('.dropify').dropify();
    }

    // addmore code start here
    function data(id) {

        $('#addTraveler_'+id).append('<br /><div class="col-md-3 removeinputfield_'+id+' "><div class="form-group "><label for="otherDocument">Other Documents  </label> <span><a  class="appendbtn"><i class="fa fa-trash trashcss  plusInonBtn" onclick="dataRemove('+id+')"  aria-hidden="true"></i> </a> </span><input type="file"  name="Pilgrim[otherDocument][]" id="otherDocument"/></div></div>\n<br />');
    }
    function dataRemove(id) {
        $('.removeinputfield_'+id).remove();
    }

    // $("#appendbtn").click(function () {
    //     $("#appendbtn").preventDefault();
    //     $('#addTraveler').append('<br /><div class="col-md-3"><div class="form-group"><label for="City">Vaccination Certificate <span><a  class="appendbtn"><i class="fa fa-plus fa-fw plusInonBtn" onclick="data()"  aria-hidden="true"></i> </a> </span> </label><input type="file"  name="Pilgrim[VaccinationCertificate][]" id="VaccinationCertificate"/></div></div>\n<br />');
    //
    // });
    // addmore code End here


    function changenationality(id) {

        var paxtotal = $("#NoOfPAX").val();
        var first_num = $("#Nationality1").val();
        for (var i = 2; i <= paxtotal; i++) {
            $("#Nationality" + i).val(first_num);
        }

    }

    function changecountry(id) {

        var paxtotal = $("#NoOfPAX").val();
        var country = $("#Countries1").val();
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country + "&selected=<?=$pilgrim_data['CityID']?>");

        for (var i = 2; i <= paxtotal; i++) {
            $("#Countries" + i).val(country);

        }
        for (var i = 1; i <= paxtotal; i++) {

            $("#City_" + i).html('<option value="">Please Select</option>' + cities.html);
        }

    }

    function changecity(id) {

        var paxtotal = $("#NoOfPAX").val();
        var city_name = $("#City_1").val();
        for (var i = 2; i <= paxtotal; i++) {
            $("#City_" + i).val(city_name);
        }

    }

    function LoadCitiesDropdown(country, i) {
        if (i == 1) {
            changecountry(country);
            return false;
        }
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country + "&selected=<?=$pilgrim_data['CityID']?>");
        $("#City_" + i).html('<option value="">Please Select</option>' + cities.html);


    }

    function RemoveRequstedAccomodationAttachmentRow(cnt) {

        RequestedAccomodationCount = parseInt($("#RequestedAccomodationCount").val());
        $('#RequestedAccomodationCount_' + cnt).remove();
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
        //alert("#RequestedAccomodationCount_" + cnt + " #City");

        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country);
        $("#RequestedAccomodationCount" + cnt + " #City").html('<option value="">Please Select</option>' + cities.html);
        DefaultScripts();
    }

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

    /*function GetRoomRate(parent, cnt) {
        alert( parent );
        var CheckIn = $("#CheckIn" + cnt).val();
        var CheckOut = $("#CheckOut" + cnt).val();

        var AgentID = $("#GroupAddForm #AgentID").val();
        var HotelID = $("#" + parent + " #Hotel_" + cnt).val();
        var RoomType = $("#" + parent + " #RoomType").val();
        var RoomTypeName =$( "#" + parent + " #RoomType option:selected" ).text();
        if(RoomTypeName=='Sharing'){
            $('#noofroomsbeds' + cnt).text("No Of Beds");
        }else{
            $('#noofroomsbeds' + cnt).text("No Of Rooms");
        }
        alert( RoomType );
        // var CheckIn = $("#" + parent + " #CheckIn"+ cnt).val();
        // var CheckOut = $("#" + parent + " #CheckOut"+ cnt).val();
        var NoOfBeds = $("#GroupAddForm  #NoOfBeds_" + cnt).val();
        var response = AjaxResponse("form_process/GetRoomTypePackageForGroup", "RoomType=" + RoomType + "&AgentID=" + AgentID + "&HotelID=" + HotelID + "&CheckIn=" + CheckIn + "&CheckOut=" + CheckOut + "&NoOfBeds=" + NoOfBeds);
        if (response.status == 'success') {
            $("#AmountPayable_" + cnt).html(response.CurrentCharges)
            $("#AmountPayableInput_" + cnt).val(response.Rate)

        }
    }*/

    function MultipleGetRoomRateDate(parent, cnt, count) {
        var CheckIn = $("#CheckIn" + cnt).val();
        var CheckOut = $("#CheckOut" + cnt).val();

        var AgentID = $("#GroupAddForm #AgentID").val();
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
        var CheckIn = $("#CheckIn" + cnt).val();
        var CheckOut = $("#CheckOut" + cnt).val();

        var AgentID = $("#GroupAddForm #AgentID").val();
        var HotelID = $("#" + parent + " #Hotel_" + cnt).val();
        var RoomType = $("#" + parent + " #" + childparent + " #RoomType_" + cnt + "_" + count).val();
        var RoomTypeName = $("#RoomType_" + cnt + "_" + count + " option:selected").text();
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
            var response = AjaxResponse("form_process/GetRoomTypePackageForGroup", "RoomType=" + RoomType + "&AgentID=" + AgentID + "&HotelID=" + HotelID + "&CheckIn=" + CheckIn + "&CheckOut=" + CheckOut + "&NoOfBeds=" + NoOfBeds);
            if (response.status == 'success') {
                $("#AmountPayable_" + cnt + "_" + count).html(response.CurrentCharges);
                $("#AmountPayableInput_" + cnt + "_" + count).val(response.Rate);
            }
            MultipleGetRoomRate(cnt);
        }

    }


    setTimeout(function () {
        // var AgentID = $("#GroupAddForm #AgentID").val();
        // LoadAgentGirdByAgentID(AgentID);
        // var ArrivalType = $("#ArrivalType").val();

        //AddTransportAttachmentRow();
        //AddNewZiyarat();
        // LoadAgentGirdByAgentID();
        //AddRequestestedAccomodationAttachmentRow();

    }, 100)
</script>
<script src="<?= $template ?>plugins/jquery-step/jquery.steps.min.js"></script>

<script>

    function GroupFormSummary() {

        /*var validate = $("form#GroupAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }*/

        //var phpdata = new window.FormData($("form#GroupAddForm")[0]);
        var phpdata = $("form#GroupAddForm").serialize();
        var response = AjaxRequest("form_process/group_bulk_pilgrim_form_submmary", phpdata, "SummaryGrid");


    }

    function changeminmaxdate() {
        var mindate = $("#ArrivalDate").val();
        var maxdate = $("#DepartureDate").val();
        $('.hdatefrom').attr('min', mindate);
        $('.hdateto').attr('max', maxdate);
    }

    function GroupValidation(currentIndex, newIndex) {
//alert(currentIndex+"-"+newIndex);
        if (currentIndex == 0 && newIndex == 1) {
            changeminmaxdate();
            RequstedBulkPilgrimFormHTML();
        }
        if (currentIndex == 5 && newIndex == 6) {
            GroupFormSummary();

        }


        return true;
    }

    $("#VoucherSection").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: true,
        cssClass: 'pill wizard',
        onStepChanging: function (event, currentIndex, newIndex) {
            return GroupValidation(currentIndex, newIndex);

        },
        onFinished: function (event, currentIndex) {
            GroupFormSubmit();
            //alert('Final Submission under process......');
        }
    });


    $("form#HotelAddForm").on("submit", function (event) {
        event.preventDefault();
    });


    function SetReturnDate(field, rules, i, options) {
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

    function GetArrivalReturnDays(field, rules, i, options) {

        var startDay = new Date($("#ArrivalDate").val());
        var endDay = new Date($("#DepartureDate").val());
        var millisBetween = endDay.getTime() - startDay.getTime();
        var days = millisBetween / (1000 * 3600 * 24);
        if (days < 8 || days > 25) return "Number of days between 8 to 25"

    }

    function checktraveldate(field, rules, i, options) {

        if (Date.parse(field.val()) < Date.parse($("#ArrivalDate").val()) || Date.parse(field.val()) > Date.parse($("#DepartureDate").val())) return "Please enter date between " + $("#ArrivalDate").val() + " and " + $("#DepartureDate").val()

    }

    function checktravelarrivaldate(field, rules, i, options) {

        if (Date.parse(field.val()) < Date.parse($("#DepartureDateDeparture").val())) return "Please enter date greater than or equal to " + $("#DepartureDateDeparture").val()

    }

    function checktravelreturndate(field, rules, i, options) {

        if (Date.parse(field.val()) < Date.parse($("#DepartureDateReturn").val())) return "Please enter date greater than or equal to " + field.val()

    }

    function checkindate(field, rules, i, options) {
        var rowid = field.data('rowid');
        var checkoutid = '#RequestedAccomodationCount_' + rowid + ' #CheckOut' + rowid;
        if (Date.parse(field.val()) < Date.parse($("#ArrivalDate").val()) || Date.parse(field.val()) > Date.parse($("#DepartureDate").val())) return "Please enter date between " + $("#ArrivalDate").val() + " and " + $("#DepartureDate").val()
        $(checkoutid).attr('min', field.val());

    }

    function checkoutdate(field, rules, i, options) {
        if (Date.parse(field.val()) < Date.parse($("#ArrivalDate").val()) || Date.parse(field.val()) > Date.parse($("#DepartureDate").val())) return "Please enter date between " + $("#ArrivalDate").val() + " and " + $("#DepartureDate").val()
    }

    function checknumberofbeds(field, rules, i, options) {
        var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;
        if (field.val() > CountPilgrim || field.val() < 1) return "Please enter No Of Beds upto " + CountPilgrim
    }

    function checknumberofpax(field, rules, i, options) {
        var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;
        if (field.val() > CountPilgrim || field.val() < 1) return "Please enter No Of Pax upto " + CountPilgrim
    }

    function checknumberofseats(field, rules, i, options) {
        var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;
        if (field.val() > CountPilgrim || field.val() < 1) return "Please enter No Of Seats upto " + CountPilgrim
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
        } else {
            $('#totalaccomodationnights').text("");
        }

    }
</script>
