<?php

use App\Models\Crud;
use App\Models\Agents;

$session = session();
$id = $session->get('id');
$date = date("d M, Y");


$Crud = new Crud();
$Agents = new Agents();
$head = 'Create New ';
$update_id = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
    $BRNData = $records['BRNData'];
}

$Transports = $records['transports'];
$Hotels = $records['hotels'];
$table = 'main."Countries"';
$Countries = $Crud->ListRecords($table, array(), array("Name" => 'ASC'));


$AgentsRecord = $Agents->ListExternalAgentsAndB2B();
?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?> Transport BRN</h5>
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
<form class="validate" method="post" action="#" id="TransportBRNAddForm" name="TransportBRNAddForm">
    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="<?= $update_id ?>">
        <input type="hidden" name="Type" id="Type" value="transport">
        <input type="hidden" name="CreatedBy" id="CreatedBy" value="<?= $id ?>">
        <input type="hidden" name="CreatedDate" id="CreatedDate" value="<?= $date ?>">

        <input type="hidden" name="ModifiedBy" id="ModifiedBy" value="<?= $id ?>">
        <input type="hidden" name="ModifiedDate" id="ModifiedDate" value="<?= $date ?>">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="FullName">BRN Code</label>
                    <input type="text" class="form-control validate[required]" id="BRNCode" name="BRNCode"
                           placeholder="BRN Code" value="<?= $BRNData['BRNCode'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="FullName">Promo Code</label>
                    <input type="text" class="form-control" id="PromoCode" name="PromoCode"
                           placeholder="Promo Code" value="<?=$BRNData['PromoCode']?>">
                </div>
            </div>
            <div class="col-md-4" id="company">
                <div class="form-group mb-4">
                    <label for="Operator">TPT Company</label>
                    <select class="form-control validate[required]" id="Company"
                            name="Company">
                        <option value="">Please Select</option>
                        <?php
                        $data['LookupsOptions'] = $Crud->LookupOptions('transportation_company');
                        foreach ($data['LookupsOptions'] as $options) {
                            $selected = (($BRNData['Company'] == $options['UID']) ? 'selected' : '');
                            echo '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['Name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4" id="company">
                <div class="form-group mb-4">
                    <label for="Operator">TPT Type</label>
                    <select class="form-control validate[required]" id="TransportType"
                            name="TransportType">
                        <option value="">Please Select</option>
                        <?php
                        $data['LookupsOptions'] = $Crud->LookupOptions('transport_types');
                        foreach ($data['LookupsOptions'] as $options) {
                            $selected = (($BRNData['TransportType'] == $options['UID']) ? 'selected' : '');
                            echo '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['Name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4" id="company">
                <div class="form-group mb-4">
                    <label for="Operator">TPT Sectors</label>
                    <select class="form-control validate[required]" id="TransportSectors"
                            name="TransportSectors">
                        <option value="">Please Select</option>
                        <?php
                        $data['LookupsOptions'] = $Crud->LookupOptions('transport_sectors');
                        foreach ($data['LookupsOptions'] as $options) {
                            $selected = (($BRNData['TransportSectors'] == $options['UID']) ? 'selected' : '');
                            echo '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['Name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4" id="Seats">
                <div class="form-group mb-4">
                    <label for="Seats">No of Vehicles</label>
                    <input type="number" min="1" class="form-control" id="NoOfVehicles" name="NoOfVehicles"
                           placeholder="No of Vehicles" value="<?= $BRNData['NoOfVehicles'] ?>">
                </div>
            </div>
            <div class="col-md-4" id="Seats">
                <div class="form-group mb-4">
                    <label for="Seats">No of Seats</label>
                    <input type="number" min="1" class="form-control validate[required]" id="Seats" name="Seats"
                           placeholder="No of Seats" value="<?= $BRNData['Seats'] ?>">
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
                    <select class="form-control" id="Country" onchange="LoadAgentAccordingToCountries(this.value);"
                            name="Country">
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
                        <option value="">Select Agent</option>
<!--                        --><?php
//                        foreach ($AgentsRecord as $AgentR) {
//                            $selected = (($BRNData['Agent'] == $AgentR['UID']) ? 'selected' : '');
//                            echo '<option ' . $selected . ' value="' . $AgentR['UID'] . '">' . $AgentR['FullName'] . '</option>';
//                        }
//                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-4">
                    <label for="FullName">Use Type</label>
                    <select class="form-control" id="UseType"
                            name="UseType">
                        <option value="">Please Select</option>
                        <option value="Visa" <?=(($BRNData['UseType'] == 'Visa') ? 'selected' : '')?>>Visa</option>
                         <option value="visa_and_transport" <?=(($BRNData['UseType'] == 'visa_and_transport') ? 'selected' : '')?>>Visa And Transport</option>
                     </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-4">
                    <label for="FullName">Booking Date
                    </label>
                    <input type="date" class="form-control validate[required]" id="BookingDate" name="BookingDate"
                           placeholder="Booking Date" value="<?=$BRNData['BookingDate']?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-4">
                    <label for="FullName">Arrival Date</label>
                    <input type="date" class="form-control validate[required]" id="GenerateDate" name="GenerateDate"
                           placeholder="Generate Date" value="<?= $BRNData['GenerateDate'] ?>">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group mb-4">
                    <label for="Active">Expire Date</label>
                    <input type="date" class="form-control validate[required]" id="ExpiryDate" name="ExpiryDate"
                           placeholder="Expire Date" value="<?= $BRNData['ExpireDate'] ?>">
                </div>
            </div>
            <!--            <div class="col-md-4">-->
            <!--                <div class="form-group mb-4">-->
            <!--                    <label for="Active">Active Date</label>-->
            <!--                    <input type="date" class="form-control validate[required]" id="ActiveDate" name="ActiveDate"-->
            <!--                           placeholder="Active Date" value="--><? //=$BRNData['ActiveDate']?><!--">-->
            <!--                </div>-->
            <!--            </div>-->
<!--            <div class="col-md-6">-->
<!--                <div class="form-group mb-4">-->
<!--                    <label for="FullName">Expire Date</label>-->
<!--                    <input type="date" class="form-control validate[required]" id="ExpireDate" name="ExpireDate"-->
<!--                           placeholder="Expire Date" value="--><?//= $BRNData['ExpireDate'] ?><!--">-->
<!--                </div>-->
<!--            </div>-->
            <div class="col-md-12">
                <div class="" id="TransportBRNAddResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <button type="button" class="btn btn-primary" onclick="TransportFormSubmit();">Save</button>
    </div>
</form>

<script>

    $("form#TransportBRNAddForm").on("submit", function (event) {
        event.preventDefault();
    });

    function TransportFormSubmit() {


        var validate = $("form#TransportBRNAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        var phpdata = $("form#TransportBRNAddForm").serialize();
        response = AjaxResponse("form_process/brn_form_submit", phpdata);

        if (response.status == 'success') {
            $("#TransportBRNAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.href = "<?=base_url('brn/transport_brn')?>";
            }, 2000)
        } else {
            $("#TransportBRNAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }



    //   var ExpireDate = $("form#TransportBRNAddForm input#ExpireDate").val();
    //        if (ExpireDate == '') {
    //            $("form#TransportBRNAddForm input#ExpireDate").val('<?=$Expiredate?>');
    //        }
    //        else {
    //        }
    // setTimeout(function () {
    //     AssignExpireDate();
    // }, 100)
    function LoadAgentAccordingToCountries(Country) {
        var Country = AjaxResponse("form_process/GetAgentAccordingToCountry", "Country=" + Country + "&selected=<?=$BRNData['Agent']?>")
        $("#Agent").html('<option value="">Please Select Agent</option>' + Country.html);

    }

    <?php
    if($update_id > 0) { ?>
    LoadAgentAccordingToCountries("<?=$BRNData['Country']?>");
    <?php } ?>

</script>