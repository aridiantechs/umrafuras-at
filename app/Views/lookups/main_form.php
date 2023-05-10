<?php
$head = 'Add New ';
$update_id = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
    $data = $records['lookups_data'];

}
?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?> Lookup</h5>
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
<form class="validate" method="post" action="#" id="LookupAddForm" name="LookupAddForm">
    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="<?= $update_id ?>">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">Key</label>
                    <input type="text" class="form-control validate[required]" id="Key" name="Key"
                           placeholder="Key" value="<?= $data['Key'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="Agent">Name</label>
                    <input type="text" class="form-control validate[required]" id="Name" name="Name"
                           placeholder="Name" value="<?= $data['Name'] ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="Description">Description</label>
                    <textarea class="form-control" id="Description" name="Description"><?= $data['Description'] ?></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="" id="LookupAddResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <button type="button" class="btn btn-primary" onclick="LookupFormSubmit();">Save</button>
    </div>
</form>
<!---->
<!---->
<!--<script>-->
<!---->
<!--    $("form#LookupAddForm").on("submit", function (event) {-->
<!--        event.preventDefault();-->
<!--    });-->
<!---->
<!--    function LookupFormSubmit() {-->
<!---->
<!--        var validate = $("form#LookupAddForm").validationEngine('validate');-->
<!--        if (validate == false) {-->
<!--            return false;-->
<!--        }-->
<!--        var phpdata = $("form#LookupAddForm").serialize();-->
<!--        response = AjaxResponse("form_process/lookup_form_submit", phpdata);-->
<!---->
<!--        if (response.status == 'success') {-->
<!--            $("#LookupAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')-->
<!--            setTimeout(function () {-->
<!--                location.href = "--><?//=base_url('setting/lookups')?>//";
//            }, 2000)
//        } else {
//            $("#LookupAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
//        }
//
//    }
//</script>