<?php
$head = 'Add New ';
$update_id = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
    $DomainData = $records['domains_data'];
}

//print_r($records);

?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?> <?= $DomainData['FullName'] ?></h5>
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
<form enctype="multipart/form-data" class="validate" method="post" action="#" id="WebsitesDomainEditForm"
      name="WebsitesDomainEditForm">
    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="<?= $update_id ?>">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Name">Domain Name</label>
                    <input type="text" class="form-control" id="FullName" name="FullName"
                           placeholder="Domain Name" value="<?= $DomainData['Name'] ?>" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Name">Mobile Domain ID</label>
                    <input type="number" class="form-control" id="MobileDomainID"
                           name="MobileDomainID" placeholder="Mobile Domain ID"
                           value="<?= $DomainData['MobileDomainID'] ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="Name">Logo</label>
                    <input type="file" class="form-control" id="Logo" name="Logo" placeholder="Logo">
                </div>
                <div class="image <?= (($DomainData['Logo'] > 0) ? '' : 'd-none') ?>">
                    <?php
                    if (isset($DomainData['Logo'])) {
                        echo '<div class="grid-img float-right" style="background-image: url(\'' . $path . "home/load_file/" . $DomainData['Logo'] . '\');">
                       </div>';
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="" id="AjaxResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Discard</button>
        <button type="submit" class="btn btn-primary" onclick="DomainsFormSubmit();">Save</button>
    </div>
</form>


<script>


    function DomainsFormSubmit() {

        var validate = $("form#WebsitesDomainEditForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        var phpdata = new window.FormData($("form#WebsitesDomainEditForm")[0]);
        response = AjaxUploadResponse("form_process/domains_update_form", phpdata);

        if (response.status == 'success') {
            $("#AjaxResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
                location.reload();
        } else {
            $("#AjaxResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }
 
</script>