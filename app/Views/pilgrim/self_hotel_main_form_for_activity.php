<?php

use App\Models\Crud;

$Crud = new Crud();
$loadimages = $records['hotel_images'];

$head = 'Add New ';
$update_id = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $CityID = $record_id;
    $data = $records['hotel_data'];


}
if(!isset($records['hotel_meta']['Facilities'])){
    $records['hotel_meta']['Facilities'] = array();
}
if(!isset($records['hotel_meta']['Amenities'])){
    $records['hotel_meta']['Amenities'] = array();
}
//print_r($records['hotel_meta']);
?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"> Add Self Hotel </h5>
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
<form enctype="multipart/form-data" class="validate" method="post" action="#" id="HotelAddForm" name="HotelAddForm">
    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="0">
        <input type="hidden" name="DomainID" id="DomainID" value="<?= $GetDomainID ?>">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="Category">Category</label>
                    <select class="form-control" id="Category"
                            name="Category">
                        <option value="">Please Select</option>
                        <?php
                        $data['LookupsOptions'] = $Crud->LookupOptions('hotel_category');
                        foreach ($data['LookupsOptions'] as $options) {
                            $selected = (($data['Category'] == $options['UID']) ? 'selected' : '');
                            echo '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['Name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>


            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="FullName">Name</label>
                    <input type="text" class="form-control" id="Name" name="Name"
                           placeholder="Name" value="<?= $data['Name'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="FullName">Telephone Number</label>
                    <input type="text" class="form-control" id="TelephoneNumber" name="TelephoneNumber"
                           placeholder="Telephone Number" value="<?= $data['TelephoneNumber'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">Address</label>
                    <input type="text" class="form-control" id="Address" name="Address"
                           placeholder="Address" value="<?= $data['Address'] ?>">
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">Distance</label>
                    <input type="text" class="form-control" id="Distance" name="Distance"
                           placeholder="Distance" value="<?= $data['Distance'] ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="FullName">Description</label>
                    <textarea type="text" class="form-control" id="Description" name="Description"
                              placeholder="Description" rows="2"><?= $data['Description'] ?></textarea>
                </div>
                <input type="hidden" name="SelfCountry" id="SelfCountry" value="SA">
                <input type="hidden" name="SelfCity" id="SelfCity" value="<?=$CityID?>">
             </div>

            <div class="col-md-12">
                <div class="" id="HotelAddResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <button type="button" class="btn btn-primary" onclick="HotelFormSubmit()">Save</button>
    </div>
</form>
<script>


    function HotelFormSubmit() {

        var validate = $("form#HotelAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        var phpdata = new window.FormData($("form#HotelAddForm")[0]);
        response = AjaxUploadResponse("form_process/self_hotel_form_submit", phpdata);

        if (response.status == 'success') {
            $("#HotelAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            LoadSelfHotelByCites('<?=$CityID?>');
            $('#MainForm_self_other_hotel').modal('hide');
         } else {
            $("#HotelAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }

    function LoadCitiesDropdown(country) {
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country + "&selected=<?=$data['CityID']?>");
        $("#City").html('<option value="">Please Select</option>' + cities.html);

    }

</script>
