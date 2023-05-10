<!--  BEGIN CONTENT AREA  -->
<link href="<?= $template ?>assets/css/tables/table-basic.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?= $template ?>plugins/jquery-step/jquery.steps.css">

<?php

use App\Models\Crud;

$Crud = new Crud();
// echo "<pre>";
$PackageName = isset($packageData[0]['Name']) ? $packageData[0]['Name'] : "";
$PackageType = isset($packageData[0]['PackageType']) ? $packageData[0]['PackageType'] : "";
$StartDate = isset($packageData[0]['StartDate']) ? $packageData[0]['StartDate'] : date("Y-m-d");
$ExpireDate = isset($packageData[0]['ExpireDate']) ? $packageData[0]['ExpireDate'] : date("Y-m-d");
$Charges = isset($packageData[0]['FoodCharges']) ? $packageData[0]['FoodCharges'] : "";
$VisaFee = isset($packageData[0]['VisaFee']) ? $packageData[0]['VisaFee'] : "";
$CountryCode = isset($packageData[0]['CountryCode']) ? $packageData[0]['CountryCode'] : "";
$Agentss = isset($packageData[0]['AgentUID']) ? $packageData[0]['AgentUID'] : "";
// $HotelsData = isset($HotelsData[0]) ? $HotelsData[0] : array();
// echo "<pre>"; print_r($Cities); exit;
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-spacing">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>B2B General Package </h4>
                            </div>
                        </div>
                    </div>
                    <form class="section contact validate" method="post" action="#" id="B2BGeneralPackageUpdateForm"
                          name="B2BGeneralPackageUpdateForm">
                        <input type="hidden" name="StartDate" id="StartDate" value="<?= $StartDate ?>">
                        <input type="hidden" name="ExpiryDate" id="ExpiryDate" value="<?= $ExpireDate ?>">
                        <div class="widget-content widget-content-area">
                            <div id="example-basic">
                                <h3>Package Detail</h3>
                                <section>
                                    <div id="PackageDetail">
                                        <div class="row">
                                            <div class="col-md-12 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="country">Country</label>
                                                            <select class="form-control no-select2"
                                                                    id="PackageCounty"
                                                                    onChange="LoadCitiesDropdown(this.value)"
                                                                    name="PackageCounty">
                                                                <option value="">Please Select</option>
                                                                <?= Countries("html", $CountryCode) ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="country">Package Name</label>
                                                            <input type="text" class="form-control mb-4"
                                                                   id="PackageName"
                                                                   name="PackageName"
                                                                   value="<?= $PackageName ?>">
                                                        </div>
                                                    </div>
<!--                                                    <div class="col-md-4">-->
<!--                                                        <div class="form-group">-->
<!--                                                            <label for="country">Agent</label>-->
<!--                                                            <select class="form-control" id="PackageAgent"-->
<!--                                                                    name="PackageAgent">-->
<!--                                                                --><?php
//                                                                if ($AgentLogged) {
//                                                                    if (count($SubAgents) > 0)
//                                                                        foreach ($SubAgents as $SA) {
//                                                                            $selected = (($Agentss == $SA['UID']) ? 'selected' : '');
//                                                                            echo '<option value="' . $SA['UID'] . '"' . $selected . '>' . $SA['FullName'] . '</option>';
//                                                                        }
//                                                                } else {
////                                                                            (isset($Agents['html'])) ? $Agents['html'] : '' ;
//                                                                    echo $Agents['html'];
//                                                                }
//                                                                ?>
<!--                                                            </select>-->
<!--                                                        </div>-->
<!--                                                    </div>-->

