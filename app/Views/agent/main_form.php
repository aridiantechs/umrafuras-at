<?php

use App\Models\Crud;
use App\Models\SaleAgent;

$Crud = new Crud();
$SaleAgents = new SaleAgent();
$head = 'Add New';
$update_id = 0;

$sales = array();
$SaleAgentsMeta = $SaleAgents->SaleAgentsMeta();
foreach ($SaleAgentsMeta as $saleAgent) {
    $sales[$saleAgent['Value']] = $saleAgent['SaleAgentID'];
}
//print_r($sales);

$SaleAgents = $records['SaleAgents'];
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
    $profile = $records['agent_profile'];
    $filedata = $records['agent_files'];

}
//print_r($filedata);
$host = str_replace("panel.", "", $_SERVER['HTTP_HOST']);
if ($host == "localhost") {
    $DomainID = 0;
} else {
    $table = 'websites."Domains"';
    $where = array("Name" => $host);
    $Domain = $Crud->SingleRecord($table, $where);
    $DomainID = $Domain['UID'];
} ?>

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
        <input type="hidden" id="AttachmentCount" name="AttachmentCount" value="0">
        <input type="hidden" id="Type" name="Type" value="agent">

        <div class="row">
            <div class="col-md-<?= (($session['domain_parent'] > 0) ? '3' : '4') ?>">
                <div class="form-group mb-4">
                    <label for="full_name">First Name</label>
                    <input type="text" class="form-control  validate[required]" id="FullName" name="FullName"
                           placeholder="First Name"
                           value="<?= $profile['FullName'] ?>">
                </div>
            </div>
            <div class="col-md-<?= (($session['domain_parent'] > 0) ? '3' : '4') ?>">
                <div class="form-group mb-4">
                    <label for="full_name">Last Name</label>
                    <input type="text" class="form-control  validate[required]" id="LastName" name="LastName"
                           placeholder="Last Name"
                           value="<?= $profile['LastName'] ?>">
                </div>
            </div>
            <div class="col-md-<?= (($session['domain_parent'] > 0) ? '3' : '4') ?>">
                <div class="form-group mb-4">
                    <label for="Address">Contact Person Name</label>
                    <input type="text" class="form-control " id="ContactPersonName" name="ContactPersonName"
                           placeholder="Contact Person Name" value="<?= $profile['ContactPersonName'] ?>">
                </div>
            </div>
            <?php
            if ($session['domain_parent'] > 0) { ?>
                <div class="col-md-3">
                <div class="form-group mb-4">
                    <label for="Address">Websites</label>
                    <select class="form-control validate[required]" id="WebsiteID" name="WebsiteID">
                        <?php
                        foreach ($Domains as $Domain) {
                            $selected = (($profile['WebsiteDomain'] == $Domain['UID']) ? 'selected' : '');
                            echo '<option value="' . $Domain['UID'] . '"' . $selected . '>' . $Domain['FullName'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                </div><?php
            } else {
                echo '<input type="hidden" class="form-control" id="WebsiteID" name="WebsiteID"  value="' . $DomainID . '">';
            }
            ?>
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
                           placeholder="Password" value="<?= $profile['Password'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="PhoneNumber">Phone Number</label>
                    <input type="number" class="form-control  validate[required]" id="PhoneNumber" name="PhoneNumber"
                           maxlength="15"
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
            <div class="col-md-<?= (($session['domain_parent'] > 0) ? '6' : '4') ?>">
                <div class="form-group mb-4">
                    <label for="Email">Country</label>
                    <select class="form-control validate[required]" id="Country"
                            name="Country" onChange="LoadCitiesDropdown(this.value)">
                        <option value="">Please Select</option>
                        <?= Countries('html', $profile['CountryID']) ?>
                    </select>
                </div>
            </div>
            <div class="col-md-<?= (($session['domain_parent'] > 0) ? '6' : '4') ?>">
                <div class="form-group mb-3">
                    <label for="Password">City</label>
                    <select class="form-control" id="City"
                            name="City">
                    </select>
                </div>
            </div>
            <div class="col-md-4 <?= (($session['domain_parent'] > 0) ? 'd-none' : '') ?>">
                <div class="form-group mb-3">
                    <label for="Domain">Domain</label>
                    <input type="text" class="form-control "
                           id="Domain"
                           name="Domain" placeholder="Domain">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Address">Sales Agent</label>
                    <select class="form-control" id="SalesAgent"
                            name="SalesAgent">
                        <?php
                        foreach ($SaleAgents as $SaleAgent) {
                            $selected = (($sales[$profile['UID']] == $SaleAgent['UID']) ? 'selected' : '');
                            echo ' <option value="' . $SaleAgent['UID'] . '"' . $selected . '>' . $SaleAgent['FullName'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="AgentLogo">Logo</label>
                    <input type="file"
                           class="form-control <?= (isset($profile['UID']) ? '' : 'validatexx[required]') ?>"
                           id="AgentLogo"
                           name="AgentLogo" placeholder="AgentLogo">
                </div>
                <div class="image <?= (($profile['Logo'] > 0) ? '' : 'd-none') ?>">
                    <?php
                    if (isset($profile['Logo'])) {
                        echo '<div class="grid-img float-right" style="background-image: url(\'' . $path . "home/load_file/" . $profile['Logo'] . '\');">
                        <a class="" href="javascript:void(0)" onclick="DeleteAgentLogo(' . $profile['Logo'] . ');" ><i class="fas fa-window-close"></i></a></div>';
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="Address">IATA License</label>
                    <select class="form-control validate[required]" id="IATALicense"
                            name="IATALicense">


                        <option value="">Kindly Select</option>
                        <option value="Yes" <?= (($profile['IATALicense'] == 'Yes') ? 'selected' : '') ?> >Yes</option>
                        <option value="No" <?= (($profile['IATALicense'] == 'No') ? 'selected' : '') ?> >No</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="Address">Umrah Agreement</label>
                    <select class="form-control validate[required]" id="UmrahAgreement"
                            name="UmrahAgreement">
                        <option value="">Kindly Select</option>
                        <option value="Yes" <?= (($profile['UmrahAgreement'] == 'Yes') ? 'selected' : '') ?> >Yes
                        </option>
                        <option value="No" <?= (($profile['UmrahAgreement'] == 'No') ? 'selected' : '') ?> >No</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="Address">Status</label>
                    <select class="form-control validate[required]" id="Status"
                            name="Status">
                        <option value="">Kindly Select</option>
                        <option value="Active" <?= (($profile['Status'] == 'Active') ? 'selected' : '') ?> >Active
                        </option>
                        <option value="InActive" <?= (($profile['Status'] == 'InActive') ? 'selected' : '') ?> >In
                            Active
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="Address">Address</label>
                    <textarea class="form-control" id="Address" name="Address" placeholder="Address"
                    ><?= $profile['Address'] ?></textarea>
                </div>
            </div>

            <div class="col-md-12">
                <h6> Attachments <a href="javascript:void(0);" id="AddFlightRows" style="margin-right: 10px;"
                                    onclick="AddNewAttachmentRow();"><span><i class="fa fa-plus float-right"
                                                                              title="Add More"></i></span></a></h6>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="AttachR" name="AttachR">
                <div class="row" id="AttachRows" name="AttachRows">
                    <div class="col-md-5">
                        <div class="form-group mb-4">
                            <label for="Address">File Description</label>
                            <input type="text"
                                   class="form-control <?= (($update_id > 0) ? '' : 'validatexxx[required]') ?>"
                                   id="Address" name="FileDescription[]"
                                   placeholder="File Description"
                            >
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group mb-4">
                            <label for="Address">Attach File</label>
                            <input type="file"
                                   class="form-control <?= (($update_id > 0) ? '' : 'validatexxxx[required]') ?>"
                                   id="AttachFiles" name="AttachFiles[]"
                                   placeholder="Contact Person Name">
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($update_id > 0) { ?>
                <div class="col-md-12">
                    <h6> Uploaded Attachments </h6>
                    <hr>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>File Description</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (count($filedata) > 0) {
                            $cnt = 0;
                            foreach ($filedata as $files) {
                                $cnt++;
                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                    <td>' . $files['FileDescription'] . '</td>
                                    <td class="text-center">
                                       <a href="' . $path . 'home/load_file/' . $files['FileID'] . '" target="_blank" data-toggle="tooltip" data-placement="top" title="Download"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></a>
                                       <a onclick="DeleteAgentAttachments(' . $files['UID'] . ');" href="" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
                                    </td>
                                </tr>';
                            }
                        } else {
                            echo '<tr> <td colspan="3" style="text-align: center; color: #dda420">No Attachment Found</td></tr>';
                        } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="" id="AgentAddResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <?php if ($session['domain_parent'] > 0) { ?>
            <button type="button" class="btn btn-primary "
                    onclick="AgentFormSubmit();">Save
            </button>
        <?php } else { ?>
            <button type="button" class="btn btn-primary"
                    onclick="IsvalidDomain();">Save
            </button>

        <?php } ?>
    </div>
</form>

<script>
    function IsvalidDomain() {
        var domainName = $("#Domain").val();
            var pattern = new RegExp('^(http?:\\/\\/)?' +
                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' +
                '((\\d{1,3}\\.){3}\\d{1,3}))' +
                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' +
                '(\\?[;&a-z\\d%_.~+=-]*)?' +
                '(\\#[-a-z\\d_]*)?$', 'i');
            var result = pattern.test(domainName);
            if (result == true || domainName == '') {
                AgentFormSubmit();
            } else {
                $("#AgentAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> Incorrect Domain..!</div>')
            }

    }

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
                location.reload();
                //location.href = "<?//=$path?>//setting/access_levels/" + response.record_id;
            }, 2000)
        } else {
            $("#AgentAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }

    function DeleteAgentAttachments(UID) {
        if (confirm("Are You Want To Remove Attachments")) {
            response = AjaxResponse("form_process/remove_agent_attachments", "UID=" + UID);
            if (response.status == 'success') {
                location.reload();
            }
        }
    }

    function LoadCitiesDropdown(country) {
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country + "&selected=<?=$profile['CityID']?>");
        $("#City").html('<option value="">Please Select</option>' + cities.html);

    }


    function DeleteAgentLogo(UID) {
        if (confirm("Are You Want To Remove This Logo")) {
            response = AjaxResponse("form_process/remove_agent_logo", "UID=" + UID);
            if (response.status == 'success') {
                location.reload();
            }
        }
    }


    function AddNewAttachmentRow() {
        AttachmentCount = parseInt($("#AttachmentCount").val());

        HTML = AttachmentFormHTML(AttachmentCount);
        $("#AttachR").append(HTML);
        $("#AttachmentCount").val(AttachmentCount + 1);

        return false;
    }

    function AttachmentFormHTML(cnt) {
        cnt = cnt + 1;
        var html;

        html = '<div class="row" id="AttachmentCount' + cnt + '" name="AttachmentCount">\n' +
            '                    <div class="col-md-5"> <div class="form-group mb-4"><label for="Address">File Description</label>\n' +
            '                            <input type="text" class="form-control" id="Address" name="FileDescription[]" placeholder="File Description" ></div>\n' +
            '                    </div>\n' +
            '                    <div class="col-md-5">\n' +
            '                        <div class="form-group mb-4"><label for="Address">Attach File</label><input type="file" class="form-control" id="AttachFiles" name="AttachFiles[]" placeholder="Contact Person Name"> </div>\n' +
            '                    </div>\n' +
            '                    <div class="col-md-2"> <div class="form-group mb-4"> <div class="col-md-12" style="margin-top: 45px;">\n' +
            '                                <a name="rowremoveButton" href="javascript:void(0);" id="rowremoveButton"><span><i class="fa fa-trash" title="Remove" onClick="RemoveAttachmentRow(' + cnt + ')"></i></span></a>\n' +
            '                            </div></div></div></div> ';
        return html;
    }

    function RemoveAttachmentRow(cnt) {
        AttachmentCount = parseInt($("#AttachmentCount").val());
        $('#AttachmentCount' + cnt).remove();
        $("#AttachmentCount").val(AttachmentCount - 1);
    }

    setTimeout(function () {
        <?php
        if ($profile['CountryID'] != '') {
            echo 'LoadCitiesDropdown("' . $profile['CountryID'] . '");';
        }?>
    }, 1000)

</script>