<?php

use App\Models\Agents;
use App\Models\Packages;
$session = session();
$session = $session->get();
//echo '<pre>';print_r($session);
$Packages = new Packages();
if ($session['account_type'] == 'external_agent' || $session['account_type'] == 'agent') {
    $Package = $Packages->LoadAgentListPackages();

    $Agent = new Agents();
    $Agents = $Agent->ListSubAgentss($session['agent_id']);

} else {
    $Package = $Packages->LoadListPackages();

//    $ExternalAgentPackages = $Packages->ListPackagesForExternalAgentsWithGeneralPackageToo();
//    $GeneralPackages = $Packages->LisGeneralPackageOnly();

    $Agent = new Agents();
    $Agents = $Agent->ListAgentsExceptExternal();
//    $ExternalAgents = $Agent->ListExternalAgents();

}
$ExternalAgentPackages = $Packages->ListPackagesForExternalAgentsWithGeneralPackageToo();
$GeneralPackages = $Packages->LisGeneralPackageOnly();
$ExternalAgents = $Agent->ListExternalAgents();

$Page = $record_id;
?>


<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"> Package Duplicate Modal </h5>
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
<form class="validate" method="post" action="#" id="PackageCopyAddForm" name="PackageCopyAddForm">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mb-3">
                    <label for="Agent">Package </label>
                    <select class="form-control validate[required]" id="PackageID" name="PackageID">
                        <option value=""> Please Select</option>
                        <?php
                        if ($Page == 'b2b_packages') {
                            foreach ($Package as $P) {
                                echo '<option value="' . $P['UID'] . '">' . $P['Name'] . ' - (' . ucwords(str_replace("_", " ", $P['PackageType'])) . ')</option>
                            ';
                            }
                        } else if ($Page == 'b2b_external_package') {
                            foreach ($GeneralPackages as $GP) {
                                echo '<option value="' . $GP['UID'] . '">' . $GP['Name'] . ' - (' . ucwords(str_replace("_", " ", $GP['PackageType'])) . ')</option>
                            ';
                            }
                            foreach ($ExternalAgentPackages as $P) {
                                echo '<option value="' . $P['UID'] . '">' . $P['Name'] . ' - (' . ucwords(str_replace("_", " ", $P['PackageType'])) . ')</option>
                            ';
                            }
                        } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group mb-3">
                    <label for="Agent">Agent</label>
                    <select class="form-control validate[required]" id="AgentID" name="AgentID">
                        <option value="0"> All Agents</option>
                        <?php
                        if ($Page == 'b2b_packages') {
                            foreach ($Agents as $Agent) {
                                echo '<option value="' . $Agent['UID'] . '">' . $Agent['FullName'] . ' ' . $Agent['LastName'] . '</option>
                            ';
                            }
                        } else if ($Page == 'b2b_external_package') {
                            foreach ($ExternalAgents as $Agent) {
                                echo '<option value="' . $Agent['UID'] . '">' . $Agent['FullName'] . ' ' . $Agent['LastName'] . '</option>
                            ';
                            }
                        } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="" id="PackageDuplicateAddResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <button type="button" class="btn btn-primary" onclick="PackageDuplicateFormSubmit();">Save</button>
    </div>
</form>

<script>
    function PackageDuplicateFormSubmit() {

        var validate = $("form#PackageCopyAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        var phpdata = $("form#PackageCopyAddForm").serialize();
        <?php if ($Page == 'b2b_packages') { ?>
        response = AjaxResponse("form_process/duplicate_package_form_submit", phpdata);
        <?php  } else if ($Page == 'b2b_external_package') { ?>
        response = AjaxResponse("form_process/duplicate_external_agent_package_form_submit", phpdata);
        <?php } ?>

        if (response.status == 'success') {
            $("#PackageDuplicateAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                //location.href = "<?//=base_url('package/b2b_packages')?>//";
                location.reload();
            }, 2000)
        } else {
            $("#PackageDuplicateAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }

</script>