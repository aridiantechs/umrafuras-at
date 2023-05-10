<?php
use App\Models\Crud;

$Crud = new Crud();
$head = 'Add New ';
$update_id = 0;


if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
    $profile = $records['agent_profile'];
    $filedata = $records['agent_files'];

}
//print_r($records);
?>

<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?> Agent</h5>
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
<form enctype="multipart/form-data" class="validate" method="post" action="#" id="AgentAddForm" name="AgentAddForm">
    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="<?= $update_id ?>">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="full_name">Full Name</label>
                    <input type="text" class="form-control" id="FullName" name="FullName" placeholder="Full Name"
                           value="<?= $profile['FullName'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Address">Contact Person Name</label>
                    <input type="text" class="form-control" id="ContactPersonName" name="ContactPersonName"
                           placeholder="Contact Person Name" value="<?= $profile['ContactPersonName'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Email">Email</label>
                    <input type="email" autocomplete="false" class="form-control validate[required]" id="Email"
                           name="Email" placeholder="Email"
                           value="<?= $profile['Email'] ?>" <?= (($update_id > 0) ? 'readonly' : '') ?>>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="Password">Password</label>
                    <input type="password" class="form-control validate[required]" id="Password" name="Password"
                           aria-describedby="Password" autocomplete="off" readonly
                           onfocus="this.removeAttribute('readonly');"
                           placeholder="Password">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="PhoneNumber">Phone Number</label>
                    <input type="number" class="form-control" id="PhoneNumber" name="PhoneNumber" maxlength="15"
                           aria-describedby="ContactNumber" value="<?= $profile['PhoneNumber'] ?>"
                           placeholder="Phone Number" min="1">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="FaxNumber">Fax Number</label>
                    <input type="number" class="form-control" id="FaxNumber" name="FaxNumber" maxlength="15"
                           aria-describedby="FaxNumber" value="<?= $profile['FaxNumber'] ?>"
                           placeholder="Fax Number" min="1">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="PhoneNumber">Mobile Number</label>
                    <input type="number" class="form-control" id="MobileNumber" name="MobileNumber" maxlength="15"
                           aria-describedby="MobileNumber" value="<?= $profile['MobileNumber'] ?>"
                           placeholder="Mobile Number" min="1">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Email">Country</label>
                    <select class="form-control validate[required]" id="Country"
                            name="Country" onChange="LoadCitiesDropdown(this.value)">
                        <option value="">Please Select</option>
                        <?= Countries('html', $profile['CountryID']) ?>
                    </select></div>
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
                           value="<?= $profile['Address'] ?>">
                </div>
            </div>
            <div class="col-md-12">
                <h6> Attachments </h6>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="AttachR" name="AttachR">
                <div class="row" id="AttachRows" name="AttachRows">
                    <div class="col-md-5">
                        <div class="form-group mb-4">
                            <label for="Address">File Description</label>
                            <input type="text" class="form-control" id="Address" name="FileDescription[]" placeholder="File Description"
                                   >
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group mb-4">
                            <label for="Address">Attach File</label>
                            <input type="file" class="form-control" id="AttachFiles" name="AttachFiles[]"
                                   placeholder="Contact Person Name">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-4">
                            <label for="Address">Actions</label>
                            <div class="col-md-12" style="margin-bottom: 20px;">
                                <a name="rowremoveButton" href="javascript:void(0);" id="rowremoveButton"><span><i
                                                class="fa fa-trash" title="Remove"></i></span></a>
                                <a href="javascript:void(0);" id="AddFlightRows" style="margin-right: 10px;"
                                   onclick="AddNewAttachmentRow();"><span><i class="fa fa-plus" title="Add More"></i></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <div class="" id="AgentAddResponse"></div>
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

        var validate = $("form#AgentAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        var phpdata = new window.FormData($("form#AgentAddForm")[0]);
        response = AjaxUploadResponse("form_process/agent_form_submit", phpdata);

        if (response.status == 'success') {
            $("#AgentAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.href = "<?=base_url('agent/index')?>";
            }, 2000)
        } else {
            $("#AgentAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }

    function LoadCitiesDropdown(country) {
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country + "&selected=<?=$profile['CityID']?>");
        $("#City").html('<option value="">Please Select</option>' + cities.html);

    }


    function AddNewAttachmentRow() {
        var itm = document.getElementById("AttachRows");
        var cln = itm.cloneNode(true);
        document.getElementById("AttachR").appendChild(cln);
    }

    $('[name=rowremoveButton]').click(function () {
        cnt = $('#AttachR #AttachRows').length;
        if (cnt > 1)
            $('#AttachR #AttachRows').slice(-1).remove();

    });
    setTimeout(function () {
        LoadCitiesDropdown('<?=$profile['CountryID']?>');
    }, 1000)

</script>