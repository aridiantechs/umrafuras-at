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
//print_r($AllAgents); exit;

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
                                    <h4>Add B2C Voucher <span id="ExportPackage"> </span>

                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <form enctype="multipart/form-data" class="validate" method="post" action="#"
                                  id="VoucherAddForm" name="VoucherAddForm">
                                <input type="hidden" id="UID" name="UID" value="0">
                                <input type="hidden" id="B2CPackageID" name="B2CPackageID" value="<?= $B2CPackageID['Description'] ?>">
                                <input type="hidden" name="CreatedBy" id="CreatedBy" value="<?= $id ?>">
                                <input type="hidden" name="CreatedDate" id="CreatedDate" value="<?= $date ?>">
                                <input type="hidden" name="VoucherType" id="VoucherType" value="B2C">


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

                                <input type="hidden" name="VoucherArrivalDate" id="VoucherArrivalDate" value="">
                                <input type="hidden" name="ReturnDate" id="ReturnDate" value="">


                                <div id="VoucherSection">
                                    <h3>Basic Details</h3>
                                    <section>
                                        <div id="VoucherDetails">
                                            <div class="row" id="voucher_details">
                                                <div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Country</label>
                                                        <select class="form-control validate[required]"
                                                                id="VoucherCountry"
                                                                name="VoucherCountry"
                                                                data-prompt-position="bottomLeft:20,35"
                                                        >
                                                            <option value="">Please Select</option>
                                                            <?= Countries("html") ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Arrival Type</label><br>
                                                        <select class="form-control validate[required]" id="ArrivalType"
                                                                name="ArrivalType"
                                                                data-prompt-position="bottomLeft:20,35"
                                                        >
                                                            <option value="Air">Air</option>
                                                            <option value="Land">Land</option>
                                                            <!--                                                            <option value="Sea">Sea</option>-->
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--                                                <div class="col-md-3">-->
                                                <!--                                                    <div class="form-group mb-3">-->
                                                <!--                                                        <label for="country">Arrival Date </label>-->
                                                <!--                                                        <input type="date"-->
                                                <!--                                                               class="form-control  validate[required,future[now],funcCall[SetReturnDate]] mb-4"-->
                                                <!--                                                               id="VoucherArrivalDate"-->
                                                <!--                                                               placeholder="Arrival Date"-->
                                                <!--                                                               min="-->
                                                <? //= date('Y-m-d', strtotime($Date . ' + 1 day')); ?><!--"-->
                                                <!--                                                               data-prompt-position="bottomLeft:20,20">-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="col-md-3">-->
                                                <!--                                                    <div class="form-group mb-3">-->
                                                <!--                                                        <label for="country">Return Date</label><br>-->
                                                <!--                                                        <input type="date"-->
                                                <!--                                                               class="form-control  validate[required,future[#VoucherArrivalDate],funcCall[GetArrivalReturnDays]] mb-4"-->
                                                <!--                                                               id="ReturnDate"-->
                                                <!--                                                               placeholder="Return Date"-->
                                                <!--                                                               data-prompt-position="bottomLeft:20,20">-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Umrah Operator</label>
                                                        <select class="form-control validate[required]"
                                                                id="UmrahOperator"
                                                                name="UmrahOperator"
                                                                data-prompt-position="bottomLeft:20,35">
                                                            <?php
                                                            foreach ($UmrahOperators as $UmrahOperator) {
                                                                echo ' <option value="' . $UmrahOperator['UID'] . '">' . $UmrahOperator['CompanyName'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Arrival Return</label>
                                                        <input type="text"
                                                               class="form-control multidate validate[required,future[now]]"
                                                               name="ArrivalReturn" id="ArrivalReturn" readonly
                                                               placeholder="ArrivalReturnDates" value=""
                                                               onchange="GetArrivalReturnDate();">

                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group mb-3">
                                                        <label for="country">Reference/Remarks</label><br>
                                                        <textarea class="form-control mb-4"
                                                                  id="ReferenceRemarks" name="ReferenceRemarks"
                                                                  placeholder="Reference/Remarks"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <h3> Pilgrims</h3>
                                    <section>
                                        <div id="Pilgrim">
                                        </div>
                                    </section>
                                    <h3> Travel </h3>
                                    <section>
                                        <div id="FilghtsDetails">
                                            <h5>Travel's Details
                                                <a href="javascript:void(0);" id="AddFlightRows"
                                                   class="btn btn_customized btn-sm float-right"
                                                   style="margin-right: 10px;"
                                                   onclick="AddNewFlightAttachmentRow(0);">Add Ticket</a>
                                                <a href="javascript:void(0);" id="AddFlightRows"
                                                   class="btn btn_customized btn-sm float-right"
                                                   style="margin-right: 10px;"
                                                   onclick="AddNewFlightAttachmentRow(1);">Add Self Ticket</a>
                                                <!--<a href="javascript:void(0);" id="AddFlightRows" class="float-right"
                                                   style="margin-right: 10px;"
                                                   onclick="AddNewFlightAttachmentRow();"><span>  <i
                                                                class="fa fa-plus" title="Add More"></i></span></a>-->
                                            </h5>
                                            <hr>
                                            <div id="FlightR" name="FlightR">

                                            </div>
                                        </div>
                                    </section>
                                    <h3>Hotel</h3>
                                    <section>
                                        <div id="RequestedAccomodationDetails">
                                            <div id="HotelR" name="HotelR">
                                                <input type="hidden" name="AccomodationCity" id="AccomodationCity">
                                                <input type="hidden" name="Accomodationcnt" id="Accomodationcnt">
                                                <h5>Accommodation Details
                                                    <small class="text-muted" id="totalaccomodationnights"></small>
                                                    <!--<a href="javascript:void(0);" id="AddFlightRows"
                                                       class="float-right" style="margin-right: 10px;"
                                                       onclick="AddRequestestedAccomodationAttachmentRow();"><span>
                                                        <i class="fa fa-plus" title="Add More"></i></span></a>-->
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
                                            </div>
                                        </div>

                                    </section>
                                    <h3> Transport</h3>
                                    <section>
                                        <div id="TransportDetailAdd">
                                            <div id="TransportR" name="TransportR">
                                                <h5>Transport Details
                                                    <!--                                                    <a href="javascript:void(0);" id="AddTransportRows"-->
                                                    <!--                                                       class="float-right" style="margin-right: 10px;"-->
                                                    <!--                                                       onclick="AddTransportAttachmentRow();"><span>-->
                                                    <!--                                                        <i class="fa fa-plus" title="Add More"></i></span></a>-->
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
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                <div class="" id="VoucherAddResponse"></div>
                <button type="button" class="btn btn_customized float-right mb-5" onclick="VoucherFormSubmit();">
                    Submit
                </button>
            </div>-->

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
    //     $("#VoucherArrivalDate").val(dates.StartDate);
    //     $("#ReturnDate").val(dates.EndDate);
    //
    //     SetReturnDate();
    //     GetArrivalReturnDays();
    //
    // }


    localStorage.setItem('CitiesHTML', '<?=$CitiesHTML?>');
    CitiesHTML = localStorage.getItem('CitiesHTML');

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
        var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;

        CountryCode = $("#VoucherCountry").val();
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
            '                                                    <div class="col-md-2"> <div class="form-group mb-3"><label for="country">Transports</label> <select class="form-control validate[required]" id="TransportRateZiyrat_' + cnt + '" name="TransportRateZiyrat[]" onchange = "ZiyaratRates(this.value,' + cnt + ')"> <option value="">Please Select  </option> ' + Transports + ' </select> </div> </div>' +
            '                                                    <div class="col-md-2">  <div class="form-group mb-3"><label for="country">No Of Pax </label><input type="text" class="form-control validate[required,funcCall[checknumberofpax]] "  name ="ZiyaratNoOfPax[]" id="ZiyaratNoOfPax_' + cnt + '" value ="" onchange="ZiyaratRatesUpdate(' + cnt + ');"></div> </div>' +
            '                                                    <div class="col-md-3">  <div class="form-group mb-3"><label for="country">Transport Rates</label><br> <input id="ZiyaratTransportsRates_' + cnt + '" type="hidden" name= "ZiyaratTransportsRates[]" value=""> <span id="ZiyaratTransportsRatess_' + cnt + '" class="AmountSpan"> - </span> </div> </div>\n' +
            '                                                    <div class="col-md-1">  <label for="country"> </label> <br> <a name="removeButton" href="javascript:void(0);" onClick="RemoveZiyaratRow(' + cnt + ')" id="removeButton" class="float-right" style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div> <div class = "col-md-12"><hr></div> </div>';
        ' </div>';
        DefaultScripts();
        return html;
    }


    function ZiyaratRates(TransportsID, cnt) {
        var PackagesUID = $("#PackageUID").val();
        var Ziarat = $("#Ziyarat_" + cnt).val();
        response = AjaxResponse("html/GetZiyaratRatesByPackageID", "Ziarat=" + Ziarat + "&PackagesUID=" + PackagesUID + "&TransportsID=" + TransportsID);
        $("#ZiyaratTransportsRatess_" + cnt).html(response.html);
        $("#ZiyaratTransportsRates_" + cnt).val(response.rate);
        $("#ZiyaratNoOfPax_" + cnt).val(null);

    }

    function ZiyaratRatesUpdate(cnt) {
        var PackagesUID = $("#PackageUID").val();
        var TransportsID = $("#TransportRateZiyrat_" + cnt).val();
        var NoOfPax = $("#ZiyaratNoOfPax_" + cnt).val();
        var Ziarat = $("#Ziyarat_" + cnt).val();
        response = AjaxResponse("html/GetZiyaratRatesByPackageUpdate", "Ziarat=" + Ziarat + "&PackagesUID=" + PackagesUID + "&TransportsID=" + TransportsID + "&NoOfPax=" + NoOfPax);
        $("#ZiyaratTransportsRatess_" + cnt).html(response.html);
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
            '<div class="col-md-2"><div class="form-group mb-2"><label for="country">City</label><select class="form-control" id="TravelCity"   name="TravelCity[]"></select></div></div>\n' +
            '<div class="col-md-3"> <div class="form-group mb-3"><label for="country">Travel Date</label><input type="date" class="form-control  validate[required,funcCall[transporttraveldate]] voucherdatefilter" id="TravelDate" name="TravelDate[]"   aria-describedby="emailHelp1"  placeholder="Travel Date" min="' + mindate + '" max="' + maxdate + '" value="' + mindate + '"></div> </div>\n' +
            ' <div class="col-md-2"> <div class="form-group mb-3"><input type="hidden" name="SelfTransport[]" value="0"><label  for="country">Sectors</label> <select  class="form-control validate[required]" id="TransportSectors_' + cnt + '" name="TransportSectors[]">\n' +
            ' <option value="">Please Select</option> ' + Sectors + ' </select></div> </div>\n' +
            '<div class="col-md-2"><div class="form-group mb-2"><label for="country">Travel Type</label><br><select class="form-control validate[required]" id="TransportTravelType" name="TransportTravelType[]"><option value="">Please Select</option><option value="Arrival">Arrival</option><option value="Departure">Departure</option><option value="Checkout">Checkout</option></select></div></div>\n' +
            ' <div class="col-md-3"> <div class="form-group mb-3"><label for="country">Transports</label> <select class="form-control validate[required]" id="TransportType_' + cnt + '" name="TransportType[]"  onchange = "TransportRates(this.value,' + cnt + ')"> <option value="">Please Select  </option>' + Transports + ' </select></div> </div>\n' +
            ' <div class="col-md-3">  <div class="form-group mb-3"><label for="country">BRN</label><select class="form-control validate[required]"  name ="TransportsBRN[]" id="TransportsBRN_' + cnt + '">' + BRN + '</select></div> </div>\n' +
            ' <div class="col-md-3">  <div class="form-group mb-3"><label for="country">No Of Pax </label><input type="text" class="form-control validate[required,funcCall[checknumberofpax]] "  name ="NoOfPax[]" id="NoOfPax_' + cnt + '" value ="' + CountPilgrim + '"></div> </div>\n' +
            ' <div class="col-md-3">  <div class="form-group mb-3"><label for="country">No Of Seats</label><input type="text" class="form-control validate[required ,funcCall[checknumberofseats]]"  name ="NoOfSeats[]" id="NoOfSeats_' + cnt + '" value ="" oninput="TransportRateUpdate(' + cnt + ');"></div> </div>\n' +
            ' <div class="col-md-2">  <div class="form-group mb-3"><label for="country">Transport Rates</label><br><input type ="hidden" name ="TransportsRates[]" id="TransportRateValue_' + cnt + '" value =""><span id="TransportsRates_' + cnt + '" class="AmountSpan">-</span> </div> </div>\n' +
            ' <div class="col-md-1">  <label for="country"> </label> <br> <a name="removeButton" href="javascript:void(0);" onClick="RemoveTransportAttachmentRow(' + cnt + ')" id="removeButton" class="float-right" style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div> <div class = "col-md-12"><hr></div> </div>';
        DefaultScripts();
        return html;

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
            ' <div class="col-md-12"><hr data-content="Self Transport" class="hr-text"></div>\n' +
            '<div class="col-md-2"><div class="form-group mb-2"><label for="country">City</label><select class="form-control" id="TravelCity"   name="TravelCity[]"></select></div></div>\n' +
            '<div class="col-md-3"> <div class="form-group mb-3"><label for="country">Travel Date</label><input type="date" class="form-control  validate[required,funcCall[transporttraveldate]] voucherdatefilter" id="TravelDate" name="TravelDate[]"   aria-describedby="emailHelp1"  placeholder="Travel Date" min="' + mindate + '" max="' + maxdate + '" value="' + mindate + '"></div> </div>\n' +
            ' <div class="col-md-2"> <div class="form-group mb-3"><input type="hidden" name="SelfTransport[]" value="1"><label  for="country">Sectors</label> <select  class="form-control validate[required]" id="TransportSectors_' + cnt + '" name="TransportSectors[]">\n' +
            ' <option value="">Please Select</option> ' + Sectors + ' </select></div> </div>\n' +
            '<div class="col-md-2"><div class="form-group mb-2"><label for="country">Travel Type</label><br><select class="form-control validate[required]" id="TransportTravelType" name="TransportTravelType[]"><option value="">Please Select</option><option value="Arrival">Arrival</option><option value="Departure">Departure</option><option value="Checkout">Checkout</option></select></div></div>\n' +
            ' <div class="col-md-3"> <div class="form-group mb-3"><label for="country">Transports</label> <select class="form-control validate[required]" id="TransportType_' + cnt + '" name="TransportType[]"> <option value="">Please Select  </option>' + Transports + ' </select></div> </div>\n' +
            ' <div class="col-md-3">  <div class="form-group mb-3"><label for="country">No Of Pax </label><input type="text" class="form-control validate[required,funcCall[checknumberofpax]]"  name ="NoOfPax[]" id="NoOfPax_' + cnt + '" value ="' + CountPilgrim + '"></div> </div>\n' +
            ' <div class="col-md-3">  <div class="form-group mb-3"><label for="country">No Of Seats</label><input type="text" class="form-control validate[required ,funcCall[checknumberofseats]]"  name ="NoOfSeats[]" id="NoOfSeats_' + cnt + '" value ="" oninput="TransportRateUpdate(' + cnt + ');"></div> </div>\n' +
            ' <div class="col-md-3">  <div class="form-group mb-3"><input type ="hidden" name ="TransportsRates[]" id="TransportRateValue_' + cnt + '" value ="0"><span id="TransportsRates_' + cnt + '" class="AmountSpan">-</span> </div> </div>\n' +
            ' <div class="col-md-2">  <div class="form-group mb-3"><label for="country"></label><input type="hidden" class="form-control"  name ="TransportsBRN[]" id="TransportsBRN_' + cnt + '" value ="0"></div> </div>\n' +
            ' <div class="col-md-1">  <label for="country"> </label> <br> <a name="removeButton" href="javascript:void(0);" onClick="RemoveTransportAttachmentRow(' + cnt + ')" id="removeButton" class="float-right" style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div> <div class = "col-md-12"><hr></div> </div>';
        DefaultScripts();
        return html;

    }

    function TransportRates(TransportID, cnt) {
        var PackagesUID = $("#PackageUID").val();
        // var NoOfSeat = $("#NoOfSeats_" + cnt).val();
        response = AjaxResponse("html/GetTransportRatesByPackageID", "TransportID=" + TransportID + "&PackagesUID=" + PackagesUID);
        // var PrintRate = NoOfSeat * response.rate;
        $("#TransportsRates_" + cnt).html(response.html);
        $("#TransportRateValue_" + cnt).val(response.rate);


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


    function AddNewFlightAttachmentRow(self) {
        FlightAttachmentCount = parseInt($("#FlightAttachmentCount").val());
        var ArrivalType = $("#ArrivalType").val();
        if (ArrivalType == 'Air') {
            HTML = FlightAttachmentFormHTML(FlightAttachmentCount, self);
            $("#FlightR").html(HTML);
        } else if (ArrivalType == 'Land') {
            HTML = LandAttachmentFormHTML(FlightAttachmentCount, self);
            $("#FlightR").append(HTML);
        }
        //$("#FlightR").append(HTML);
        $("#FlightAttachmentCount").val(FlightAttachmentCount + 1);
        DefaultScripts();
        return false;
    }


    function LoadDataByPackageID() {
        PilgrimHtml = AjaxResponse("html/GetB2CVoucherPilgrimGrid", "B2CPakageID=" + <?= $B2CPackageID['Description'] ?> + "&vid=0");
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
            '        <input type="hidden" id="Traveltype" name="Traveltype[]" value="Air"><input type="hidden" name="TravelSelf[]" value="' + self + '"><div class="col-md-2">  <div class="form-group mb-3" style="text-align: center"> <?=$Departure?>  <input type="hidden" id="FlightType" name="FlightType[]" value="Departure"> </div> </div>\n' +
            '        <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Sector<small id="coloredtext"> (From) </small></label>  <select class="form-control validate[required]" id="SectorFrom' + cnt + '"  name="SectorFrom[]"> <option value="">Please Select</option> <?=$Airportshtml?> </select> </div> </div>\n' +
            '        <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Sector<small id="coloredtext"> (To) </small></label>  <select class="form-control validate[required]" id="SectorTo' + cnt + '"  name="SectorTo[]"> <option value="">Please Select</option> <?=$Airportshtml?> </select> </div> </div>\n' +
            '        <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Airline</label>  <select class="form-control validate[required]" id="Airline"  name="Airline[]"> <option value="">Please Select</option> <?=$AirLineshtml?> </select> </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Flight Number</label> <input type="text" class="form-control validate[required]" id="Reference" name="Reference[]"  aria-describedby="emailHelp1"  placeholder="Flight Number">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">PNR</label> <input type="text" class="form-control validate[required]" id="PNR" name="PNR[]" aria-describedby="emailHelp1"  placeholder="PNR"> </div> </div>\n' +
            '        <div class="col-md-3">  <div class="form-group mb-3"> <label for="country">Departure Date</label>  <input type="date" class="form-control validate[required,funcCall[checktraveldate]]"  id="DepartureDateDeparture" name="DepartureDate[]" min="' + mindate + '" max="' + maxdate + '"  aria-describedby="emailHelp1"  placeholder="Departure Date" value="' + mindate + '">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Departure Time</label> <input type="time" class="form-control validate[required]" id="DepartureTime" name="DepartureTime[]"  aria-describedby="emailHelp1" placeholder="Departure Time"> </div> </div>\n' +
            '        <div class="col-md-3">  <div class="form-group mb-3"> <label for="country">Arrival Date</label> <input type="date" class="form-control validate[required,funcCall[checktraveldate],funcCall[checktravelarrivaldate]]" id="ArrivalDate" name="ArrivalDate[]" min="' + mindate + '" max="' + maxdate + '"  aria-describedby="emailHelp1" placeholder="Arrival Date" value="' + maxdate + '">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Arrival Time</label> <input type="time" class="form-control validate[required]" id="ArrivalTime" name="ArrivalTime[]" aria-describedby="emailHelp1" placeholder="Arrival Time"></div></div>\n' +
            '        <div class="col-md-1">  <label for="country"> </label> </div>' +
            '        <div class = "col-md-12"><hr></div>\n';
        html2 = '';


        if (self == 0) {
            html2 += '<div class="col-md-12"><hr data-content="Ticket" class="hr-text"></div>\n';

        } else {
            html2 += '<div class="col-md-12"><hr data-content="Self Ticket" class="hr-text"></div>\n';

        }
        html2 +=
            '        <input type="hidden" id="Traveltype" name="Traveltype[]" value="Air"><input type="hidden" name="TravelSelf[]" value="' + self + '"><div class="col-md-2">  <div class="form-group mb-3"  style="text-align: center">  <?=$Arrival?>  <input type="hidden" id="FlightType" name="FlightType[]" value="Return"> </div> </div>\n' +
            '        <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Sector<small id="coloredtext"> (From) </small></label>  <select class="form-control validate[required]" id="SectorFromReturn' + cnt + '"  name="SectorFrom[]"> <option value="">Please Select</option> <?=$Airportshtml?> </select> </div> </div>\n' +
            '        <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Sector<small id="coloredtext"> (To) </small></label>  <select class="form-control validate[required]" id="SectorToReturn' + cnt + '"  name="SectorTo[]"> <option value="">Please Select</option> <?=$Airportshtml?> </select> </div> </div>\n' +
            '        <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Airline</label>  <select class="form-control validate[required]" id="AirlineReturn"  name="Airline[]"> <option value="">Please Select</option> <?=$AirLineshtml?> </select> </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Flight Number</label> <input type="text" class="form-control validate[required]" id="ReferenceReturn" name="Reference[]"  aria-describedby="emailHelp1"  placeholder="Flight Number">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">PNR</label> <input type="text" class="form-control validate[required]" id="PNRReturn" name="PNR[]" aria-describedby="emailHelp1"  placeholder="PNR"> </div> </div>\n' +
            '        <div class="col-md-3">  <div class="form-group mb-3"> <label for="country">Departure Date</label>  <input type="date" class="form-control validate[required,funcCall[checktraveldate]]"  id="DepartureDateReturn" name="DepartureDate[]"  aria-describedby="emailHelp1"  placeholder="Departure Date" min="' + mindate + '" max="' + maxdate + '" value="' + mindate + '">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Departure Time</label> <input type="time" class="form-control validate[required]" id="DepartureTimeReturn" name="DepartureTime[]" aria-describedby="emailHelp1" placeholder="Departure Time"> </div> </div>\n' +
            '        <div class="col-md-3">  <div class="form-group mb-3"> <label for="country">Arrival Date</label> <input type="date" class="form-control validate[required,funcCall[checktraveldate],funcCall[checktravelreturndate]]" id="ArrivalDateReturn" name="ArrivalDate[]"  aria-describedby="emailHelp1" placeholder="Arrival Date" min="' + mindate + '" max="' + maxdate + '" value="' + maxdate + '">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Arrival Time</label> <input type="time" class="form-control validate[required]" id="ArrivalTimeReturn" name="ArrivalTime[]" aria-describedby="emailHelp1" placeholder="Arrival Time"></div></div>\n' +
            '        <div class="col-md-1">  <label for="country"> </label><a name="removeButton" href="javascript:void(0);" onClick="RemoveFlightAttachmentRow(' + cnt + ')" id="removeButton" class="float-right" style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a> </div>' +
            '        <div class = "col-md-12"><hr></div>\n';

        DefaultScripts();
        finalhtml = '<div class="row" id="FlightAttachmentCount' + cnt + '" name="FlightAttachmentCount">' + html + html2 + '</div>';
        return finalhtml;
    }

    function LandAttachmentFormHTML(cnt, self) {
        cnt = cnt + 1;
        var html;


        html = '<div class="row" id="FlightAttachmentCount' + cnt + '" name="FlightAttachmentCount">\n';
        if (self == 0) {
            html += '<div class="col-md-12"><hr data-content="Ticket" class="hr-text"></div>\n';

        } else {
            html += '<div class="col-md-12"><hr data-content="Self Ticket" class="hr-text"></div>\n';

        }
        html +=
            '        <input type="hidden" id="Traveltype" name="Traveltype[]" value="Land"> <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Type</label> <input type="hidden" name="TravelSelf[]" value="' + self + '"><select class="form-control validate[required]" id="FlightType"  name="FlightType[]"> <option value="">Please Select</option> <option value="Departure">Departure</option>  <option value="Return">Return</option> </select> </div> </div>\n' +
            '        <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Sector<small id="coloredtext"> (From) </small></label>  <select class="form-control validate[required]" id="SectorFrom' + cnt + '"  name="SectorFrom[]"> <option value="">Please Select</option> <?=$landbordershtml?> </select> </div> </div>\n' +
            '        <div class="col-md-2"> <div class="form-group mb-3">  <label for="country">Sector<small id="coloredtext"> (To) </small></label>  <select class="form-control validate[required]" id="SectorTo' + cnt + '"  name="SectorTo[]"> <option value="">Please Select</option> <?=$landbordershtml?> </select> </div> </div>\n' +
            '        <div class="col-md-3">  <div class="form-group mb-3"> <label for="country">Flight Number</label> <input type="text" class="form-control" id="Reference" name="Reference[]"  aria-describedby="emailHelp1"  placeholder="Flight Number">  </div> </div>\n' +
            '        <div class="col-md-3">  <div class="form-group mb-3"> <label for="country">PNR</label> <input type="text" class="form-control" id="PNR" name="PNR[]" aria-describedby="emailHelp1"  placeholder="PNR"> </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Departure Date</label>  <input type="date" class="form-control validate[required]"  id="DepartureDate" name="DepartureDate[]"  aria-describedby="emailHelp1"  placeholder="Departure Date">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Departure Time</label> <input type="time" class="form-control validate[required]" id="DepartureTime" name="DepartureTime[]" aria-describedby="emailHelp1" placeholder="Departure Time"> </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Arrival Date</label> <input type="date" class="form-control validate[required]" id="ArrivalDate" name="ArrivalDate[]"  aria-describedby="emailHelp1" placeholder="Arrival Date">  </div> </div>\n' +
            '        <div class="col-md-2">  <div class="form-group mb-3"> <label for="country">Arrival Time</label> <input type="time" class="form-control validate[required]" id="ArrivalTime" name="ArrivalTime[]" aria-describedby="emailHelp1" placeholder="Arrival Time"></div></div>\n' +
            '        <div class="col-md-1">  <label for="country"> </label> <br> <a name="removeButton" href="javascript:void(0);" onClick="RemoveFlightAttachmentRow(' + cnt + ')" id="removeButton" class="float-right" style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div> <div class = "col-md-12"><hr></div></div></div>\n' +
            '   </div> ';
        DefaultScripts();
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
        $("#RequestedAccomodationCount").val(RequestedAccomodationCount + 1);

        CountryCode = $("#VoucherCountry").val();
        LoadCitiesDropdownagain(CountryCode);

        DefaultScripts();
        return false;
    }

    function AddSelfRequestestedAccomodationAttachmentRow() {
        RequestedAccomodationCount = parseInt($("#RequestedAccomodationCount").val());


        HTML = RequstedSelfAccomodationAttachmentFormHTML(RequestedAccomodationCount);
        $("#HotelR").append(HTML);
        $("#RequestedAccomodationCount").val(RequestedAccomodationCount + 1);

        CountryCode = $("#VoucherCountry").val();
        LoadCitiesDropdownagain(CountryCode);

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
        html = '<div class="row" id="RequestedAccomodationCount_' + cnt + '" name="RequestedAccomodationCount">\n' +
            '<div class="col-md-12"><hr id="datacontent' + cnt + '" data-content="Package Hotel" class="hr-text"><input type="hidden" class="accommationnights" name="AccommationNights[]" id="AccommationNights' + cnt + '"></div>\n' +
            '<div class="col-md-4">  <div class="form-group mb-3"> <label for="country">City</label> <input type="hidden" name="Self[]" value="0"> <select class="form-control validate[required]" id="City" onChange="LoadHotelByCites(this.value,' + cnt + ')"  name="City[]">  </select> </div>  </div>\n' +
            '<div class="col-md-4">  <div class="form-group mb-3"> <label for="country">Hotel</label>  <select class="form-control validate[required]" id="Hotel_' + cnt + '"  name="Hotels[]" onchange="GetRoomRate(\'RequestedAccomodationCount_' + cnt + '\',' + cnt + ');">   </select>    </div> </div>\n' +
            '<div class="col-md-3"> <div class="form-group mb-3">  <label for="country">Room Type</label>  <select class="form-control validate[required]" id="RoomType"  name="RoomType[]" onchange="GetRoomRate(\'RequestedAccomodationCount_' + cnt + '\',' + cnt + ');">   <option value="">Please Select</option>  <?=$RoomTypes?>  </select>  </div> </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country">Check-In</label>   <input type="date" class="form-control validate[required,funcCall[checkindate]]" data-rowid="' + cnt + '" id="CheckIn' + cnt + '" name="CheckIn[]"   aria-describedby="emailHelp1"  placeholder="Check IN" min="' + mindate + '" max="' + maxdate + '" value="' + mindate + '">   </div>   </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country">Check-Out</label> <input type="date" class="form-control validate[required,funcCall[checkoutdate]]" id="CheckOut' + cnt + '"  name="CheckOut[]"  aria-describedby="emailHelp1"  placeholder="Check Out" min="' + mindate + '" max="' + maxdate + '" value="' + maxdate + '" onchange="GetNoOfDaysRate(\'RequestedAccomodationCount_' + cnt + '\',' + cnt + ',0)";>   </div>  </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country" id="noofroomsbeds' + cnt + '">No Of Beds</label> <input type="number" class="form-control NoOfBeds validate[required,funcCall[checknumberofbeds]]" min="1" max="' + CountPilgrim + '" required="required" id="NoOfBeds_' + cnt + '"  name="NoOfBeds[]" value="' + CountPilgrim + '" oninput="GetRoomRate(\'RequestedAccomodationCount_' + cnt + '\',' + cnt + ');"  aria-describedby="emailHelp1"  placeholder="No Of Beds">   </div>  </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country">BRN</label> <select class="form-control validate[required]"  id="AccommodationBRN_' + cnt + '"  name="AccommodationBRN[]">' + BRN + '</select></div>  </div>\n' +
            '<div class="col-md-2">  <label for="country">Amount</label>  <div class="form-group mb-3"> <input type ="hidden" name ="AmountPayable[]" id="AmountPayableInput_' + cnt + '" value =""> <span class="AmountSpan" id="AmountPayable_' + cnt + '"></span>  </div>  </div>\n' +
            '<div class="col-md-2">  <label for="country"> </label> <br> <a name="removeButton" href="javascript:void(0);" onClick="RemoveRequstedAccomodationAttachmentRow(' + cnt + ')" id="removeButton" class="float-right" style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div> \n' +
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

        html = '<div class="row" id="RequestedAccomodationCount_' + cnt + '">\n' +
            '<div class="col-md-12"><hr id="datacontent' + cnt + '" data-content="Self Hotel" class="hr-text"><input type="hidden" class="accommationnights" name="AccommationNights[]" id="AccommationNights' + cnt + '"></div>\n' +
            '<div class="col-md-4">  <div class="form-group mb-3"> <label for="country">City</label>  <input type="hidden" name="Self[]" value="1"><select class="form-control" id="City" onChange="LoadSelfHotelByCites(this.value,' + cnt + ')"  name="City[]">  </select> </div>  </div>\n' +
            '<div class="col-md-4">  <div class="form-group mb-3"> <label for="country">Hotel</label>  <select class="form-control" id="Hotel_' + cnt + '"  name="Hotels[]" onchange="GetHotelName(this.value,' + cnt + ');">   </select>    </div> </div>\n' +
            '<div class="col-md-3"> <div class="form-group mb-3">  <label for="country">Room Type</label>  <select class="form-control" id="RoomType"  name="RoomType[]"  onchange="GetRoomRate(\'RequestedAccomodationCount_' + cnt + '\',' + cnt + ');" >   <option value="">Please Select</option>  <?=$RoomTypes?>  </select>  </div> </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country">Check-In</label>   <input type="date" class="form-control validate[required,funcCall[checkindate]]" data-rowid="' + cnt + '" id="CheckIn' + cnt + '" name="CheckIn[]" min="' + mindate + '" max="' + maxdate + '" value="' + mindate + '"   aria-describedby="emailHelp1"  placeholder="Check Out">   </div>   </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country">Check-Out</label> <input type="date" class="form-control validate[required,funcCall[checkoutdate]]" id="CheckOut' + cnt + '"  name="CheckOut[]"   aria-describedby="emailHelp1" min="' + mindate + '" max="' + maxdate + '" value="' + maxdate + '"  placeholder="Check Out" onchange="GetNoOfDaysRate(\'RequestedAccomodationCount_' + cnt + '\',' + cnt + ',1)";>   </div>  </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country" id="noofroomsbeds' + cnt + '">No Of Beds</label> <input type="number" class="form-control NoOfBeds validate[required,funcCall[checknumberofbeds]]" min="1" max="' + CountPilgrim + '" required="required" id="NoOfBeds_' + cnt + '"  name="NoOfBeds[]" value="' + CountPilgrim + '"   aria-describedby="emailHelp1"  placeholder="No Of Beds">   </div>  </div>\n' +
            '<div class="col-md-2">   <div class="form-group mb-3">  <label for="country"></label> <input type="hidden" class="form-control" id="AccommodationBRN_' + cnt + '"  name="AccommodationBRN[]" aria-describedby="emailHelp1"  placeholder="BRN" value="0">   </div>  </div>\n' +
            '<div class="col-md-2"></div>\n' +
            '<div class="col-md-2">  <label for="country"> </label> <br> <a name="removeButton" href="javascript:void(0);" onClick="RemoveRequstedAccomodationAttachmentRow(' + cnt + ')" id="removeButton" class="float-right" style="padding: 25px;"><span> <i class="fa fa-trash" title="Remove"></i></span></a></div> \n' +
            '<div class="col-md-12"> <hr> </div>  </div>  </div> \n' +
            '</div> ';
        DefaultScripts();
        return html;

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
                location.reload();
            }, 2000)
        } else {
            $("#VoucherAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }

    function LoadCitiesDropdownagain(country) {
        cnt = parseInt($("#RequestedAccomodationCount").val());
        //alert("#RequestedAccomodationCount_" + cnt + " #City");

        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country);
        $("#RequestedAccomodationCount_" + cnt + " #City").html('<option value="">Please Select</option>' + cities.html);
        DefaultScripts();
    }

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

    function LoadSelfHotelByCites(city, cnt) {
        hotels = AjaxResponse("html/GetSelfHotelDropdownByCity", "city=" + city + "&selected=<?=$VoucherAccommmodationData['Hotel']?>");
        // $("#Hotels_" + cnt).html('<option value="">Please Select</option>' + hotels.html);
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

    function GetRoomRate(parent, cnt) {
        var CheckIn = $("#CheckIn" + cnt).val();
        var CheckOut = $("#CheckOut" + cnt).val();

        var AgentID = $("#VoucherAddForm #AgentID").val();
        var HotelID = $("#" + parent + " #Hotel_" + cnt).val();
        var RoomType = $("#" + parent + " #RoomType").val();
        var RoomTypeName = $("#" + parent + " #RoomType option:selected").text();
        if (RoomTypeName == 'Sharing') {
            $('#noofroomsbeds' + cnt).text("No Of Beds");
        } else {
            $('#noofroomsbeds' + cnt).text("No Of Rooms");
        }
        // var CheckIn = $("#" + parent + " #CheckIn" + cnt).val();
        // var CheckOut = $("#" + parent + " #CheckOut" + cnt).val();
        var NoOfBeds = $("#VoucherAddForm  #NoOfBeds_" + cnt).val();
        if (AgentID > 0 && HotelID > 0 && RoomType > 0) {
            response = AjaxResponse("form_process/GetRoomTypePackage", "RoomType=" + RoomType + "&AgentID=" + AgentID + "&HotelID=" + HotelID + "&CheckIn=" + CheckIn + "&CheckOut=" + CheckOut + "&NoOfBeds=" + NoOfBeds);
            if (response.status == 'success') {
                $("#AmountPayable_" + cnt).html(response.CurrentCharges)
                $("#AmountPayableInput_" + cnt).val(response.CurrentChargesValue)

            }
        }

    }

    setTimeout(function () {
        LoadDataByPackageID();
        // var ArrivalType = $("#ArrivalType").val();
        //AddNewFlightAttachmentRow(ArrivalType);

        //AddTransportAttachmentRow();
        //AddNewZiyarat();
        // LoadAgentGirdByAgentID();
        //AddRequestestedAccomodationAttachmentRow();

    }, 100)
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
            return VoucherValidation(currentIndex, newIndex);

        },
        onFinished: function (event, currentIndex) {
            VoucherFormSubmit();
        }
    });

    function ValidateAccomodationForm() {
        var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;
        var chk = 0;
        $("#RequestedAccomodationDetails input.NoOfBeds").each(function (obj) {
            inputid = $(this).attr('id');
            inputvalue = this.value;
            if (inputvalue > CountPilgrim || inputvalue < 1) {

                $("#RequestedAccomodationDetails #" + inputid).css('background-color', 'rgb(255,0,0,.2)');
                chk = 1;

            } else {
                $("#RequestedAccomodationDetails #" + inputid).css('background-color', 'transparent');

            }


        });

        if (chk == 1) {
            return false;
        } else {
            return true;
        }

    }

    function VoucherValidation(currentIndex, newIndex) {
        if (newIndex < currentIndex) {
            $("form#VoucherAddForm").validationEngine('hideAll');
            return true;
        }
        var validate = $("form#VoucherAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        if (currentIndex == 1 && newIndex == 2) {
            var CountPilgrim = document.querySelectorAll('input[name="VoucherPilgrimID[]"]:checked').length;
            var CountLeaderPilgrim = document.querySelectorAll('input[name="leader[]"]:checked').length;
            if (CountPilgrim > 0 && CountLeaderPilgrim > 0) {
                return true;
            } else {
                return false;
            }
        } else if (currentIndex == 2 && newIndex == 3) {
            ////// travel to Accomodation
            if ($("#FlightAttachmentCount").val() > 0) {
                return true;
            } else {
                return false;
            }
        } else if (currentIndex == 3 && newIndex == 4) {
            ////// Accomodation to Transport

            if ($("#RequestedAccomodationCount").val() > 0) {
                return true;
            } else {
                return false;
            }
        } else if (currentIndex == 4 && newIndex == 5) {
            ////// Transport to Ziyarat

            if ($("#TransportAttachmentCount").val() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            // var validate = $("form#VoucherAddForm").validationEngine('validate');
            // if (validate == false) {
            //     return false;
            // }
        }
        return true;

    }

    function GetHotelName(hotel, hotelindex) {
        if (hotel == 'Other') {

            $("#AccomodationCity").val($("#RequestedAccomodationCount_" + hotelindex + " #City").val());
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
            $("#RequestedAccomodationCount_" + $("#Accomodationcnt").val() + " " + "#Hotel_" + $("#Accomodationcnt").val()).val(response.record_id).select2();

            $('#MainForm').modal('hide');
            $('#HotelAddForm')[0].reset();
            /*setTimeout(function () {
                location.href = "<?=base_url('package/hotel')?>";
            }, 2000)*/
        } else {
            $("#HotelAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

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

    function SetReturnDate() {

        if ($("#VoucherArrivalDate").val() != '') {
            var someDate = new Date($("#VoucherArrivalDate").val());
            someDate.setDate(someDate.getDate() + 1); //number  of days to add, e.x. 15 days
            var mindate = someDate.toISOString().substr(0, 10);
            $("#ReturnDate").attr('min', mindate);
            var someDate = new Date($("#VoucherArrivalDate").val());
            someDate.setDate(someDate.getDate() + 25); //number  of days to add, e.x. 15 days
            var maxdate = someDate.toISOString().substr(0, 10);
            $("#ReturnDate").attr('max', maxdate);
        } else {
            return false;
        }


    }

    function GetArrivalReturnDays() {

        var startDay = new Date($("#VoucherArrivalDate").val());
        var endDay = new Date($("#ReturnDate").val());
        var millisBetween = endDay.getTime() - startDay.getTime();
        var days = millisBetween / (1000 * 3600 * 24);
        if (days < 8 || days > 25) return "Number of days between 8 to 25"

    }

    function checktraveldate(field, rules, i, options) {

        if (Date.parse(field.val()) < Date.parse($("#VoucherArrivalDate").val()) || Date.parse(field.val()) > Date.parse($("#ReturnDate").val())) return "Please enter date between " + $("#VoucherArrivalDate").val() + " and " + $("#ReturnDate").val()

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
        if (Date.parse(field.val()) < Date.parse($("#VoucherArrivalDate").val()) || Date.parse(field.val()) > Date.parse($("#ReturnDate").val())) return "Please enter date between " + $("#VoucherArrivalDate").val() + " and " + $("#ReturnDate").val()
        $(checkoutid).attr('min', field.val());

    }

    function checkoutdate(field, rules, i, options) {
        if (Date.parse(field.val()) < Date.parse($("#VoucherArrivalDate").val()) || Date.parse(field.val()) > Date.parse($("#ReturnDate").val())) return "Please enter date between " + $("#VoucherArrivalDate").val() + " and " + $("#ReturnDate").val()
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

    function transporttraveldate(field, rules, i, options) {
        var rowid = field.data('rowid');
        var checkoutid = '#TransportAttachmentCount' + rowid + ' #TravelDate' + rowid;
        if (Date.parse(field.val()) < Date.parse($("#VoucherArrivalDate").val()) || Date.parse(field.val()) > Date.parse($("#ReturnDate").val())) return "Please enter date between " + $("#VoucherArrivalDate").val() + " and " + $("#ReturnDate").val()
        $(checkoutid).attr('min', field.val());
    }

    $(document).ready(function () {
        $("form#VoucherAddForm").validationEngine('attach', {

            promptPosition: "bottomRight",
            scroll: false
        });
    });

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
