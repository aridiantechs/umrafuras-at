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
$SessionFilters = $session->get('HotelPurchaseSessionFilters');
$BookingDateFrom = $BookingDateTo = $BookingID = $expiry_date_to = $expiry_date_from = $Hotel = '';


if (isset($SessionFilters['booking_date_from']) && $SessionFilters['booking_date_from'] != '') {
    $BookingDateFrom = $SessionFilters['booking_date_from'];
}

if (isset($SessionFilters['booking_date_to']) && $SessionFilters['booking_date_to'] != '') {
    $BookingDateTo = $SessionFilters['booking_date_to'];
}

if (isset($SessionFilters['check_in_date_from']) && $SessionFilters['check_in_date_from'] != '') {
    $check_in_date_from = $SessionFilters['check_in_date_from'];
}

if (isset($SessionFilters['check_in_date_to']) && $SessionFilters['check_in_date_to'] != '') {
    $check_in_date_to = $SessionFilters['check_in_date_to'];
}

if (isset($SessionFilters['booking_id']) && $SessionFilters['booking_id'] != '') {
    $BookingID = $SessionFilters['booking_id'];
}

if (isset($SessionFilters['Hotel']) && $SessionFilters['Hotel'] != '') {
    $Hotel = $SessionFilters['Hotel'];
}


