<?php
$head = 'Upload Visa';
$update_id = 0;
if ($record_id > 0) {
    $head = 'Upload Visa';
    $update_id = $record_id;
    $records = $records['visa_upload_data'][0];
}
$passportNo = isset($records['PassportNumber']) ? $records['PassportNumber'] : "";
$VisaNumber = isset($records['VisaNumber']) ? $records['VisaNumber'] : "";
$MofaNo = isset($records['MOFANumber']) ? $records['MOFANumber'] : "";
$PilgrimID = isset($records['PilgrimID']) ? $records['PilgrimID'] : "";
// print_r($records);
?>


<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?></h5>
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

<form class="validate" enctype="multipart/form-data" method="post" action="#" id="VisaAddForm" name="VisaAddForm">
    <div class="modal-body">
        <input type="hidden" name="MOFANumber" id="MOFANumber" value="<?= $MofaNo ?>">
        <input type="hidden" name="PilgrimID" id="PilgrimID" value="<?= $PilgrimID ?>">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label>Passport No</label><br/>
                    <label><?= $passportNo ?></label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label>MOFA No</label><br/>
                    <label><?= $MofaNo ?></label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="VisaNumber">Visa Number</label>
                    <input type="text" class="form-control validate[required]" id="VisaNumber" name="VisaNumber"
                           placeholder="Visa Number" value="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="VisaIssueDate">Visa Issue Date</label>
                    <input type="date" class="form-control validate[required]" id="VisaIssueDate" name="VisaIssueDate"
                           placeholder="Visa Issue Date" value="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="VisaExpiryDate">Visa Expiry Date</label>
                    <input type="date" class="form-control validate[required]" id="VisaExpiryDate" name="VisaExpiryDate"
                           placeholder="Visa Expiry Date" value="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="VisaType">Type</label>
                    <select class="form-control validate[required]" id="VisaType"
                            name="VisaType">
                        <option value="">Please Select</option>
                        <option value="umrah">Umrah</option>
                        <option value="hajj">Hajj</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group pull-right">
                    <label for="Name">Upload Visa File</label>
                    <input type="file" class="form-control" id="UploadFile"
                           name="UploadFile"
                           placeholder="Upload File">
                </div>
            </div>
            <div class="col-md-12">
                <div class="" id="VisaAddResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <button type="submit" class="btn btn-primary" onclick="VisaUploadFormSubmit();">Save</button>
    </div>
</form>

<script>
    $("form#VisaAddForm").on("submit", function (event) {
        event.preventDefault();
    });

    function VisaUploadFormSubmit() {

        var validate = $("form#VisaAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        var phpdata = new window.FormData($("form#VisaAddForm")[0]);
        response = AjaxUploadResponse("form_process/visa_form_submit", phpdata);
        if (response.status == 'success') {
            $("#VisaAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.href = "<?=base_url('mofa/visa_not_printed')?>";
            }, 2000)
        } else {
            $("#VisaAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }

</script>