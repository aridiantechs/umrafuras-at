<?php
use App\Models\Crud;

$Lookup = explode(":", $record_id);
$lookups_key = $Lookup[0];
$record_id = $Lookup[1];

$Crud = new Crud();
$table = 'main."Lookups"';
$where = array("UID" => $lookups_key);
$lookup = $Crud->SingleRecord($table, $where);

$head = 'Add '.$lookup['Name']." ";
$update_id = 0;
if ($record_id > 0) {
    $update_id = $record_id;
    $dataa = $records['lookups_option_data'];
    $head = 'Update '.$lookup['Name']." ";
}
?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?> Option</h5>
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
<form class="validate" method="post" action="#" id="LookupOptionAddForm" name="LookupOptionAddForm">
    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="<?= $update_id ?>">
        <input type="hidden" name="idd" id="idd" value="<?=$lookups_key?>">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mb-3">
                    <label for="Agent">Name</label>
                    <input type="text" class="form-control validate[required]" id="Name" name="Name"
                           placeholder="Name" value="<?= $dataa['Name'] ?>">
                </div>
            </div>
            <div class="col-md-6 hide d-none">
                <div class="form-group mb-4">
                    <label for="Description">Order No</label>
                    <input type="number" class="form-control validate[required]" id="OrderID" name="OrderID"
                           placeholder="Order No" min="0" value="0">
                    <?//= $dataa['OrderID'] ?>
                </div>
            </div>
<!--            <div class="col-md-12">-->
<!--                <div class="form-group mb-4">-->
<!--                    <label for="Description">Description</label>-->
<!--                    <textarea class="form-control" id="Description" name="Description"></textarea>-->
<!--                </div>-->
<!--            </div>-->
            <div class="col-md-12">
                <div class="" id="LookupOptionsAddResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <button type="button" class="btn btn-primary" onclick="LookupOptionsFormSubmit();">Save</button>
    </div>
</form>

<script>

    $("form#LookupOptionAddForm").on("submit", function (event) {
        event.preventDefault();
    });

    function LookupOptionsFormSubmit() {

        var validate = $("form#LookupOptionAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        var phpdata = $("form#LookupOptionAddForm").serialize();
        response = AjaxResponse("form_process/lookup_options_form_submit", phpdata);

        if (response.status == 'success') {
            $("#LookupOptionsAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                 location.reload();
            }, 2000)
        } else {
            $("#LookupOptionsAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }
</script>