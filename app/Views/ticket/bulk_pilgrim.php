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

use App\Models\Crud;

$Crud = new Crud();
$TitlesOptions = $Crud->LookupOptions('title_options');

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
                                    <h4>Add Bulk Pilgrims <span id="ExportPackage"> </span></h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <form enctype="multipart/form-data" class="validate" method="post" action="#"
                                  id="BulkPilgrimsForm" name="BulkPilgrimsForm">
                                <input type="hidden" name="ArrivalDate" id="ArrivalDate" value="">
                                <input type="hidden" name="DepartureDate" id="DepartureDate" value="">
                                <input type="hidden" id="DomainID" name="DomainID" value="<?= $GetDomainID ?>">
                                <div id="BulkPilgrimsSection">
                                    <h3>Basic Details</h3>
                                    <section>
                                        <div id="VoucherDetails">
                                            <div class="row" id="voucher_details">
                                                <div class="col-md-3">
                                                    <label for="country">Agent</label>
                                                    <?php
                                                    if ($session['account_type'] == "external_agent" || $session['account_type'] == "agent") {
                                                        echo '<select class="form-control validate[required] text-input"  id="AgentID" name="AgentID">
                                                                    <option value="">Please Select</option>';
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
                                                        echo '<select class="form-control validate[required] text-input" 
                                                                    id="AgentID" name="AgentID"> 
                                                                        <option value="">Please Select</option>';
                                                        foreach ($AllAgents as $agent) {
                                                            $table = 'packages."Packages"';
                                                            $where = array("AgentUID" => $agent['UID']);
                                                            $Agents = $Crud->SingleRecord($table, $where);
                                                            if (isset($Agents['UID']) && $Agents['UID'] > 0) {
                                                                echo ' <option value="' . $agent['UID'] . '">' . $agent['FullName'] . " (" . ucwords(str_replace("_", " ", $agent['Type'])) . ")" . '</option>  ';
                                                            }
                                                        }
                                                        echo '</select>';
                                                    } ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="country">Country</label>
                                                    <select class="form-control validate[required]"
                                                            id="Country"
                                                            name="Country"
                                                            data-prompt-position="bottomLeft:20,35">
                                                        <option value="SA">Saudi Arabia</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="country">Group Name </label>
                                                    <input type="text" class="form-control  validate[required] mb-4"
                                                           id="GroupName" name="GroupName"
                                                           placeholder="Group Name"
                                                           data-prompt-position="bottomLeft:20,20">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="country">Arrival Departure</label>
                                                    <input type="text"
                                                           class="form-control multidate validate[required,future[now]]"
                                                           name="ArrivalReturn" id="ArrivalReturn"
                                                           placeholder="ArrivalReturnDates"
                                                           onchange="GetArrivalReturnDate();">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="country">Visa</label><br>
                                                    <select class="form-control validate[required]" id="Visa"
                                                            name="Visa"
                                                            data-prompt-position="bottomLeft:20,35">
                                                        <option value="">Please Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="country">No Of PAX </label>
                                                    <input type="number" min="1"
                                                           class="form-control  validate[required] mb-4"
                                                           id="NoOfPAX" name="NoOfPAX"
                                                           placeholder="No Of PAX"
                                                           data-prompt-position="bottomLeft:20,20">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="country">Refund Amount</label><br>
                                                    <input value="0" class="form-control validate[required]"
                                                           type="number" min="0" name="RefundAmount"
                                                           id="RefundAmount">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="country">Reference/Remarks</label><br>
                                                    <textarea class="form-control mb-4"
                                                              id="Remarks" name="Remarks"
                                                              placeholder="Remarks"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <h3>Pilgrims </h3>
                                    <section>
                                        <div id="PersonalDetails">
                                            <div class="row">
                                                <div class="col-lg-12 mx-auto">
                                                    <div class="info" id="bulkpilgrim"></div>
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
                <div class="" id="GroupAddResponse"></div>
            </div>
        </div>
    </div>
