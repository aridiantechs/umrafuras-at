<?php

use App\Models\Crud;
use App\Models\Agents;
use App\Models\BrnRecords;

$Crud = new Crud();
$Agents = new Agents();
$BrnRecords = new BrnRecords();
$head = 'Create New ';
$update_id = 0;
$Agent = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
    $BRNPromoData = $records['BRNPromoData'];
    $Agent = $BRNPromoData['AgentUID'];
}
$Hotels = $BrnRecords->ListHotelsData();
$AgentsRecord = $Agents->ListExternalAgentsAndB2B();
?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?> Promo Code </h5>
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
<form class="validate" method="post" action="#" id="BRNPromoCodeAddForm" name="BRNPromoCodeAddForm">
    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="<?= $update_id ?>">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="country">Agent Name</label>
                    <select class="form-control validate[required]" id="Agent"
                            name="Agent">
                        <option value="">Select Agent</option>
                        <?php
                        foreach ($AgentsRecord as $AgentR) {
                            $selected = (($BRNPromoData['AgentUID'] == $AgentR['UID']) ? 'selected' : '');
                            echo '<option ' . $selected . ' value="' . $AgentR['UID'] . '">' . $AgentR['FullName'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="country">Hotels</label>
                    <select class="form-control validate[required]" id="Hotel"
                            name="Hotel">
                        <option value="">Select Hotel</option>
                        <?php
                        foreach ($Hotels as $Hotel) {
                            $Name = ((isset($Hotel['City']) && $Hotel['City'] != '') ? $Hotel['City'] . " &raquo; " . $Hotel['Name'] : $Hotel['Name']);
                            $selected = (($BRNPromoData['HotelUID'] == $Hotel['UID']) ? 'selected' : '');
                            echo '<option ' . $selected . ' value="' . $Hotel['UID'] . '">' . $Name . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="FullName">BRN Code</label>
                    <input type="text" class="form-control validate[required]" id="PromoCode" name="PromoCode"
                           placeholder="Promo Code" value="<?= $BRNPromoData['PromoCode'] ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">Activation Date</label>
                    <input type="date" class="form-control validate[required]" id="ActivationDate" name="ActivationDate"
                           placeholder="Promo Code" value="<?= $BRNPromoData['ActivationDate'] ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">Expiry Date</label>
                    <input type="date" class="form-control validate[required]" id="ExpiryDate" name="ExpiryDate"
                           placeholder="Promo Code" value="<?= $BRNPromoData['ExpiryDate'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">Care of</label>
                    <input type="text" class="form-control validate[required]" id="CareOf" name="CareOf"
                           placeholder="Care Of" value="<?= $BRNPromoData['CareOf'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">Status</label>
                    <select name="Status" id="Status" class="form-control validate[required]">
                        <option <?= (($BRNPromoData['Status'] == '') ? 'selected' : '') ?> value="">Select Status
                        </option>
                        <option <?= (($BRNPromoData['Status'] == 'Active') ? 'selected' : '') ?> value="Active">Active
                        </option>
                        <option <?= (($BRNPromoData['Status'] == 'Block') ? 'selected' : '') ?> value="Block">Block
                        </option>
                    </select>
                </div>
            </div>

            <div class="col-md-12">
                <div class="" id="BRNPromoCodeAddResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <button type="button" class="btn btn-primary" onclick="BRNPromoCodeAddFormSubmit();">Save</button>
    </div>
</form>

<script>

    $("form#BRNPromoCodeAddForm").on("submit", function (event) {
        event.preventDefault();
    });

    function BRNPromoCodeAddFormSubmit() {

        var validate = $("form#BRNPromoCodeAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        var phpdata = $("form#BRNPromoCodeAddForm").serialize();
        response = AjaxResponse("form_process/brn_promo_code_form_submit", phpdata);

        if (response.status == 'success') {
            $("#BRNPromoCodeAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.href = "<?=base_url('brn/promo_code')?>";
            }, 2000)
        } else {
            $("#BRNPromoCodeAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }


</script>