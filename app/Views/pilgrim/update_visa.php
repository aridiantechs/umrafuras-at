<?php

use App\Models\Crud;

$Crud = new Crud();

$head = 'Add';
$update_id = 0;
$update_id = $record_id;

$Visatable = 'pilgrim."visa"';
$where = array("PilgrimID" => $update_id);
$PilgrimVisa = $Crud->SingleRecord($Visatable, $where);

if ($PilgrimVisa['VisaNumber'] > 0) {
    $head = 'Update';

}

?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?> Visa Details</h5>
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
<form enctype="multipart/form-data" class="validate" method="post" action="#" id="VisaAddForm" name="VisaAddForm">
    <div class="modal-body">
        <input type="hidden" name="PilgrimID" id="PilgrimID" value="<?= $update_id ?>">
        <input type="hidden" name="VisaID" id="VisaID" value="<?= $PilgrimVisa['VisaNumber'] ?>">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Category">Visa Number</label>
                    <?php
                    if ($PilgrimVisa['VisaNumber'] > 0) {
                        echo '<input class="form-control"   name="VisaNumber"  id="VisaNumber" placeholder="Visa Number" readonly value="'. $PilgrimVisa['VisaNumber'].'">';
                    } else {
                        echo '<input type="number" class="form-control validate[required]" id="VisaNumber" name="VisaNumber"
                           placeholder="Visa Number" min="1" value="' . $PilgrimVisa['VisaNumber'] . '">';
                    }
                    ?>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Category">Type</label>
                    <select class="form-control validate[required]" id="Type"
                            name="Type">
                        <option value="">Please Select</option>
                        <?php
                        $data['LookupsOptions'] = $Crud->LookupOptions('visa_types');
                        foreach ($data['LookupsOptions'] as $options) {
                            $selected = (($PilgrimVisa['Type'] == $options['UID']) ? 'selected' : '');
                            echo '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['Name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Category">Issue Date</label>
                    <input type="date" class="form-control validate[required]" id="IssueDate" name="IssueDate"
                           placeholder="Issue Date" value="<?= $PilgrimVisa['IssueDate'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Category">Expiry Date</label>
                    <input type="date" class="form-control validate[required]" id="ExpiryDate" name="ExpiryDate"
                           placeholder="Expiry Date" value="<?= $PilgrimVisa['ExpireDate'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Category">MOFA Number</label>
                    <input type="number" class="form-control validate[required]" id="MofaNumber" name="MofaNumber"
                           placeholder="Mofa Number" min="1" value="<?= $PilgrimVisa['MOFANumber'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Category">Visa Attachment</label>
                    <input type="file" class="form-control validate[required]" id="VisaAttachment" name="VisaAttachment"
                           placeholder="VisaAttachment">
                </div>
            </div>
            <div class="col-md-12">
                <?php
                if (isset($PilgrimVisa['VisaAttachment'])) {
                    echo '<img src="' . $path . 'home/load_file/' . $PilgrimVisa['VisaAttachment'] . '" class="Image float-right" alt="Visa Attachment"  width="150px;">';
                }
                ?>
            </div>
            <div class="col-md-12">
                <div class="" id="VisaDetailAddResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <button type="button" class="btn btn-primary" onclick="VisaDetailFormSubmit()">Save</button>
    </div>
</form>

<script type="text/javascript">
    $("form#VisaAddForm").on("submit", function (event) {
        event.preventDefault();
    });

    function VisaDetailFormSubmit() {

        var validate = $("form#VisaAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        var phpdata = new window.FormData($("form#VisaAddForm")[0]);
        response = AjaxUploadResponse("form_process/visa_details_form_submit", phpdata);

        if (response.status == 'success') {
            $("#VisaDetailAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
              location.href = "<?=base_url('pilgrim/index')?>";
            }, 2000)
        } else {
            $("#VisaDetailAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }
</script>