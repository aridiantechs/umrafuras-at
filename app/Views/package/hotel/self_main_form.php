<?php

use App\Models\Crud;

$Crud = new Crud();
$loadimages = $records['hotel_images'];

$head = 'Add New ';
$update_id = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
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
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?> Hotel</h5>
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
        <input type="hidden" name="UID" id="UID" value="<?= $update_id ?>">
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
                <input type="hidden" name="SelfCountry" id="SelfCountry">
                <input type="hidden" name="SelfCity" id="SelfCity">
                <input type="hidden" name="cnt" id="cnt">
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



    function LoadCitiesDropdown(country) {
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country + "&selected=<?=$data['CityID']?>");
        $("#City").html('<option value="">Please Select</option>' + cities.html);

    }
    $(document).ready(function () {
        $("#HotelAddForm #SelfCountry").val($("#VoucherCountry").val());
        $("#HotelAddForm #SelfCity").val($("#AccomodationCity").val());
        $("#HotelAddForm #cnt").val($("#Accomodationcnt").val());
    });

</script>
