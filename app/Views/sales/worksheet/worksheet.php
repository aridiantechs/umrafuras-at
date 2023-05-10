<?php

use App\Models\Crud;

$Crud = new Crud();
$session = session();
$SessionFilters = $session->get('WorkSheetSessionFilters');
$SalesOfficersData = $Crud->ListRecords('main."Users"', array('UserType' => 'sale-officer', 'Archive' => 0), array('FullName' => 'ASC'));
$SubmittedBy = $WorkSheetStartDate = $WorkSheetEndDate = '';

if (isset($SessionFilters['submitted_by']) && $SessionFilters['submitted_by'] != '') {
    $SubmittedBy = $SessionFilters['submitted_by'];
}

if (isset($SessionFilters['worksheet_start_date']) && $SessionFilters['worksheet_start_date'] != '') {
    $WorkSheetStartDate = $SessionFilters['worksheet_start_date'];
}

if (isset($SessionFilters['worksheet_end_date']) && $SessionFilters['worksheet_end_date'] != '') {
    $WorkSheetEndDate = $SessionFilters['worksheet_end_date'];
}
?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head"> Worksheet List
                    <a href="<?= $path ?>lead/add_organic_worksheet" class="btn btn_customized btn-sm float-right"
                    >Add worksheet
                    </a>

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
                                      onsubmit="WorkSheetFiltersFormSubmit( 'WorkSheetSearchFilterForm' ); return false;"
                                      class="section contact" name="WorkSheetSearchFilterForm"
                                      id="WorkSheetSearchFilterForm">
                                    <input type="hidden" name="SessionKey" id="SessionKey"
                                           value="WorkSheetSessionFilters">
                                    <input type="hidden" name="worksheet_start_date" id="worksheet_start_date"
                                           value="<?= $WorkSheetStartDate ?>">
                                    <input type="hidden" name="worksheet_end_date" id="worksheet_end_date"
                                           value="<?= $WorkSheetEndDate ?>">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Submitted By</label>
                                                <select class="form-control" id="submitted_by"
                                                        name="submitted_by">
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    foreach ($SalesOfficersData as $SOD) {
                                                        echo '<option ' . (($SubmittedBy == $SOD['UID']) ? 'selected' : '') . ' value="' . $SOD['UID'] . '">' . $SOD['FullName'] . '</option>';
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
                                                       name="worksheet_create_date" id="worksheet_create_date"
                                                       placeholder="Create Dates" value=""
                                                       onchange="GetWorkSheetCreateDate();">
                                            </div>
                                        </div>
                                        <div class="col-md-8" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="WorkSheetFiltersFormSubmit( 'WorkSheetSearchFilterForm' );"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('WorkSheetSessionFilters');"
                                                        id="btnreset" type="button" class="btn btn-danger">Clear
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="WorkSheetFilterAjaxResult"></div>
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
                        <table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Submitted By</th>
                                <th>Submitted On</th>
                                <th>Created Date</th>
                                <th>Platforms</th>
                                <th>Completed %</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $cnt = 1;

                            foreach ($WorkSheetData as $WSD) {

                                $actions = '
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">';
                                $actions .= '<a class="dropdown-item" href="' . $path . 'lead/update_organic_worksheet/' . $WSD['UID'] . '" onclick="">Update</a>';
                                $actions .= '<a target="_blank" class="dropdown-item" href="' . $path . 'exports/worksheet/' . $WSD['UID'] . '" >Print</a>';
                                $actions .= '</div>';

                                echo '<tr>
                                    <td>' . $cnt . '</td>
                                                <td>' . $WSD['UserName'] . '</td>
                                                <td>' . date("d M, Y", strtotime($WSD['SystemDate'])) . '</td>
                                                <td>' . date("d M, Y", strtotime($WSD['CreatedAt'])) . '</td>
                                                <td>' . wordwrap($WSD['PlatForms'], "50", "<br>", true) . '</td>
                                                <td>' . $WSD['TotalPercent'] . '</td>
                                                <td>                                               
                                                <div class="btn-group">
                                            <button type="button"
                                                    class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split"
                                                    id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" data-reference="parent">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                     stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-chevron-down">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg>
                                            </button>
                                            ' . $actions . '
                                        </div>
                                                 </td>
                                             </tr>';

                                $cnt++;
                            }
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

            var WorkSheetStartDate = "<?=$WorkSheetStartDate?>";
            var WorkSheetEndDate = "<?=$WorkSheetEndDate?>";
            $("#worksheet_start_date").val(WorkSheetStartDate);
            $("#worksheet_end_date").val(WorkSheetEndDate);
            if (WorkSheetStartDate != '' && WorkSheetEndDate != '') {
                $("#worksheet_create_date").val(WorkSheetStartDate + " to " + WorkSheetEndDate);
            } else {
                $("form#WorkSheetSearchFilterForm input#worksheet_start_date").val('');
                $("form#WorkSheetSearchFilterForm input#worksheet_end_date").val('');
            }

        }, 1000);
    });

    $('#ReportTable').DataTable({
        "scrollX": true,
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
        "pageLength": 100
    });

    function GetWorkSheetCreateDate() {
        const WorkSheetDate = $("#worksheet_create_date").val();
        const words = WorkSheetDate.split(' to ');
        $("#worksheet_start_date").val(words[0]);
        $("#worksheet_end_date").val(words[1]);
    }

    function WorkSheetFiltersFormSubmit(parent) {

        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {
            GridMessages(parent, 'WorkSheetFilterAjaxResult', 'alert-success', rslt.msg, 1500);
            setTimeout(function () {
                location.reload();
            }, 2000);
        }
    }

    function ClearSession(SessionKey) {

        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('WorkSheetSearchFilterForm', 'WorkSheetFilterAjaxResult', 'alert-success', rslt.msg, 1500);
            $("form#WorkSheetSearchFilterForm input#worksheet_start_date").val('');
            $("form#WorkSheetSearchFilterForm input#worksheet_end_date").val('');
            $("form#WorkSheetSearchFilterForm")[0].reset();
            setTimeout(function () {
                location.reload();
            }, 2000);
        }
    }

    setTimeout(function () {
        $('<a href="<?=$path?>exports/worksheet_list" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);

</script>
