<?php

$session = session();
$SessionFilters = $session->get('TransportBrnPurchaseReportSessionFilters');
$BookingDateFrom = $BookingDateTo = $BookingID = $ArrivalDateFrom = $ArrivalDateTo = $Company = $SystemUsers = '';

if (isset($SessionFilters['booking_date_from']) && $SessionFilters['booking_date_from'] != '') {
    $BookingDateFrom = $SessionFilters['booking_date_from'];
}

if (isset($SessionFilters['booking_date_to']) && $SessionFilters['booking_date_to'] != '') {
    $BookingDateTo = $SessionFilters['booking_date_to'];
}

if (isset($SessionFilters['booking_id']) && $SessionFilters['booking_id'] != '') {
    $BookingID = $SessionFilters['booking_id'];
}

if (isset($SessionFilters['arrival_date_from']) && $SessionFilters['arrival_date_from'] != '') {
    $ArrivalDateFrom = $SessionFilters['arrival_date_from'];
}

if (isset($SessionFilters['arrival_date_to']) && $SessionFilters['arrival_date_to'] != '') {
    $ArrivalDateTo = $SessionFilters['arrival_date_to'];
}

if (isset($SessionFilters['company']) && $SessionFilters['company'] != '') {
    $Company = $SessionFilters['company'];
}

if (isset($SessionFilters['system_users']) && $SessionFilters['system_users'] != '') {
    $SystemUsers = $SessionFilters['system_users'];
}

?>
<style>
    table.cell-border thead th, table.cell-border tbody td {
        border: 0.5px solid #DDA420;
        border-collapse: collapse;
    }
</style>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Transport BRN Purchase
                    <?php if ($CheckAccess['umrah_reports_stats_brn_transport_transport_brn_purchase_export']  && isset($SessionFilters) && $SessionFilters != '') { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/trp_brn_purchase" target="_blank"> Export Record
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="TransportBrnPurchaseReportForm" id="TransportBrnPurchaseReportForm"
                      onsubmit="TransportBrnPurchaseReportFormSubmit('TransportBrnPurchaseReportForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey"
                           value="TransportBrnPurchaseReportSessionFilters">

                    <input type="hidden" name="booking_date_from" id="booking_date_from"
                           value="<?= $BookingDateFrom ?>">
                    <input type="hidden" name="booking_date_to" id="booking_date_to"
                           value="<?= $BookingDateTo ?>">
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
                                            <label for="country">Booking Date</label>
                                            <input onchange="GetBookingDate();" type="text"
                                                   class="form-control multidate"
                                                   name="booking_date" id="booking_date">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="country">Booking ID</label>
                                            <input value="<?=$BookingID?>" type="text" class="form-control"
                                                   name="booking_id" id="booking_id">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="country">Arrival Date</label>
                                            <input onchange="GetArrivalDate();" type="text"
                                                   class="form-control multidate"
                                                   name="arrival_date" id="arrival_date">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="country">Company</label>
                                            <input value="<?=$Company?>" type="text" class="form-control"
                                                   name="company" id="company">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="country">System Users</label>
                                            <input value="<?=$SystemUsers?>" type="text" class="form-control"
                                                   name="system_users" id="system_users">
                                        </div>
                                        <div class="col-md-2" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="TransportBrnPurchaseReportFormSubmit('TransportBrnPurchaseReportForm');"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('TransportBrnPurchaseReportSessionFilters');"
                                                        id="btnreset" type="button" class="btn btn-danger">Clear
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="TransportBrnPurchaseReportAjaxResult"></div>
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
                        <table id="TransportBrnPurchaseRecord" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Booking Date</th>
                                <th>BRN No</th>
                                <th>Booking ID</th>
                                <th>Vehicle Type</th>
                                <th>QTY</th>
                                <th>Seats</th>
                                <th>Arrival Date</th>
                                <th>Company Name</th>
                                <th>System User</th>
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
            var SessionBookingDateFrom = "<?=$BookingDateFrom?>";
            var SessionBookingDateTo = "<?=$BookingDateTo?>";
            $("#booking_date_from").val(SessionBookingDateTo);
            $("#booking_date_to").val(SessionBookingDateTo);
            if (SessionBookingDateFrom != '' && SessionBookingDateTo != '') {
                $("#booking_date").val(SessionBookingDateFrom + " to " + SessionBookingDateTo);
            }
        }, 1000);

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
         TransportBrnPurchaseRecord();
        <?php }?>

    });

    function TransportBrnPurchaseRecord(){

        $('#TransportBrnPurchaseRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Transport BRN Purchase Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Transport BRN Purchase Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_all_trnasport_brn_purchase_report",
                type: "POST",
                data: function (data) {
                }
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

    function GetBookingDate() {
        const Date = $("#booking_date").val();
        const words = Date.split(' to ');
        $("#booking_date_from").val(words[0]);
        $("#booking_date_to").val(words[1]);
    }

    function GetArrivalDate() {
        const Date = $("#arrival_date").val();
        const words = Date.split(' to ');
        $("#arrival_date_from").val(words[0]);
        $("#arrival_date_to").val(words[1]);
    }

    function TransportBrnPurchaseReportFormSubmit(parent) {

        //var dataTable = $('#TransportBrnPurchaseRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {
            GridMessages(parent, 'TransportBrnPurchaseReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                location.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        //var dataTable = $('#TransportBrnPurchaseRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('TransportBrnPurchaseReportForm', 'TransportBrnPurchaseReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#TransportBrnPurchaseReportForm input#booking_date_from").val('');
                $("form#TransportBrnPurchaseReportForm input#booking_date_to").val('');
                $("form#TransportBrnPurchaseReportForm input#arrival_date_from").val('');
                $("form#TransportBrnPurchaseReportForm input#arrival_date_to").val('');
                $("form#TransportBrnPurchaseReportForm")[0].reset();

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

    <?php if ($CheckAccess['umrah_reports_stats_brn_transport_transport_brn_purchase_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/trp_brn_purchase" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
