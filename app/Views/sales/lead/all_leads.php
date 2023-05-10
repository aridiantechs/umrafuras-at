<?php

use App\Models\Crud;

$Crud = new Crud();
$session = session();
$SessionFilters = $session->get('AllLeadsRecordSessionFilters');
$SalesOfficersData = $Crud->ListRecords('main."Users"', array('UserType' => 'sale-officer', 'Archive' => 0), array('FullName' => 'ASC'));
$SearchProduct = $SalesOfficer = $Keyword = $CreateStartDate = $CreateEndDate = '';

if (isset($SessionFilters['keyword']) && $SessionFilters['keyword'] != '') {
    $Keyword = $SessionFilters['keyword'];
}

if (isset($SessionFilters['product']) && $SessionFilters['product'] != '') {
    $SearchProduct = $SessionFilters['product'];
}

if (isset($SessionFilters['sale_officer']) && $SessionFilters['sale_officer'] != '') {
    $SalesOfficer = $SessionFilters['sale_officer'];
}

if (isset($SessionFilters['create_start_date']) && $SessionFilters['create_start_date'] != '') {
    $CreateStartDate = $SessionFilters['create_start_date'];
}

if (isset($SessionFilters['create_end_date']) && $SessionFilters['create_end_date'] != '') {
    $CreateEndDate = $SessionFilters['create_end_date'];
}

?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">All Leads</h4>
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
                                      onsubmit="AllLeadsRecordFiltersFormSubmit( 'AllLeadsRecordSearchFilterForm' ); return false;"
                                      class="section contact" name="AllLeadsRecordSearchFilterForm"
                                      id="AllLeadsRecordSearchFilterForm">
                                    <input type="hidden" name="SessionKey" id="SessionKey"
                                           value="AllLeadsRecordSessionFilters">
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
                                                <label>Products</label>
                                                <select class="form-control" id="product"
                                                        name="product">
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    foreach ($Products as $Product) {
                                                        if($Product != 'home' && $Product != 'sales'){
                                                            echo '<option ' . (($SearchProduct == $Product) ? 'selected' : '') . '  value="' . $Product . '">' . ucwords($Product) . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
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
                                                <label for="country">Created Date</label>
                                                <input type="text"
                                                       class="form-control multidate "
                                                       name="lead_create_date" id="lead_create_date"
                                                       placeholder="Create Dates" value=""
                                                       onchange="GetLeadCreateDate();">
                                            </div>
                                        </div>
                                        <div class="col-md-3" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="AllLeadsRecordFiltersFormSubmit( 'AllLeadsRecordSearchFilterForm' );"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('AllLeadsRecordSessionFilters');"
                                                        id="btnreset" type="button" class="btn btn-danger">Clear
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="AllLeadRecordFilterAjaxResult"></div>
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
                         <table id="AllLeadsRecord" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ref.ID</th>
                                <th>Submitted On</th>
                                <th>Sale Officer</th>
                                <th>Assign Date</th>
                                <th>Full Name</th>
                                <th>Products</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
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
                $("form#AllLeadsRecordSearchFilterForm input#create_start_date").val('');
                $("form#AllLeadsRecordSearchFilterForm input#create_end_date").val('');
            }

        }, 1000);

        var dataTable = $('#AllLeadsRecord').DataTable({
            "processing": true,
            "searching": true,
            "responsive": true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, 'All']],
            "pageLength": 100,
            "lengthChange": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ All Leads Record",
                "info": "Showing _START_ to _END_ of _TOTAL_ All Leads Record",
            },
            "ajax": {
                url: "<?= $path ?>lead/fetch_all_leads_record",
                type: "POST",
            },
            "columnDefs": [
                {
                    "defaultContent": "-",
                    "targets": "_all",
                    "orderable": false,
                },
            ],
        });
    });

    function GetLeadCreateDate() {
        const LeadCreateDate = $("#lead_create_date").val();
        const words = LeadCreateDate.split(' to ');
        $("#create_start_date").val(words[0]);
        $("#create_end_date").val(words[1]);
    }

    function AllLeadsRecordFiltersFormSubmit(parent) {

        var dataTable = $('#AllLeadsRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {
            GridMessages(parent, 'AllLeadRecordFilterAjaxResult', 'alert-success', rslt.msg, 1500);
            setTimeout(function () {
                dataTable.ajax.reload();
            }, 2000);
        }
    }

    function ClearSession(SessionKey) {

        var dataTable = $('#AllLeadsRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('AllLeadsRecordSearchFilterForm', 'AllLeadRecordFilterAjaxResult', 'alert-success', rslt.msg, 1500);
            $("form#AllLeadsRecordSearchFilterForm input#create_start_date").val('');
            $("form#AllLeadsRecordSearchFilterForm input#create_end_date").val('');
            $("form#AllLeadsRecordSearchFilterForm")[0].reset();
            setTimeout(function () {
                dataTable.ajax.reload();
            }, 2000);
        }
    }

</script>
