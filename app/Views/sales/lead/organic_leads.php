<?php

use App\Models\Crud;

$Crud = new Crud();
$session = session();
$SessionFilters = $session->get('OrganicLeadsSessionFilter');
$SalesOfficersData = $Crud->ListRecords('main."Users"', array('UserType' => 'sale-officer', 'Archive' => 0), array('FullName' => 'ASC'));
$SalesOfficer = $Keyword = $DistributionStartDate = $DistributionEndDate = $Status = $Product =  '';

if (isset($SessionFilters['keyword']) && $SessionFilters['keyword'] != '') {
    $Keyword = $SessionFilters['keyword'];
}

if (isset($SessionFilters['sale_officer']) && $SessionFilters['sale_officer'] != '') {
    $SalesOfficer = $SessionFilters['sale_officer'];
}

if (isset($SessionFilters['status']) && $SessionFilters['status'] != '') {
    $Status = $SessionFilters['status'];
}

if (isset($SessionFilters['product']) && $SessionFilters['product'] != '') {
    $Product = $SessionFilters['product'];
}


if (isset($SessionFilters['create_start_date']) && $SessionFilters['create_start_date'] != '') {
    $CreateStartDate = $SessionFilters['create_start_date'];
}

if (isset($SessionFilters['create_end_date']) && $SessionFilters['create_end_date'] != '') {
    $CreateEndDate = $SessionFilters['create_end_date'];
}
?>
<h4 class="page-head"></h4>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head"> Organic Leads
                    <button type="button" class="btn btn_customized btn-sm float-right"
                            onclick="LoadModal('sales/add_organic_lead_form', 0,'modal-lg')">Add Organic Lead
                    </button>

                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <div id="toggleAccordion">
                    <div class="card">
                        <div class="card-header">
                            <section class="mb-0 mt-0">
                                <div role="menu" class="" data-toggle="collapse"
                                     data-target="#FilterDetails" aria-expanded="true"
                                     aria-controls="FilterDetails">
                                    Filters
                                </div>
                            </section>
                        </div>
                        <div id="FilterDetails" class="collapse show " aria-labelledby=""
                             data-parent="#toggleAccordion">
                            <div class="card-body">
                                <form method="post"
                                      onsubmit="OrganicLeadsSessionFilterFormSubmit( 'OrganicLeadsSessionFilterForm' ); return false;"
                                      class="section contact" name="OrganicLeadsSessionFilterForm"
                                      id="OrganicLeadsSessionFilterForm">
                                    <input type="hidden" name="SessionKey" id="SessionKey"
                                           value="OrganicLeadsSessionFilter">
                                    <input type="hidden" name="create_start_date" id="create_start_date"
                                           value="<?= $CreateStartDate ?>">
                                    <input type="hidden" name="create_end_date" id="create_end_date"
                                           value="<?= $CreateEndDate ?>">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Keyword <small style="font-weight: bold; font-size: 10px;">(
                                                        FullName, Email, Contact, WhatsApp )</small></label>
                                                <input value="<?= $Keyword ?>" type="text" id="keyword" name="keyword"
                                                       placeholder="Keyword"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Sale Officer</label>
                                                <select class="form-control" id="sale_officer"
                                                        name="sale_officer">
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    foreach ($SalesOfficersData as $SOD) {
                                                        echo '<option ' . (($SalesOfficer == $SOD['UID']) ? 'selected' : '') . ' value="' . $SOD['UID'] . '">' . $SOD['FullName'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Status</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="">Select Status</option>
                                                    <?php
                                                    $LeadStatusArray = \App\Models\Main::LeadStatusArray();
                                                    foreach ($LeadStatusArray as $key => $value) {
                                                        echo '<option ' . ((isset($Status) && $Status == $key) ? 'selected' : '') . ' value="' . $key . '">' . $value . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group mb-3">
                                                <label for="Products">Products </label>
                                                <select class="form-control validate[required]" id="product"
                                                        name="product">
                                                    <option value="" selected disabled> Select Product</option>
                                                    <?php foreach ($Products as $value) {
                                                        if ($value == 'home' || $value == 'sales') {
                                                        } else {
                                                            $selected = (($Product == $value) ? 'selected' : '');
                                                            ?>
                                                            <option value="<?= $value ?>" <?= $selected ?>> <?= ucwords($value) ?></option>
                                                        <?php }
                                                    } ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Created Date</label>
                                                <input type="text"
                                                       class="form-control multidate "
                                                       name="lead_create_date" id="lead_create_date"
                                                       placeholder="Create Dates" value=""
                                                       onchange="GetLeadCreateDate();">
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="OrganicLeadsSessionFilterFormSubmit('OrganicLeadsSessionFilterForm');"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('OrganicLeadsSessionFilter');"
                                                        id="btnreset" type="button" class="btn btn-danger">Clear
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="OrganicLeadsSessionAjaxFilterForm"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <table id="OrganicLeads" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ref.ID</th>
                                <th>Submitted On</th>
                                <th>Created On</th>
                                <th>Product</th>
                                <th>Sales Officer</th>
                                <th>Full Name</th>
                                <th>Contact</th>
                                <th>WhatsApp No</th>
                                <th>Facebook</th>
                                <th>Instagram</th>
                                <th>Twitter</th>
                                <th>LinkedIn</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    $(document).ready(function () {

        setTimeout(function () {

            var CreateStartDate = "<?=$CreateStartDate?>";
            var CreateEndDate = "<?=$CreateEndDate?>";
            $("#create_start_date").val(CreateStartDate);
            $("#create_end_date").val(CreateEndDate);
            if (CreateStartDate != '' && CreateEndDate != '') {
                $("#lead_create_date").val(CreateStartDate + " to " + CreateEndDate);
            } else {
                $("form#OrganicLeadsSessionFilterForm input#create_start_date").val('');
                $("form#OrganicLeadsSessionFilterForm input#create_end_date").val('');
            }
        }, 1000);


        $('#OrganicLeads').DataTable({
            "processing": true,
            "pageLength": 100,
            "searching": false,
            "serverSide": true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
            "ajax": {
                url: '<?=$path?>lead/fetch_all_unorganic_lead',
                type: 'POST',
            }
        });
    });


    // setTimeout(function () {
    //     $('<a href="#" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    // }, 100);


    function RemoveOrganicLead(LeadUID) {
        if (confirm("Do You Want to Delete Organic Lead")) {
            var rslt = AjaxResponse('lead/remove_organic_lead', 'LeadUID=' + LeadUID);
            if (rslt.status == 'success') {
                setTimeout(function () {
                    location.reload();
                }, 1500);
            }
        }
    }


    function GetLeadCreateDate() {
        const LeadCreateDate = $("#lead_create_date").val();
        const words = LeadCreateDate.split(' to ');
        $("#create_start_date").val(words[0]);
        $("#create_end_date").val(words[1]);
    }

    function OrganicLeadsSessionFilterFormSubmit(parent) {

        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {
            GridMessages(parent, 'OrganicLeadsSessionAjaxFilterForm', 'alert-success', rslt.msg, 1500);
            setTimeout(function () {
                location.reload();
            }, 2000);
        }
    }

    function ClearSession(SessionKey) {

        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {
            GridMessages('OrganicLeadsSessionFilterForm', 'OrganicLeadsSessionAjaxFilterForm', 'alert-success', rslt.msg, 1500);
            $("form#OrganicLeadsSessionFilterForm input#create_start_date").val('');
            $("form#OrganicLeadsSessionFilterForm input#create_end_date").val('');
            $("form#OrganicLeadsSessionFilterForm")[0].reset();
            setTimeout(function () {
                location.reload();
            }, 2000);
        }
    }

</script>
