<?php

$head = 'Create New ';
$update_id = 0;
$Agent = 0;
$CalenderData = array();
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
    $CalenderData = $records['CalenderData'];
}
?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?> Calender</h5>
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
<form class="validate" method="post" action="#" id="CalenderForm" name="CalenderForm">
    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="<?= $update_id ?>">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="country">Year</label>
                    <input value="<?=$CalenderData['Year']?>" type="number" name="year" id="year" class="form-control validate[required]">
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group mb-4">
                    <label for="country">Title</label>
                    <input placeholder="Title" value="<?=$CalenderData['Title']?>" type="text" name="title" id="title" class="form-control validate[required]">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">Start Date</label>
                    <input type="date" class="form-control validate[required]" id="start_date" name="start_date"
                           placeholder="Start Date" value="<?=$CalenderData['StartDate']?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">End Date</label>
                    <input type="date" class="form-control validate[required]" id="end_date" name="end_date"
                           placeholder="End Date" value="<?=$CalenderData['EndDate']?>">
                </div>
            </div>

            <div class="col-md-12">
                <div class="" id="CalenderResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <button type="button" class="btn btn-primary" onclick="CalenderFormSubmit();">Save</button>
    </div>
</form>

<script>

    $("form#CalenderForm").on("submit", function (event) {
        event.preventDefault();
    });

    function CalenderFormSubmit() {

        var validate = $("form#CalenderForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        var phpdata = $("form#CalenderForm").serialize();
        var response = AjaxResponse("form_process/calender_form_submit", phpdata);

        if (response.status == 'success') {
            $("#CalenderResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.href = "<?=base_url('setting/umrah_calender')?>";
            }, 2000)
        } else {
            $("#CalenderResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }


</script>