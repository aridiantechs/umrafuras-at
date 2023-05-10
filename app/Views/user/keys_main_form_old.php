<?php


$update_id = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
    $profile = $records['user_profile'];
    $profileType = $profile['UserType'];

}

?>


<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">User Access Level Keys User Id = ( <?=$update_id." ".$profileType?> ) </h5>
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
<form class="validate" method="post" action="#" id="UserKeysForm" name="UserKeysForm">
    <div class="modal-body">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Name">Full Name</label>
                    <input type="text" class="form-control validate[required]" id="FullName" name="FullName"
                           placeholder="Full Name" value="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Name">Contact Number</label>
                    <input type="text" class="form-control" id="ContactNumber" name="ContactNumber"
                           placeholder="Contact Number" maxlength="16" value="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Operator">Email</label>
                    <input type="email" class="form-control validate[required]" id="Email" name="Email"
                           placeholder="Email"
                           value="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="Age">Password</label>
                    <input type="password" class="form-control "
                           id="Password" name="Password"
                           aria-describedby="Password" autocomplete="off" readonly
                           onfocus="this.removeAttribute('readonly');"
                           placeholder="Password" value="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="Position">Designation</label>
                    <input type="text" class="form-control" id="Designation" name="Designation"
                           placeholder="Designation" value="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="country">User Type </label>
                    <select class="form-control validate[required]" id="UserType"
                            name="UserType" >
                        <option value="">Please Select</option>

                    </select>
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
        <button type="button" class="btn btn-primary" >Save</button>
    </div>
</form>
<script>





</script>