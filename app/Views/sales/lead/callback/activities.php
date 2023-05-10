<?php

use App\Models\Crud;
use App\Models\LeadModel;

$Crud = new Crud();
$Lead = new LeadModel();
$LeadAgent = '-';
if ($record['UserID'] > 0) {
    $AgentData = $Crud->SingleRecord('main."Users"', array('UID' => $record['UserID']));
    $LeadAgent = ((isset($AgentData['FullName']) && $AgentData['FullName'] != '') ? $AgentData['FullName'] : '-');
}
$SubmittedPropertyTags = $Crud->ListRecords('sales."LeadsMeta"', array('LeadID' => $record['UID'], 'Options' => 'tags'));
$finalTagsMeta = array();
foreach ($SubmittedPropertyTags as $Tag) {
    $finalTagsMeta[] = $Tag['Value'];
}
$AllLeadsActivities = $Lead->GetAllLeadActivities($record['UID']);
$LeadReassignLog = $Lead->GetLeadReassignLog($record['UID']);

$LeadsMetaArray = array('MobileNumber1' => 'Mobile No 1', 'CompanyAgentName' => 'Company Agent',
                            'Phone1' => 'Phone 1', 'Phone2' => 'Phone 2', 'City' => 'City');
$LeadsMetaData = $Lead->GetAllLeadsMetaWithOutTags($record['UID']);
?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <input type="hidden" class="form-control" id="ID" name="ID" value="1">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing details-table">
                <div class="widget-content widget-content-area br-6">
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <?= ucwords($record['FullName']); ?>
                                <badge class="badge badge-success badge-mini"><?= ucwords($record['LeadCategory']) ?></badge>
                                <a onclick="LoadModal('sales/lead/unassign/add_lead', <?=$record['UID']?> , 'modal-lg' )"
                                   style="float: right; font-size: 10px; color: white !important; font-weight: bold;" class="btn btn-success btn-sm">Update Lead</a>
                                <badge style="float: right; font-size: 15px;"
                                       class="badge badge-success badge-mini"><?= ((isset($record['Status']) && $record['Status'] != '') ? ucwords(str_replace("_", ' ', $record['Status'])) : '-') ?></badge>

                            </h4>
                            <p><b>Created At:</b> <?= date("d M, Y h:i A", strtotime($record['CreatedAt'])) ?></p>
                        </div>
                    </div>
                    <hr style="margin-top: 0px !important;">
                    <div class="row pt-2 pb-2">
                        <div class="col-3"><b>Leads code: <?= Code('UF/L/', $record['UID']) ?></b></div>
                        <div class="col-3"><b>Contact
                                No:</b> <?= ((isset($record['ContactNo']) && $record['ContactNo'] != '') ? '<a target="_blank" href="'.WhatsAppUrl($record['ContactNo']).'">'.$record['ContactNo'].'</a>' : '-') ?>
                        </div>
                        <div class="col-3"><b>Whatsapp
                                No: </b> <?= ((isset($record['WhatsAppNo']) && $record['WhatsAppNo'] != '') ? '<a target="_blank" href="'.WhatsAppUrl($record['WhatsAppNo']).'">'.$record['WhatsAppNo'].'</a>' : '-') ?>
                        </div>
                        <div class="col-3">
                            <b>Agent: </b> <?= $LeadAgent ?>
                        </div>

                    </div>
                    <div class="row pt-2 pb-2">
                        <div class="col-3">
                            <b>Email: </b><?= ((isset($record['Email']) && $record['Email'] != '') ? $record['Email'] : '-') ?>
                        </div>
                        <div class="col-3">
                            <b>Product: </b> <?= ((isset($record['ProductID']) && $record['ProductID'] != '') ? ucwords($record['ProductID']) : '-') ?>
                        </div>
                        <div class="col-3"><b>Organic:</b> -</div>
                    </div>
                    <div class="row">
                        <?php
                        foreach ($LeadsMetaArray as $Key => $Value) {
                            if (isset($LeadsMetaData[$Key])) {
                                echo '<div class="col-3 pt-2 pb-2"><b>' . $Value . ':</b> ' . $LeadsMetaData[$Key] . '</div>';
                            } else {
                                echo '<div class="col-3 pt-2 pb-2"><b>' . $Value . ':</b> -</div>';
                            }
                        }
                        ?>
                    </div>
                    <?php
                    $PropertyTags = $Crud->LookupOptions('lead_tags');
                    if (count($PropertyTags) > 0) {
                        ?>
                        <div class="row pt-2 pb-2">
                            <div class="col-md-9">
                                <p style="font-weight: bold;"><b style="color: #14477C;">Tags: </b><?php

                                    foreach ($PropertyTags as $AD) {
                                        echo '  <span style="padding: 0 .9rem !important;">
                                                  <label>
                                                    <input ' . ((in_array($AD['UID'], $finalTagsMeta)) ? 'checked' : '') . ' value="' . $AD['UID'] . '" 
                                                     onclick="AddPropertyTags(this.value)" name="[' . $AD['UID'] . ']" id="' . $AD['UID'] . '" type="checkbox" class="checkbox-input checked_all"   />
                                                    <span style="color: #14477C !important;font-size: 15px;">' . $AD['Name'] . '</span>
                                                  </label>
                                             </span>';
                                    }
                                    ?>
                                </p>
                            </div>

                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="col-xl-8 col-lg-8 col-sm-12  layout-spacing details-table">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                        <table id="#" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="12%">Date</th>
                                <th width="12%">Type</th>
                                <th width="71%">Activity</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (count($AllLeadsActivities) > 0) {

                                $cnt = 1;
                                foreach ($AllLeadsActivities as $ALA) {
                                    echo '<tr>
                                            <td><b>' . $cnt . '</b></td>
                                            <td><b>' . date("d M, Y", strtotime($ALA['SystemDate'])) . '</b></td>
                                            <td>' . $ALA['Type'] . '</td>
                                            <td>' . $ALA['Activity'] . '</td>
                                         </tr>';

                                    $cnt++;
                                }

                            } else {
                                echo '<tr><td colspan="4"><div class="alert alert-danger text-center font-weight-bold">No Record Found...!</div></td></tr>';
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area mb-3">
                    <div class="row">
                        <div class="col-md-7">
                            <button style="width: 100% !important; font-weight: bold; font-size:10px; background: #0c4128 !important; color: white !important;"
                                    onclick="LoadModal('sales/lead/callback/lead_status', <?= $record['UID'] ?>, 'modal-lg')"
                                    class="btn btn-sm btn-green">Lead Activities / Status / Callback
                            </button>
                        </div>
                        <div class="col-md-5">
                            <button style="width: 100% !important; font-weight: bold; font-size:10px;"
                                    onclick="LoadModal('sales/lead/callback/lead_assignment', <?= $record['UID'] ?>,'modal-lg')"
                                    class="btn btn-sm btn-success">Lead Assignment
                            </button>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area br-6 mb-3">
                    <h5 class="header-title">Activity Remarks</h5>
                    <form enctype="multipart/form-data" class="validate"
                          method="post" action="#"
                          name="AttachmentSendForm"
                          id="AttachmentSendForm"
                          onsubmit="AttachmentSendFormSubmit('AttachmentSendForm'); return false;">
                        <input type="hidden" id="LeadUID"
                               name="LeadUID"
                               value="<?= $record['UID'] ?>">
                        <div class="row form-group" style="margin-bottom: 0rem !important;" id="Attachments">
                            <div class="col-md-12 mb-3">
                                <label>Remarks</label>
                                <textarea type="textarea" class="form-control" name="remarks" id="remarks"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <input name="file" type="file" class="form-control"/>
                            </div>
                            <div class="col-md-12" id="AttachmentAjaxResult"></div>
                            <div style="text-align: right" class="col-md-12">
                                <button id="ActivityRemarksButton" type="button"
                                        onclick="AttachmentSendFormSubmit('AttachmentSendForm');"
                                        class="btn btn-success btn-sm">Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="widget-content widget-content-area br-6">
                    <h5 class="header-title">Re-Assigning Log</h5>
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <?php
                            if (count($LeadReassignLog) > 0) {
                                echo '<ul style="padding-left: 20px !important; font-size: 12px;">';
                                foreach ($LeadReassignLog as $LRL) {
                                    echo '<li>Lead Assign From <b>' . $LRL['ReAssignFrom'] . '</b> To <b>' . $LRL['ReAssignedTo'] . '</b> On <small style="font-weight: bold;">' . date("d M, Y h:i A", strtotime($LRL['SystemDate'])) . '</small> </li>';
                                }
                                echo '</ul>';
                            } else {
                                echo '<div class="text-center font-weight-bold alert alert-danger">No Record Found...!</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function AddPropertyTags(Tag) {
        var CheckedVal = document.getElementById(Tag);
        if (CheckedVal.checked == true) {
            var Value = 1;
        } else {
            var Value = 0;
        }
        AjaxResponse("lead/add_property_tags_option", "Tag=" + Tag + "&LeadID=" + <?=$record['UID']?> + "&Value=" + Value);
    }

    function AttachmentSendFormSubmit(parent) {

        var remarks = $("form#AttachmentSendForm textarea#remarks").val();
        var file = $("form#AttachmentSendForm input#file").val();
        if (remarks == '') {
            GridMessages('AttachmentSendForm', 'AttachmentAjaxResult', 'alert-danger', 'Kindly Add Remarks', 2000);
        } else if (file == '') {
            GridMessages('AttachmentSendForm', 'AttachmentAjaxResult', 'alert-danger', 'Kindly Add File', 2000);
        } else {

            $("#ActivityRemarksButton").html("Please Wait...");
            $("#ActivityRemarksButton").removeClass("btn-success");
            $("#ActivityRemarksButton").addClass("btn-danger btn-sm");
            $("#ActivityRemarksButton").attr("disabled", true);

            var phpdata = new window.FormData($("form#" + parent)[0]);
            var response = AjaxUploadResponse('lead/activity_attachments_form_submit', phpdata);
            if (response.status == 'success') {

                setTimeout(function () {
                    GridMessages('AttachmentSendForm', 'AttachmentAjaxResult', 'alert-success', response.message, 2000);
                    location.reload();
                }, 2000);

                $("#ActivityRemarksButton").html("Send");
                $("#ActivityRemarksButton").removeClass("btn-danger");
                $("#ActivityRemarksButton").addClass("btn-success btn-sm");
                $("#ActivityRemarksButton").attr("disabled", false);


            } else {
                GridMessages('AttachmentSendForm', 'AttachmentAjaxResult', 'alert-danger', response.message, 2000);

                $("#ActivityRemarksButton").html("Send");
                $("#ActivityRemarksButton").removeClass("btn-danger");
                $("#ActivityRemarksButton").addClass("btn-success");
                $("#ActivityRemarksButton").attr("disabled", false);

            }
        }
    }

</script>