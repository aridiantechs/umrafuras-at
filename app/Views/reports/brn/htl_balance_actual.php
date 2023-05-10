<!--  BEGIN CONTENT AREA  -->
<style>
    table.cell-border thead th, table.cell-border tbody td {
        border: 0.5px solid #DDA420;
        border-collapse: collapse;
    }
</style>

<?php

use App\Models\Crud;

$Crud = new Crud();

$session = session();
$SessionFilters = $session->get('HTLBalanceActualSessionFilter');
$BookingDateFrom = $BookingDateTo = $BookingID = $CheckInDateTo = $CheckInDateFrom = '';


if (isset($SessionFilters['booking_date_from']) && $SessionFilters['booking_date_from'] != '') {
    $BookingDateFrom = $SessionFilters['booking_date_from'];
}

if (isset($SessionFilters['booking_date_to']) && $SessionFilters['booking_date_to'] != '') {
    $BookingDateTo = $SessionFilters['booking_date_to'];
}

if (isset($SessionFilters['checkin_date_from']) && $SessionFilters['checkin_date_from'] != '') {
    $CheckInDateFrom = $SessionFilters['checkin_date_from'];
}

if (isset($SessionFilters['checkin_date_to']) && $SessionFilters['checkin_date_to'] != '') {
    $CheckInDateTo = $SessionFilters['checkin_date_to'];
}

if (isset($SessionFilters['booking_id']) && $SessionFilters['booking_id'] != '') {
    $BookingID = $SessionFilters['booking_id'];
}

if (isset($SessionFilters['Status']) && $SessionFilters['Status'] != '') {
    $Status = $SessionFilters['Status'];
}


//print_r($BookingDateFrom);
//print_r($BookingDateTo);
//print_r($CheckInDateFrom);
//print_r($CheckInDateTo);exit;

