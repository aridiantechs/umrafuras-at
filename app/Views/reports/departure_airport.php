<?php

$session = session();
$SessionFilters = $session->get('DepartureAirportReportSessionFilters');
$Country = $Agent = $DepartureDateFrom = $DepartureDateTo = $TPTType = '';
if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $Country = $SessionFilters['country'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $Agent = $SessionFilters['agent'];
}

if (isset($SessionFilters['tpt_type']) && $SessionFilters['tpt_type'] != '') {
    $TPTType = $SessionFilters['tpt_type'];
}

if (isset($SessionFilters['reference']) && $SessionFilters['reference'] != '') {
    $Reference = $SessionFilters['reference'];
}

if (isset($SessionFilters['departure_date_from']) && $SessionFilters['departure_date_from'] != '') {
    $DepartureDateFrom = $SessionFilters['departure_date_from'];
}

if (isset($SessionFilters['departure_date_to']) && $SessionFilters['departure_date_to'] != '') {
    $DepartureDateTo = $SessionFilters['departure_date_to'];
}
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Departure Airport
                    <?php if ($CheckAccess['umrah_reports_stats_arrival_departure_departure_airport_export'] && isset($SessionFilters) && $SessionFilters != '') { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/departure_airport" target="_blank">Export Records
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="DepartureAirportReportForm" id="DepartureAirportReportForm"
                      onsubmit="DepartureAirportReportFormSubmit('DepartureAirportReportForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="DepartureAirportReportSessionFilters">
                    <input type="hidden" name="departure_date_from" id="departure_date_from"
                           value="<?= $DepartureDateFrom ?>">
                    <input type="hidden" name="departure_date_to" id="departure_date_to"
                           value="<?= $DepartureDateTo ?>">
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
                                                <label for="country">TPT Type</label>
                                                <input value="<?= $TPTType ?>" type="text" name="tpt_type" id="tpt_type"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="country">Dep Date</label>
                                            <input onchange="GetDepartureDate();" type="text"
                                                   class="form-control multidate"
                                                   name="departure_date" id="departure_date">
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Reference</label>
                                                <input value="<?= $Reference ?>" type="text" name="reference"
                                                       id="reference"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="DepartureAirportReportAjaxResult"></div>
                                        <div class="col-md-12" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="DepartureAirportReportFormSubmit('DepartureAirportReportForm');"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('DepartureAirportReportSessionFilters');"
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
                    <?php
                    if (isset($SessionFilters) && $SessionFilters != '') { ?>
                        <div class="table-responsive mb-4 mt-4">
                            <table id="DepartureAirportRecord" class="table table-hover non-hover display nowrap"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Country</th>
                                    <th>Agent Name</th>
                                    <th>V. No</th>
                                    <th>City</th>
                                    <th>Actual Hotel</th>
                                    <th>Room No</th>
                                    <th>Dep Date</th>
                                    <th>Dep Hotel Time</th>
                                    <th>Airport</th>
                                    <th>Flight No</th>
                                    <th>Flight Time</th>
                                    <th>Pax</th>
                                    <th>Seats</th>
                                    <th>TPT Type</th>
                                    <th>Vehicle Number</th>
                                    <th>Driver Name</th>
                                    <th>Driver Mob. Number</th>
                                    <th>Pax Mob. No</th>
                                    <th>TPT Company</th>
                                    <th>Category</th>
                                    <th>Reference</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    <?php } else {
                        ?>
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
            var SessionDepartureDateFrom = "<?=$DepartureDateFrom?>";
            var SessionDepartureDateTo = "<?=$DepartureDateTo?>";
            $("#departure_date_from").val(SessionDepartureDateFrom);
            $("#departure_date_to").val(SessionDepartureDateTo);
            if (SessionDepartureDateFrom != '' && SessionDepartureDateTo != '') {
                $("#departure_date").val(SessionDepartureDateFrom + " to " + SessionDepartureDateTo);
            }
        }, 1000);

        <?php
        if(isset($SessionFilters) && $SessionFilters != ''){?>
        DepartureAirportRecord();
        <?php }?>

    });

    function DepartureAirportRecord() {

        $('#DepartureAirportRecord').DataTable({
            "processing": true,
            "searching": false,
            "responsive": true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, 'All']],
            "pageLength": 100,
            "lengthChange": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ Departure Airport Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Departure Airport Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_all_departure_airport_report",
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

    }

    function GetDepartureDate() {
        const Date = $("#departure_date").val();
        const words = Date.split(' to ');
        $("#departure_date_from").val(words[0]);
        $("#departure_date_to").val(words[1]);
    }

    function DepartureAirportReportFormSubmit(parent) {

        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'DepartureAirportReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                location.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('DepartureAirportReportForm', 'DepartureAirportReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#DepartureAirportReportForm input#departure_date_from").val('');
                $("form#DepartureAirportReportForm input#departure_date_to").val('');
                $("form#DepartureAirportReportForm")[0].reset();

                location.reload();
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

    <?php if ($CheckAccess['umrah_reports_stats_arrival_departure_departure_airport_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/departure_airport" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
