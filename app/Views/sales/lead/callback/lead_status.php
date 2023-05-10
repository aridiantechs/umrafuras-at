<?php

use App\Models\Crud;

$Crud = new Crud();
$LeadRecord = $records['LeadRecord'];
$CallBackDate = ((isset($LeadRecord['CallBackDateTime']) && $LeadRecord['CallBackDateTime'] != '') ? date("Y-m-d", strtotime($LeadRecord['CallBackDateTime'])) : '');
$CalBackTime = ((isset($LeadRecord['CallBackDateTime']) && $LeadRecord['CallBackDateTime'] != '') ? date("H:i", strtotime($LeadRecord['CallBackDateTime'])) : '');
?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Lead Status / CallBack</h5>
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
<form class="validate" method="post" name="LeadsStatusCallBackForm" id="LeadsStatusCallBackForm"
      onsubmit="LeadsStatusCallBackFormSubmit('LeadsStatusCallBackForm'); return false;">
    <input type="hidden" name="LeadUID" id="LeadUID" value="<?= $LeadRecord['UID'] ?>">
    <input type="hidden" name="FormType" id="FormType" value="call_back">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="country">Lead Status/CallBack</label>
                    <select onchange="LoadSaleMaturityFormSegment( this.value );" class="form-control" id="status"
                            name="status">
                        <option value="">Select Status</option>
                        <?php
                        if ($LeadRecord['LeadCategory'] == 'B2B') {
                            foreach ($B2BLeadStatusArray as $key => $value) {
                                echo ' <option ' . ((isset($LeadRecord['Status']) && $LeadRecord['Status'] == $key) ? 'selected' : '') . '  value="' . $key . '">' . $value . '</option>';
                            }
                        } else {
                            foreach ($B2CLeadStatusArray as $key => $value) {
                                echo ' <option ' . ((isset($LeadRecord['Status']) && $LeadRecord['Status'] == $key) ? 'selected' : '') . '  value="' . $key . '">' . $value . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12" id="LeadStatusCallBackFormDiv">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Call Back Date</label>
                            <input value="<?= $CallBackDate ?>" id="call_back_date" name="call_back_date" type="date"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Call Back Time</label>
                            <input value="<?= $CalBackTime ?>" id="call_back_time" name="call_back_time" type="time"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Activity</label>
                            <textarea id="callback_activity" name="callback_activity" type="text"
                                      class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="d-none" id="ClosedClientFormDiv" style="width: 100%">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="mb-0">Reason</label>
                        <select id="Reason" name="Reason" class=" form-control"
                                data-style="py-0">
                            <option value="">Kindly Select</option>
                            <?php
                            if ($LeadRecord['LeadCategory'] == 'B2B') {
                                $B2BCloseReasons = $Crud->LookupOptions('b2b_lead_close_reason');
                                foreach ($B2BCloseReasons as $Reasons) {
                                    echo '<option value="' . $Reasons['UID'] . '">' . $Reasons['Name'] . '</option>';
                                }
                            } else {
                                $B2CCloseReasons = $Crud->LookupOptions('b2c_lead_close_reason');
                                foreach ($B2CCloseReasons as $Reasons) {
                                    echo '<option value="' . $Reasons['UID'] . '">' . $Reasons['Name'] . '</option>';
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group" style="margin-bottom: 0rem;">
                        <label class="mb-0">Remarks</label>
                        <textarea style="margin-bottom: 5px !important;" name="Remarks"
                                  id="Remarks" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="d-none" id="FollowUpFormDiv" style="width: 100%; padding: 15px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="mb-0">Reason</label>
                                <select id="FollowUpReason" name="FollowUpReason" class=" form-control"
                                        data-style="py-0">
                                    <option value="">Kindly Select</option>
                                    <?php
                                    $LeadFollowUpReason = $Crud->LookupOptions('lead_followup_reason');
                                    foreach ($LeadFollowUpReason as $Reason) {
                                        echo '<option ' . ((isset($LeadRecord['FollowUpReason']) && $LeadRecord['FollowUpReason'] == $Reason['UID']) ? 'selected' : '') . ' value="' . $Reason['UID'] . '">' . $Reason['Name'] . '</option>';
                                    } ?>
                                    <option value="0">Other</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="mb-0">Call Back Date</label>
                                <input value="<?= $CallBackDate ?>" class="form-control" type="date"
                                       min="<?= date("Y-m-d") ?>"
                                       id="call_back_date_followup"
                                       name="call_back_date_followup"
                                       placeholder="Call Back Date">
                            </div>
                            <div class="col-md-3">
                                <label class="mb-0">Call Back Time</label>
                                <input value="<?= $CalBackTime ?>" class="form-control" type="time"
                                       id="call_back_time_followup"
                                       name="call_back_time_followup"
                                       placeholder="Call Back Time">
                            </div>
                            <div class="col-md-12 mt-3">
                                <label class="mb-0">Activity</label>
                                <textarea style="margin-bottom: 5px !important;"
                                          name="callback_activity_followup"
                                          id="callback_activity_followup" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-none" id="LeadStatusSaleMaturityFormDiv">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <label class="mb-0">Remarks</label>
                        <textarea style="margin-bottom: 5px !important; line-height: 25px !important;"
                                  name="maturity_remarks"
                                  id="maturity_remarks" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="LeadsStatusCallBackAjaxResponse"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Discard</button>
        <button id="LeadStatusCallBackButton" type="button" class="btn btn-primary"
                onclick="LeadsStatusCallBackFormSubmit('LeadsStatusCallBackForm');">Save
        </button>
    </div>
</form>
<script type="text/javascript">

    $(document).ready(function () {
        setTimeout(function () {
            LoadSaleMaturityFormSegment('<?=$LeadRecord['Status']?>');
        }, 1000);
    });

    function LoadSaleMaturityFormSegment(Value) {

        if (Value == 'sale') {
            $("form#LeadsStatusCallBackForm input#FormType").val('maturity');

            $("form#LeadsStatusCallBackForm div#LeadStatusSaleMaturityFormDiv").removeClass('d-none');
            $("form#LeadsStatusCallBackForm div#LeadStatusCallBackFormDiv").addClass('d-none');
            $("form#LeadsStatusCallBackForm div#ClosedClientFormDiv").addClass('d-none');
            $("form#LeadsStatusCallBackForm div#FollowUpFormDiv").addClass('d-none');

        } else if (Value == 'closed_clients') {

            $("form#LeadsStatusCallBackForm input#FormType").val('closed_clients');
            $("form#LeadsStatusCallBackForm div#LeadStatusSaleMaturityFormDiv").addClass('d-none');
            $("form#LeadsStatusCallBackForm div#LeadStatusCallBackFormDiv").addClass('d-none');

            $("form#LeadsStatusCallBackForm div#ClosedClientFormDiv").removeClass('d-none');
            $("form#LeadsStatusCallBackForm div#FollowUpFormDiv").addClass('d-none');

        } else if (Value == 'followup') {

            $("form#LeadsStatusCallBackForm input#FormType").val('followup');
            $("form#LeadsStatusCallBackForm div#LeadStatusSaleMaturityFormDiv").addClass('d-none');
            $("form#LeadsStatusCallBackForm div#LeadStatusCallBackFormDiv").addClass('d-none');
            $("form#LeadsStatusCallBackForm div#ClosedClientFormDiv").addClass('d-none');
            $("form#LeadsStatusCallBackForm div#FollowUpFormDiv").removeClass('d-none');

        } else {

            $("form#LeadsStatusCallBackForm input#FormType").val('no_answer_callback');
            $("form#LeadsStatusCallBackForm div#ClosedClientFormDiv").addClass('d-none');
            $("form#LeadsStatusCallBackForm div#FollowUpFormDiv").addClass('d-none');
            $("form#LeadsStatusCallBackForm div#LeadStatusSaleMaturityFormDiv").addClass('d-none');
            $("form#LeadsStatusCallBackForm div#LeadStatusCallBackFormDiv").removeClass('d-none');
        }
    }

    function LeadsStatusCallBackFormSubmit(parent) {

        var LeadUID = $("form#LeadsStatusCallBackForm input#LeadUID").val();

        var FormType = $("form#LeadsStatusCallBackForm input#FormType").val();
        var Status = $("form#LeadsStatusCallBackForm select#status").val();
        var Reason = $("form#LeadsStatusCallBackForm select#Reason").val();
        var FollowUpReason = $("form#LeadsStatusCallBackForm select#FollowUpReason").val();
        var call_back_date_followup = $("form#LeadsStatusCallBackForm input#call_back_date_followup").val();
        var call_back_time_followup = $("form#LeadsStatusCallBackForm input#call_back_time_followup").val();

        if (Status == '') {
            $("form#LeadsStatusCallBackForm select#status").focus();
            GridMessages('LeadsStatusCallBackForm', 'LeadsStatusCallBackAjaxResponse', 'alert-danger', 'Please Select Lead Status', 2500);
            return false;
        } else if (Status == 'closed_clients' && Reason == '') {
            $("form#LeadsStatusCallBackForm select#Reason").focus();
            GridMessages('LeadsStatusCallBackForm', 'LeadsStatusCallBackAjaxResponse', 'alert-danger', 'Please Select Lead Closing Reason', 2500);
            return false;
        } else if (Status == 'followup' && FollowUpReason == '') {
            $("form#LeadsStatusCallBackForm select#FollowUpReason").focus();
            GridMessages('LeadsStatusCallBackForm', 'LeadsStatusCallBackAjaxResponse', 'alert-danger', 'Please Select Lead Followup Reason', 2500);
            return false;
        } else if (Status == 'followup' && call_back_date_followup == '') {
            $("form#LeadsStatusCallBackForm select#FollowUpReason").focus();
            GridMessages('LeadsStatusCallBackForm', 'LeadsStatusCallBackAjaxResponse', 'alert-danger', 'Please Add Lead Followup Date', 2500);
            return false;
        } else if (Status == 'followup' && call_back_time_followup == '') {
            $("form#LeadsStatusCallBackForm select#FollowUpReason").focus();
            GridMessages('LeadsStatusCallBackForm', 'LeadsStatusCallBackAjaxResponse', 'alert-danger', 'Please Add Lead Followup Time', 2500);
            return false;
        } else {
            if (LeadUID != '' && LeadUID > 0) {

                $("#LeadStatusCallBackButton").html("Please Wait...");
                $("#LeadStatusCallBackButton").removeClass("btn-success");
                $("#LeadStatusCallBackButton").addClass("btn-danger btn-sm");
                $("#LeadStatusCallBackButton").attr("disabled", true);

                var data = $("form#" + parent).serialize();
                if (FormType == 'maturity') {
                    var rslt = AjaxResponse('lead/leads_status_maturity_form_submit', data);
                } else if (FormType == 'closed_clients') {
                    var rslt = AjaxResponse('lead/closed_leads_form_submit', data);
                } else if (FormType == 'followup') {
                    var rslt = AjaxResponse('lead/followup_leads_form_submit', data);
                } else {
                    var rslt = AjaxResponse('lead/leads_status_callback_form_submit', data);
                }
                if (rslt.status == 'success') {

                    GridMessages('LeadsStatusCallBackForm', 'LeadsStatusCallBackAjaxResponse', 'alert-success', rslt.message, 2500);
                    setTimeout(function () {
                        location.reload();
                    }, 3500);

                    $("#LeadStatusCallBackButton").html("Save");
                    $("#LeadStatusCallBackButton").removeClass("btn-danger");
                    $("#LeadStatusCallBackButton").addClass("btn-success btn-sm");
                    $("#LeadStatusCallBackButton").attr("disabled", false);

                } else {
                    GridMessages('LeadsStatusCallBackForm', 'LeadsStatusCallBackAjaxResponse', 'alert-danger', rslt.message, 2500);

                    $("#LeadStatusCallBackButton").html("Save");
                    $("#LeadStatusCallBackButton").removeClass("btn-danger");
                    $("#LeadStatusCallBackButton").addClass("btn-success btn-sm");
                    $("#LeadStatusCallBackButton").attr("disabled", false);
                }

            } else {
                GridMessages('LeadsStatusCallBackForm', 'LeadsStatusCallBackAjaxResponse', 'alert-danger', 'Lead ID Not Found', 2500);
            }
        }
    }
</script>