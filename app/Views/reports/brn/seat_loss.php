<?php

use App\Models\Crud;

$Crud = new Crud();

$session = session();
$SessionFilters = $session->get('SeatLossReportSessionFilters');
$BookingDateFrom = $BookingDateTo = $BookingID = $VehicleType = $Company = '';


if (isset($SessionFilters['booking_date_from']) && $SessionFilters['booking_date_from'] != '') {
    $BookingDateFrom = $SessionFilters['booking_date_from'];
}

if (isset($SessionFilters['booking_date_to']) && $SessionFilters['booking_date_to'] != '') {
    $BookingDateTo = $SessionFilters['booking_date_to'];
}

if (isset($SessionFilters['booking_id']) && $SessionFilters['booking_id'] != '') {
    $BookingID = $SessionFilters['booking_id'];
}

if (isset($SessionFilters['vehicle_type']) && $SessionFilters['vehicle_type'] != '') {
    $VehicleType = $SessionFilters['vehicle_type'];
}

if (isset($SessionFilters['company']) && $SessionFilters['company'] != '') {
    $Company = $SessionFilters['company'];
}

?>
<style>
    table.cell-border thead th, table.cell-border tbody td {
        border: 0.5px solid #DDA420;agent_work_report
        border-collapse: collapse;
    }
</style>


<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Seat Loss
                    <?php if ($CheckAccess['umrah_reports_stats_transport_seat_loss_export'] && isset($SessionFilters) && $SessionFilters != '') { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/seat_loss" target="_blank"> Export Record
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="SeatLossReportForm" id="SeatLossReportForm"
                      onsubmit="SeatLossReportFormSubmit('SeatLossReportForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey"
                           value="SeatLossReportSessionFilters">
                    <input type="hidden" name="booking_date_from" id="booking_date_from"
                           value="<?= $BookingDateFrom ?>">
                    <input type="hidden" name="booking_date_to" id="booking_date_to"
                           value="<?= $BookingDateTo ?>">
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
                                            <div class="form-group">
                                                <label for="country">Booking ID</label>
                                                <input value="<?= $BookingID ?>" type="text" class="form-control"
                                                       name="booking_id"
                                                       id="booking_id">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="Operator">Vehicle Type</label>
                                                <select class="form-control" id="vehicle_type"
                                                        name="vehicle_type">
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    $LookupsOptions = $Crud->LookupOptions('transport_types');
                                                    foreach ($LookupsOptions as $options) {
                                                        $Selected = (($VehicleType == $options['UID']) ? 'selected' : '');
                                                        echo '<option ' . $Selected . ' value="' . $options['UID'] . '">' . $options['Name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="country">Company</label>
                                                <input value="<?= $Company ?>" type="text" class="form-control"
                                                       name="company"
                                                       id="company">
                                            </div>
                                        </div>
                                        <div class="col-md-3" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="SeatLossReportFormSubmit('SeatLossReportForm');"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('SeatLossReportSessionFilters');"
                                                        id="btnreset" type="button" class="btn btn-danger">Clear
                                                    Filter
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="SeatLossReportAjaxResult"></div>
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
                        <table id="SeatLossRecord" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>

                                <th>Booking Date</th>
                                <th>BRN No</th>
                                <th>Booking ID</th>

                                <th>Vehicle Type</th>
                                <th>Sector</th>

                                <th>Seat Loss</th>
                                <th>Company Name</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!--                            <tr>-->
                            <!--                                <td>1</td>-->
                            <!--                                <td>2342423</td>-->
                            <!--                                <td>6/29/2021</td>-->
                            <!--                                <td>MQM0005191239:19283</td>-->
                            <!--                                <td>Bus</td>-->
                            <!--                                <td>LALA INTL</td>-->
                            <!--                                <td>MAK-MED</td>-->
                            <!--                                <td>90% </td>-->
                            <!--                                <td>10</td>-->
                            <!--                                <td>BASMA</td>-->
                            <!--                            </tr>-->
                            <!--                            <tr>-->
                            <!--                                <td>2</td>-->
                            <!--                                <td>2342423</td>-->
                            <!--                                <td>6/29/2021</td>-->
                            <!--                                <td>MQM0005191239:19283</td>-->
                            <!--                                <td>Bus</td>-->
                            <!--                                <td>LALA INTL</td>-->
                            <!--                                <td>MAK-MED</td>-->
                            <!--                                <td>90% </td>-->
                            <!---->
                            <!--                                <td>10</td>-->
                            <!--                                <td>BASMA</td>-->
                            <!--                            </tr>-->
                            <!--                            <tr>-->
                            <!--                                <td>3</td>-->
                            <!--                                <td>2342423</td>-->
                            <!--                                <td>6/29/2021</td>-->
                            <!--                                <td>MQM0005191239:19283</td>-->
                            <!--                                <td>Bus</td>-->
                            <!--                                <td>LALA INTL</td>-->
                            <!--                                <td>MAK-MED</td>-->
                            <!--                                <td>90% </td>-->
                            <!---->
                            <!--                                <td>10</td>-->
                            <!--                                <td>BASMA</td>-->
                            <!--                            </tr>-->
                            </tbody>
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
            var BookingDateFrom = "<?=$BookingDateFrom?>";
            var BookingDateTo = "<?=$BookingDateTo?>";
            $("#booking_date_from").val(BookingDateFrom);
            $("#booking_date_to").val(BookingDateTo);
            if (BookingDateFrom != '' && BookingDateTo != '') {
                $("#booking_date").val(BookingDateFrom + " to " + BookingDateTo);
               }
        }, 1000);

        <?php
        if(isset($SessionFilters) && $SessionFilters != ''){?>
        SeatLossRecord();
        <?php }?>
    });

    function SeatLossRecord(){

        $('#SeatLossRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Seat Loss",
                "info": "Showing _START_ to _END_ of _TOTAL_ Seat Loss",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_all_seat_loss_report",
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
    }

    function GetBookingDate() {

        const EntryDate = $("#booking_date").val();
        const words = EntryDate.split(' to ');
        $("#booking_date_from").val(words[0]);
        $("#booking_date_to").val(words[1]);
    }

    function SeatLossReportFormSubmit(parent) {

        //var dataTable = $('#SeatLossRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'SeatLossReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                //dataTable.ajax.reload();
                location.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        //var dataTable = $('#SeatLossRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('SeatLossReportForm', 'SeatLossReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#SeatLossReportForm input#booking_date_from").val('');
                $("form#SeatLossReportForm input#booking_date_to").val('');
                $("form#SeatLossReportForm")[0].reset();

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

    <?php if ($CheckAccess['umrah_reports_stats_transport_seat_loss_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/seat_loss" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);
    <?php } ?>

</script>
