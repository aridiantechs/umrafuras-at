<?php

use App\Models\Crud;

$Crud = new Crud();
$LeadRecord = $records['LeadRecord'];
$LeadAgent = ( ( isset($LeadRecord['UserID']) && $LeadRecord['UserID'] != '' )? $LeadRecord['UserID'] : 0 );
$SalesOfficersData = $Crud->ListRecords('main."Users"', array('UserType' => 'sale-officer', 'Archive' => 0, 'UID !=' => $LeadAgent), array('FullName' => 'ASc'));
?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Reassign Lead</h5>
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
<div class="modal-body">
    <form method="post" name="ReAssignForm" id="ReAssignForm"
          onsubmit="ReAssignFormSubmit('ReAssignForm'); return false;">
        <input type="hidden" name="LeadsUID" id="LeadsUID" value="<?=$LeadRecord['UID']?>">
        <input type="hidden" name="ReAssignedFrom" id="ReAssignedFrom" value="<?=$LeadRecord['UserID']?>">
        <div class="row">
            <div class="col-md-10">
                <label for="country">Lead Reassign To</label>
                <select class="form-control" id="ReAssignedTo" name="ReAssignedTo">
                    <option value="">Kindly Select</option>
                    <?php
                    foreach ($SalesOfficersData as $SOD) {
                        echo '<option value="' . $SOD['UID'] . '">' . $SOD['FullName'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2 mt-4 pt-1">
                <button id="LeadAssignmentButton" type="button" class="btn btn-success btn-sm form-control" onclick="ReAssignFormSubmit('ReAssignForm');">
                    Assign
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-4" id="ReAssignFormAjaxResponse"></div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Discard</button>
</div>
<script type="text/javascript">

    $(document).ready(function () {
        setTimeout(function () {
            $("form#ReAssignForm")[0].reset();
        }, 500);
    });

    function ReAssignFormSubmit(parent) {

        if (confirm("Do You Want To Re-Assign Lead")) {

            var ReAssignedTo = $("form#ReAssignForm select#ReAssignedTo").val();
            if (ReAssignedTo != '') {

                $("#LeadAssignmentButton").html("Wait...");
                $("#LeadAssignmentButton").removeClass("btn-success");
                $("#LeadAssignmentButton").addClass("btn-danger btn-sm");
                $("#LeadAssignmentButton").attr("disabled", true);

                var data = $("form#" + parent).serialize();
                var response = AjaxResponse('lead/leads_reassign_form_submit', data);
                if (response.status == 'success') {
                    GridMessages('ReAssignForm', 'ReAssignFormAjaxResponse', 'alert-success', response.message, 2000);
                    setTimeout(function () {
                        location.reload();
                    }, 2000);

                    $("#LeadAssignmentButton").html("Assign");
                    $("#LeadAssignmentButton").removeClass("btn-danger");
                    $("#LeadAssignmentButton").addClass("btn-success btn-sm");
                    $("#LeadAssignmentButton").attr("disabled", false);

                } else {
                    GridMessages('ReAssignForm', 'ReAssignFormAjaxResponse', 'alert-warning', response.message, 2000);

                    $("#LeadAssignmentButton").html("Assign");
                    $("#LeadAssignmentButton").removeClass("btn-danger");
                    $("#LeadAssignmentButton").addClass("btn-success btn-sm");
                    $("#LeadAssignmentButton").attr("disabled", false);
                }

            } else {
                GridMessages('ReAssignForm', 'ReAssignFormAjaxResponse', 'alert-warning', 'Please Select Agent To Re-Assign Lead', 2000);
            }
        }
    }

</script>