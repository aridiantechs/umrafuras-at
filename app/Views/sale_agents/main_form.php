<?php

use App\Models\Crud;

$Crud = new Crud();
$head = 'Add New ';
$update_id = 0;

if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
    $profile = $records['agent_profile'];


}
//print_r($filedata);
?>

<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?> Sale Agent</h5>
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
<form enctype="multipart/form-data" class="validate" method="post" action="#" id="SaleAgentAddForm" name="SaleAgentAddForm">
    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="<?= $update_id ?>">
        <input type="hidden" name="DomainID" id="DomainID" value="<?= $GetDomainID ?>">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="full_name">Full Name</label>
                    <input type="text" class="form-control  validate[required]" id="FullName" name="FullName" placeholder="Full Name"
                           value="<?=$profile['FullName']?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="PhoneNumber">Phone Number</label>
                    <input type="number" class="form-control  validate[required]" id="PhoneNumber" name="PhoneNumber" maxlength="15"
                           aria-describedby="ContactNumber" value="<?=$profile['PhoneNumber']?>"
                           placeholder="Phone Number" min="1">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="full_name">Emergency Contact Name</label>
                    <input type="text" class="form-control  validate[required]" id="EmergencyContactName" name="EmergencyContactName" placeholder="Emergency Contact Name"
                           value="<?=$profile['EmergencyContactName']?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="PhoneNumber">Emergency Contact #</label>
                    <input type="number" class="form-control  validate[required]" id="EmergencyContactNumber" name="EmergencyContactNumber" maxlength="15"
                           aria-describedby="EmergencyContactNumber" value="<?=$profile['EmergencyContactNumber']?>"
                           placeholder="Emergency Contact Number" min="1">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Email">Email</label>
                    <input type="email" autocomplete="false" class="form-control validate[required]" id="Email"
                           name="Email" placeholder="Email"
                           value="<?=$profile['Email']?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="Password">Password</label>
                    <input type="password" class="form-control validate[required]" id="Password" name="Password"
                           aria-describedby="Password" autocomplete="off" readonly
                           onfocus="this.removeAttribute('readonly');"
                           placeholder="Password" value="<?=$profile['Password']?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Email">Country</label>
                    <select class="form-control validate[required]" id="Country"
                            name="Country" onChange="LoadCitiesDropdown(this.value)">
                        <option value="">Please Select</option>
                        <?= Countries('html', $profile['Country']) ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="Password">City</label>
                    <select class="form-control" id="City"
                            name="City">
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="Address">Address</label>
                    <input type="text" class="form-control" id="Address" name="Address" placeholder="Address"
                           value="<?=$profile['Address']?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="" id="SaleAgentAddResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <button type="button" class="btn btn-primary" onclick="AgentFormSubmit();">Save</button>
    </div>
</form>

<script>

    function AgentFormSubmit() {

        var validate = $("form#SaleAgentAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        var phpdata = new window.FormData($("form#SaleAgentAddForm")[0]);
        response = AjaxUploadResponse("form_process/sale_agent_form_submit", phpdata);

        if (response.status == 'success') {
            $("#SaleAgentAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.reload();
            }, 2000)
        } else {
            $("#SaleAgentAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }

    function LoadCitiesDropdown(country) {
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country + "&selected=<?=$profile['City']?>");
        $("#City").html('<option value="">Please Select</option>' + cities.html);

    }

    setTimeout(function () {
        LoadCitiesDropdown('<?=$profile['Country']?>');
    }, 1000)
</script>