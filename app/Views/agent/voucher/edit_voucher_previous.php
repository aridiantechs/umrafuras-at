<link rel="stylesheet" type="text/css" href="<?= $template ?>plugins/jquery-step/jquery.steps.css">
<?php

use App\Models\Main;
use App\Models\Crud;

$Crud = new Crud();
$session = session();
$session = $session->get();


$data['LookupsOptions'] = $Crud->LookupOptions('room_types');
foreach ($data['LookupsOptions'] as $options) {
    $selected = (($data['Category'] == $options['UID']) ? 'selected' : '');
    $RoomTypes = '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['Name'] . '</option>';
}

$airports = new Main();
$data['airport'] = $airports->ListAirports();
$Airportshtml = '';

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
                                    <h4>Edit Voucher
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <form enctype="multipart/form-data" class="validate" method="post" action="#"
                                  id="VoucherAddForm" name="VoucherAddForm">
                                <input type="hidden" id="UID" name="UID" value="<?= $VoucherData['UID'] ?>">
                                <div id="example-basic">
                                    <h3>Voucher Details</h3>
                                    <section>
                                        <div id="VoucherDetails">
                                            <div class="row" id="voucher_details">
                                                <div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Agent</label>
                                                        <?php
                                                        if ($AgentLogged) {
                                                            echo '<input type="hidden" id="AgentID" name="AgentID" value="' . $session['id'] . '"> 
                                                                <span class="form-control"  id="Agent" name="AgentName" placeholder="AgentName">' . $session['name'] . '</span>';
                                                        } else {
                                                            echo '<select class="form-control validate[required]" id="AgentID" name="AgentID" onChange="LoadAgentGirdByAgentID(this.value)"> <option value="">Please Select</option>';
                                                            foreach ($Agents as $agent) {
                                                                $selected = (($VoucherData['AgentUID'] == $agent['UID']) ? 'selected' : '');
                                                                echo ' <option value="' . $agent['UID'] . '"' . $selected . '>' . $agent['FullName'] . '</option>  ';
                                                            }
                                                            echo '</select>';
                                                        } ?>

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Voucher Code</label>
                                                        <input type="text" class="form-control mb-4"
                                                               id="VoucherCode" name="VoucherCode"
                                                               placeholder="Voucher Code"
                                                               value="<?= $VoucherData['VoucherCode'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Arrival Type</label><br>
                                                        <select class="form-control validate[required]" id="ArrivalType"
                                                                name="ArrivalType">
                                                            <option value="Air" <?= (($VoucherData['ArrivalType'] == 'Air') ? 'selected' : '') ?>>Air</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Arrival Date </label>
                                                        <input type="date" class="form-control mb-4"
                                                               id="VoucherArrivalDate" name="VoucherArrivalDate"
                                                               placeholder="Arrival Date"
                                                               value="<?= $VoucherData['ArrivalDate'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Expiry Date</label><br>
                                                        <input type="date" class="form-control mb-4"
                                                               id="ExpiryDate" name="ExpiryDate"
                                                               placeholder="Expiry Date"
                                                               value="<?= $VoucherData['ExpiryDate'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Reference/Remarks</label><br>
                                                        <textarea class="form-control mb-4"
                                                                  id="Reference" name="Reference"
                                                                  placeholder="Reference"><?= $VoucherData['Reference'] ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <h3> Pilgrim Details</h3>
                                    <section>
                                        <div id="Pilgrim">
                                        </div>
                                    </section>
                                    <h3> Flight's Detail </h3>
                                    <section>
                                        <div id="FilghtsDetails">
                                            <div id="FlightR" name="FlightR">
                                                <h5>Flight Details
                                                    <a href="javascript:void(0);" id="AddFlightRows"
                                                       class="float-right" style="margin-right: 10px;"
                                                       onclick="AddNewFlightAttachmentRow();"><span>
                                                        <i class="fa fa-plus" title="Add More"></i></span></a>
                                                </h5>
                                                <hr>
                                                <?php foreach ($VoucherFlightsDetails as $voucherFlightsDetail) { ?>
                                                    <div class="row" id="FlightRows" name="FlightRows">
                                                        <input type="hidden" id="FlightAttachmentCount"
                                                               name="FlightAttachmentCount" value="0">
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3"><label for="country">Flight
                                                                    Type</label> <select class="form-control"
                                                                                         id="FlightType"
                                                                                         name="FlightType[]">
                                                                    <option value="">Please Select</option>
                                                                    <option value="Departure"<?= (($voucherFlightsDetail['FlightType'] == 'Departure') ? 'selected' : '') ?>>
                                                                        Departure
                                                                    </option>
                                                                    <option value="Return" <?= (($voucherFlightsDetail['FlightType'] == 'Return') ? 'selected' : '') ?>>
                                                                        Return
                                                                    </option>
                                                                </select></div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-3">
                                                                <label for="country">Airport</label>
                                                                <select class="form-control" id="Airport"
                                                                        name="Airport[]">
                                                                    <option value="">Please Select</option><?php
                                                                    foreach ($data['airport'] as $option) {
                                                                        echo '<option value="' . $option['UID'] . '" ' . (($voucherFlightsDetail['AirportID'] == $option['UID']) ? 'selected' : '') . '>
                                                                                ' . $option['Code'] . '-' . $option['Name'] . '-' . $option['CountryName'] . '
                                                                              </option>';
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3">
                                                                <label for="Sector">Sector</label>
                                                                <input type="text" class="form-control" id="Sector"
                                                                       name="Sector[]" aria-describedby="emailHelp1"
                                                                       placeholder="Sector"
                                                                       value="<?= $voucherFlightsDetail['Sector'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3">
                                                                <label for="FlightNumber">Flight No</label>
                                                                <input type="text" class="form-control"
                                                                       id="FlightNumber" name="FlightNumber[]"
                                                                       aria-describedby="emailHelp1"
                                                                       placeholder="Flight Number"
                                                                       value="<?= $voucherFlightsDetail['FlightNo'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3">
                                                                <label for="PNR">PNR</label>
                                                                <input type="text" class="form-control" id="PNR"
                                                                       name="PNR[]" aria-describedby="emailHelp1"
                                                                       placeholder="PNR"
                                                                       value="<?= $voucherFlightsDetail['PNR'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group mb-3">
                                                                <label for="DepartureDate">Departure Date</label>
                                                                <input type="date" class="form-control"
                                                                       id="DepartureDate" name="DepartureDate[]"
                                                                       aria-describedby="emailHelp1"
                                                                       placeholder="Departure Date"
                                                                       value="<?= $voucherFlightsDetail['DepartureDate'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group mb-3">
                                                                <label for="country">Departure Time</label>
                                                                <input type="time" class="form-control"
                                                                       id="DepartureTime" name="DepartureTime[]"
                                                                       aria-describedby="emailHelp1"
                                                                       placeholder="Departure Time"
                                                                       value="<?= $voucherFlightsDetail['DepartureTime'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group mb-3">
                                                                <label for="ArrivalDate">Arrival Date</label>
                                                                <input type="date" class="form-control"
                                                                       id="ArrivalDate" name="ArrivalDate[]"
                                                                       aria-describedby="emailHelp1"
                                                                       placeholder="Arrival Date"
                                                                       value="<?= $voucherFlightsDetail['ArrivalDate'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group mb-3">
                                                                <label for="country">Arrival Time</label>
                                                                <input type="time" class="form-control"
                                                                       id="ArrivalTime" name="ArrivalTime[]"
                                                                       aria-describedby="emailHelp1"
                                                                       placeholder="Arrival Time"
                                                                       value="<?= $voucherFlightsDetail['ArrivalTime'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="form-group mb-3">
                                                                <label for="country"> </label>
                                                                <br>
                                                                <a name="removeButton" href="javascript:void(0);"
                                                                   onClick="RemoveFlightAttachmentDetailRow(<?= $voucherFlightsDetail['UID'] ?>)"
                                                                   id="removeButton" class="float-right"
                                                                   style="padding: 25px;"><span>
                                                                        <i class="fa fa-trash"
                                                                           title="Remove"></i></span></a>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <hr>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </section>
                                    <h3> Requested Accommodation Detail</h3>
                                    <section>
                                        <div id="RequestedAccomodationDetails">
                                            <div id="HotelR" name="HotelR">
                                                <h5>Accommodation Details
                                                    <a href="javascript:void(0);" id="AddFlightRows"
                                                       class="float-right" style="margin-right: 10px;"
                                                       onclick="AddRequestestedAccomodationAttachmentRow();"><span>
                                                        <i class="fa fa-plus" title="Add More"></i></span></a>
                                                </h5>
                                                <hr>
                                                <input type="hidden" id="RequestedAccomodationCount"
                                                       name="RequestedAccomodationCount" value="0">
                                                <div class="row" id="HotelRows" name="HotelRows">
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-3"><label for="country">Country
                                                                Name</label> <select class="form-control" id="Country"
                                                                                     name="Country[]"
                                                                                     onChange="LoadCitiesDropdown(this.value)">
                                                                <option value="">Please Select
                                                                </option> <?= Countries("html") ?>   </select></div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-3"><label for="country">City</label>
                                                            <select class="form-control" id="City"
                                                                    onChange="LoadHotelByCites(this.value)"
                                                                    name="City[]"> </select></div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group mb-3"><label for="country">Hotel</label>
                                                            <select class="form-control" id="Hotels"
                                                                    name="Hotels[]"> </select></div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3"><label for="country">Room
                                                                Type</label> <select class="form-control" id="RoomType"
                                                                                     name="RoomType[]"
                                                                                     onchange="RoomtypeSelect(this.value);">
                                                                <option value="">Please Select
                                                                </option> <?= $RoomTypes ?>  </select></div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3"><label
                                                                for="country">Check-In</label> <input type="date"
                                                                                                      class="form-control"
                                                                                                      id="CheckIn"
                                                                                                      name="CheckIn[]"
                                                                                                      aria-describedby="emailHelp1"
                                                                                                      placeholder="Check Out">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-3"><label
                                                                for="country">Check-Out</label> <input type="date"
                                                                                                       class="form-control"
                                                                                                       id="CheckOut"
                                                                                                       name="CheckOut[]"
                                                                                                       aria-describedby="emailHelp1"
                                                                                                       placeholder="Check Out">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3"><label for="country">Charges</label>
                                                        <div class="form-group mb-3"><span class="AmountSpan"
                                                                                           id="AmountPayable"
                                                                                           name="AmountPayable[]"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <hr>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </section>
                                    <h3> Extra</h3>
                                    <section>
                                        <div id="defaultAccordionThree">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                                                    <div class="widget-content widget-content-area br-6">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                                                                <thead>
                                                                <tr>
                                                                    <th class="checkbox-column">
                                                                        <label class="new-control new-checkbox checkbox-primary"
                                                                               style="height: 18px; margin: 0 auto;">
                                                                            <input type="checkbox"
                                                                                   class="new-control-input todochkbox"
                                                                                   id="todoAll">
                                                                            <span class="new-control-indicator"></span>
                                                                        </label>
                                                                    </th>
                                                                    <th>Service Name</th>
                                                                    <th>Serivce Charges</th>
                                                                    <th>Total Charges</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                foreach ($records['pilgrims'] as $record) {
                                                                    echo '
                                                                       <tr>
                                                                        <td class="checkbox-column">
                                                                            <label class="new-control new-checkbox checkbox-primary" style="height: 18px; margin: 0 auto;">
                                                                                <input type="checkbox" class="new-control-input todochkbox" id="todo-1">
                                                                                <span class="new-control-indicator"></span>
                                                                            </label>
                                                                        </td>
                                                                        <td>' . $record['GroupName'] . '</td>
                                                                        <td>' . $record['FirstName'] . '</td>
                                                                        <td>' . $record['DOB'] . '</td>                                                                      
                                                                        </tr>';
                                                                } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
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
                <div class="" id="VoucherAddResponse"></div>
                <button type="button" class="btn btn_customized float-right mb-5" onclick="VoucherFormSubmit();">
                    Submit
                </button>
            </div>

        </div>
    </div>
</div>
</div>

<script>

    setTimeout(function () {
        LoadAgentGirdByAgentID(<?=$VoucherData['AgentUID']?>);
    }, 100)

    function AddNewFlightAttachmentRow() {
        FlightAttachmentCount = parseInt($("#FlightAttachmentCount").val());

        HTML = FlightAttachmentFormHTML(FlightAttachmentCount);
        $("#FlightR").append(HTML);
        $("#FlightAttachmentCount").val(FlightAttachmentCount + 1);

        return false;
    }

    function LoadAgentGirdByAgentID(id) {
        PilgrimHtml = AjaxResponse("html/GetVoucherPilgrimGrid", "id=" + id + "&vid=<?=$VoucherData['UID']?>");
        $("#Pilgrim").html(PilgrimHtml.html);
    }


    function FlightAttachmentFormHTML(cnt) {
        cnt = cnt + 1;
        var html;

        html = '<div class="row" id="FlightAttachmentCount' + cnt + '" name="FlightAttachmentCount">\n' +
            '       <input type="hidden" id="FlightAttachmentCount" name="FlightAttachmentCount" value="0">\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Flight Type</label> <select class="form-control" id="FlightType"  name="FlightType[]"> <option value="">Please Select</option> <option value="Departure">Departure</option>  <option value="Return">Return</option> </select> </div> </div>\n' +
            '        <div class="col-md-4"> <div class="form-group mb-3">  <label for="country">Airport</label>  <select class="form-control" id="Airport' + cnt + '"  name="Airport[]"> <option value="">Please Select</option> <?=$Airportshtml?> </select> </div> </div>\n' +
            '        <div class="col-md-2">   <div class="form-group mb-3"> <label for="country">Sector</label> <input type="text" class="form-control" id="Sector"  name="Sector[]" aria-describedby="emailHelp1" placeholder="Sector">  </div>  </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Flight No</label> <input type="text" class="form-control" id="FlightNumber" name="FlightNumber[]"  aria-describedby="emailHelp1"  placeholder="Flight Number">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">PNR</label> <input type="text" class="form-control" id="PNR" name="PNR[]" aria-describedby="emailHelp1"  placeholder="PNR"> </div> </div>\n' +
            '        <div class="col-md-3">  <div class="form-group mb-3"> <label for="country">Departure Date</label>  <input type="date" class="form-control"  id="DepartureDate" name="DepartureDate[]"  aria-describedby="emailHelp1"  placeholder="Departure Date">  </div> </div>\n' +
            '        <div class="col-md-3">  <div class="form-group mb-3"> <label for="country">Departure Time</label> <input type="time" class="form-control" id="DepartureTime" name="DepartureTime[]" aria-describedby="emailHelp1" placeholder="Departure Time"> </div> </div>\n' +
            '        <div class="col-md-3">  <div class="form-group mb-3"> <label for="country">Arrival Date</label> <input type="date" class="form-control" id="ArrivalDate" name="ArrivalDate[]"  aria-describedby="emailHelp1" placeholder="Arrival Date">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Arrival Time</label> <input type="time" class="form-control" id="ArrivalTime" name="ArrivalTime[]" aria-describedby="emailHelp1" placeholder="Arrival Time"></div></div>\n' +
            '        <div class="col-md-1">  <label for="country"> </label> <br> <a name="removeButton" href="javascript:void(0);" onClick="RemoveFlightAttachmentRow(' + cnt + ')" id="removeButton" class="float-right" style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div> <div class = "col-md-12"><hr></div></div></div>\n' +
            '   </div> ';


        return html;
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
        $("#FlightAttachmentCount").val(RequestedAccomodationCount + 1);

        return false;
    }


    function RequstedAccomodationAttachmentFormHTML(cnt) {
        cnt = cnt + 1;
        var html;

        html = '    <div class="row" id="RequestedAccomodationCount_' + cnt + '" name="RequestedAccomodationCount">\n' +

            '                                                    <input type="hidden" id="RequestedAccomodationCount" name="RequestedAccomodationCount" value="0">\n' +
            '                                                    <div class="col-md-4"> <div class="form-group mb-3"> <label for="country">Country Name</label>  <select class="form-control" id="Country"  name="Country[]"  onChange="LoadCitiesDropdownagain(this.value,' + cnt + ')"> <option value="">Please Select</option>  <?= Countries("html") ?>   </select>  </div> </div>\n' +
            '                                                    <div class="col-md-4">  <div class="form-group mb-3"> <label for="country">City</label>  <select class="form-control" id="City_' + cnt + '" onChange="LoadHotelByCites(this.value)"  name="City[]">  </select> </div>  </div>\n' +
            '                                                    <div class="col-md-4">  <div class="form-group mb-3"> <label for="country">Hotel</label>  <select class="form-control" id="Hotels"  name="Hotels[]">   </select>    </div> </div>\n' +
            '                                                    <div class="col-md-3"> <div class="form-group mb-3">  <label for="country">Room Type</label>  <select class="form-control" id="RoomType"  name="RoomType[]" onchange="RoomtypeSelect(this.value);">   <option value="">Please Select</option>  <?=$RoomTypes?>  </select>  </div> </div>\n' +
            '                                                    <div class="col-md-3">   <div class="form-group mb-3">  <label for="country">Check-In</label>   <input type="date" class="form-control" id="CheckIn" name="CheckIn[]"   aria-describedby="emailHelp1"  placeholder="Check Out">   </div>   </div>\n' +
            '                                                    <div class="col-md-3">   <div class="form-group mb-3">  <label for="country">Check-Out</label> <input type="date" class="form-control" id="CheckOut"  name="CheckOut[]"  aria-describedby="emailHelp1"  placeholder="Check Out">   </div>  </div>\n' +
            '                                                    <div class="col-md-3">  <label for="country">Charges</label>  <div class="form-group mb-3">  <span class="AmountSpan" id="AmountPayable"  name="AmountPayable[]"></span>  </div>  </div>\n' +
            '                                                    <div class="col-md-12"> <hr> </div>  </div>  </div> \n' +
            '                                                </div> ';

        return html;
        LoadCitiesDropdownagain(country, cnt);
    }


    function RemoveRequstedAccomodationAttachmentRow(cnt) {

        RequestedAccomodationCount = parseInt($("#RequestedAccomodationCount").val());
        $('#FlightAttachmentCount' + cnt).remove();
        $("#RequestedAccomodationCount").val(RequestedAccomodationCount - 1);
    }


    function VoucherFormSubmit() {

        var validate = $("form#VoucherAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        var phpdata = new window.FormData($("form#VoucherAddForm")[0]);
        response = AjaxUploadResponse("form_process/voucher_form_submit", phpdata);

        if (response.status == 'success') {
            $("#VoucherAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.href = "<?=base_url('agent/vouchers')?>";
            }, 2000)
        } else {
            $("#VoucherAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }

    function LoadCitiesDropdownagain(country, cnt) {
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country);
        $("#City_" + cnt).html('<option value="">Please Select</option>' + cities.html);
    }

    function LoadCitiesDropdown(country) {
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country);
        $("#City").html('<option value="">Please Select</option>' + cities.html);
    }

    function LoadHotelByCites(city) {
        hotels = AjaxResponse("html/GetHotelDropdownByPackageCity", "city=" + city + "&agentid=<?=$agentid?>");
        $("#Hotels").html('<option value="">Please Select</option>' + hotels.html);
    }

    function RoomtypeSelect(roomtype) {
        response = AjaxResponse("form_process/GetRoomTypePackage", "roomtype=" + roomtype + "&agentid=<?=$agentid?>");
        if (response.status == 'success') {
            $("#TotalPayableAmount").html(response.TotalCharges)
            $("#AmountPayable").html(response.CurrentCharges)

        }
    }

    // checkall('todoAll', 'todochkbox');
    // $('[data-toggle="tooltip"]').tooltip()


    // function LoadPilgrimSection() {
    //     PilgrimHtml = AjaxResponse("html/GetVoucherPilgrimGrid",);
    //     $("#Pilgrim").html(PilgrimHtml.html);
    // }

    function RemoveFlightAttachmentDetailRow(UID) {
        if (confirm("Are You Sure You Want To Remove This Flight Row")) {
            response = AjaxResponse("form_process/remove_flight_row", "UID=" + UID);
            if (response.status == 'success') {
                location.href = "<?=base_url('agent/edit_voucher/' . $VoucherData['UID'] . '-' . $VoucherData['VoucherCode'] . '')?>";
            }


        }
    }
</script>


<script src="<?= $template ?>plugins/jquery-step/jquery.steps.min.js"></script>
<script src="<?= $template ?>plugins/jquery-step/custom-jquery.steps.js"></script>

