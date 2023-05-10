<?php

use App\Models\Users;
use App\Models\Crud;

$Crud = new Crud();

$session = session();
$session = $session->get();
$SystemUsers = new Users();
$sale_officers = $SystemUsers->ListSalesUsers();
$source = array('excel_import' => 'Excel Import', 'facebook' => 'Facebook', 'organic' => 'Organic', 'purchased' => 'Purchased', 'tidio' => 'Tidio');

$head = 'Add  ';
$update_id = 0;
$class = '';
$LeadsProducts = array();
if ($record_id > 0) {
    $head = 'Update';
    $update_id = $record_id;
    $profile = $records['leads_records'];
    $profileLead = $records['leads_meta'];
    $LeadsProducts = $records['leads_products'];

}
//$Productsss = '';
//foreach ($LeadsProducts as $Product) {
//    $Productsss .= $Product['ProductName'];
//}

//echo "<pre>";
//print_r($LeadsProducts);


if ($update_id > 0) {
    $class = 'd-none';
}

$SelectedLeadCategory = ((isset($profile['LeadCategory']) && $profile['LeadCategory'] != '') ? $profile['LeadCategory'] : '');
$SelectedLeadStatus = ((isset($profile['Status']) && $profile['Status'] != '') ? $profile['Status'] : '');
$SelectedLeadCloseReason = ((isset($profile['CloseReason']) && $profile['CloseReason'] != '') ? $profile['CloseReason'] : '');

?>


<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?> Lead </h5>
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
<div>

