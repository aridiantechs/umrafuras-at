<?php
$session = session();
$UserUID = $session->get('id');

use App\Models\Crud;

$Crud = new Crud();

$head = 'Add ';
$update_id = 0;
$LeadsProducts = array();
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
    $LeadData = $records['OrganicLeads'];
    $LeadsMeta = $records['LeadsMeta'];
    $LeadsProducts = $records['leads_products'];

}
$SelectedLeadCategory = ((isset($LeadData['LeadCategory']) && $LeadData['LeadCategory'] != '') ? $LeadData['LeadCategory'] : '');
$SelectedLeadStatus = ((isset($LeadData['Status']) && $LeadData['Status'] != '') ? $LeadData['Status'] : '');
$SelectedLeadCloseReason = ((isset($LeadData['CloseReason']) && $LeadData['CloseReason'] != '') ? $LeadData['CloseReason'] : '');
//print_r($LeadsMeta);exit;

?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?=$head?> Organic lead</h5>
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
<form class="validate" method="post" action="#" name="OrganicLeadsAddForm" id="OrganicLeadsAddForm"
      onsubmit="OrganicLeadsFormSubmit('OrganicLeadsAddForm'); return false;">
    <input type="hidden" name="UID" id="UID" value="<?=$LeadData['UID']?>">
    <input type="hidden" name="SalesOfficer" id="SalesOfficer" value="<?= $UserUID ?>">
    <input type="hidden" name="CreateDate" id="CreateDate" value="<?= date("Y-m-d") ?>">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="Name">Full Name</label>
                    <input type="text" class="form-control validate[required]" id="FullName" name="FullName"
                           placeholder="Full Name" value="<?=$LeadData['FullName']?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="Name">Contact Number</label>
                    <input type="number" min="1" class="form-control" id="ContactNumber" name="ContactNumber"
                           placeholder="Contact Number" maxlength="16" minlength="13" value="<?=$LeadData['ContactNo']?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="Name">WhatsApp No </label>
                    <input type="number" min="1" class="form-control" id="WhatsAppNo" name="WhatsAppNo"
                           placeholder="WhatsApp No" maxlength="16" minlength="13" value="<?=$LeadData['WhatsAppNo']?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="Name">Email </label>
                    <input type="email" class="form-control" name="Email"
                           placeholder="Email" value="<?=$LeadData['Email']?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label>Lead Category</label>
                    <select onchange="LoadStatusByCategories(this.value);" class="form-control" id="lead_category"
                            name="lead_category">
                        <option <?= (($SelectedLeadCategory == 'B2B') ? 'selected' : '') ?> value="B2B">B2B</option>
                        <option <?= (($SelectedLeadCategory == 'B2C') ? 'selected' : '') ?> value="B2C">B2C</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4" id="b2bstatusdiv">
                <div class="form-group mb-3">
                    <label>Lead Status </label>
                    <select onchange="ShowCloseReasons(this.value);" class="form-control" id="b2b_leadStatus"
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
                    <select onchange="ShowCloseReasons(this.value);" class="form-control" id="b2c_leadStatus"
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

            <!--<div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="projects">Product</label>
                    <select class="form-control validate[required]" id="Product"
                            name="Product">
                        <option value="">Please Select</option>
                        <?php /*foreach ($Products as $value) {
                            if ($value == 'home' || $value == 'sales') {
                            } else {
                                $selected = (($LeadData['ProductID']) == $value ? 'selected' : ''); */?>
                                <option value="<?/*= $value */?>" <?/*=$selected*/?>> <?/*= ucwords($value) */?></option>
                            <?php /*}
                        } */?>

                    </select>
                </div>
            </div>-->

            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="Name">Instagram</label>
                    <input type="text" class="form-control" name="Instagram" id="Instagram"
                           placeholder="Instagram" value="<?=$LeadsMeta['Instagram']?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="Name">Facebook</label>
                    <input type="text" class="form-control" name="Facebook" id="Facebook"
                           placeholder="Facebook" value="<?=$LeadsMeta['Facebook']?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="Name">Twitter</label>
                    <input type="text" class="form-control" name="Twitter" id="Twitter"
                           placeholder="Twitter" value="<?=$LeadsMeta['Twitter']?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="Name">Linked In</label>
                    <input type="text" class="form-control" name="LinkedIn" id="LinkedIn"
                           placeholder="LinkedIn" value="<?=$LeadsMeta['LinkedIn']?>">
                </div>
            </div>

            <div class="col-md-12">
                <h5> Products </h5>
            </div>
            <div class="col-md-12">
                <hr style="margin-bottom: 20px;">
            </div>

            <div class="col-md-12">
                <?php foreach ($Products as $value) {
                    if ($value == 'home' || $value == 'sales') {
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
            <div class="col-md-12">
                <div class="form-group" id="OrganicLeadsAddAjaxResponse"></div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Discard</button>
        <button id="LeadSaveButton" type="button" class="btn btn-primary" onclick="OrganicLeadsFormSubmit('OrganicLeadsAddForm');">Save
        </button>
    </div>
</form>


<script type="text/javascript">

    $(document).ready(function () {

        var SelectedLeadCategory = "<?=$SelectedLeadCategory?>";
        var SelectedLeadStatus = "<?=$SelectedLeadStatus?>";
        var SelectedLeadCloseReason = "<?=$SelectedLeadCloseReason?>";
        setTimeout(function () {
            if (SelectedLeadCategory != '') {
                LoadStatusByCategories(SelectedLeadCategory, SelectedLeadStatus);
            }
        }, 250);

        setTimeout(function () {
            if (SelectedLeadStatus != '') {
                ShowCloseReasons(SelectedLeadStatus, SelectedLeadCloseReason);
            }
        }, 500);
    });

    function LoadStatusByCategories(Value, Selected = '') {

        if (Value == 'B2B') {

            $("form#OrganicLeadsAddForm div#b2bstatusdiv").removeClass('d-none');
            $("form#OrganicLeadsAddForm div#b2cstatusdiv").addClass('d-none');

            if (Selected != '') {

                $("form#OrganicLeadsAddForm div#b2bstatusdiv select#b2b_leadStatus").val(Selected);
                $("form#OrganicLeadsAddForm div#b2cstatusdiv select#b2c_leadStatus").val('');

            } else {
                $("form#OrganicLeadsAddForm div#b2bstatusdiv select#b2b_leadStatus").val('');
                $("form#OrganicLeadsAddForm div#b2cstatusdiv select#b2c_leadStatus").val('');
            }


        } else {

            $("form#OrganicLeadsAddForm div#b2bstatusdiv").addClass('d-none');
            $("form#OrganicLeadsAddForm div#b2cstatusdiv").removeClass('d-none');

            if (Selected != '') {
                $("form#OrganicLeadsAddForm div#b2bstatusdiv select#b2b_leadStatus").val('');
                $("form#OrganicLeadsAddForm div#b2cstatusdiv select#b2c_leadStatus").val(Selected);
            } else {
                $("form#OrganicLeadsAddForm div#b2bstatusdiv select#b2b_leadStatus").val('');
                $("form#OrganicLeadsAddForm div#b2cstatusdiv select#b2c_leadStatus").val('');
            }
        }

        $("form#OrganicLeadsAddForm div#b2bclosereasondiv").addClass('d-none');
        $("form#OrganicLeadsAddForm div#b2cclosereasondiv").addClass('d-none');

        $("form#OrganicLeadsAddForm div#b2bclosereasondiv select#b2b_close_reason").val('');
        $("form#OrganicLeadsAddForm div#b2cclosereasondiv select#b2c_close_reason").val('');
    }

    function ShowCloseReasons(Value, Selected = '') {

        var Category = $("form#OrganicLeadsAddForm select#lead_category").val();
        if (Value == 'closed_clients') {

            if (Category == 'B2B') {

                $("form#OrganicLeadsAddForm div#b2bclosereasondiv").removeClass('d-none');
                $("form#OrganicLeadsAddForm div#b2cclosereasondiv").addClass('d-none');

                if (Selected != '') {
                    $("form#OrganicLeadsAddForm div#b2bclosereasondiv select#b2b_close_reason").val(Selected);
                    $("form#OrganicLeadsAddForm div#b2cclosereasondiv select#b2c_close_reason").val('');

                } else {
                    $("form#OrganicLeadsAddForm div#b2bclosereasondiv select#b2b_close_reason").val('');
                    $("form#OrganicLeadsAddForm div#b2cclosereasondiv select#b2c_close_reason").val('');
                }

            } else {

                $("form#OrganicLeadsAddForm div#b2bclosereasondiv").addClass('d-none');
                $("form#OrganicLeadsAddForm div#b2cclosereasondiv").removeClass('d-none');

                if (Selected != '') {
                    $("form#OrganicLeadsAddForm div#b2bclosereasondiv select#b2b_close_reason").val('');
                    $("form#OrganicLeadsAddForm div#b2cclosereasondiv select#b2c_close_reason").val(Selected);
                } else {
                    $("form#OrganicLeadsAddForm div#b2bclosereasondiv select#b2b_close_reason").val('');
                    $("form#OrganicLeadsAddForm div#b2cclosereasondiv select#b2c_close_reason").val('');
                }
            }

        } else {

            $("form#OrganicLeadsAddForm div#b2bclosereasondiv").addClass('d-none');
            $("form#OrganicLeadsAddForm div#b2cclosereasondiv").addClass('d-none');

            $("form#OrganicLeadsAddForm div#b2bclosereasondiv select#b2b_close_reason").val('');
            $("form#OrganicLeadsAddForm div#b2cclosereasondiv select#b2c_close_reason").val('');
        }
    }

    function OrganicLeadsFormSubmit(parent) {

        var ContactNumber = $("form#OrganicLeadsAddForm input#ContactNumber").val();
        var WhatsAppNo = $("form#OrganicLeadsAddForm input#WhatsAppNo").val();

        var Facebook = $("form#OrganicLeadsAddForm input#Facebook").val();
        var Linkedln = $("form#OrganicLeadsAddForm input#LinkedIn").val();
        var Twitter = $("form#OrganicLeadsAddForm input#Twitter").val();
        var Instagram = $("form#OrganicLeadsAddForm input#Instagram").val();
        var Product = $("form#OrganicLeadsAddForm select#Product").val();

        // alert(Instagram);

        if (ContactNumber == '' && WhatsAppNo == '') {
            GridMessages('OrganicLeadsAddForm', 'OrganicLeadsAddAjaxResponse', 'alert alert-danger', 'Contact Number And WhatsApp Number Both Cannot Be Empty', 2500);
            return false;
        } else if (Facebook == '' && Linkedln == '' && Twitter == '' && Instagram == '') {
            GridMessages('OrganicLeadsAddForm', 'OrganicLeadsAddAjaxResponse', 'alert alert-danger', 'Kindly Add Atleast One Social Link', 2500);
            return false;
        }
        else if (Product == '') {
            GridMessages('OrganicLeadsAddForm', 'OrganicLeadsAddAjaxResponse', 'alert alert-danger', 'Product Cannot Be Empty', 2500);
            return false;
        } else {

            $('form#OrganicLeadsAddForm button#LeadSaveButton').removeClass('btn-success');
            $('form#OrganicLeadsAddForm button#LeadSaveButton').addClass('btn-danger');
            $('form#OrganicLeadsAddForm button#LeadSaveButton').html('Plz Wait....');
            $('form#OrganicLeadsAddForm button#LeadSaveButton').attr("disabled", true);

            var data = $("form#" + parent).serialize();
            var rslt = AjaxResponse('lead/organic_leads_form_submit', data);
            if (rslt.status == 'success') {
                GridMessages('OrganicLeadsAddForm', 'OrganicLeadsAddAjaxResponse', 'alert alert-success', rslt.message, 2000);
                setTimeout(function () {
                    $("form#" + parent)[0].reset();
                    location.reload();
                }, 300);

            } else {

                GridMessages('OrganicLeadsAddForm', 'OrganicLeadsAddAjaxResponse', 'alert alert-danger', rslt.message, 2000);
                $('form#OrganicLeadsAddForm button#LeadSaveButton').addClass('btn-success');
                $('form#OrganicLeadsAddForm button#LeadSaveButton').removeClass('btn-danger');
                $('form#OrganicLeadsAddForm button#LeadSaveButton').html('Save');
                $('form#OrganicLeadsAddForm button#LeadSaveButton').attr("disabled", false);

            }
        }
    }


</script>