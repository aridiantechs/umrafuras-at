<?php

use App\Models\Crud;
use App\Models\Agents;

$Crud = new Crud();
$Agents = new Agents();

$session = session();
$id = $session->get('id');
$date = date("d M, Y");
$Expiredate = date("d M, Y") - 1;

$head = 'Create New ';
$update_id = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
    $BRNData = $records['BRNData'];
}
$Transports = $records['transports'];
$Hotels = $records['hotels'];
$PromoCode = $records['BRNPromoData'];
$AgentsRecord = $Agents->ListExternalAgentsAndB2B();


$table = 'main."Countries"';
$Countries = $Crud->ListRecords($table, array(), array("Name" => 'ASC'));


?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?> Hotel BRN </h5>
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
<form class="validate" method="post" action="#" id="HotelBRNAddForm" name="HotelBRNAddForm">
    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="<?= $update_id ?>">
        <input type="hidden" name="Type" id="Type" value="hotel">
        <input type="hidden" name="CreatedBy" id="CreatedBy" value="<?= $id ?>">
        <input type="hidden" name="CreatedDate" id="CreatedDate" value="<?= $date ?>">

        <input type="hidden" name="ModifiedBy" id="ModifiedBy" value="<?= $id ?>">
        <input type="hidden" name="ModifiedDate" id="ModifiedDate" value="<?= $date ?>">

        <input type="hidden" name="ExpireDate" id="ExpireDate" value="">
        <div class="row">
            <div class="col-md-4">
                <label for="FullName">BRN Code</label>
                <input style="height: 45px;" type="text" class="form-control validate[required]" id="BRNCode" name="BRNCode"
                       placeholder="BRN Code" value="<?= $BRNData['BRNCode'] ?>">
            </div>
            <div class="col-md-4">
                <label for="FullName">Promo Code</label>

                <select class="form-control validate[required]" id="PromoCode"
                        name="PromoCode">
                    <option value="">Please Select</option>
                    <?php
                    foreach ($PromoCode as $options) {
                        $selected = (($BRNData['PromoCode'] == $options['UID']) ? 'selected' : '');
                        echo '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['PromoCode'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-4" id="hotel">
                <label for="Operator">Hotel List-</label>
                <select style="height: 45px;" class="form-control" id="HotelList"
                        name="HotelList">
                    <option value="">Please Select</option>
                    <?php
                    foreach ($Hotels as $hotel) {
                        $selected = (($BRNData['HotelsID'] == $hotel['UID']) ? 'selected' : '');
                        echo '<option value="' . $hotel['UID'] . '"' . $selected . '>' . $hotel['Name'] . ' (' . CityName($hotel['CityID']) . ')</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4" id="Rooms">
                <div class="form-group mb-4">
                    <label for="Rooms">Rooms</label>
                    <input type="text" class="form-control validate[required]" id="Rooms" name="Rooms"
                           placeholder="Rooms" value="<?= $BRNData['Rooms'] ?>">
                </div>
            </div>
            <div class="col-md-4" id="Beds">
                <div class="form-group mb-4">
                    <label for="Beds">Beds</label>
                    <input type="text" class="form-control validate[required]" id="Beds" name="Beds"
                           placeholder="Beds" value="<?= $BRNData['Beds'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="Operator">Operator</label>
                    <select class="form-control" id="Operator"
                            name="Operator">
                        <option value="">Please Select</option>
                        <?php
                        $Main = new \App\Models\Main();
                        $Operators = $Main->LoadOperators('BRN');
                        foreach ($Operators as $Operator) {
                            $selected = (($BRNData['Operator'] == $Operator['UID']) ? 'selected' : '');
                            echo '<option value="' . $Operator['UID'] . '"' . $selected . '>' . $Operator['CompanyName'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="country">Country</label>
                    <select class="form-control" id="Country"
                            name="Country" onchange="LoadAgentAccordingToCountry(this.value);">
                        <option value="">Please Select</option>
                        <?php
                        foreach ($Countries as $option) {
                            echo '<option value="' . $option['ISO2'] . '" ' . (($BRNData['Country'] == $option['ISO2']) ? 'selected' : '') . '>' . $option['Name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="country">Agent</label>
                    <select class="form-control" id="Agent"
                            name="Agent">
                        <option value="">Select Country</option>
                        <!--                        --><?php
                        //                        foreach ($AgentsRecord as $AgentR) {
                        //                            $selected = (($BRNData['Agent'] == $AgentR['UID']) ? 'selected' : '');
                        //                            echo '<option ' . $selected . ' value="' . $AgentR['UID'] . '">' . $AgentR['FullName'] . '</option>';
                        //                        }
                        //                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="FullName">Purchased ID</label>
                    <input type="text" class="form-control validate[required]" id="PurchaseID" name="PurchaseID"
                           placeholder="Purchased ID" value="<?= $BRNData['PurchaseID'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="FullName">Purchased By</label>
                    <select class="form-control" id="PurchasedBy"
                            name="PurchasedBy">
                        <option value="">Please Select</option>
                        <?php
                        $Users = new \App\Models\Users();
                        $AllUsers = $Users->ListUsers();
                        foreach ($AllUsers as $User) {
                            $selected = (($BRNData['PurchasedBy'] == $User['UID']) ? 'selected' : '');
                            echo '<option value="' . $User['UID'] . '"' . $selected . '>' . $User['FullName'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="FullName">Use Type</label>
                    <select class="form-control" id="UseType"
                            name="UseType">
                        <option value="">Please Select</option>
                        <option value="Visa" <?= (($BRNData['UseType'] == 'Visa') ? 'selected' : '') ?>>Visa</option>
                        <option value="Hotel" <?= (($BRNData['UseType'] == 'Hotel') ? 'selected' : '') ?>>Hotel</option>
                        <option value="visa_and_hotel" <?= (($BRNData['UseType'] == 'visa_and_hotel') ? 'selected' : '') ?>>
                            Visa And Hotel
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="FullName">Booking Date
                    </label>
                    <input type="date" class="form-control validate[required]" id="BookingDate" name="BookingDate"
                           placeholder="Booking Date" value="<?= $BRNData['BookingDate'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="FullName">Check In Date</label>
                    <input type="date" class="form-control validate[required]" id="GenerateDate" name="GenerateDate"
                           placeholder="Check In Date" value="<?= $BRNData['GenerateDate'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="Active">Check Out Date</label>
                    <input type="date" class="form-control validate[required]" id="ActiveDate" name="ActiveDate"
                           placeholder="Check Out Date" value="<?= $BRNData['ActiveDate'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="Active">Expire Date</label>
                    <input type="date" class="form-control validate[required]" id="ExpiryDate" name="ExpiryDate"
                           placeholder="Expire Date" value="<?= $BRNData['ExpireDate'] ?>">
                </div>
            </div>

            <div class="col-md-12">
                <div class="" id="BRNAddResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <button type="button" class="btn btn-primary" onclick="HotelBRNFormSubmit();">Save</button>
    </div>
</form>

<script>

    $(document).ready(function (){
        $("form#HotelBRNAddForm select#PromoCode").select2({
            dropdownParent: $('#MainForm')
        });
    });

    $("form#HotelBRNAddForm").on("submit", function (event) {
        event.preventDefault();
    });

    function HotelBRNFormSubmit() {

        var validate = $("form#HotelBRNAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        var phpdata = $("form#HotelBRNAddForm").serialize();
        response = AjaxResponse("form_process/brn_form_submit", phpdata);

        if (response.status == 'success') {
            $("#BRNAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.href = "<?=base_url('brn/hotel_brn')?>";
            }, 2000)
        } else {
            $("#BRNAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }
    }

    function LoadAgentAccordingToCountry(Country) {
        var Country = AjaxResponse("form_process/GetAgentAccordingToCountry", "Country=" + Country + "&selected=<?=$BRNData['Agent']?>")
        $("#Agent").html('<option value="">Please Select Agent</option>' + Country.html);

    }

    <?php
    if($update_id > 0) { ?>
    LoadAgentAccordingToCountry("<?=$BRNData['Country']?>");
    <?php } ?>

</script>