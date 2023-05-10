<?php
$session = session();
$session = $session->get();
$head = 'Add New ';

$profile = $records['Users_record'];

$update_id = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
}
?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?>Sale Officer</h5>
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
<form class="validate" method="post" action="#" id="UserAddForm" name="UserAddForm">
    <div class="modal-body">
        <div class="row">
            <input type="hidden" name="UserType" id="UserType" value="sale-officer">
            <input type="hidden" name="DomainID" id="DomainID" value="<?= $GetDomainID ?>">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Name">Full Name</label>
                    <input type="text" class="form-control validate[required]" id="FullName" name="FullName"
                           placeholder="Full Name" value="<?= $profile['FullName'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Name">Contact Number</label>
                    <input type="text" class="form-control validate[required]" id="ContactNumber" name="ContactNumber"
                           placeholder="Contact Number" maxlength="16" value="<?= $profile['ContactNumber'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Operator">Email</label>
                    <input type="email" class="form-control validate[required,custom[email]]" id="Email" name="Email"
                           placeholder="Email"
                           value="<?= $profile['Email'] ?>" <?= (($update_id > 0) ? 'readonly' : '') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="Age">Password</label>
                    <input type="password" class="form-control <?= (($update_id > 0) ? '' : 'validate[required]') ?>"
                           id="Password" name="Password"
                           aria-describedby="Password" autocomplete="off" readonly
                           onfocus="this.removeAttribute('readonly');"
                           placeholder="Password" value="<?= $profile['Password'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="Position">Designation</label>
                    <input type="text" class="form-control validate[required]" id="Designation" name="Designation"
                           placeholder="Designation" value="<?= $profile['Designation'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="country">User</label>
                    <select class="form-control" id="ParentID" name="ParentID">
                        <?php
                        foreach ($profile as $record1K => $record1V) {
                            echo '<option value="' . $record1V['UID'] . '">' . $record1V['FullName'] . '</option>';

                        }
                        ?></select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group mb-4" id="statuses">

                </div>
            </div>
            <div class="col-md-12">
                <div class="" id="UserAddResponse"></div>
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