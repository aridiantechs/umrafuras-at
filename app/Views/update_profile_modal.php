<?php
$head = 'Add New ';
$update_id = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
}

//print_r($records);

?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
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
<form class="validate" method="post" action="#" id="OperatorAddForm" name="OperatorAddForm">
    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="Name">Full Name</label>
                    <input type="text" class="form-control validate[required]" id="FullName" name="FullName" placeholder="Full Name">
                </div>
            </div>
            <div class="col-md-12">
                <div class="" id="Response"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Discard</button>
        <button type="submit" class="btn btn-primary" onclick="">Save</button>
    </div>
</form>