?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Hotel BRN Purchase
                    <?php if ($CheckAccess['umrah_reports_stats_brn_hotel_hotel_brn_purchase_export']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/htl_purchase" target="_blank"> Export Record
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                    <form method="post" name="HotelPurchaseReportForm" id="HotelPurchaseReportForm"
                          onsubmit="HotelPurchaseReportFormSubmit('HotelPurchaseReportForm'); return false;">
                        <input type="hidden" name="SessionKey" id="SessionKey" value="HotelPurchaseSessionFilters">
                    <input type="hidden" name="booking_date_from" id="booking_date_from" value="<?=$BookingDateFrom?>">
                    <input type="hidden" name="booking_date_to" id="booking_date_to" value="<?=$BookingDateTo?>">
                    <input type="hidden" name="check_in_date_from" id="check_in_date_from" value="<?=$check_in_date_from?>">
                    <input type="hidden" name="check_in_date_to" id="check_in_date_to" value="<?=$check_in_date_to?>">
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
                                                    <div class="form-group">
                                                        <label for="country">Booking Date </label>
                                                        <input onchange="GetBookingDate();" type="text"
                                                               class="form-control multidate"
                                                               name="booking_date" id="booking_date">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">CheckIn Date</label>
                                                        <input onchange="GetCheckInDate();" type="text"
                                                               class="form-control multidate"
                                                               name="check_in_date" id="check_in_date">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Booking ID</label>
                                                        <input type="text" class="form-control" id="booking_id"
                                                               name="booking_id" placeholder="Booking ID">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Hotel Name</label>
                                                        <select class="form-control validate[required]" id="Hotel"
                                                                name="Hotel">
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            foreach ($hotels as $hotel) {
                                                                echo '<option value="' . $hotel['UID'] . '"' . (($Hotel == $hotel['UID']) ? 'selected' : '') . '>' . $hotel['Name'] . '</option>  ';
                                                            }

                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-12" id="HotelPurchaseAjaxResult"></div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="HotelPurchaseReportFormSubmit('HotelPurchaseReportForm'); return false;"
                                                                class="btn btn-success">Display Record
                                                        </button>
                                                        <button onclick="ClearSession('HotelPurchaseSessionFilters'); return false;"
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
                        <table id="HotelPurchaseRecord" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Booking Date</th>
                                <th>Expiry Date</th>
                                <th>BRN No</th>
                                <th>Booking ID</th>
                                <th>City</th>
                                <th>Hotel Name</th>
                                <th>Rooms</th>
                                <th>Beds</th>
                                <th>CHK In Date</th>
                                <th>CHK Out Date</th>
                                <th>Nights</th>
                                <th>Purchased By</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            /*                            $cnt = 0;
                                                        foreach ($records as $record) {
                                                            $cnt++;

                                                            echo '
                                                            <tr>
                                                                <td>' . $cnt . '</td>
                                                                <td>' . DATEFORMAT($record['GenerateDate']) . '</td>
                                                                <td>' . DATEFORMAT($record['ExpireDate']) . '</td>
                                                                <td>' . ((isset($record['BRNCode'])) ? $record['BRNCode'] : '-') . '</td>
                                                                <td>' . ((isset($record['PurchaseID'])) ? $record['PurchaseID'] : '-') . '</td>

                                                                <td>' . ((isset($record['CityName'])) ? $record['CityName'] : '-') . '</td>
                                                                <td>' . $record['HotelName'] . '</td>
                                                                <td>' . ((isset($record['Rooms'])) ? $record['Rooms'] : '-') . '</td>
                                                                <td>' . ((isset($record['Beds'])) ? $record['Beds'] : '-') . '</td>
                                                                <td>' . ((isset($record['ChechInDate'])) ? DATEFORMAT($record['ChechInDate']) : '-') . '</td>
                                                                <td>' . ((isset($record['CheckOutDate'])) ? DATEFORMAT($record['CheckOutDate']) : '-') . '</td>
                                                                <td>' . ((isset($record['TotalNights'])) ? $record['TotalNights'] : '-') . '</td>
                                                                <td>' . $record['PurchasedBy']. '</td>


                                                            </tr> ';
                                                        }
                                                        */ ?>

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
            var CheckinDateFrom = "<?=$expiry_date_from?>";
            var CheckinDateTo = "<?=$expiry_date_to?>";
            $("#expiry_date_from").val(CheckinDateFrom);
            $("#expiry_date_to").val(CheckinDateTo);
            if (CheckinDateFrom != '' && CheckinDateTo != '') {
                $("#check_in_date").val(CheckinDateFrom + " to " + CheckinDateTo);
            }
        }, 1000);

        <?php
        if(isset($SessionFilters) && $SessionFilters != ''){?>
        HotelPurchaseRecord();
        <?php }?>
    });


    $(document).ready(function () {

        // setTimeout(function () {
        //     $("#booking_date_from").val('');
        //     $("#booking_date_to").val('');
        //     $("#check_in_date_from").val('');
        //     $("#check_in_date_to").val('');
        // }, 1000);

        function HotelPurchaseRecord() {
            $('#HotelPurchaseRecord').DataTable({
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
                    "lengthMenu": "Show _MENU_ Hotel Purchase Report",
                    "info": "Showing _START_ to _END_ of _TOTAL_ Hotel Purchase Report",
                },
                "ajax": {
                    url: "<?= $path ?>reports/fetch_all_hotel_purchase_report",
                    type: "POST",
                    data: function (data) {
                        data.booking_date_from = $('#booking_date_from').val();
                        data.booking_date_to = $('#booking_date_to').val();
                        data.check_in_date_from = $('#check_in_date_from').val();
                        data.check_in_date_to = $('#check_in_date_to').val();
                        data.booking_id = $('#booking_id').val();
                        data.hotel_name = $('#hotel_name').val();
                        data.city = $('#city').val();
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

        $("#btnsearch").click(function () {
            location.reload();
        });
        $('#btnreset').click(function () { //button reset event click
            $('#HotelPurchaseSearchFilters')[0].reset();
            $("#booking_date_from").val('');
            $("#booking_date_to").val('');
            $("#check_in_date_from").val('');
            $("#check_in_date_to").val('');
            location.reload();  //just reload table
        });
    });

    function GetBookingDate() {
        const Date = $("#booking_date").val();
        const words = Date.split(' to ');
        $("#booking_date_from").val(words[0]);
        $("#booking_date_to").val(words[1]);
    }

    function GetCheckInDate() {
        const Date = $("#check_in_date").val();
        const words = Date.split(' to ');
        $("#check_in_date_from").val(words[0]);
        $("#check_in_date_to").val(words[1]);
    }


    function HotelPurchaseReportFormSubmit(parent) {

        //var dataTable = $('#SeatLossRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'HotelPurchaseAjaxResult', 'alert-success', rslt.msg, 250);
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

            GridMessages('HotelPurchaseReportForm', 'HotelPurchaseAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#HotelPurchaseReportForm input#booking_date_from").val('');
                $("form#HotelPurchaseReportForm input#booking_date_to").val('');
                $("form#HotelPurchaseReportForm input#check_in_date_from").val('');
                $("form#HotelPurchaseReportForm input#check_in_date_from").val('');
                $("form#HotelPurchaseReportForm")[0].reset();


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

    <?php if ($CheckAccess['umrah_reports_stats_brn_hotel_hotel_brn_purchase_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/htl_purchase" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
