<!--  BEGIN CONTENT AREA  -->
<link rel="stylesheet" type="text/css" href="<?= $template ?>plugins/jquery-step/jquery.steps.css">
<?php

use App\Models\Crud;

$Crud = new Crud();


?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-spacing">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">

                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Add New B2B Package</h4>
                            </div>
                        </div>
                    </div>
                    <form class="section contact validate" method="post" action="#" id="PackageAddForm"
                          name="PackageAddForm">
                        <input type="hidden" name="StartDate" id="StartDate" value=" ">
                        <input type="hidden" name="GroupCode" id="GroupCode" value=" ">
                        <input type="hidden" name="ExpiryDate" id="ExpiryDate" value=" ">
                        <input type="hidden" name="DomainID" id="DomainID" value="<?= $GetDomainID ?>">
                        <div class="widget-content widget-content-area">
                            <div id="AddPackage">
                                <h3>Package Detail</h3>
                                <section>
                                    <div id="PackageDetail">
                                        <div class="row">
                                            <div class="col-md-12 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="country">Agent</label>
                                                            <select class="form-control validate[required]"
                                                                    id="PackageAgent"
                                                                    name="PackageAgent">
                                                                <?php
                                                                foreach ($ExternalAgents as $SA) {
                                                                    echo '<option value="' . $SA['UID'] . '">' . $SA['FullName'] . '</option>';
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="country">Country</label>
                                                            <select class="form-control validate[required]"
                                                                    id="PackageCounty"
                                                                    name="PackageCounty"
                                                                    onChange="LoadCitiesDropdown(this.value)">
                                                                <option value="">Please Select</option>
                                                                <?= Countries("html") ?>
                                                            </select>
                                                        </div>
                                                    </div>
<!--                                                    <div class="col-md-3">-->
<!--                                                        <div class="form-group">-->
<!--                                                            <label for="country">Group Code</label>-->
<!--                                                            <input type="text"-->
<!--                                                                   class="form-control mb-4"-->
<!--                                                                   id="GroupCode" name="GroupCode"-->
<!--                                                                   placeholder="Group Code">-->
<!--                                                        </div>-->
<!--                                                    </div>-->
                                                    <!--                                                    <div class="col-md-3">-->
                                                    <!--                                                        <div class="form-group">-->
                                                    <!--                                                            <label for="country">Start Date</label>-->
                                                    <!--                                                            <input type="date"-->
                                                    <!--                                                                   class="form-control mb-4 validate[required]"-->
                                                    <!--                                                                   id="StartDate" name="StartDate"-->
                                                    <!--                                                                   placeholder="Nationality">-->
                                                    <!--                                                        </div>-->
                                                    <!--                                                    </div>-->

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="country">Package Name</label>
                                                            <input type="text"
                                                                   class="form-control mb-4 validate[required]"
                                                                   id="PackageName" name="PackageName"
                                                                   placeholder="Package Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="country">Start End</label>
                                                            <input type="text"
                                                                   class="form-control multidate validate[required,future[now]]"
                                                                   name="ArrivalReturn" id="ArrivalReturn" readonly
                                                                   placeholder="ArrivalReturnDates" value=""
                                                                   onchange="GetArrivalReturnDate();">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mx-auto">
                                                        <div class="row">

                                                            <!--                                                    <div class="col-md-3">-->
                                                            <!--                                                        <div class="form-group">-->
                                                            <!--                                                            <label for="country">Expire Date</label>-->
                                                            <!--                                                            <input type="date"-->
                                                            <!--                                                                   class="form-control mb-4 validate[required]"-->
                                                            <!--                                                                   id="ExpiryDate" name="ExpiryDate"-->
                                                            <!--                                                                   placeholder="No of Pax">-->
                                                            <!--                                                        </div>-->
                                                            <!--                                                    </div>-->
                                                            <?php
                                                            $data['LookupsOptions'] = $Crud->LookupOptions('visa_types');
                                                            foreach ($data['LookupsOptions'] as $options) {
                                                                echo '  <div class="col-md-3">
                                                    <div class="form-group"> <label for="visa charges">' . $options['Name'] . ' Rate</label> <input type="text" class="form-control mb-4 validate[required]" id="VisaCharges" name="VisaCharges[' . $options['UID'] . ']" placeholder="' . $options['Name'] . ' Visa"></div>
                                                                </div>';
                                                            }
                                                            ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </section>
                                <h3>Hotels</h3>
                                <section>
                                    <div id="Hotels">
                                        <input type="hidden" id="HotelCount" name="HotelCount" value="0">
                                        <div class="row">
                                            <div class="col-md-12 mx-auto">
                                                <div class="table-responsive" style="overflow: auto;">
                                                    <table id="MainRecords"
                                                           class="table table-hover non-hover display nowrap"
                                                           style="width:100%; margin-bottom: 0px!important;">
                                                        <thead>
                                                        <tr>
                                                            <th>Location</th>
                                                            <th>Category</th>
                                                            <th>Hotel</th><?php
                                                            foreach ($RoomTypes as $RoomType) {
                                                                echo "<th>" . $RoomType['Name'] . "</th>";
                                                            }
                                                            ?>
                                                            <th>
                                                                <button type="button" onclick="AddNewHotel()"
                                                                        class="btn btn-success btn-sm"> +
                                                                </button>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h3>Transport</h3>
                                <section>
                                    <div id="Transport">
                                        <div class="row">
                                            <div class="col-md-12 mx-auto">
                                                <div class="table-responsive" style="overflow: auto;">
                                                    <table id="MainRecords"
                                                           class="table table-hover non-hover display nowrap"
                                                           style="width:100%; margin-bottom: 0px!important;">
                                                        <thead>
                                                        <tr>
                                                            <th>Sectors</th>
                                                            <?php
                                                            foreach ($TransportData as $thisType) {
                                                                echo '<th>' . $thisType . '</th>';
                                                            }
                                                            ?>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        for ($i = 0; $i < count($TransportSectors); $i++) {
                                                            $Sector = strtolower(str_ireplace(" ", "_", $TransportSectors[$i]["UID"]));
                                                            echo '<tr>';
                                                            echo '<td>' . $TransportSectors[$i]["Name"] . '</td>';
                                                            foreach ($TransportData as $TransportUID => $thisType) {
                                                                echo '<td><input class="form-control" type="text" name="TransportRate[' . $TransportUID . "|" . $Sector . "|" . $i . ']"></td>';
                                                            }
                                                            echo '</tr>';
                                                        }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h3>Ziyarat</h3>
                                <section>
                                    <div id="Ziyarat">
                                        <input type="hidden" id="ZiyaratCount" name="ZiyaratCount" value="0">
                                        <div class="row">
                                            <div class="col-md-12 mx-auto">
                                                <div class="table-responsive" >
                                                    <table id="MainRecords"  style="overflow: auto;"
                                                           class="table table-responsive table-hover non-hover display nowrap"
                                                           style="width:100%; margin-bottom: 0px!important;">
                                                        <thead>
                                                        <tr>
                                                            <th>Location</th>
                                                            <th>Ziyarat</th><?php
                                                            foreach ($TransportData as $thisType) {
                                                                echo '<th>' . $thisType . '</th>';
                                                            }
                                                            ?>
                                                            <th>
                                                                <button type="button" onclick="AddNewZiyarat()"
                                                                        class="btn btn-success btn-sm"> +
                                                                </button>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h3>Other Services</h3>
                                <section>
                                    <div id="other">
                                        <div class="row">
                                            <div class="col-md-12 mx-auto">
                                                <div class="row">
                                                    <?php
                                                    foreach ($ExtraServices as $key => $thisService) {
                                                        ?>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="location"><?= $thisService['Name']; ?> </label>
                                                                <input type="text" class="form-control mb-4"
                                                                       id="extra"
                                                                       name="Extra[<?= $thisService['UID'] ?>]"
                                                                       placeholder="<?= $thisService['Name']; ?>">
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button id="multiple-messages" onclick="PackageFormSubmit()"
                                                        class="btn btn_customized float-right">Save
                                                    Changes
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                <div class="" id="PackageAddResponse"></div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">

    $("form#PackageAddForm").on("submit", function (event) {
        event.preventDefault();
    });

    function PackageFormSubmit() {

        var validate = $("form#PackageAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        var phpdata = new window.FormData($("form#PackageAddForm")[0]);
        response = AjaxUploadResponse("form_process/external_agent_package_form_submit", phpdata);

        if (response.status == 'success') {
            $("#PackageAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.href = "<?=base_url('package/b2b_external_package')?>";
            }, 2000)
        } else {
            $("#PackageAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }

    // function LoadHotelByCites(city, cnt) {
    //     hotels = AjaxResponse("html/GetHotelDropdownByCity", "city=" + city);
    //     $("#Hotels  tbody tr#TR" + cnt + " select#Hotel_" + cnt).html('<option value="">Please Select</option>' + hotels.html);
    // }

    function LoadHotelByCites(CatID, cnt) {
        City = $("#City_" + cnt).val();
        hotels = AjaxResponse("html/GetHotelCategoryDropdownByCity", "city=" + City + "&CatID=" + CatID);
        $("#Hotels  tbody tr#TR" + cnt + " select#Hotel_" + cnt).html('<option value="">Please Select</option>' + hotels.html);
    }

    function LoadZiyaratByCites(city, cnt) {
        ziarat = AjaxResponse("html/GetZiaratDropdownByCity", "city=" + city);
        $("#Ziyarat  tbody tr#TR" + cnt + " select#Ziyarat_" + cnt).html('<option value="">Ziyarat</option>' + ziarat.html);
    }

    function LoadCitiesDropdown(country) {
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country);
        $(".HotelCities").html('<option value="">Please Select</option>' + cities.html);
    }

    function DefaultHotelRowHTML(cnt) {
        cnt = cnt + 1;
        var html;
        <?php
        $HotelCategory = $Crud->LookupOptions('hotel_category');

        $HTML = '';
        // print_r($RoomTypes); exit;
        foreach ($RoomTypes as $RoomType) {
            $Name = 'RoomType[' . $RoomType['UID'] . '][]';
            $HTML .= "<td><input class=\'form-control\' type=\'text\' name=" . $Name . "></td>";
        }
        $Category = '';
        foreach ($HotelCategory as $options) {
            $Category .= '<option value=' . $options['UID'] . '>' . $options['Name'] . '</option>';
        }?>

        CountryCode = $("#PackageCounty").val();
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + CountryCode);
        HotelCities = '<select class="form-control HotelCities" id="City_' + cnt + '" name="City[]"><option value="">Please Select</option>' + cities.html + '</select>'
        Hotels = '<select class="form-control" id="Hotel_' + cnt + '" name="Hotel[]" ><option value="">Please select City</option></select>'

        html = '' +
            '<tr id="TR' + cnt + '">' +
            '<td>' + HotelCities + '</td>' +
            '<td><select class="form-control validate[required]" id="HotelCategory_' + cnt + '" name="HotelCategory[]"  onChange="LoadHotelByCites(this.value, ' + cnt + ')" ><option value="">Please Select Category</option> <?=$Category?></select></td>' +

            '<td>' + Hotels + '</td>' +
            '<?=$HTML?>' +
            '<td><a href="#" onClick="RemoveRow(\'TR' + cnt + '\')">' +
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"\n' +
            'stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"\n' +
            'class="feather feather-x t-icon t-hover-icon"><line x1="18" y1="6" x2="6" y2="18"></line>\n' +
            '<line x1="6" y1="6" x2="18" y2="18"></line></td>' +
            '</tr>';

        return html;
    }

    function DefaultZiyaratRowHTML(cnt) {
        cnt = cnt + 1;
        var html;
        <?php
        $HTML = '';
        // print_r($TransportData); exit;
        foreach ($TransportData as $key => $thisType) {
            $Name = 'ZiyaratRates[' . $key . '][]';
            $HTML .= "<td><input class=\'form-control\' type=\'text\' name=" . $Name . "></td>";
        } ?>

        CountryCode = $("#PackageCounty").val();
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + CountryCode);
        ZiyaratCities = '<select class="form-control HotelCities" id="ZiyaratCity_' + cnt + '" name="ZiyaratCity[]" onChange="LoadZiyaratByCites(this.value, ' + cnt + ')" ><option value="">City</option>' + cities.html + '</select>'
        Ziyarats = '<select class="form-control" id="Ziyarat_' + cnt + '" name="Ziyarat[]" ><option value="">Ziyarat</option></select>'

        html = '' +
            '<tr id="TR' + cnt + '">' +
            '<td>' + ZiyaratCities + '</td>' +
            '<td>' + Ziyarats + '</td>' +
            '<?=$HTML?>' +
            '<td><a href="#" onClick="RemoveZiyaratRow(\'TR' + cnt + '\')">' +
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"\n' +
            'stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"\n' +
            'class="feather feather-x t-icon t-hover-icon"><line x1="18" y1="6" x2="6" y2="18"></line>\n' +
            '<line x1="6" y1="6" x2="18" y2="18"></line></td>' +
            '</tr>';

        return html;
    }


    function RemoveRow(id) {
        HotelCount = parseInt($("#HotelCount").val());
        $("#Hotels  tbody tr#" + id).remove();
        $("#HotelCount").val(HotelCount - 1);
    }

    function RemoveZiyaratRow(id) {
        ZiyaratCount = parseInt($("#ZiyaratCount").val());
        $("#Ziyarat  tbody tr#" + id).remove();
        $("#ZiyaratCount").val(ZiyaratCount - 1);
    }


    function AddNewHotel() {
        HotelCount = parseInt($("#HotelCount").val());

        HTML = DefaultHotelRowHTML(HotelCount);
        $("#Hotels  tbody").append(HTML);
        $("#HotelCount").val(HotelCount + 1);
        return false;
    }

    function GetArrivalReturnDate() {

        const ArrivalReturn = $("#ArrivalReturn").val();
        const words = ArrivalReturn.split(' to ');
        $("#StartDate").val(words[0]);
        $("#ExpiryDate").val(words[1]);

        GetArrivalReturnDate();

    }

    function AddNewZiyarat() {
        ZiyaratCount = parseInt($("#ZiyaratCount").val());

        HTML = DefaultZiyaratRowHTML(ZiyaratCount);
        $("#Ziyarat  tbody").append(HTML);
        $("#ZiyaratCount").val(ZiyaratCount + 1);
        return false;
    }


    setTimeout(function () {
        AddNewHotel();
        AddNewZiyarat();
    }, 1000)


</script>

<script src="<?= $template ?>plugins/jquery-step/jquery.steps.min.js"></script>


<script>
    $("#AddPackage").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: true,
        cssClass: 'pill wizard'
    });
</script>


