<!--  BEGIN CONTENT AREA  -->
<?php

$session = session();
$SessionFilters = $session->get('PassportManagementStatsReportSessionFilters');
$Agent = $PaxName = $PassportNo = $MofaNo = $VisaNo = $EntryStartDate = $EntryEndDate = '';

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $Agent = $SessionFilters['agent'];
}

if (isset($SessionFilters['pax_name']) && $SessionFilters['pax_name'] != '') {
    $PaxName = $SessionFilters['pax_name'];
}

if (isset($SessionFilters['ppt_no']) && $SessionFilters['ppt_no'] != '') {
    $PassportNo = $SessionFilters['ppt_no'];
}

if (isset($SessionFilters['mofa_no']) && $SessionFilters['mofa_no'] != '') {
    $MofaNo = $SessionFilters['mofa_no'];
}

if (isset($SessionFilters['visa_no']) && $SessionFilters['visa_no'] != '') {
    $VisaNo = $SessionFilters['visa_no'];
}

if (isset($SessionFilters['entry_start_date']) && $SessionFilters['entry_start_date'] != '') {
    $EntryStartDate = $SessionFilters['entry_start_date'];
}

if (isset($SessionFilters['entry_end_date']) && $SessionFilters['entry_end_date'] != '') {
    $EntryEndDate = $SessionFilters['entry_end_date'];
}


?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Passport Management Report
                    <?php if ($CheckAccess['umrah_reports_status_stats_export_ppt_management']) { ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?= $path ?>exports/ppt_management" target="_blank">Export Records
                    </a>
                    <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="PassportManagementStatsSearchFiltersFormSubmit('PassportManagementSearchFilterForm'); return false;" class="section contact" id="PassportManagementSearchFilterForm">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="PassportManagementStatsReportSessionFilters">
                    <input type="hidden" name="entry_start_date" id="entry_start_date" value="<?=$EntryStartDate?>">
                    <input type="hidden" name="entry_end_date" id="entry_end_date" value="<?=$EntryEndDate?>">
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
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Agent Name</label>
                                                <select class="form-control" id="agent"
                                                        name="agent">
                                                    <?= $AgentsDropDown['html'] ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Pax Name</label>
                                                <input value="<?=$PaxName?>" type="text" class="form-control" id="pax_name"
                                                       name="pax_name"
                                                       placeholder="Pax Name">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">PPT#</label>
                                                <input value="<?=$PassportNo?>" type="text" class="form-control" id="ppt_no"
                                                       name="ppt_no"
                                                       placeholder="PPT No">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Mofa#</label>
                                                <input value="<?=$MofaNo?>" type="text" class="form-control" id="mofa_no"
                                                       name="mofa_no"
                                                       placeholder="MOFA No">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Visa#</label>
                                                <input value="<?=$VisaNo?>" type="text" class="form-control" id="visa_no"
                                                       name="visa_no"
                                                       placeholder="Visa No">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Entry Date</label>
                                                <input type="text" class="form-control multidate"
                                                       name="entry_date" id="entry_date"
                                                       placeholder="Entry Dates" value=""
                                                       onchange="GetEntryDate();">
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="PassportManagementStatsAjaxResult"></div>
                                        <div class="col-md-12" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="PassportManagementStatsSearchFiltersFormSubmit('PassportManagementSearchFilterForm');"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('PassportManagementStatsReportSessionFilters');"
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
                </form>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <table id="PassportManagementRecord" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>EA Code</th>
                                <th>Agent Name</th>
                                <th>Group Code</th>
                                <th>Group Name</th>
                                <th>PAX Name</th>
                                <th>PPT No.</th>
                                <th>DOB</th>
                                <th>MOFA No</th>
                                <th>VISA No.</th>
                                <th>Entry Date</th>
                                <th>Entry Time</th>
                                <th>Entry Port</th>
                                <th>Arrival Mode</th>
                                <th>Entry Carrier</th>
                                <th>Flight No.</th>
                                <th>Category</th>
                                <th>Reference</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            /*                            $cnt=0;
                                                        foreach ($records as $record) {

                                                            $cnt++;


                                                            $Category = 'B2B';
                                                            if ($record['IATAType'] == 'external_agent') {
                                                                $Category = 'External Agent';
                                                            }
                                                            echo '
                                                            <tr>
                                                            <td>'.$cnt.'</td>
                                                            <td>' . Code('UF/A/', $record['AgentID']) . '</td>
                                                            <td>' . $record['IATANAME'] . '</td>
                                                            <td>' . Code('UF/G/', $record['GroupID']) . '</td>
                                                            <td>' . $record['GroupName'] . '</td>
                                                            <td>' . $record['PilgrimFullName'] . '</td>
                                                            <td>' . $record['PassportNumber'] . '</td>
                                                            <td>' . DATEFORMAT($record['DOB']) . '</td>
                                                            <td>' . $record['MOFANumber'] . '</td>
                                                            <td>' . $record['VisaNo'] . '</td>
                                                            <td>' . DATEFORMAT($record['EntryDate']) . '</td>
                                                            <td>' . TIMEFORMAT($record['EntryTime']) . '</td>
                                                            <td>' . $record['EntryPort'] . '</td>
                                                            <td>' . $record['ArrivalMode'] . '</td>
                                                            <td>' . $record['EntryCarrier'] . '</td>
                                                            <td>' . $record['FlightNo'] . '</td>
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

        setTimeout(function () {
            $("#entry_start_date").val('');
            $("#entry_end_date").val('');
        }, 1000);

        var dataTable = $('#PassportManagementRecord').DataTable({
            "processing": true,
            "searching": false,
            "responsive": true,
            "pageLength": 100,
            "lengthChange": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ Passport Management Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Passport Management Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_passport_management_report",
                type: "POST"
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

    function GetEntryDate() {

        const EntryDate = $("#entry_date").val();
        const words = EntryDate.split(' to ');
        $("#entry_start_date").val(words[0]);
        $("#entry_end_date").val(words[1]);
    }
</script>
<script type="application/javascript">

    function PassportManagementStatsSearchFiltersFormSubmit(parent) {
        var dataTable = $('#PassportManagementRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'PassportManagementStatsAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                dataTable.ajax.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {
        var dataTable = $('#PassportManagementRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('PassportManagementSearchFilterForm', 'PassportManagementStatsAjaxResult', 'alert-success', rslt.msg, 250);
            $("form#PassportManagementSearchFilterForm")[0].reset();
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

    <?php if ($CheckAccess['umrah_reports_status_stats_export_ppt_management']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/ppt_management" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);
    <?php } ?>

</script>