</div>
<form class="validate" method="post" action="#" id="AddUnassignLeadForm" name="AddUnassignLeadForm">
    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="<?= $update_id ?>">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="FullName">Full Name</label>
                    <input type="text" class="form-control " id="FullName" name="FullName"
                           placeholder="Full Name" value="<?= $profile['FullName'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="ContactNumber">Contact Number</label><span class="ml-1 text-danger"
                                                                           id="ContactNumberSpan"></span>
                    <input type="number" class="form-control"
                           id="ContactNumber" name="ContactNumber"
                           placeholder="Contact Number" value="<?= $profile['ContactNo'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="WhatsAppNo">WhatsApp No </label> <span class="ml-1 text-danger"
                                                                       id="WhatsAppNoSpan"></span>
                    <input type="number" class="form-control"
                           min="11" max="13" id="WhatsAppNo" name="WhatsAppNo"
                           placeholder="WhatsApp No" value="<?= $profile['WhatsAppNo'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="Email">Email </label>
                    <input type="text" class="form-control " name="Email"
                           placeholder="Email" value="<?= $profile['Email'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label>Lead Category</label>
                    <select onchange="LoadStatusByCategory(this.value);" class="form-control" id="lead_category"
                            name="lead_category">
                        <option <?= (($SelectedLeadCategory == 'B2B') ? 'selected' : '') ?> value="B2B">B2B</option>
                        <option <?= (($SelectedLeadCategory == 'B2C') ? 'selected' : '') ?> value="B2C">B2C</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4" id="b2bstatusdiv">
                <div class="form-group mb-3">
                    <label>Lead Status </label>
                    <select onchange="ShowCloseReason(this.value);" class="form-control" id="b2b_leadStatus"
                            name="b2b_leadStatus">
                        <option value=""> Select Lead Status</option>
                        <?php
                        foreach ($B2BLeadStatusArray as $key => $value) {
                            echo ' <option ' . $selected . ' value="' . $key . '">' . $value . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4 d-none" id="b2cstatusdiv">
                <div class="form-group mb-3">
                    <label>Lead Status </label>
                    <select onchange="ShowCloseReason(this.value);" class="form-control" id="b2c_leadStatus"
                            name="b2c_leadStatus">
                        <option value=""> Select Lead Status</option>
                        <?php
                        foreach ($B2CLeadStatusArray as $key => $value) {
                            echo ' <option ' . $selected . ' value="' . $key . '">' . $value . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4 d-none" id="b2bclosereasondiv">
                <div class="form-group mb-3">
                    <label>Close Reason</label>
                    <select class="form-control" id="b2b_close_reason"
                            name="b2b_close_reason">
                        <option value=""> Select Reason</option>
                        <?php
                        $B2BCloseReasons = $Crud->LookupOptions('b2b_lead_close_reason');
                        foreach ($B2BCloseReasons as $Reasons) {
                            echo '<option value="' . $Reasons['UID'] . '">' . $Reasons['Name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4 d-none" id="b2cclosereasondiv">
                <div class="form-group mb-3">
                    <label>Close Reason</label>
                    <select class="form-control" id="b2c_close_reason"
                            name="b2c_close_reason">
                        <option value=""> Select Reason</option>
                        <?php
                        $B2CCloseReasons = $Crud->LookupOptions('b2c_lead_close_reason');
                        foreach ($B2CCloseReasons as $Reasons) {
                            echo '<option value="' . $Reasons['UID'] . '">' . $Reasons['Name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="=Company">Company / Agent </label>
                    <input type="text" class="form-control " id="CompanyAgent" name="CompanyAgent"
                           placeholder="Company Agent" value="<?= $profileLead['CompanyAgentName'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="=Company">Mobile # 1 </label>
                    <input type="text" class="form-control" id="MobileNo1" name="MobileNo1"
                           placeholder="Mobile No 1" value="<?= $profileLead['MobileNumber1'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="=Company">Phone # 1</label>
                    <input type="text" class="form-control " id="PhoneNo1" name="PhoneNo1"
                           placeholder="Phone No 1" value="<?= $profileLead['Phone1'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="=Company">Phone # 2</label>
                    <input type="text" class="form-control " id="PhoneNo2" name="PhoneNo2"
                           placeholder="Phone No 2" value="<?= $profileLead['Phone2'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="=Company">City</label>
                    <input type="text" class="form-control " id="City" name="City"
                           placeholder="City" value="<?= $profileLead['City'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="=Company">Zone</label>
                    <input type="text" class="form-control " id="Zone" name="Zone"
                           placeholder="Zone" value="<?= $profileLead['Zone'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="=saleOfficer">Sale Officers </label>
                    <select class="form-control " id="saleOfficer"
                            name="saleOfficer">
                        <option value="0"> Select Sale Officer</option>
                        <?php foreach ($sale_officers as $record) {
                            $selected = (($profile['UserID'] == $record['UID']) ? 'selected' : ''); ?>
                            <option value="<?= $record['UID'] ?>" <?= $selected ?> ><?= $record['FullName'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="Personal">Personal </label>
                    <select class="form-control " id="Personal"
                            name="Personal">
                        <option value="">Please Select</option>
                        <option <?= (($profile['Personal'] == 1) ? 'selected' : '') ?> value="1">Yes</option>
                        <option <?= (($profile['Personal'] == 0) ? 'selected' : '') ?> value="0">No</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="=PersonalRealtion">Personal Relation Level </label>
                    <select class="form-control " id="PersonalRelation"
                            name="PersonalRelation">
                        <option value="" selected disabled>Please Select</option>
                        <?php for ($i = 0; $i <= 10; $i++) {
                            $selected = (($profileLead['PersonalRelation'] == $i) ? 'selected' : '');
                            ?>
                            <option value="<?= $i ?>" <?= $selected ?>><?= $i ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-4 <?= $class ?>  d-none"> <!-- d-none class use for remove create date because create date in system date -->
                <div class="form-group mb-4">
                    <label for="createDate">Create Date </label>
                    <input type="date" class="form-control  " id="createDate" name="createDate"
                           value="<?php if ($update_id == 0) {
                               echo date('Y-m-d');
                           } else {
                               echo $profile['CreatedAt'];
                           } ?>">
                </div>
            </div>


            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="=Source"> Source </label>
                    <select class="form-control " id="Source"
                            name="Source">
                        <option value="" selected disabled> Select Source</option>
                        <?php
                        foreach ($source as $key => $value) {
                            $selected = (($profile['Source'] == $key) ? 'selected' : '');
                            ?>
                            <option value="<?= $key ?>" <?= $selected ?>> <?= ($value) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
<!--            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="Products">Products </label>
                    <select class="form-control " id="Products"
                            name="Products">
                        <option value="" selected disabled> Select Projects</option>
                        <?php /*foreach ($Products as $value) {
                            if ($value == 'home' || $value == 'sales') {
                            } else {
                                $selected = (($profile['ProductID'] == $value) ? 'selected' : '');
                                */?>
                                <option value="<?/*= $value */?>" <?/*= $selected */?>><?/*= ucwords($value) */?></option>
                            <?php /*}
                        } */?>

                    </select>
                </div>
            </div>-->
            <div class="col-md-12">
                <h5> Products </h5>
            </div>
            <div class="col-md-12">
                <hr style="margin-bottom: 20px;">
            </div>

            <div class="col-md-12">
                <?php foreach ($Products as $value) {
                    if ($value == 'home' || $value == 'sales' || $value == 'hr') {
                    } else {
                        if (in_array($value, $LeadsProducts)) {
                            $checked = 'checked';
                        } else {
                            $checked = '';
                        }
                        ?>
                        <label class="new-checkbox checkbox-primary" style="margin-right: 10px;">
                            <input id="<?= $value ?>" type="checkbox" class="" value="1"
                                   name="Products[<?= $value ?>]" style="margin-right: 7px;" <?= $checked ?> >
                            <span></span><strong><?= ucwords($value) ?></strong>
                        </label>
                    <?php }
                } ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="Status">
        </div>
    </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Discard</button>
        <button id="LeadSaveButton" type="button" class="btn btn-primary" onclick="AddUnassignLeadFormSubmit();">Save
        </button>
    </div>
</form>

<script>
    $("form#AddUnassignLeadForm").on("submit", function (event) {
        event.preventDefault();
    });

    $(document).ready(function () {

        var SelectedLeadCategory = "<?=$SelectedLeadCategory?>";
        var SelectedLeadStatus = "<?=$SelectedLeadStatus?>";
        var SelectedLeadCloseReason = "<?=$SelectedLeadCloseReason?>";
        setTimeout(function () {
            if (SelectedLeadCategory != '') {
                LoadStatusByCategory(SelectedLeadCategory, SelectedLeadStatus);
            }
        }, 250);

        setTimeout(function () {
            if (SelectedLeadStatus != '') {
                ShowCloseReason(SelectedLeadStatus, SelectedLeadCloseReason);
            }
        }, 500);
    });

    function LoadStatusByCategory(Value, Selected = '') {

        if (Value == 'B2B') {

            $("form#AddUnassignLeadForm div#b2bstatusdiv").removeClass('d-none');
            $("form#AddUnassignLeadForm div#b2cstatusdiv").addClass('d-none');

            if (Selected != '') {

                $("form#AddUnassignLeadForm div#b2bstatusdiv select#b2b_leadStatus").val(Selected);
                $("form#AddUnassignLeadForm div#b2cstatusdiv select#b2c_leadStatus").val('');

            } else {
                $("form#AddUnassignLeadForm div#b2bstatusdiv select#b2b_leadStatus").val('');
                $("form#AddUnassignLeadForm div#b2cstatusdiv select#b2c_leadStatus").val('');
            }


        } else {

            $("form#AddUnassignLeadForm div#b2bstatusdiv").addClass('d-none');
            $("form#AddUnassignLeadForm div#b2cstatusdiv").removeClass('d-none');

            if (Selected != '') {
                $("form#AddUnassignLeadForm div#b2bstatusdiv select#b2b_leadStatus").val('');
                $("form#AddUnassignLeadForm div#b2cstatusdiv select#b2c_leadStatus").val(Selected);
            } else {
                $("form#AddUnassignLeadForm div#b2bstatusdiv select#b2b_leadStatus").val('');
                $("form#AddUnassignLeadForm div#b2cstatusdiv select#b2c_leadStatus").val('');
            }
        }

        $("form#AddUnassignLeadForm div#b2bclosereasondiv").addClass('d-none');
        $("form#AddUnassignLeadForm div#b2cclosereasondiv").addClass('d-none');

        $("form#AddUnassignLeadForm div#b2bclosereasondiv select#b2b_close_reason").val('');
        $("form#AddUnassignLeadForm div#b2cclosereasondiv select#b2c_close_reason").val('');
    }

    function ShowCloseReason(Value, Selected = '') {

        var Category = $("form#AddUnassignLeadForm select#lead_category").val();
        if (Value == 'closed_clients') {

            if (Category == 'B2B') {

                $("form#AddUnassignLeadForm div#b2bclosereasondiv").removeClass('d-none');
                $("form#AddUnassignLeadForm div#b2cclosereasondiv").addClass('d-none');

                if (Selected != '') {
                    $("form#AddUnassignLeadForm div#b2bclosereasondiv select#b2b_close_reason").val(Selected);
                    $("form#AddUnassignLeadForm div#b2cclosereasondiv select#b2c_close_reason").val('');

                } else {
                    $("form#AddUnassignLeadForm div#b2bclosereasondiv select#b2b_close_reason").val('');
                    $("form#AddUnassignLeadForm div#b2cclosereasondiv select#b2c_close_reason").val('');
                }

            } else {

                $("form#AddUnassignLeadForm div#b2bclosereasondiv").addClass('d-none');
                $("form#AddUnassignLeadForm div#b2cclosereasondiv").removeClass('d-none');

                if (Selected != '') {
                    $("form#AddUnassignLeadForm div#b2bclosereasondiv select#b2b_close_reason").val('');
                    $("form#AddUnassignLeadForm div#b2cclosereasondiv select#b2c_close_reason").val(Selected);
                } else {
                    $("form#AddUnassignLeadForm div#b2bclosereasondiv select#b2b_close_reason").val('');
                    $("form#AddUnassignLeadForm div#b2cclosereasondiv select#b2c_close_reason").val('');
                }
            }

        } else {

            $("form#AddUnassignLeadForm div#b2bclosereasondiv").addClass('d-none');
            $("form#AddUnassignLeadForm div#b2cclosereasondiv").addClass('d-none');

            $("form#AddUnassignLeadForm div#b2bclosereasondiv select#b2b_close_reason").val('');
            $("form#AddUnassignLeadForm div#b2cclosereasondiv select#b2c_close_reason").val('');
        }
    }

    function AddUnassignLeadFormSubmit() {

        var ContactNumber = $("#ContactNumber").val();
        var WhatsAppNo = $("#WhatsAppNo").val();

        if (ContactNumber == '' && WhatsAppNo == '') {
            $("#Status").html('<div class="text-center alert alert-danger mb-4" role="alert">  <strong> Contact Number And WhatsApp Number Both Cannot Be Empty.</strong> </div>')
            setTimeout(function () {
                $("#Status").html('')
            }, 2000)
        } else {

            $('form#AddUnassignLeadForm button#LeadSaveButton').removeClass('btn-success');
            $('form#AddUnassignLeadForm button#LeadSaveButton').addClass('btn-danger');
            $('form#AddUnassignLeadForm button#LeadSaveButton').html('Plz Wait....');
            $('form#AddUnassignLeadForm button#LeadSaveButton').attr("disabled", true);

            var data = $("form#AddUnassignLeadForm").serialize();
            var response = AjaxResponse("Lead/save_lead_record", data);

            if (response.status == 'success') {

                GridMessages('AddUnassignLeadForm', 'Status', 'alert-success', response.message, 2500);
                setTimeout(function () {

                    $('form#AddUnassignLeadForm')[0].reset();

                    $('form#AddUnassignLeadForm button#LeadSaveButton').addClass('btn-success');
                    $('form#AddUnassignLeadForm button#LeadSaveButton').removeClass('btn-danger');
                    $('form#AddUnassignLeadForm button#LeadSaveButton').html('Save');
                    $('form#AddUnassignLeadForm button#LeadSaveButton').attr("disabled", false);

                    location.reload();
                }, 500);

            } else {

                GridMessages('AddUnassignLeadForm', 'Status', 'alert-danger', response.message, 2500);

                $('form#AddUnassignLeadForm button#LeadSaveButton').addClass('btn-success');
                $('form#AddUnassignLeadForm button#LeadSaveButton').removeClass('btn-danger');
                $('form#AddUnassignLeadForm button#LeadSaveButton').html('Save');
                $('form#AddUnassignLeadForm button#LeadSaveButton').attr("disabled", false);
            }
        }
    }

</script>