</div>
<script src="<?= $template ?>plugins/jquery-step/jquery.steps.min.js"></script>
<script>

    $("form#BulkPilgrimsForm").on("submit", function (event) {
        event.preventDefault();
    });

    $("#BulkPilgrimsSection").steps({
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
        }
    });

    function GroupValidation(currentIndex, newIndex) {

        if (newIndex < currentIndex) {
            $("form#BulkPilgrimsForm").validationEngine('hideAll');
            return true;
        }
        var validate = $("form#BulkPilgrimsForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        if (currentIndex == 0 && newIndex == 1) {
            RequstedBulkPilgrimFormHTML();
        }
        if (currentIndex == 5 && newIndex == 6) {
            GroupFormSummary();
        }
        return true;
    }


    function RequstedBulkPilgrimFormHTML() {

        var html = '';
        var paxtotal = $("#NoOfPAX").val();
        var count = 0;
        for (let i = 1; i <= paxtotal; i++) {
            count++;
            /*if (i == 1) {
                changenationality = 'onchange="changenationality(this.value);"';
                changecity = 'onchange="changecity(this.value);"';

            }*/

            html += '<div class="row">\n' +
                '<div class="col-xl-12 col-lg-12 col-md-8 mt-md-0 mt-4">\n' +
                '<div class="form">\n' +
                '<div class="row">\n' +
                '<div class="col-md-3"><label for="country">Title</label>' +
                '<select class="form-control" id="Title" name="Pilgrim[Title][]"> ' +
                '<option value="">Please Select</option>';
            <?php
            foreach($TitlesOptions as $TO){?>
            html += '<option value="<?=$TO['UID']?>"><?=$TO['Name']?></option>';
            <?php    }
            ?>
            html += '</select></div>\n' +
                '<div class="col-md-3"><label for="address">FirstName</label><input type="text" class="form-control mb-4  validate[required]" id="FirstName" name="Pilgrim[FirstName][]" placeholder="First Name"></div>\n' +
                '<div class="col-md-3"><label for="location">Middle Name</label><input type="text" class="form-control mb-4  validate[required]" id="MiddleName" name="Pilgrim[MiddleName][]" placeholder="Middle Name"></div>\n' +
                '<div class="col-md-3"><label for="location">Last Name</label><input type="text" class="form-control mb-4  validate[required]" id="LastName" name="Pilgrim[LastName][]" placeholder="Last Name"></div>\n' +
                '</div>\n' +
                '<div class="row">\n' +
                '<div class="col-md-3"><label for="phone">Passport Number </label><input type="text" class="form-control mb-4  validate[required]" id="PassportNumber" name="Pilgrim[PassportNumber][]" placeholder="Passport Number"></div>\n' +
                '<div class="col-md-3"><label for="email">Passport Issue Date</label><input type="date" class="form-control mb-4" id="PassportIssueDate" name="Pilgrim[PassportIssueDate][]" placeholder="Passport Issue Date"></div>\n' +
                '<div class="col-md-3"><label for="email">Passport Expiry Date</label><input type="date" class="form-control mb-4" id="PassportExpiryDate" name="Pilgrim[PassportExpiryDate][]" placeholder="Passport Expiry Date"></div>\n' +
                '</div>\n' +
                '<div class="row">\n' +
                '<div class="col-md-3"><label for="phone">CitizenShip Number</label><input type="text" class="form-control mb-4  validate[required]" id="CitizenShipNumber" name="Pilgrim[CitizenShipNumber][]" placeholder="CitizenShip Number"></div>\n' +
                '<div class="col-md-3"><label for="email">Issue Date</label><input type="date" class="form-control mb-4" id="IssueDate" name="Pilgrim[IssueDate][]" placeholder=" Issue Date"></div>\n' +
                '<div class="col-md-3"><label for="email">Expiry Date</label><input type="date" class="form-control mb-4" id="ExpiryDate" name="Pilgrim[ExpiryDate][]" placeholder=" Expiry Date"></div>\n' +
                '<div class="col-md-3"><label for="email">DOB</label><input type="date" class="form-control mb-4" id="DOB" name="Pilgrim[DOB][]" placeholder="DOB"></div>\n' +
                '</div>\n' +
                '<div class="row">\n' +
                '<div class="col-md-3"><label for="phone">CitizenShip Card</label><input type="file"  name="Pilgrim[CitizenShipCard][]" id="CitizenShipCard"/></div>\n' +
                '<div class="col-md-3"><label for="phone">Passport 1st Page </label><input type="file"  name="Pilgrim[PassportFile][]" id="PassportFile"/></div>\n' +
                '<div class="col-md-3"><label for="email">Visa</label><input type="file"  name="Pilgrim[Visa][]" id="Visa"/></div>\n' +
                '<div class="col-md-3"><label for="City">Vaccination Certificate  </label><input type="file"  name="Pilgrim[VaccinationCertificate][]" id="VaccinationCertificate"/></div>\n' +
                '</div>\n' +
                '<div class="row" id="addTraveler_' + count + '"></div> \n</div>\n ' +
                '</div>\n' +
                '</div>\n' +
                '<div class="col-md-12"><hr style="border-top: 1px solid black"></div>';
        }
        DefaultScripts();
        $('#bulkpilgrim').html(html);
        $('.dropify').dropify();
    }

    function GetArrivalReturnDate() {

        const ArrivalReturn = $("#ArrivalReturn").val();
        const words = ArrivalReturn.split(' to ');
        $("#ArrivalDate").val(words[0]);
        $("#DepartureDate").val(words[1]);
    }


    /*function GroupFormSummary() {

        var phpdata = $("form#GroupAddForm").serialize();
        var response = AjaxRequest("form_process/group_bulk_pilgrim_form_submmary", phpdata, "SummaryGrid");


    }*/

    /*function GroupFormSubmit() {

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
    }*/

</script>
