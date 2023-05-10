<!--  BEGIN CONTENT AREA  -->
<?php

use App\Models\Crud;

$Crud = new Crud();
$session = session();
$SessionFilters = $session->get('MofaIssuedStatsReportSessionFilters');
$Country = $Agent = $Group = $Pilgrim = $PassportNo = $Nationality = $Reference = '';
if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $Country = $SessionFilters['country'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $Agent = $SessionFilters['agent'];
}

if (isset($SessionFilters['group']) && $SessionFilters['group'] != '') {
    $Group = $SessionFilters['group'];
}

if (isset($SessionFilters['pilgrim']) && $SessionFilters['pilgrim'] != '') {
    $Pilgrim = $SessionFilters['pilgrim'];
}

if (isset($SessionFilters['pp_no']) && $SessionFilters['pp_no'] != '') {
    $PassportNo = $SessionFilters['pp_no'];
}

if (isset($SessionFilters['nationality']) && $SessionFilters['nationality'] != '') {
    $Nationality = $SessionFilters['nationality'];
}

if (isset($SessionFilters['reference']) && $SessionFilters['reference'] != '') {
    $Reference = $SessionFilters['reference'];
}

?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">MOFA Issued
                    <?php if ($CheckAccess['umrah_reports_status_stats_export_mofa_issued']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/mofa_issued" target="_blank"> Export Record
                        </a>
                    <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="MofaIssuedStatsForm" id="MofaIssuedStatsForm"
                      onsubmit="MofaIssuedStatsSearchFiltersFormSubmit('MofaIssuedStatsForm');">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="MofaIssuedStatsReportSessionFilters">
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
                            <div id="FilterDetails" class="collapse show" aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Country</label>
                                                        <select class="form-control" id="country"
                                                                name="country">
                                                            <option value="">Please Select</option>
                                                            <?= Countries('html', $Country) ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Agent</label>
                                                        <select class="form-control" id="agent"
                                                                name="agent">
                                                            <?= $AgentsDropDown['html'] ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Group Name</label>
                                                        <input class="form-control" id="group" name="group"
                                                               placeholder="Group Name"
                                                               value="<?= $Group ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Pilgrim</label>
                                                        <input class="form-control" id="pilgrim" name="pilgrim"
                                                               placeholder="Pilgrim Name"
                                                               value="<?= $Pilgrim ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">P/P#</label>
                                                        <input class="form-control" id="pp_no" name="pp_no"
                                                               placeholder="Passport No"
                                                               value="<?= $PassportNo ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Nationality</label>
                                                        <input type="text" class="form-control" id="nationality"
                                                               name="nationality"
                                                               value="<?= $Nationality ?>"
                                                               placeholder="Nationality">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Reference</label>
                                                        <input type="text" class="form-control" id="reference"
                                                               name="reference"
                                                               value="<?= $Reference ?>"
                                                               placeholder="Reference">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="MofaIssuedStatsAjaxResult"></div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="MofaIssuedStatsSearchFiltersFormSubmit('MofaIssuedStatsForm');"
                                                                id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('MofaIssuedStatsReportSessionFilters');"
                                                                id="btnreset" type="button" class="btn btn-danger">Clear
                                                            Filter
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <table id="MofaIssuedRecord" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>EA Code</th>
                                <th>Country</th>
                                <th>Pilgrim. ID</th>

                                <th>Agent Name</th>
                                <th>HTL category</th>
                                <th>Group Name</th>
                                <th>Pilgrim Name</th>
                                <th>Gender</th>
                                <th>P/p No</th>
                                <th>D.O.B</th>
                                <th>Nationality</th>
                                <th>Mofa No</th>

                                <th>City</th>


                                <!--                                <th>Mofa Issue Date</th>-->
                                <th>Category</th>
                                <th>Reference</th>


                            </tr>
                            </thead>
                            <tbody>
                            <!-- --><?php
                            /*                            $cnt = 0;
                                                        foreach ($records as $record) {
                                                            $cnt++;
                                                            $Category = 'B2B';
                                                            if ($record['IATAType'] == 'external_agent') {
                                                                $Category = 'External Agent';
                                                            }
                                                            echo '
                                                            <tr>
                                                            <td>' . $cnt . '</td>
                                                              <td>' . Code('UF/A/', $record['AgentID']) . '</td>
                                                               <td>' . $record['CountryName'] . '</td>
                                                            <td>' . Code('UF/P/', $record['UID']) . '</td>

                                                            <td>' . $record['AgentName'] . '</td>
                                                             <td>' . $record['HotelCategory'] . '</td>
                                                            <td>' . $record['GroupName'] . '</td>
                                                            <td>' . $record['PilgrimFullName'] . '</td>
                                                            <td>' . $record['Gender'] . '</td>
                                                            <td>' . $record['PassportNumber'] . '</td>
                                                            <td>' . DATEFORMAT($record['DOB']) . '</td>
                                                            <td>' . $record['Nationality'] . '</td>
                                                             <td>' . $record['MOFANumber'] . '</td>
                                                            <td>' . $record['CityName'] . '</td>


                                                     <!--       <td>' . DATEFORMAT($record['IssueDate']) . '</td> -->
                                                            <td>' . $Category . '</td>
                                                            <td>' . $record['ReferenceName'] . '</td>

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
        var dataTable = $('#MofaIssuedRecord').DataTable({
            "processing": true,
            "searching": false,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, 'All']],
            "pageLength": 100,
            "lengthChange": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ Mofa Issued",
                "info": "Showing _START_ to _END_ of _TOTAL_ Mofa Issued",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_mofa_issued",
                type: "POST"
            },
            "columnDefs": [
                {
                    "defaultContent": "-",
                    "targets": "_all",
                    //"targets":[0, 3, 4],
                    "orderable": false,
                },
            ],
        });
    });
</script>
<script type="application/javascript">

    function MofaIssuedStatsSearchFiltersFormSubmit(parent) {
        var dataTable = $('#MofaIssuedRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'MofaIssuedStatsAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                dataTable.ajax.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {
        var dataTable = $('#MofaIssuedRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('MofaIssuedStatsForm', 'MofaIssuedStatsAjaxResult', 'alert-success', rslt.msg, 250);
            $("form#MofaIssuedStatsForm")[0].reset();
            setTimeout(function () {
                dataTable.ajax.reload();
            }, 500);
        }
    }

    /*$('#ReportTable').DataTable({
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
    });*/
    <?php if ($CheckAccess['umrah_reports_status_stats_export_mofa_issued']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/mofa_issued" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
