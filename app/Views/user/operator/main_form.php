<?php
$head = 'Add New ';
$update_id = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
    $OperatorData = $records['operator_data'];
}

//print_r($records);

?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?> Operator</h5>
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
<form enctype="multipart/form-data" class="validate" method="post" action="#" id="OperatorAddForm" name="OperatorAddForm">

     <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="<?= $update_id ?>">
        <input type="hidden" name="DomainID" id="DomainID" value="<?= $GetDomainID ?>">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Name">Country</label>
                    <select class="form-control validate[required]" id="Country"
                            name="Country" onChange="LoadCitiesDropdown(this.value)">
                        <option value="">Please Select</option>
                        <?= Countries('html', $OperatorData['Country']) ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Name">Category </label>
                    <select class="form-control validate[required]" id="Category"
                            name="Category">
                        <option value="">Please Select</option>
                        <option value="BRN" <?=(($OperatorData['Category'] == 'BRN') ? 'selected' : '')?> >BRN</option>
                        <option value="Visa" <?=(($OperatorData['Category'] == 'Visa') ? 'selected' : '')?> >Visa</option>
                        <option value="Hotel" <?=(($OperatorData['Category'] == 'Hotel') ? 'selected' : '')?> >Hotel</option>
                        <option value="Transport" <?=(($OperatorData['Category'] == 'Transport') ? 'selected' : '')?> >Transport</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Name">Company Name</label>
                    <input type="text" class="form-control" id="CompanyName" name="CompanyName" placeholder="Company Name" value="<?=$OperatorData['CompanyName']?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Name">Contact Person Name</label>
                    <input type="text" class="form-control validate[required]" id="ContactPersonName" name="ContactPersonName" placeholder="Contact Person Name" value="<?=$OperatorData['ContactPersonName']?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Contact">Contact No</label>
                    <input type="number"  min="1" class="form-control validate[required]" id="ContactNo" name="ContactNo" placeholder="Contact Number" value="<?=$OperatorData['ContactNo']?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Email">Email</label>
                    <input type="email" class="form-control validate[required]" id="Email" name="Email" placeholder="Email" value="<?=$OperatorData['Email']?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="OfficeCity">Office City</label>
                    <input type="text" class="form-control" id="OfficeCity" name="OfficeCity" placeholder="Office City" value="<?=$OperatorData['OfficeCity']?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Name">Type</label>
                    <input type="text" class="form-control" id="Type" name="Type" placeholder="Type" value="<?=$OperatorData['Type']?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Name">Logo</label>
                    <input type="file" class="form-control" id="Logo" name="Logo" placeholder="Logo">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Color">Pick Color</label>
                    <input type="color" class="form-control" id="Color" name="Color" value="<?=$OperatorData['Color']?>" placeholder="Color">
                </div>
            </div>

            <div class="col-md-12">
                <?php
                if (isset($OperatorData['Logo'])) {
                    echo'<img style="width:50% !important;" src="'.$path.'home/load_file/'.$OperatorData['Logo'].'">
                    <a class="" href="javascript:void(0)" onclick="DeleteOperatorLogo(' . $OperatorData['Logo'] . ');" ><i class="fas fa-window-close"></i></a>';
                    /*echo '<div class="grid-img float-right" style="background-image: url(\'' . $path . "home/load_file/" . $OperatorData['Logo'] . '\'); width:100% !important;">
                        <a class="" href="javascript:void(0)" onclick="DeleteOperatorLogo(' . $OperatorData['Logo'] . ');" ><i class="fas fa-window-close"></i></a></div>';*/
                }
                ?>
            </div>

            <div class="col-md-12">
            <div class="" id="OperatorResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Discard</button>
        <button type="submit" class="btn btn-primary" onclick="OperatorFormSubmit();">Save</button>
    </div>
</form>


<script>
    $("form#OperatorAddForm").on("submit", function (event) {
        event.preventDefault();
        //OperatorFormSubmit();
    });

     function OperatorFormSubmit() {

         var validate = $("form#OperatorAddForm").validationEngine('validate');
         if (validate == false) {
             return false;
         }

         var phpdata = new window.FormData($("form#OperatorAddForm")[0]);
         response = AjaxUploadResponse("form_process/operator_form_submit", phpdata);


        if (response.status == 'success') {
            $("#OperatorResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.href = "<?=base_url('user/operator')?>";
            }, 2000)
        } else {
            $("#OperatorResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }
    }

    function DeleteOperatorLogo(UID) {
        if (confirm("Are You Want To Remove This Logo")) {
            var response = AjaxResponse("form_process/remove_operator_logo", "UID=" + UID);
            if (response.status == 'success') {
                location.reload();
            }
        }
    }

</script>