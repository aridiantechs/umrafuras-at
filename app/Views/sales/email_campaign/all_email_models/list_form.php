
<?php
$session = session();
$session = $session->get();
$head = 'Add  ';
$update_id = 0;
if ($record_id > 0) {
$head = 'Update ';
$update_id = $record_id;
$profile = $records['email_list_records'];




}
?>


<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?=$head?> List </h5>
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
<form class="validate" method="post" action="#" id="Emailisting" name="EmailListing">
    <div class="modal-body">
        <div class="row">
            <input type="hidden" value="<?=$update_id?>" name="UID">
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="Name"> List Name</label>
                    <input type="text" class="form-control validate[required]" id="listname" name="listname"
                           placeholder="List Name" value="<?=$profile['FullName']?>">
                </div>
            </div>
            <?php if ($update_id == 0) {
                $class = '';
            } else {
                $class = 'd-none';
            } ?>
            <div class="col-md-12 <?=$class?>">
                <div class="form-group mb-4">
                    <label for="createDate">Create Date </label>
                    <input type="date" class="form-control validate[required] " id="createDate" name="createDate"
                           value="<?php if($update_id == 0){  echo date('Y-m-d'); } else {  echo $profile['CreatedAt'];  } ?>">
                </div>
            </div>

            <div class="col-md-12">
                <div class="" id="Status"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Discard</button>
        <button type="button" class="btn btn-primary" onclick="EmailListingFormSubmit();">Save</button>
    </div>
</form>

<script>

    function EmailListingFormSubmit() {

        var validate = $("form#Emailisting").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        var data = $("form#Emailisting").serialize();
        response = AjaxResponse("emailcampaign/save_email_list_record", data);

        if (response.status == 'success') {
            $("#Status").html('<div class="text-center alert alert-success mb-4" role="alert">  <strong>Success!</strong> ' + response.message + ' </div>')
            $("form#Emailisting").trigger("reset");
            location.reload();
        } else if (response.status == 'Duplicate List') {
            $("#Status").html('<div class="text-center alert alert-danger mb-4" role="alert">  <strong>!</strong> ' + response.message + ' </div>')
        }

    }


</script>