?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">HTL Balance Visa / Actual
                    <?php if ($CheckAccess['umrah_reports_stats_brn_hotel_hotel_brn_balance_actual_export']) { ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?= $path ?>exports/htl_balance_actual" target="_blank"> Export Record
                    </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="HTLBalanceActualForm" id="HTLBalanceActualForm"
                      onsubmit="HTLBalanceActualFormSubmit('HTLBalanceActualForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey"
                           value="HTLBalanceActualSessionFilter">
                    <input type="hidden" name="booking_date_from" id="booking_date_from"
                           value="<?= $BookingDateFrom ?>">
                    <input type="hidden" name="booking_date_to" id="booking_date_to"
                           value="<?= $BookingDateTo ?>">
                    <input type="hidden" name="checkin_date_from" id="checkin_date_from"
                           value="<?= $CheckInDateFrom ?>">
                    <input type="hidden" name="checkin_date_to" id="checkin_date_to"
                           value="<?= $CheckInDateTo ?>">
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
                                                <div class="col-md-3">
                                                    <label for="country">Booking Date</label>
                                                    <input onchange="GetBookingDate();" type="text"
                                                           class="form-control multidate"
                                                           name="booking_date" id="booking_date">
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Booking ID</label>
                                                        <input value="<?= $BookingID ?>" type="text" class="form-control"
                                                               name="booking_id"
                                                               id="booking_id">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">CheckIn Date</label>
                                                        <input type="text" onchange="GetCheckInDate();"
                                                               class="form-control multidate"
                                                               name="CheckInDate" id="CheckInDate">

                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Status</label>
                                                        <input type="text" class="form-control" name="Status"
                                                               value="<?= $Status ?>"
                                                               placeholder="Status">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="HTLBalanceActualAjaxResult"></div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button class="btn btn-success" type="submit">Search
                                                        </button>
                                                        <!--onclick="HTLBalanceActualFormSubmit('HTLBalanceActualForm');"-->
                                                        <button onclick="ClearFilters('HTLBalanceActualSessionFilter'); return false;"
                                                                class="btn btn-danger">Clear Filter
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
                    <?php
                    if (isset($SessionFilters) && $SessionFilters != '') { ?>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="ReportTable" class="table table-hover non-hover display nowrap cell-border"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Booking Date</th>
<!--                                <th>Expiry Date</th>-->
                                <th>BRN No</th>
                                <th>Booking ID</th>
                                <th>City</th>
                                <th>Hotel Name</th>
                                <th>Rooms</th>
                                <th>Beds</th>
                                <th>Check In </th>
                                <th>Check Out </th>
                                <th>Nights</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>

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

        // setTimeout(function (){
        //     $("#booking_date_from").val('');
        //     $("#booking_date_to").val('');
        //     $("#checkin_date_from").val('');
        //     $("#checkin_date_to").val('');
        // }, 1000);
        setTimeout(function () {

            var CheckinDateFrom = "<?=$CheckInDateFrom?>";
            var CheckinDateTo = "<?=$CheckInDateTo?>";
            $("#checkin_date_from").val(CheckinDateFrom);
            $("#checkin_date_to").val(CheckinDateTo);
            if (CheckinDateFrom != '' && CheckinDateTo != '') {
                $("#CheckInDate").val(CheckinDateFrom + " to " + CheckinDateTo);
            }

            var BookingDateFrom = "<?=$BookingDateFrom?>";
            var BookingDateTo = "<?=$BookingDateTo?>";
            $("#booking_date_from").val(BookingDateFrom);
            $("#booking_date_to").val(BookingDateTo);
            if (BookingDateFrom != '' && BookingDateTo != '') {
                $("#booking_date").val(BookingDateFrom + " to " + BookingDateTo);
            }
        }, 1000);



        var dataTable = $('#ReportTable').DataTable({
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
                "lengthMenu": "Show _MENU_ Hotel BRN balance Actual",
                "info": "Showing _START_ to _END_ of _TOTAL_ Hotel BRN balance Actual",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_hotel_brn_balance_actual_report",
                type: "POST",
                data: function (data) {
                    /*data.booking_date_from = $('#booking_date_from').val();
                    data.booking_date_to = $('#booking_date_to').val();
                    data.check_in_date_from = $('#check_in_date_from').val();
                    data.check_in_date_to = $('#check_in_date_to').val();
                    data.booking_id = $('#booking_id').val();
                    data.hotel_name = $('#hotel_name').val();
                    data.city = $('#city').val();*/
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
        $("#btnsearch").click(function () {
            dataTable.ajax.reload();
        });
        $('#btnreset').click(function () { //button reset event click
            $('#HotelPurchaseSearchFilters')[0].reset();
            $("#booking_date_from").val('');
            $("#booking_date_to").val('');
            $("#checkin_date_from").val('');
            $("#checkin_date_to").val('');
            dataTable.ajax.reload();  //just reload table
        });
    });

    function GetBookingDate() {
        const Date = $("#booking_date").val();
        const words = Date.split(' to ');
        // alert(words);
        $("#booking_date_from").val(words[0]);
        $("#booking_date_to").val(words[1]);
    }
    function GetCheckInDate() {
        const Date = $("#CheckInDate").val();
        const words = Date.split(' to ');
        $("#checkin_date_from").val(words[0]);
        $("#checkin_date_to").val(words[1]);
    }



    function HTLBalanceActualFormSubmit(parent) {

        //var dataTable = $('#SeatLossRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'HTLBalanceActualAjaxResult', 'alert-success', rslt.msg, 250);
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

            GridMessages('HTLBalanceActualForm', 'HTLBalanceActualAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#HTLBalanceActualForm input#booking_date_from").val('');
                $("form#HTLBalanceActualForm input#booking_date_to").val('');
                $("form#HTLBalanceActualForm input#checkin_date_to").val('');
                $("form#HTLBalanceActualForm input#checkin_date_from").val('');
                $("form#HTLBalanceActualForm")[0].reset();

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

    <?php if ($CheckAccess['umrah_reports_stats_brn_hotel_hotel_brn_balance_actual_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/htl_balance_actual" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
