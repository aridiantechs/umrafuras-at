<?php

use App\Models\Agents;
use App\Models\Crud;

$Crud = new Crud();
$session = session();
$id = $session->get('id');
$AgentsModel = new Agents();
$AllAgents = $AgentsModel->AllAgentList();

$head = 'Create New ';
$update_id = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
    $BRNData = $records['BRNData'];
}

?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?> Use BRN </h5>
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
<form class="validate" method="post" action="#" id="UseBRNAddForm" name="UseBRNAddForm">
    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="<?= $update_id ?>">
        <div class="row">
            <div class="col-md-6" id="hotel">
                <div class="form-group mb-4">
                    <label for="Operator">Type</label>
                    <select class="form-control" id="Type"
                            name="Type" onchange="ListBrnAccordingToType(this.value);">
                        <option value="">Please Select</option>
                        <option value="hotel" <?= (($BRNData['Type'] == 'hotel') ? 'selected' : '') ?>>Hotel</option>
                        <option value="transport" <?= (($BRNData['Type'] == 'transport') ? 'selected' : '') ?>>
                            Transport
                        </option>

                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">BRN</label>
                    <select class="form-control" id="BRNCode"
                            name="BRNCode">
                        <option value="">Please Select Type</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="FullName">Use ID</label>
                    <select class="form-control" id="UseID"
                            name="UseID">
                        <option value="">Please Select</option>
                        <?php
                        foreach ($AllAgents as $allAgent) {
                            $selected = (($BRNData['UseID'] == $allAgent['UID']) ? 'selected' : '');
                            echo '<option value="' . $allAgent['UID'] . ' " ' . $selected . '>' . $allAgent['FullName'] . ' </option>';
                        }

                        ?>

                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="FullName">Used Date
                    </label>
                    <input type="date" class="form-control validate[required]" id="UsedDate" name="UsedDate"
                           placeholder="Used Date" value="<?= $BRNData['UsedDate'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="FullName">Expire Date
                    </label>
                    <input type="date" class="form-control validate[required]" id="ExpireDate" name="ExpireDate"
                           placeholder="Expire Date" value="<?= $BRNData['ExpireDate'] ?>">
                </div>
            </div>
        </div>
        <div class="row d-none" id="Hotels">
            <div class="col-md-6" id="Rooms">
                <div class="form-group mb-4">
                    <label for="Rooms">Rooms</label>
                    <input type="number" min="1" class="form-control validate[required]" id="Rooms" name="Rooms"
                           placeholder="Rooms" value="<?= $BRNData['Rooms'] ?>">
                </div>
            </div>
            <div class="col-md-6" id="Beds">
                <div class="form-group mb-4">
                    <label for="Beds">Beds</label>
                    <input type="number" min="1" class="form-control validate[required]" id="Beds" name="Beds"
                           placeholder="Beds" value="<?= $BRNData['Beds'] ?>">
                </div>
            </div>
        </div>
        <div class="row d-none" id="Transport">
            <div class="col-md-6" id="Rooms">
                <div class="form-group mb-4">
                    <label for="Rooms">Used Seats</label>
                    <input type="number" min="1" class="form-control validate[required]" id="Seats" name="Seats"
                           placeholder="Seats" value="<?= $BRNData['Seats'] ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="" id="UseBRNAddResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <button type="button" class="btn btn-primary" onclick="UseBRNFormSubmit();">Save</button>
    </div>
</form>

<script>

    $("form#UseBRNAddForm").on("submit", function (event) {
        event.preventDefault();
    });

    function UseBRNFormSubmit() {

        var validate = $("form#UseBRNAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        var phpdata = $("form#UseBRNAddForm").serialize();
        response = AjaxResponse("form_process/use_brn_form_submit", phpdata);

        if (response.status == 'success') {
            $("#UseBRNAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.href = "<?=base_url('brn/use_brn')?>";
            }, 2000)
        } else {
            $("#UseUseBRNAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }

    function ListBrnAccordingToType(type) {
        if (type == 'hotel') {
            $("div#Hotels").removeClass("d-none");
            $("div#Transport").addClass("d-none");

        } else if (type == 'transport') {

            $("div#Transport").removeClass("d-none");
            $("div#Hotels").addClass("d-none");

        }

        BRN = AjaxResponse("html/GetBRNAccordingToType", "type=" + type + "&selected=<?=$BRNData['BRNCode']?>");
        $("#BRNCode").html('<option value="">Please Select</option>' + BRN.html);
    }


    setTimeout(function () {
        <?php if($update_id > 0){?>
        ListBrnAccordingToType('<?=$BRNData['Type']?>');
        <?php }?>
    }, 100)

</script>