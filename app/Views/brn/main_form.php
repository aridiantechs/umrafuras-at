<?php

use App\Models\Crud;

$Crud = new Crud();
$head = 'Create New ';
$update_id = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
    $BRNData = $records['BRNData'];
}

$Transports = $records['transports'];
$Hotels = $records['hotels'];
?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?> BRN  </h5>
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
<form class="validate" method="post" action="#" id="BRNAddForm" name="BRNAddForm">
    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="<?= $update_id ?>">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="FullName">BRN Code</label>
                    <input type="text" class="form-control validate[required]" id="BRNCode" name="BRNCode"
                           placeholder="BRN Code" value="<?=$BRNData['BRNCode']?>">
                </div>
            </div>

            <div class="col-md-6" id="type">
                <div class="form-group mb-4">
                    <label for="Operator">Type</label>
                    <select class="form-control" id="Type"
                            name="Type" onchange="ShowDiv(this.value)">
                        <option value="">Please Select</option>
                        <option value="Transport" <?=(($BRNData['Type'] == 'Transport') ? "selected" : '')?> >Transport</option>
                        <option value="Hotel" <?=(($BRNData['Type'] == 'Hotel') ? "selected" : '')?> >Hotel</option>

                    </select>
                </div>
            </div>
            <div class="col-md-6 d-none" id="company">
                <div class="form-group mb-4">
                    <label for="Operator">Company</label>
                    <select class="form-control" id="Company"
                            name="Company">
                        <option value="">Please Select</option>
                        <?php
                        $data['LookupsOptions'] = $Crud->LookupOptions('transportation_company');
                        foreach ($data['LookupsOptions'] as $options) {
                            $selected = (($BRNData['Company'] == $options['UID']) ? 'selected' : '');
                            echo '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['Name'] . '</option>';
                        }
                        ?>
<!--                        --><?php
//                        foreach ($Transports as $transport) {
//                            $selected = (($BRNData['Company'] == $transport['UID']) ? 'selected' : '');
//                            echo '<option value="' . $transport['UID'] . '"' . $selected . '>' . OptionName($transport['Type']) . ' (' . $transport['Description'] . ')</option>';
//                        }
//                        ?>

                    </select>
                </div>
            </div>
            <div class="col-md-6 d-none" id="hotel">
                <div class="form-group mb-4">
                    <label for="Operator">Hotel List</label>
                    <select class="form-control" id="HotelList"
                            name="HotelList">
                        <option value="">Please Select</option>
                        <?php
                        foreach ($Hotels as $hotel) {
                            $selected = (($BRNData['HotelID'] == $hotel['UID']) ? 'selected' : '');
                            echo '<option value="' . $hotel['UID'] . '"' . $selected . '>' . $hotel['Name'] . ' (' . CityName($hotel['CityID']) . ')</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4 d-none" id="Seats">
                <div class="form-group mb-4">
                    <label for="Seats">Seats</label>
                    <input type="text" class="form-control validate[required]" id="Seats" name="Seats"
                           placeholder="Seats" value="<?=$BRNData['Seats']?>">
                </div>
            </div>
            <div class="col-md-2 d-none" id="Rooms">
                <div class="form-group mb-4">
                    <label for="Rooms">Rooms</label>
                    <input type="text" class="form-control validate[required]" id="Rooms" name="Rooms"
                           placeholder="Rooms" value="<?=$BRNData['Rooms']?>">
                </div>
            </div>
            <div class="col-md-2 d-none" id="Beds">
                <div class="form-group mb-4">
                    <label for="Beds">Beds</label>
                    <input type="text" class="form-control validate[required]" id="Beds" name="Beds"
                           placeholder="Beds" value="<?=$BRNData['Beds']?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Operator">Operator</label>
                    <select class="form-control" id="Operator"
                            name="Operator">
                        <option value="">Please Select</option>
                        <?php
                        $data['LookupsOptions'] = $Crud->LookupOptions('brn_operators');
                        foreach ($data['LookupsOptions'] as $options) {
                            $selected = (($BRNData['Operator'] == $options['UID']) ? 'selected' : '');
                            echo '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['Name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">Generate Date</label>
                    <input type="date" class="form-control validate[required]" id="GenerateDate" name="GenerateDate"
                           placeholder="Generate Date" value="<?=$BRNData['GenerateDate']?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Active">Active Date</label>
                    <input type="date" class="form-control validate[required]" id="ActiveDate" name="ActiveDate"
                           placeholder="Active Date" value="<?=$BRNData['ActiveDate']?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">Expire Date</label>
                    <input type="date" class="form-control validate[required]" id="ExpireDate" name="ExpireDate"
                           placeholder="Expire Date" value="<?=$BRNData['ExpireDate']?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="" id="BRNAddResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <button type="button" class="btn btn-primary" onclick="GroupFormSubmit();">Save</button>
    </div>
</form>

<script>

    setTimeout(function () {
        ShowDiv('<?=$BRNData['Type']?>');
    }, 100);

    $("form#BRNAddForm").on("submit", function (event) {
        event.preventDefault();
    });

    function GroupFormSubmit() {

        var validate = $("form#BRNAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        var phpdata = $("form#BRNAddForm").serialize();
        response = AjaxResponse("form_process/brn_form_submit", phpdata);

        if (response.status == 'success') {
            $("#BRNAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.href = "<?=base_url('brn/index')?>";
            }, 2000)
        } else {
            $("#BRNAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }

    function ShowDiv(val) {
        if (val == 'Transport') {
            $("div#type").removeClass("col-md-6");
            $("div#type").addClass("col-md-4");
            $("div#company").removeClass("col-md-6 d-none");
            $("div#company").addClass("col-md-4");
            $("div#hotel").addClass("d-none");
            $("div#Quantity").addClass("d-none");


            $("div#Rooms").addClass("d-none");
            $("div#Beds").addClass("d-none");
            $("div#Seats").removeClass("d-none");

        } else if (val == 'Hotel') {

            $("div#type").removeClass("col-md-6");
            $("div#type").addClass("col-md-4");
            $("div#hotel").removeClass("col-md-6 d-none");
            $("div#hotel").addClass("col-md-4");
            $("div#company").addClass("d-none");
            $("div#Quantity").addClass("d-none");


            $("div#Rooms").removeClass("d-none");
            $("div#Beds").removeClass("d-none");
            $("div#Seats").addClass("d-none");

        } else  {
            $("div#company").addClass("d-none");
            $("div#type").addClass("col-md-6");
            $("div#hotel").addClass("d-none");
            $("div#Rooms").addClass("d-none");
            $("div#Beds").addClass("d-none");
            $("div#Seats").addClass("d-none");

        }
    }

</script>