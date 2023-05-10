<?php

use App\Models\Crud;

$Crud = new Crud();
$session = session();
$SessionFilters = $session->get('LastThirtyDaysLeadsSessionFilters');
$SalesOfficersData = $Crud->ListRecords('main."Users"', array('UserType' => 'sale-officer', 'Archive' => 0), array('FullName' => 'ASC'));
$SalesOfficer = $Keyword = $DistributionStartDate = $DistributionEndDate = $Status = '';
$OldRecords = 'no';

if (isset($SessionFilters['keyword']) && $SessionFilters['keyword'] != '') {
    $Keyword = $SessionFilters['keyword'];
}

if (isset($SessionFilters['sale_officer']) && $SessionFilters['sale_officer'] != '') {
    $SalesOfficer = $SessionFilters['sale_officer'];
}

if (isset($SessionFilters['status']) && $SessionFilters['status'] != '') {
    $Status = $SessionFilters['status'];
}

if (isset($SessionFilters['old_record']) && $SessionFilters['old_record'] != '') {
    $OldRecords = $SessionFilters['old_record'];
}

if (isset($SessionFilters['distribution_start_date']) && $SessionFilters['distribution_start_date'] != '') {
    $DistributionStartDate = $SessionFilters['distribution_start_date'];
}

if (isset($SessionFilters['distribution_end_date']) && $SessionFilters['distribution_end_date'] != '') {
    $DistributionEndDate = $SessionFilters['distribution_end_date'];
}
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">
                    <b style="color:darkgoldenrod !important;">"<?= ucwords($product_name) ?>"</b> Last 30 Days Leads
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
                                      onsubmit="LastThirtyDaysLeadsSessionFiltersFormSubmit( 'LastThirtyDaysLeadsSessionFiltersForm' ); return false;"
                                      class="section contact" name="LastThirtyDaysLeadsSessionFiltersForm"
                                      id="LastThirtyDaysLeadsSessionFiltersForm">
                                    <input type="hidden" name="SessionKey" id="SessionKey"
                                           value="LastThirtyDaysLeadsSessionFilters">
                                    <input type="hidden" name="distribution_start_date" id="distribution_start_date"
                                           value="<?= $DistributionStartDate ?>">
                                    <input type="hidden" name="distribution_end_date" id="distribution_end_date"
                                           value="<?= $DistributionEndDate ?>">
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
                                            <div class="form-group">
                                                <label for="country">Distribution Date</label>
                                                <input type="text"
                                                       class="form-control multidate"
                                                       name="lead_distribution_date" id="lead_distribution_date"
                                                       placeholder="Distribution Dates" value=""
                                                       onchange="GetLeadDistributionDate();">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Old Records</label>
                                                <select class="form-control" id="old_record"
                                                        name="old_record">
                                                    <option <?= ((isset($OldRecords) && $OldRecords == 'no') ? 'selected' : '') ?>
                                                            value="no">Last 30 Days Leads
                                                    </option>
                                                    <option <?= ((isset($OldRecords) && $OldRecords == 'yes') ? 'selected' : '') ?>
                                                            value="yes">All
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="LastThirtyDaysLeadsSessionFiltersFormSubmit( 'LastThirtyDaysLeadsSessionFiltersForm' );"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('LastThirtyDaysLeadsSessionFilters');"
                                                        id="btnreset" type="button" class="btn btn-danger">Clear
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="LastThirtyDaysLeadFilterAjaxResult"></div>
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
                        <table id="LastMonthLeadRecords" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Ref.ID</th>
                                <th>Submitted On</th>
                                <th>Created On</th>
                                <th>Status</th>
                                <th>Sale Officer</th>
                                <th>Distribution DateTime</th>
                                <th>Full Name</th>
                                <th>Contact</th>
                                <th>WhatsApp No</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            /*                                for ($i = 1; $i < 10; $i++) {

                                                                echo '<tr>
                                                                        <td>' . $i . '</td>
                                                                        <td>Pakistan</td>
                                                                        <td>Dummy IATA Name</td>
                                                                        <td>4234</td>
                                                                        <td>98</td>
                                                                        <td>23 Apr, 2021</td>
                                                                        <td>ISB</td>
                                                                        <td>5 Star</td>
                                                                         <td>Al Furas</td>
                                                                         <td>Sharing</td>
                                                                        <td>5</td>
                                                                        <td>17</td>
                                                                        <td>15</td>
                                                                        <td>5</td>
                                                                        <td>5</td>
                                                                        <td>10:00 am</td>
                                                                        <td>Dummy</td>
                                                                        <td>0336564646</td>
                                                                        <td>b2c</td>
                                                                        <td>Usman Khan</td>
                                                                    </tr> ';
                                                            }
                                                        */ ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" language="javascript">
    $(document).ready(function () {

        setTimeout(function () {

            var DistributionStartDate = "<?=$DistributionStartDate?>";
            var DistributionEndDate = "<?=$DistributionEndDate?>";
            $("#distribution_start_date").val(DistributionStartDate);
            $("#distribution_end_date").val(DistributionEndDate);
            if (DistributionStartDate != '' && DistributionEndDate != '') {
                $("#lead_distribution_date").val(DistributionStartDate + " to " + DistributionEndDate);
            } else {
                $("form#LastThirtyDaysLeadsSessionFiltersForm input#distribution_start_date").val('');
                $("form#LastThirtyDaysLeadsSessionFiltersForm input#distribution_end_date").val('');
            }
        }, 1000);

        var product_name = '<?= $product_name ?>';
        $('#LastMonthLeadRecords').DataTable({
            "searching": false,
            "processing": true,
            "pageLength": 100,
            "serverSide": true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, 'All']],
            "ajax": {
                url: "<?= $path ?>lead/get_last_month_product_data",
                type: 'POST',
                data: {product: product_name}
            }
        });
    });

    function GetLeadDistributionDate() {
        const LeadDistributionDate = $("#lead_distribution_date").val();
        const words = LeadDistributionDate.split(' to ');
        $("#distribution_start_date").val(words[0]);
        $("#distribution_end_date").val(words[1]);
    }

    function LastThirtyDaysLeadsSessionFiltersFormSubmit(parent) {

        var dataTable = $('#LastMonthLeadRecords').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {
            GridMessages(parent, 'LastThirtyDaysLeadFilterAjaxResult', 'alert-success', rslt.msg, 1500);
            setTimeout(function () {
                dataTable.ajax.reload();
            }, 2000);
        }
    }

    function ClearSession(SessionKey) {

        var dataTable = $('#LastMonthLeadRecords').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('LastThirtyDaysLeadsSessionFiltersForm', 'LastThirtyDaysLeadFilterAjaxResult', 'alert-success', rslt.msg, 1500);
            $("form#LastThirtyDaysLeadsSessionFiltersForm input#distribution_start_date").val('');
            $("form#LastThirtyDaysLeadsSessionFiltersForm input#distribution_end_date").val('');
            $("form#LastThirtyDaysLeadsSessionFiltersForm")[0].reset();

            setTimeout(function () {
                $("form#LastThirtyDaysLeadsSessionFiltersForm select#old_record").val('no');
                dataTable.ajax.reload();
            }, 2000);
        }
    }
</script>

