<?php

$session = session();
$SessionFilters = $session->get('ArrivalSummaryReportSessionFilters');
$Country = $ArrivalDateFrom = $ArrivalDateTo = $Flight = $Airport = '';

if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $Country = $SessionFilters['country'];
}

if (isset($SessionFilters['arrival_date_from']) && $SessionFilters['arrival_date_from'] != '') {
    $ArrivalDateFrom = $SessionFilters['arrival_date_from'];
}

if (isset($SessionFilters['arrival_date_to']) && $SessionFilters['arrival_date_to'] != '') {
    $ArrivalDateTo = $SessionFilters['arrival_date_to'];
}

if (isset($SessionFilters['flight']) && $SessionFilters['flight'] != '') {
    $Flight = $SessionFilters['flight'];
}

if (isset($SessionFilters['airport']) && $SessionFilters['airport'] != '') {
    $Airport = $SessionFilters['airport'];
}
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Arrival Summary Report
                    <?php if ($CheckAccess['umrah_reports_stats_transport_arrival_summary_export'] && isset($SessionFilters) && $SessionFilters != '') { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/arrival_summary_layout" target="_blank">Export Records
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="ArrivalSummaryReportForm" id="ArrivalSummaryReportForm"
                      onsubmit="ArrivalSummaryReportFormSubmit('ArrivalSummaryReportForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey"
                           value="ArrivalSummaryReportSessionFilters">
                    <input type="hidden" name="arrival_date_from" id="arrival_date_from"
                           value="<?= $ArrivalDateFrom ?>">
                    <input type="hidden" name="arrival_date_to" id="arrival_date_to"
                           value="<?= $ArrivalDateTo ?>">
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
                                                <label for="country">Country</label>
                                                <select class="form-control validate[required]" id="country"
                                                        name="country">
                                                    <option value="">Please Select</option>
                                                    <?= Countries('html', $Country) ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="country">Arrival Date</label>
                                            <input onchange="GetArrivalDate();" type="text"
                                                   class="form-control multidate"
                                                   name="arrival_date" id="arrival_date">
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Flight</label>
                                                <input value="<?= $Flight ?>" type="text" class="form-control"
                                                       name="flight"
                                                       id="flight">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Airport</label>
                                                <input value="<?= $Airport ?>" type="text" class="form-control"
                                                       name="airport"
                                                       id="airport">
                                            </div>
                                        </div>
                                        <div class="col-md-4" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="ArrivalSummaryReportFormSubmit('ArrivalSummaryReportForm');"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('ArrivalSummaryReportSessionFilters');"
                                                        id="btnreset" type="button" class="btn btn-danger">Clear
                                                    Filter
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="ArrivalSummaryReportAjaxResult"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <?php
                    if (isset($SessionFilters) && $SessionFilters != '') { ?>
                        <div class="table-responsive mb-4 mt-4">
                            <table id="ArrivalTransportSummaryRecord" class="table table-hover non-hover display nowrap"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Origin Country</th>
                                    <th>Arrival Date</th>
                                    <th>Flight No</th>
                                    <th>Arrival Time (DESC order)</th>
                                    <th>PAX</th>
                                    <th>TPT Type</th>
                                    <th>Airport</th>
                                    <th>Arrival Mode</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-warning text-center font-weight-bold">Filters! Plz Select Filters
                            To View Record...
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">

    $(document).ready(function () {

        setTimeout(function () {
            var SessionArrivalDateFrom = "<?=$ArrivalDateFrom?>";
            var SessionArrivalDateTo = "<?=$ArrivalDateTo?>";
            $("#arrival_date_from").val(SessionArrivalDateFrom);
            $("#arrival_date_to").val(SessionArrivalDateTo);
            if (SessionArrivalDateFrom != '' && SessionArrivalDateTo != '') {
                $("#arrival_date").val(SessionArrivalDateFrom + " to " + SessionArrivalDateTo);
            }
        }, 1000);

        <?php
        if(isset($SessionFilters) && $SessionFilters != ''){?>
        ArrivalTransportSummaryRecord();
        <?php }?>
    });


    function ArrivalTransportSummaryRecord() {
        $('#ArrivalTransportSummaryRecord').DataTable({
            "processing": true,
            "searching": false,
            "responsive": true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
            "pageLength": 100,
            "lengthChange": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ Arrival Summary Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Arrival Summary Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_arrival_transport_summary_report",
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

    }

    function GetArrivalDate() {

        const EntryDate = $("#arrival_date").val();
        const words = EntryDate.split(' to ');
        $("#arrival_date_from").val(words[0]);
        $("#arrival_date_to").val(words[1]);
    }

    function ArrivalSummaryReportFormSubmit(parent) {

        //var dataTable = $('#ArrivalTransportSummaryRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'ArrivalSummaryReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                location.reload();
                //dataTable.ajax.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        //var dataTable = $('#ArrivalTransportSummaryRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('ArrivalSummaryReportForm', 'ArrivalSummaryReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#ArrivalSummaryReportForm input#arrival_date_from").val('');
                $("form#ArrivalSummaryReportForm input#arrival_date_to").val('');
                $("form#ArrivalSummaryReportForm")[0].reset();

                location.reload();
                //dataTable.ajax.reload();
            }, 500);
        }
    }
</script>
<script type="application/javascript">

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

    <?php if ($CheckAccess['umrah_reports_stats_transport_arrival_summary_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/arrival_summary_layout" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
