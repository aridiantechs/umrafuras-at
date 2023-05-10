<?php

use App\Models\Crud;
use App\Models\SaleAgent;

$Crud = new Crud();
$update_id = 0;
$remarks = $records['voucher_remarks'];
$PilgrimDetail = $records['PilgrimDetails'];
$PilgrimDetails = $PilgrimDetail[0];
//print_r($PilgrimDetails);

$voucher_remarks = $remarks[0];
$UID = $records['UID'];
//print_r($voucher_remarks);


?>

<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"> Voucher Remarks</h5>
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
<div class="modal-body" style="padding: 15px 15px;">
    <form enctype="multipart/form-data" class="validate" method="post" action="#" id="RemarksForm" name="RemarksForm">
        <div class="row">
            <div class="col-md-12">
                <h6> Pilgrim Detail </h6>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <br>
                            <span><?=$PilgrimDetails['FirstName']?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="full_name">Email</label>
                            <br>
                            <span><?=$PilgrimDetails['Email']?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="full_name">Passport Number</label>
                            <br>
                            <span><?=$PilgrimDetails['PassportNumber']?></span>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="full_name">Nationality</label>
                            <br>
                            <span><?=$PilgrimDetails['Nationality']?></span>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="full_name">MOI Number</label>
                            <br>
                            <span><?=$PilgrimDetails['MOINumber']?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="full_name">Visa Number</label>
                            <br>
                            <span><?=$PilgrimDetails['VisaNo']?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <hr>
                <div class="form-group">
                    <label for="full_name">Remarks</label>
                    <textarea class="form-control  validate[required]" id="Remarks"
                              name="Remarks"> <?= $voucher_remarks['Value'] ?>
                    </textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="" id="VoucherRemarksResponse"></div>
            </div>
        </div>
    </form>
</div>

<div class="modal-footer">
    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
    <button type="button" class="btn btn-primary" onclick="VoucherRemarksFormSubmit();">Save
    </button>
</div>

<script>

    function VoucherRemarksFormSubmit() {

        var validate = $("form#RemarksForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        var phpdata = new window.FormData($("form#RemarksForm")[0]);
        response = AjaxUploadResponse("form_process/voucher_remarks_form_submit", phpdata);

        if (response.status == 'success') {
            $("#VoucherRemarksResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.reload();
            }, 2000)
        } else {
            $("#VoucherRemarksResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }
</script>