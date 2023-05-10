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
$SessionFilters = $session->get('HotelUseVisaSessionFilters');
$BookingDateFrom = $BookingDateTo = $BookingID = $expiry_date_to = $expiry_date_from = $Hotel = '';


if (isset($SessionFilters['booking_date_from']) && $SessionFilters['booking_date_from'] != '') {
    $BookingDateFrom = $SessionFilters['booking_date_from'];
}

if (isset($SessionFilters['booking_date_to']) && $SessionFilters['booking_date_to'] != '') {
    $BookingDateTo = $SessionFilters['booking_date_to'];
}

if (isset($SessionFilters['expiry_date_from']) && $SessionFilters['expiry_date_from'] != '') {
    $expiry_date_from = $SessionFilters['expiry_date_from'];
}

if (isset($SessionFilters['expiry_date_to']) && $SessionFilters['expiry_date_to'] != '') {
    $expiry_date_to = $SessionFilters['expiry_date_to'];
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
                <h4 class="page-head">Hotel BRN use Visa
                    <?php if ($CheckAccess['umrah_reports_stats_brn_hotel_hotel_brn_use_visa_export']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/htl_use_visa" target="_blank"> Export Record
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="HotelUseActualReportForm" id="HotelUseActualReportForm"
                      onsubmit="HotelUseVisaReportFormSubmit('HotelUseActualReportForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="HotelUseVisaSessionFilters">
                    <input type="hidden" name="booking_date_from" id="booking_date_from"
                           value="<?= $BookingDateFrom ?>">
                    <input type="hidden" name="booking_date_to" id="booking_date_to" value="<?= $BookingDateTo ?>">
                    <input type="hidden" name="expiry_date_from" id="expiry_date_from" value="<?= $expiry_date_from ?>">
                    <input type="hidden" name="expiry_date_to" id="expiry_date_to" value="<?= $expiry_date_to ?>">
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
                                                <label for="">Expiry Date</label>
                                                <input onchange="GetExpiryDate();" type="text"
                                                       class="form-control multidate"
                                                       name="expiry_date" id="expiry_date">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Booking ID</label>
                                                <input type="text" class="form-control" id="booking_id"
                                                       name="booking_id" placeholder="Booking ID"
                                                       value="<?= $BookingID ?>">
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

                                        <div class="col-md-12" id="HotelUseVisaAjaxResult"></div>
                                        <div class="col-md-12" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="HotelUseVisaReportFormSubmit('HotelUseActualReportForm'); return false;"
                                                        class="btn btn-success">Display Record
                                                </button>
                                                <button onclick="ClearSession('HotelUseVisaSessionFilters'); return false;"
                                                        class="btn btn-danger">Clear Filter
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
                            <table id="HotelUseVisaRecord" class="table table-hover non-hover display nowrap"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Booking Date</th>
                                    <th>Expiry Date</th>
                                    <th>BRN No</th>
                                    <th>Booking ID</th>
                                    <th>Use ID</th>
                                    <th>Used Date</th>
                                    <th>City</th>
                                    <th>Hotel Name</th>
                                    <th>Room</th>
                                    <th>Beds</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Nights</th>
                                    <th>User</th>
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
                                                                    <td>N/A</td>
                                                                    <td>N/A</td>

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
            var ExpiryDateFrom = "<?=$expiry_date_from?>";
            var ExpiryDateTo = "<?=$expiry_date_to?>";
            $("#expiry_date_from").val(ExpiryDateFrom);
            $("#expiry_date_to").val(ExpiryDateTo);
            if (ExpiryDateFrom != '' && ExpiryDateTo != '') {
                $("#expiry_date").val(ExpiryDateFrom + " to " + ExpiryDateTo);
            }
        }, 1000);

        <?php
        if(isset($SessionFilters) && $SessionFilters != ''){?>
        HotelUseVisaRecord();
        <?php }?>
    });

    function HotelUseVisaRecord() {
        $('#HotelUseVisaRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Hotel Use Visa Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Hotel Use Visa Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_all_hotel_use_visa_report",
                type: "POST",
                data: function (data) {
                    data.booking_date_from = $('#booking_date_from').val();
                    data.booking_date_to = $('#booking_date_to').val();
                    data.expiry_date_from = $('#expiry_date_from').val();
                    data.expiry_date_to = $('#expiry_date_to').val();
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
        $('#HotelUseVisaSearchFilters')[0].reset();
        $("#booking_date_from").val('');
        $("#booking_date_to").val('');
        $("#expiry_date_from").val('');
        $("#expiry_date_to").val('');
        $("#check_in_date_from").val('');
        $("#check_in_date_to").val('');
        location.reload();
    });


    function GetBookingDate() {
        const Date = $("#booking_date").val();
        const words = Date.split(' to ');
        $("#booking_date_from").val(words[0]);
        $("#booking_date_to").val(words[1]);
    }

    function GetExpiryDate() {
        const Date = $("#expiry_date").val();
        const words = Date.split(' to ');
        $("#expiry_date_from").val(words[0]);
        $("#expiry_date_to").val(words[1]);
    }


    function HotelUseVisaReportFormSubmit(parent) {

        //var dataTable = $('#SeatLossRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'HotelUseVisaAjaxResult', 'alert-success', rslt.msg, 250);
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

            GridMessages('HotelUseActualReportForm', 'HotelUseVisaAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#HotelUseActualReportForm input#booking_date_from").val('');
                $("form#HotelUseActualReportForm input#booking_date_to").val('');
                $("form#HotelUseActualReportForm input#expiry_date_from").val('');
                $("form#HotelUseActualReportForm input#expiry_date_to").val('');
                $("form#HotelUseActualReportForm")[0].reset();


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

    <?php if ($CheckAccess['umrah_reports_stats_brn_hotel_hotel_brn_use_visa_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/htl_use_visa" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
