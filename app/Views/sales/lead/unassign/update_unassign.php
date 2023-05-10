<?php
$session = session();
$session = $session->get();
$update_id = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
}


//print_r($finalMeta);

?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Update <?=$update_id?> Lead</h5>
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
<form class="validate" method="post" action="#" id="UpdateLeadForm" name="UpdateLeadForm">
    <div class="modal-body pt-0">
        <input type="hidden" name="UID" id="UID" value="<?=$update_id?>">
        <input type="hidden" name="DomainID" id="DomainID" value="#">
        <input type="hidden" name="ParentID" id="ParentID" value="#">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Full Name </label>
                        <input type="text" name="full_name" value="" placeholder="Full Name" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Contact </label>
                        <input type="text" name="contact" value="" placeholder="Contact Number" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>WhatsApp </label>
                        <input type="text" name="whatsapp" value="" placeholder="WhatsApp Number" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>Email </label>
                        <input type="email" name="email" value="" placeholder="email@gmail.com" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="File">Personal </label>
                        <select class="form-control " id=""
                                name="">
                            <option value="">Select</option>
                            <option value="">Yes</option>
                            <option value="">No</option>

                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="File">Lead Status </label>
                        <select class="form-control "
                                name="">
                            <option value="">Follow Up</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="File">BDOs </label>
                        <select class="form-control "
                                name="">
                            <option value="">please Select</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="File">Interest Level </label>
                        <select class="form-control "
                                name="">
                            <option value="">please Select</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="File">Create Date </label>
                        <input type="date" placeholder="" name="create_date" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="File">Source </label>
                        <select class="form-control "
                                name="">
                            <option value="">please Select</option>
                            <option value="">Facebook</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="File">Product </label>
                        <select class="form-control "
                                name="">
                            <option value="">please Select</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label >Call Back Date </label><br>
                        <input type="date" placeholder="" name="call_back_date" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="File">Call Back Time </label><br>
                        <input type="time" placeholder="" name="call_back_time" class="form-control">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="" id="UserAddResponse"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Discard</button>
        <button type="button" class="btn btn-primary" onclick="UserFormSubmit();">Save</button>
    </div>
</form>
<script>


    function UserFormSubmit() {

        var validate = $("form#UserAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        var phpdata = $("form#UserAddForm").serialize();
        response = AjaxResponse("form_process/user_form_submit", phpdata);
        if (response.status == 'success') {
            $("#UserAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')

            if (response.user_insert_id == undefined && response.user_type == undefined) {
                setTimeout(function () {
                    location.reload();
                }, 2000)
            } else {
                setTimeout(function () {
                    window.location.href = '<?= $path; ?>setting/access_levels/' + response.user_insert_id + '?type=' + response.user_type + '';
                }, 2000)
            }

        } else {
            $("#UserAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }


</script>