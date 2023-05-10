<?php

use App\Models\Crud;

$Crud = new Crud();
$session = session();
$SessionFilters = $session->get('PersonalLeadsSessionFilters');
$SalesOfficersData = $Crud->ListRecords('main."Users"', array('UserType' => 'sale-officer', 'Archive' => 0), array('FullName' => 'ASC'));
$SalesOfficer = $Keyword = $CreateStartDate = $CreateEndDate = $DistributionStartDate = $DistributionEndDate = '';

if (isset($SessionFilters['keyword']) && $SessionFilters['keyword'] != '') {
    $Keyword = $SessionFilters['keyword'];
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
                    <b style="color:darkgoldenrod !important;">"<?= ucwords($product_name) ?>"</b> Personal Leads
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
                                      onsubmit="PersonalLeadsFiltersFormSubmit( 'PersonalLeadsSearchFilterForm' ); return false;"
                                      class="section contact" name="PersonalLeadsSearchFilterForm"
                                      id="PersonalLeadsSearchFilterForm">
                                    <input type="hidden" name="SessionKey" id="SessionKey"
                                           value="PersonalLeadsSessionFilters">
                                    <input type="hidden" name="create_start_date" id="create_start_date"
                                           value="<?=$CreateStartDate?>">
                                    <input type="hidden" name="create_end_date" id="create_end_date"
                                           value="<?=$CreateEndDate?>">
                                    <input type="hidden" name="distribution_start_date" id="distribution_start_date"
                                           value="<?=$DistributionStartDate?>">
                                    <input type="hidden" name="distribution_end_date" id="distribution_end_date"
                                           value="<?=$DistributionEndDate?>">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Keyword <small style="font-weight: bold; font-size: 10px;">(
                                                        FullName, Email, Contact, WhatsApp )</small></label>
                                                <input value="<?=$Keyword?>" type="text" id="keyword" name="keyword"
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
                                                        echo '<option '.( ( isset($SalesOfficer) && $SalesOfficer != '' )? 'selected' : '' ).'  value="' . $SOD['UID'] . '">' . $SOD['FullName'] . '</option>';
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
                                        <div class="col-md-3" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="PersonalLeadsFiltersFormSubmit( 'PersonalLeadsSearchFilterForm' );"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('PersonalLeadsSessionFilters');"
                                                        id="btnreset" type="button" class="btn btn-danger">Clear
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="PersonalLeadFilterAjaxResult"></div>
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
                        <table id="PersonalLeadRecord" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ref.ID</th>
                                <th>Submitted On</th>
                                <th>Created On</th>
                                <th>Sale Officer</th>
                                <th>Distribution DateTime</th>
                                <th>Full Name</th>
                                <th>Contact</th>
                                <th>WhatsApp No</th>
                                <th>Status</th>
                                <th>Lead Category</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" language="javascript">
    $(document).ready(function () {

        setTimeout(function () {

            var CreateStartDate = "<?=$CreateStartDate?>";
            var CreateEndDate = "<?=$CreateEndDate?>";
            $("#create_start_date").val(CreateStartDate);
            $("#create_end_date").val(CreateEndDate);
            if (CreateStartDate != '' && CreateEndDate != '') {
                $("#lead_create_date").val(CreateStartDate + " to " + CreateEndDate);
            } else {
                $("form#PersonalLeadsSearchFilterForm input#create_start_date").val('');
                $("form#PersonalLeadsSearchFilterForm input#create_end_date").val('');
            }

            var DistributionStartDate = "<?=$DistributionStartDate?>";
            var DistributionEndDate = "<?=$DistributionEndDate?>";
            $("#distribution_start_date").val(DistributionStartDate);
            $("#distribution_end_date").val(DistributionEndDate);
            if (DistributionStartDate != '' && DistributionEndDate != '') {
                $("#lead_distribution_date").val(DistributionStartDate + " to " + DistributionEndDate);
            } else {
                $("form#PersonalLeadsSearchFilterForm input#distribution_start_date").val('');
                $("form#PersonalLeadsSearchFilterForm input#distribution_end_date").val('');
            }

        }, 1000);

        var product_name = '<?= $product_name ?>';
        $('#PersonalLeadRecord').DataTable({
            "searching": false,
            "processing": true,
            "pageLength": 100,
            "serverSide": true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, 'All']],
            "ajax": {
                url: "<?= $path ?>lead/fetch_personal_data",
                type: 'POST',
                data: {productname: product_name}
            }
        });
    });

    function GetLeadCreateDate() {
        const LeadCreateDate = $("#lead_create_date").val();
        const words = LeadCreateDate.split(' to ');
        $("#create_start_date").val(words[0]);
        $("#create_end_date").val(words[1]);
    }

    function GetLeadDistributionDate() {
        const LeadDistributionDate = $("#lead_distribution_date").val();
        const words = LeadDistributionDate.split(' to ');
        $("#distribution_start_date").val(words[0]);
        $("#distribution_end_date").val(words[1]);
    }

    function PersonalLeadsFiltersFormSubmit(parent) {

        var dataTable = $('#PersonalLeadRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {
            GridMessages(parent, 'PersonalLeadFilterAjaxResult', 'alert-success', rslt.msg, 1500);
            setTimeout(function () {
                dataTable.ajax.reload();
            }, 2000);
        }
    }

    function ClearSession(SessionKey) {

        var dataTable = $('#PersonalLeadRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('PersonalLeadsSearchFilterForm', 'PersonalLeadFilterAjaxResult', 'alert-success', rslt.msg, 1500);
            $("form#PersonalLeadsSearchFilterForm input#create_start_date").val('');
            $("form#PersonalLeadsSearchFilterForm input#create_end_date").val('');
            $("form#PersonalLeadsSearchFilterForm input#distribution_start_date").val('');
            $("form#PersonalLeadsSearchFilterForm input#distribution_end_date").val('');
            $("form#PersonalLeadsSearchFilterForm")[0].reset();
            setTimeout(function () {
                dataTable.ajax.reload();
            }, 2000);
        }
    }


</script>