<!--                                                    <div class="col-md-3">-->
<!--                                                        <div class="form-group">-->
<!--                                                            <label for="country">Start Date</label>-->
<!--                                                            <input type="date" class="form-control mb-4"-->
<!--                                                                   id="StartDate" value="--><?//= $StartDate ?><!--"-->
<!--                                                                   name="StartDate" placeholder="Nationality">-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                    <div class="col-md-3">-->
<!--                                                        <div class="form-group">-->
<!--                                                            <label for="country">Expire Date</label>-->
<!--                                                            <input type="date" class="form-control mb-4"-->
<!--                                                                   id="ExpiryDate" value="--><?//= $ExpireDate ?><!--"-->
<!--                                                                   name="ExpiryDate" placeholder="No of Pax">-->
<!--                                                        </div>-->
<!--                                                    </div>-->

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="country">Start End</label>
                                                            <input type="text" class="form-control multidate validate[required]"
                                                                   name="ArrivalReturn" id="ArrivalReturn" readonly
                                                                   placeholder="ArrivalReturnDates" value="<?=$StartDate?> to <?=$ExpireDate?>"
                                                                   onchange="GetArrivalReturnDate();">

                                                        </div>
                                                    </div>
                                                    <?php
                                                    $data['LookupsOptions'] = $Crud->LookupOptions('visa_types');
                                                    foreach ($data['LookupsOptions'] as $options) {
                                                        $table = 'packages."Meta"';
                                                        $where = array("ReferenceID" => $record_id, "Option" => $options['UID']);
                                                        $PackageMetaData = $Crud->SingleRecord($table, $where);
                                                        echo '
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="visa charges">' . $options['Name'] . '</label>
                                                                <input type="text" class="form-control mb-4 validate[required]" id="VisaCharges" name="VisaCharges[' . $options['UID'] . ']" placeholder="' . $options['Name'] . ' Visa" value="'.$PackageMetaData['Value'].'">
                                                            </div>
                                                        </div>';
                                                    }
                                                    ?>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h3>Hotels</h3>
                                <section>
                                    <div id="Hotels">
                                        <input type="hidden" id="PackageID" name="PackageID"
                                               value="<?= $record_id; ?>">
                                        <input type="hidden" id="HotelCount" name="HotelCount"
                                               value="<?= count($HotelsData) ?>">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-md-12 mx-auto">
                                                    <div class="table-responsive" style="overflow: auto;">
                                                        <table id="MainRecords" class="table table-hover non-hover display nowrap">
                                                            <thead>
                                                            <tr>
                                                                <th>City</th>
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
                                                            <tbody><?php

                                                            $i = 0;
                                                            foreach ($HotelsData as $HotelUID => $thisData) {
                                                                 list($HotelUID, $CityUID, $RoomType, $selectedHotelCategory) = explode("|", $HotelUID);

//                                                                $hotels = $Packages->ListHotelsByCityID($CityUID);

                                                                $HotelCategory = $Crud->LookupOptions('hotel_category');
                                                                $Category = '';
                                                                foreach ($HotelCategory as $options) {
                                                                    $selected = (($selectedHotelCategory == $options['UID']) ? 'selected' : '');
                                                                    $Category .= '<option value="' . $options['UID'] . '" ' . $selected . '>' . $options['Name'] . '</option>';
                                                                }
                                                                ?>
                                                            <tr id="TR<?= $i ?>">
                                                                <td>
                                                                    <select class="form-control HotelCities"
                                                                            id="City_<?= $i ?>" name="City[]"
                                                                            <!--onChange="LoadHotelByCites(this.value, <?/*= $i */?>)"-->>
                                                                        <option value="">Please Select</option>
                                                                        <?php
                                                                        // print_r($Cities);
                                                                        foreach ($Cities as $thisCity) {
                                                                            echo '<option value="' . $thisCity['UID'] . '" ' . (($CityUID == $thisCity['UID']) ? 'selected' : '') . '>' . $thisCity['Name'] . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control validate[required]"
                                                                            id="HotelCategory_<?= $i ?>"
                                                                            name="HotelCategory[]"
                                                                            onChange="LoadHotelByCites(this.value, <?= $i ?>)">
                                                                        <option value="">Please Select Category
                                                                        </option> <?= $Category ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control"
                                                                            id="Hotel_<?= $i ?>" name="Hotel[]">
                                                                        <option value="">Please select</option>
                                                                        <?php
                                                                        // print_r($Cities);
                                                                        foreach ($hotels as $thisHotel) {
                                                                            echo '<option value="' . $thisHotel['UID'] . '" ' . (($HotelUID == $thisHotel['UID']) ? 'selected' : '') . '>' . $thisHotel['Name'] . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td><?php
                                                                foreach ($RoomTypes as $RoomType) {
                                                                    $key = $RoomType['UID'];
                                                                    $Name = 'RoomType[' . $key . '][]';
                                                                    $Value = (isset($thisData[$RoomType['UID']])) ? $thisData[$RoomType['UID']] : '';
                                                                    echo "<td><input class='form-control' type=\'text\' value='" . $Value . "' name='" . $Name . "'></td>";
                                                                }
                                                                $TR = "TR" . $i; ?>
                                                                <td>
                                                                    <a href="#" onClick="RemoveRow('<?= $TR ?>')">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                             width="24" height="24"
                                                                             viewBox="0 0 24 24" fill="none"
                                                                             stroke="currentColor" stroke-width="2"
                                                                             stroke-linecap="round"
                                                                             stroke-linejoin="round"
                                                                             class="feather feather-x t-icon t-hover-icon">
                                                                            <line x1="18" y1="6" x2="6"
                                                                                  y2="18"></line>
                                                                            <line x1="6" y1="6" x2="18"
                                                                                  y2="18"></line>
                                                                        </svg>
                                                                    </a>
                                                                </td>
                                                                </tr><?php
                                                                $i++;
                                                            }
                                                            ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h3>Transport</h3>
                                <section>
                                    <div id="Transport">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-md-12 mx-auto">
                                                    <div class="table-responsive" style="overflow: auto;">
                                                        <table id="MainRecords" class="table table-hover non-hover display nowrap">
                                                            <thead>
                                                            <tr>
                                                                <?php
                                                                foreach ($TransportData AS $thisType) {
                                                                    echo '<th>' . $thisType . '</th>';
                                                                }
                                                                ?>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            for ($i = 0; $i < count($TransportSectors); $i++) {
                                                                $Sector = strtolower(str_ireplace(" ", "_", $TransportSectors[$i]["UID"]));
                                                                echo '<tr style="border-bottom: 0px;"><td colspan="' . count($TransportData) . '">' . $TransportSectors[$i]["Name"] . '</td></tr>';
                                                                echo '<tr>';
                                                                foreach ($TransportData AS $TransportUID => $thisType) {
                                                                    $value = "";
                                                                    if (isset($TransportDBData[$TransportUID . "_" . $Sector . "_" . $i])) {
                                                                        $value = $TransportDBData[$TransportUID . "_" . $Sector . "_" . $i];
                                                                    }

                                                                    echo '<td><input class="form-control" value="' . $value . '" type="text" name="TransportRate[' . $TransportUID . "|" . $Sector . "|" . $i . ']"></td>';
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
                                    </div>
                                </section>
                                <h3>Ziyarat</h3>
                                <section>
                                    <div id="Ziyarat">
                                        <input type="hidden" id="ZiyaratCount" name="ZiyaratCount"
                                               value="<?= $ziyaratCount ?>">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-md-12 mx-auto">
                                                    <div class="table-responsive" style="overflow: auto;">
                                                        <table id="MainRecords" class="table table-hover non-hover display nowrap">
                                                            <thead>
                                                            <tr>
                                                                <th>Location</th>
                                                                <th>Ziyarat</th><?php
                                                                foreach ($TransportData AS $thisType) {
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
                                                            <tbody>
                                                            <?php

                                                            $i = 0;
                                                            if (count($ZiyaratData) > 0)
                                                                foreach ($ZiyaratData as $ZiyaratUID => $thisData) {
                                                                    list($ZiyaratUID, $CityUID) = explode("|", $ZiyaratUID);
                                                                    ?>
                                                                <tr id="TR<?= $i ?>">
                                                                    <td>
                                                                        <select class="form-control HotelCities"
                                                                                id="ZiyaratCity_<?= $i ?>"
                                                                                name="ZiyaratCity[]"
                                                                                onChange="LoadZiyaratByCites(this.value, <?= $i ?>)">
                                                                            <option value="">Please Select</option>
                                                                            <?php
                                                                            // print_r($Cities);
                                                                            foreach ($Cities as $thisCity) {
                                                                                echo '<option value="' . $thisCity['UID'] . '" ' . (($CityUID == $thisCity['UID']) ? 'selected' : '') . '>' . $thisCity['Name'] . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-control"
                                                                                id="Ziyarat_<?= $i ?>" name="Ziyarat[]">
                                                                            <option value="">Please select</option>
                                                                            <?php
                                                                            // print_r($Cities);
                                                                            foreach ($ziyarat as $thisZiyarat) {
                                                                                echo '<option value="' . $thisZiyarat['UID'] . '" ' . (($ZiyaratUID == $thisZiyarat['UID']) ? 'selected' : '') . '>' . $thisZiyarat['Name'] . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </td><?php
                                                                    foreach ($TransportData AS $key => $thisType) {
                                                                        // $key = $thisType['UID'];
                                                                        $Name = 'ZiyaratRates[' . $key . '][]';
                                                                        $Value = (isset($thisData[$key])) ? $thisData[$key] : '';
                                                                        echo "<td><input class='form-control' type=\'text\' value='" . $Value . "' name='" . $Name . "'></td>";
                                                                    }
                                                                    $TR = "TR" . $i; ?>
                                                                    <td>
                                                                        <a href="#"
                                                                           onClick="RemoveZiyaratRow('<?= $TR ?>')">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                 width="24" height="24"
                                                                                 viewBox="0 0 24 24" fill="none"
                                                                                 stroke="currentColor" stroke-width="2"
                                                                                 stroke-linecap="round"
                                                                                 stroke-linejoin="round"
                                                                                 class="feather feather-x t-icon t-hover-icon">
                                                                                <line x1="18" y1="6" x2="6"
                                                                                      y2="18"></line>
                                                                                <line x1="6" y1="6" x2="18"
                                                                                      y2="18"></line>
                                                                            </svg>
                                                                        </a>
                                                                    </td>
                                                                    </tr><?php
                                                                    $i++;
                                                                }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
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
                                                    // echo "<pre>";
                                                    // print_r($ServiceData);
                                                    foreach ($ExtraServices AS $key => $thisService) {
                                                        // print_r($thisService);
                                                        $Value = (isset($ServiceData[$thisService['UID']])) ? $ServiceData[$thisService['UID']] : '';
                                                        ?>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="location"><?= $thisService['Name']; ?> </label>
                                                                <input type="number" class="form-control mb-4"
                                                                       value="<?= $Value ?>"
                                                                       id="laundry"
                                                                       name="Extra[<?= $thisService['UID'] ?>]"
                                                                       placeholder="<?= $thisService['Name']; ?>">
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button id="multiple-messages" onclick="PackageFormSubmit()" class="btn btn_customized float-right">Save
                                                    Changes
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>


                        </div>
                    </form
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                        <div class="" id="b2bGeneralPackageUpdateResponse"></div>
                    </div>
                </div>
            </div>

        </div>



    </div>
</div>

<script type="application/javascript">
    function GetArrivalReturnDate() {

        const ArrivalReturn = $("#ArrivalReturn").val();
        const words = ArrivalReturn.split(' to ');
        $("#StartDate").val(words[0]);
        $("#ExpiryDate").val(words[1]);



    }
    $("form#B2BGeneralPackageUpdateForm").on("submit", function (event) {
        event.preventDefault();
    });

    function PackageFormSubmit() {

        var validate = $("form#B2BGeneralPackageUpdateForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        var phpdata = new window.FormData($("form#B2BGeneralPackageUpdateForm")[0]);
        response = AjaxUploadResponse("form_process/b2b_general_package_form_submit", phpdata);

        if (response.status == 'success') {
            $("#b2bGeneralPackageUpdateResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.href = "<?=base_url('package/b2b_general_package')?>";
            }, 2000)
        } else {
            $("#b2bGeneralPackageUpdateResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }

    function LoadCitiesDropdown(country) {
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country);
        $(".HotelCities").html('<option value="">Please Select</option>' + cities.html);
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

    function DefaultHotelRowHTML(cnt) {
        cnt = cnt + 1;
        var html;
        <?php
        $HTML = '';
        $HotelCategory = $Crud->LookupOptions('hotel_category');
        // print_r($RoomTypes); exit;
        foreach ($RoomTypes as $RoomType) {
            $Name = 'RoomType[' . $RoomType['UID'] . '][]';
            $HTML .= "<td><input class=\'form-control\' type=\'text\' name=" . $Name . "></td>";
        }

        $Category = '';
        foreach ($HotelCategory as $options) {
            $Category .= '<option value=' . $options['UID'] . '>' . $options['Name'] . '</option>';
        }
        ?>

        CountryCode = $("#PackageCounty").val();
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + CountryCode);
        HotelCities = '<select class="form-control HotelCities" id="City_' + cnt + '" name="City[]" ><option value="">Please Select</option>' + cities.html + '</select>'
        Hotels = '<select class="form-control" id="Hotel_' + cnt + '" name="Hotel[]" ><option value="">Please select City</option></select>'

        html = '' +
            '<tr id="TR' + cnt + '">' +
            '<td>' + HotelCities + '</td>' +
            '<td><select class="form-control validate[required]" id="HotelCategory_' + cnt + '" name="HotelCategory[]"  onChange="LoadHotelByCites(this.value, ' + cnt + ')" ><option value="">Please Select Category</option> <?= $Category ?></select></td>' +
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
        foreach ($TransportData AS $key => $thisType) {
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
        $("#Hotels  tbody tr#" + id).remove();
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

    function AddNewZiyarat() {
        ZiyaratCount = parseInt($("#ZiyaratCount").val());

        HTML = DefaultZiyaratRowHTML(ZiyaratCount);
        $("#Ziyarat  tbody").append(HTML);
        $("#ZiyaratCount").val(ZiyaratCount + 1);
        return false;
    }

    setTimeout(function () {
        // AddNewHotel();
        GetArrivalReturnDate();

    }, 1000)

</script>

<script src="<?= $template ?>plugins/jquery-step/jquery.steps.min.js"></script>
<script src="<?= $template ?>plugins/jquery-step/custom-jquery.steps.js"></script>

