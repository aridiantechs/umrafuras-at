<?php

use App\Models\Crud;

$Crud = new Crud();

$UnAssignLeadsData = $Crud->ListRecords('sales."Leads"', array('UserID' => 0));
$UnAssignLeads = count($UnAssignLeadsData);
$SalesOfficersData = $Crud->ListRecords('main."Users"', array('UserType' => 'sale-officer', 'Archive' => 0), array('FullName' => 'ASc'));
?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Total <span
                style="color: #B1593D;">"<b><?= $UnAssignLeads ?></b>"</span> Un-Assign Leads
        Available</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="feather feather-x-circle">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
    </button>
</div>
<form class="validate" method="post" name="UnAssignLeadsForm" id="UnAssignLeadsForm"
      onsubmit="UnAssignLeadsFormSubmit('UnAssignLeadsForm'); return false;">
    <input type="hidden" name="total_un_assign_leads" id="total_un_assign_leads" value="<?=$UnAssignLeads?>">
    <div class="modal-body pt-0">
        <?php
        if (isset($UnAssignLeads) && $UnAssignLeads != '' && $UnAssignLeads > 0) { ?>
            <div class="row mt-3">
                <div class="col-md-10">
                    <div class="form-group">
                        <label for="country">Sales Officer</label>
                        <select class="form-control" id="agent_uid" name="agent_uid">
                            <option value="">Kindly Select</option>
                            <?php
                            foreach ($SalesOfficersData as $SOD) {
                                echo '<option value="' . $SOD['UID'] . '">' . $SOD['FullName'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="leads">Leads</label>
                        <input type="text" name="leads_counter" id="leads_counter" placeholder="leads"
                               class="form-control">
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="row" id="UnAssignLeadsAlertDiv">
                <div class="col-md-12 text-center">
                    <div class="alert alert-danger text-center  font-weight-bold">No Un-Assign Leads Record
                        Available
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="row mt-3">
            <div class="col-md-12" id="UnAssignLeadsImportAjaxResponse"></div>
        </div>
    </div>
    <div class="modal-footer">
        <?php
        if (isset($UnAssignLeads) && $UnAssignLeads != '' && $UnAssignLeads > 0) { ?>
            <button id="UnAssignLeadsFormButton" type="button" class="btn btn-success btn-sm"
                    onclick="UnAssignLeadsFormSubmit('UnAssignLeadsForm');">
                Assign
            </button>
        <?php } ?>
        <button class="btn btn-sm" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Discard</button>
    </div>
</form>
<script>

    function UnAssignLeadsFormSubmit(parent) {

        var TotalUnAssign = $("form#UnAssignLeadsForm input#total_un_assign_leads").val();
        var TotalLeadsInput = $("form#UnAssignLeadsForm input#leads_counter").val();
        var Agent = $("form#UnAssignLeadsForm select#agent_uid").val();

        if (Agent == '') {
            GridMessages('UnAssignLeadsForm', 'UnAssignLeadsImportAjaxResponse', 'alert-danger', "Please Select Agent To Assign Leads", 3000)
        } else if (isNaN(TotalLeadsInput) || TotalLeadsInput == '' || TotalLeadsInput < 0) {
            GridMessages('UnAssignLeadsForm', 'UnAssignLeadsImportAjaxResponse', 'alert-danger', "Please Correctly Fill Leads Input", 3000);
            $("form#UnAssignLeadsForm input#leads_counter").focus();
        } else {

            if (confirm("Do You Want to Assign Leads To Selected Agents ")) {

                $("#UnAssignLeadsFormButton").html("Wait...");
                $("#UnAssignLeadsFormButton").removeClass("btn-success btn-sm");
                $("#UnAssignLeadsFormButton").addClass("btn-danger btn-sm");
                $("#UnAssignLeadsFormButton").attr("disabled", true);

                var data = $("form#" + parent).serialize();
                var rslt = AjaxResponse('lead/un_assign_leads_form_submit', data);
                if (rslt.status == 'success') {
                    GridMessages('UnAssignLeadsForm', 'UnAssignLeadsImportAjaxResponse', 'alert-success', rslt.message, 3000);
                    setTimeout(function () {
                        $("form#" + parent)[0].reset();
                        location.reload();
                    }, 4500);

                    $("#UnAssignLeadsFormButton").html("Assign");
                    $("#UnAssignLeadsFormButton").removeClass("btn-danger btn-sm");
                    $("#UnAssignLeadsFormButton").addClass("btn-success btn-sm");
                    $("#UnAssignLeadsFormButton").attr("disabled", false);

                } else {

                    $("#UnAssignLeadsFormButton").html("Assign");
                    $("#UnAssignLeadsFormButton").removeClass("btn-danger btn-sm");
                    $("#UnAssignLeadsFormButton").addClass("btn-success btn-sm");
                    $("#UnAssignLeadsFormButton").attr("disabled", false);

                    GridMessages('UnAssignLeadsForm', 'UnAssignLeadsImportAjaxResponse', 'alert-danger', rslt.message, 3000);
                }

            }

        }
    }
</script>