<?php
$session = session();
$session = $session->get();
$update_id = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;

}

$StaffProjectsData = $records['StaffProjectsData'];
$ProjectsList = $records['ProjectsList'];
$Meta = array();
foreach ($StaffProjectsData as $rec) {
    $Meta[$rec['ProjectID']] = $rec['ThresholdValue'];
}
//print_r($ProjectsList);
//exit;
?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Project Threshold</h5>
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
<form enctype="multipart/form-data" class="validate" method="post" action="#" id="ProjectThresholdForm" name="ProjectThresholdForm">

    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="<?=$update_id?>">
        <div class="row">

            <div class="col-md-12">
                <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                    <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Project Name</th>
                            <th>Allot</th>
                            <th>Threshold Value</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $cnt = 0;
                        $records = array();
                        foreach ($ProjectsList as $Key => $Projects) {
                            if ($Projects == 'home' || $Projects == 'sales') {
                            } else {
                                $cnt++;
                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                    <td>' . ucwords($Projects) . '</td>
                                    <td> 
                                     <select class="form-control" id="ProjectID" name="ProjectID[' . $Projects . ']">
                                                    <option value="0">Select..</option>
                                                    <option ' . (($Meta[$Projects] > 0) ? 'selected' : '') . '  value="' . $Projects . '">Yes</option>
                                                    <option ' . ((!isset($Meta[$Projects])) ? 'selected' : '') . ' value="0">No</option>
                                     </select>
                                 </td>      
                                 <td>
                                   <input type="number" class="form-control validate[required]" id="ThresholdValue" name="ThresholdValue[' . $Projects. ']" placeholder="Threshold Value" min="0" value="' . ((isset($Meta[$Projects]) && $Meta[$Projects] != '') ? $Meta[$Projects] : '0') . '">
                                   </td>                             
                                </tr>';
                            }
                        } ?>
                        </tbody>

                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <div class="" id="ProjectThresholdAddResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <button type="button" class="btn btn-primary" onclick="ProjectThresholdFormSubmit();">Save
        </button>
    </div>
</form>


<script>

    function ProjectThresholdFormSubmit(parent) {
        // var phpdata = new window.FormData($("form#" + parent)[0]);
        // var response = AjaxUploadResponse('form_process/threshold_form_submit', phpdata);


        var phpdata = new window.FormData($("form#ProjectThresholdForm")[0]);
        response = AjaxUploadResponse("form_process/threshold_form_submit", phpdata);
        
        if (response.status == 'success') {
            $("#ProjectThresholdAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.reload();
            }, 2000)
        } else {
            $("#ProjectThresholdAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }

</script>