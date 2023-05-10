<?php

use App\Models\Crud;
use App\Models\SaleAgent;

$Crud = new Crud();
$SaleAgents = new SaleAgent();
$head = 'Add New';
$update_id = 0;


$voucher_log = $records['voucher_log'];
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
}
//print_r($voucher_log);
?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Voucher Status</h5>
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
<form enctype="multipart/form-data" class="validate" method="post" action="#" id="VoucherStatusForm"
      name="VoucherStatusForm">
    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="<?= $update_id ?>">


        <div class="row">
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="Email">Status</label>
                    <select class="form-control validate[required]" id="VoucherStatus"
                            name="VoucherStatus" onclick="CheckStatus(this.value)">
                        <option value="Approved">Approved</option>
                        <option value="Reject">Reject</option>

                    </select>
                </div>
            </div>
            <div class="col-md-12 d-none" id="RefundType">
                <div class="form-group mb-4">
                    <label for="FullName">Refund Type</label>
                    <div class="n-chk">
                        <?php
                        $RefundType = array();
                        $RefundType['full_refund'] = "Full Refund";
                        $RefundType['accommodation_refund'] = "Accommodation Refund";
                        $RefundType['transport_refund'] = "Transport Refund";
                        $RefundType['ziayart'] = "Ziyarat Refund";
                        $RefundType['service_refund'] = "Service Refund";
                        ?>
                        <?php
                        foreach ($RefundType as $options => $value) {
//                            $checked = (in_array($options, $Meta)) ? 'checked' : '';
                            echo '<label class="new-control new-checkbox checkbox-primary"><input id="RefundTypes"  type="checkbox"  class="new-control-input" value="' . $options . '" name="RefundTypes[]" ><span class="new-control-indicator"></span>' . $value . '</label>';
                        } ?></div>

                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="Email">Remarks</label>
                    <textarea class="form-control mb-4 validate[required]"
                              id="Remarks" name="Remarks"
                              placeholder="Remarks"></textarea>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="" id="VoucherStatusResponse"></div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
            <button type="button" class="btn btn-primary" onclick="VoucherStatusFormSubmit();">Save</button>
        </div>

    </div>
</form>
<script>

    function CheckStatus(Value) {
        if (Value == "Refund") {
            $("div#RefundType").removeClass("d-none");
        } else {
            $("div#RefundType").addClass("d-none");
        }

    }

    function VoucherStatusFormSubmit() {

        var validate = $("form#VoucherStatusForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        var phpdata = new window.FormData($("form#VoucherStatusForm")[0]);
        response = AjaxUploadResponse("form_process/voucher_status_form_submit", phpdata);

        if (response.status == 'success') {
            $("#VoucherStatusResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.reload();
            }, 2000)
        } else {
            $("#VoucherStatusResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }
</script>
