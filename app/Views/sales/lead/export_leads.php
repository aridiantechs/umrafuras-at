<?php

use App\Models\Crud;

$Crud = new Crud();
$SalesOfficersData = $Crud->ListRecords('main."Users"', array('UserType' => 'sale-officer', 'Archive' => 0), array('FullName' => 'ASC'));
$session = session();
$SessionFilters = $session->get('LeadsExportsSessionFilters');
$SalesOfficer = $Product = $Keyword = $Status = $ExportsStartDate = $ExportsEndDate = '';
if (isset($SessionFilters['keyword']) && $SessionFilters['keyword'] != '') {
    $Keyword = $SessionFilters['keyword'];
}

if (isset($SessionFilters['sale_officer']) && $SessionFilters['sale_officer'] != '') {
    $SalesOfficer = $SessionFilters['sale_officer'];
}

if (isset($SessionFilters['productname']) && $SessionFilters['productname'] != '') {
    $Product = $SessionFilters['productname'];
}
if (isset($SessionFilters['statusname']) && $SessionFilters['statusname'] != '') {
    $Status = $SessionFilters['statusname'];
}

if (isset($SessionFilters['exports_start_date']) && $SessionFilters['exports_start_date'] != '') {
    $ExportsStartDate = $SessionFilters['exports_start_date'];
}

if (isset($SessionFilters['exports_end_date']) && $SessionFilters['exports_end_date'] != '') {
    $ExportsEndDate = $SessionFilters['exports_end_date'];
}


?>
<h4 class="page-head"></h4>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head"> Export Leads

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
                                      onsubmit="LeadsExportsFiltersFormSubmit( 'LeadsExportsSearchFilterForm' ); return false;"
                                      class="section contact" name="LeadsExportsSearchFilterForm"
                                      id="LeadsExportsSearchFilterForm">
                                    <input type="hidden" name="SessionKey" id="SessionKey"
                                           value="LeadsExportsSessionFilters">
                                    <input type="hidden" name="exports_start_date" id="exports_start_date"
                                           value="<?= $ExportsStartDate ?>">
                                    <input type="hidden" name="exports_end_date" id="exports_end_date"
                                           value="<?= $ExportsEndDate ?>">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Keyword</label>
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
                                                <label for="country">Created Date</label>
                                                <input type="text"
                                                       class="form-control multidate validate[required,future[now]]"
                                                       name="lead_exports_date" id="lead_exports_date"
                                                       placeholder="Exports Dates" value=""
                                                       onchange="GetLeadExportsDate();">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control" id="statusname" name="statusname">
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    foreach ($LeadStatusArray as $LeadStatusArrayK => $LeadStatusArrayV) {
                                                        echo '<option ' . (($Status == $LeadStatusArrayK) ? 'selected' : '') . '  value="' . $LeadStatusArrayK . '">' . $LeadStatusArrayV . '</option>';
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Product</label>
                                                <select class="form-control" id="productname" name="productname">
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    foreach ($Products as $product) {
                                                        if ($product != 'home' && $product != 'sales' && $product != 'visitor')
                                                            echo '<option ' . (($Product == $product) ? 'selected' : '') . ' value="' . $product . '">' . $product . '</option>';
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="LeadsExportsFiltersFormSubmit( 'LeadsExportsSearchFilterForm' );"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('LeadsExportsSessionFilters');"
                                                        id="btnreset" type="button" class="btn btn-danger">Clear
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="LeadExportsFilterAjaxResult"></div>
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
                        <table id="exportdata" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Ref.ID</th>
                                <th>Created On</th>
                                <th>Full Name</th>
                                <th>Products</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Contact</th>
                                <th>WhatsApp No</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!--                            --><?php
                            //                            for($i=1;$i<10;$i++)
                            //                            {
                            //                                echo '
                            //                                <tr>
                            //                                <td>'.$i.'</td>
                            //                                <td>Pakistan</td>
                            //                                <td>Dummy IATA Name</td>
                            //                                <td>4234</td>
                            //                                <td>98</td>
                            //                                <td>23 Apr, 2021</td>
                            //                                <td>ISB</td>
                            //                                <td>5 Star</td>
                            //                                 <td>Al Furas</td>
                            //                                 <td>Sharing</td>
                            //                                <td>5</td>
                            //                                <td>17</td>
                            //                                <td>15</td>
                            //
                            //                                <td>5</td>
                            //                                <td>5</td>
                            //                                <td>10:00 am</td>
                            //                                <td>Dummy</td>
                            //                                <td>0336564646</td>
                            //                                <td>b2c</td>
                            //                                <td>Usman Khan</td>
                            //
                            //                                </tr> ';
                            //                            }
                            //                            ?>
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
            var ExportStartDate = "<?=$ExportsStartDate?>";
            var ExportEndDate = "<?=$ExportsEndDate?>";
            $("#exports_start_date").val(ExportStartDate);
            $("#exports_end_date").val(ExportEndDate);
            if (ExportStartDate != '' && ExportEndDate != '') {
                $("#lead_exports_date").val(ExportStartDate + " to " + ExportEndDate);
            }
        }, 1000);

        $('#exportdata').DataTable({
            "searching": false,
            "processing": true,
            "pageLength": 100,
            "serverSide": true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, 'All']],
            "ajax": {
                url: "<?= $path ?>lead/get_exports_leads_data",
                type: 'POST'
            }
        });
    });

    function GetLeadExportsDate() {
        const LeadExportsDate = $("#lead_exports_date").val();
        const words = LeadExportsDate.split(' to ');
        $("#exports_start_date").val(words[0]);
        $("#exports_end_date").val(words[1]);
    }

    function LeadsExportsFiltersFormSubmit(parent) {

        var dataTable = $('#exportdata').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {
            GridMessages(parent, 'LeadExportsFilterAjaxResult', 'alert-success', rslt.msg, 1500);
            setTimeout(function () {
                dataTable.ajax.reload();
            }, 2000);
        }
    }

    function ClearSession(SessionKey) {

        var dataTable = $('#exportdata').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {
            GridMessages('LeadsExportsSearchFilterForm', 'LeadExportsFilterAjaxResult', 'alert-success', rslt.msg, 1500);
            $("form#LeadsExportsSearchFilterForm input#exports_start_date").val('');
            $("form#LeadsExportsSearchFilterForm input#exports_start_date").val('');
            $("form#LeadsExportsSearchFilterForm")[0].reset();
            setTimeout(function () {
                dataTable.ajax.reload();
            }, 2000);
        }
    }


</script>
