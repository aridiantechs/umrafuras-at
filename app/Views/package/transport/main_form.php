<?php
use App\Models\Crud;
$Crud = new Crud();

$loadimages = $records['transport_images'];
//print_r($loadimages);

$head = 'Add New ';
$update_id = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
    $data = $records['transport_data'];
}
?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?> Transport</h5>
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
<form enctype="multipart/form-data" class="validate"  method="post" action="#" id="TransportAddForm" name="TransportAddForm">
    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="<?= $update_id ?>">
        <input type="hidden" name="DomainID" id="DomainID" value="<?= $GetDomainID ?>">

        <div class="row">
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="Type">Type</label>
                    <select class="form-control validate[required]" id="Type"
                            name="Type">
                        <option value="">Please Select</option>
                        <?php
                        $data['LookupsOptions'] = $Crud->LookupOptions('transport_types');
                        foreach ($data['LookupsOptions'] as $options)
                        {
                            $selected = ( ($data['Type']==$options['UID']) ? 'selected' : '' );
                            echo'<option value="'.$options['UID'].'"'.$selected.'>'.$options['Name'].'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="Description">Description</label>
                    <textarea class="form-control" id="Description" name="Description" rows="2"
                              placeholder="Description"><?= $data['Description'] ?></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="FullName">Luggage Capacity</label>
                    <textarea class="form-control" id="LuggageCapacity" name="LuggageCapacity" rows="2"
                              placeholder="Luggage Capacity"><?= $data['LuggageCapacity'] ?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">PAX Details</label>
                    <input type="number" class="form-control validate[required]" id="PAXDetail" name="PAXDetail" placeholder="PAX Detail" value="<?= $data['PAXDetail'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">Cover Image</label>
                    <input type="file" class="form-control <?= (isset($data['UID']) ? '' : 'validate[required]') ?>" id="CoverImage" name="CoverImage">
                </div>
                <div class="image <?= (($data['CoverImage']>0) ? '' : 'd-none') ?>">
                    <?php
                    if (isset($data['CoverImage'])) {
                        echo '<div class="grid-img float-right" style="background-image: url(\''.$path."home/load_file/". $data['CoverImage'] .'\');">
                        <a class="" href="javascript:void(0)" onclick="DeleteTransportCoverImage('.$data['CoverImage'].');" ><i class="fas fa-window-close"></i></a></div>';
                    }
                    ?>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="FullName">Images Upload</label>
                    <input type="file" class="form-control <?= (isset($data['UID']) ? '' : 'validate[required]') ?>" id="MultiImages" name="MultiImages[]" multiple>
                </div>
            </div>
            <div class="col-md-12">
                <div class="show-image <?= (($update_id) < 1 ? "d-none" : '') ?>">
                    <?php
                    $cnt = 0;
                    foreach ($loadimages as $images) {
                        $hide = ($cnt != 0) ? "" : "d-none";
                        echo '<div class="grid-img" style="background-image: url(\''.$path."home/load_file/". $images['FileID'] .'\');">
                        <a class="'.$hide.'" href="javascript:void(0)" onclick="DeleteTransportImage(' . $images['UID'] . ');" ><i class="fas fa-window-close"></i></a></div>';
                    $cnt++;
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="" id="TransportAddResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <button type="submit" class="btn btn-primary" onclick="TransportFormSubmit()">Save</button>
    </div>
</form>
<script>
    $("form#TransportAddForm").on("submit", function (event) {
        event.preventDefault();
    });

    function TransportFormSubmit() {

        var validate = $("form#TransportAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        var phpdata = new window.FormData($("form#TransportAddForm")[0]);
        response = AjaxUploadResponse("form_process/transport_form_submit", phpdata);

        if (response.status == 'success') {
            $("#TransportAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.href = "<?=base_url('package/transport')?>";
            }, 2000)
        } else {
            $("#TransportAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }
    function DeleteTransportImage(UID) {
        if (confirm("Are You Want To Remove Image")) {
            response = AjaxResponse("form_process/remove_transport_image", "UID=" + UID);
            if (response.status == 'success') {
                location.reload();
            }
        }
    }
    function DeleteTransportCoverImage(UID) {
        if (confirm("Are You Want To Remove This Cover Image")) {
            response = AjaxResponse("form_process/remove_transport_cover_image", "UID=" + UID);
            if (response.status == 'success') {
                location.reload();
            }
        }
    }

</script>