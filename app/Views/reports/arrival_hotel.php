<?php

$session = session();
$SessionFilters = $session->get('ArrivalHotelReportSessionFilters');
$Country = $Agent = $CheckInDateFrom = $CheckInDateTo = $City = $VoucherCode = $Hotel =  '';

if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $Country = $SessionFilters['country'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $Agent = $SessionFilters['agent'];
}

if (isset($SessionFilters['checkin_date_from']) && $SessionFilters['checkin_date_from'] != '') {
    $CheckInDateFrom = $SessionFilters['checkin_date_from'];
}

if (isset($SessionFilters['checkin_date_to']) && $SessionFilters['checkin_date_to'] != '') {
    $CheckInDateTo = $SessionFilters['checkin_date_to'];
}

if (isset($SessionFilters['voucher_code']) && $SessionFilters['voucher_code'] != '') {
    $VoucherCode = $SessionFilters['voucher_code'];
}

if (isset($SessionFilters['city']) && $SessionFilters['city'] != '') {
    $City = $SessionFilters['city'];
}

if (isset($SessionFilters['hotel']) && $SessionFilters['hotel'] != '') {
    $Hotel = $SessionFilters['hotel'];
}
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Arrival Hotel Report
                    <?php if ($CheckAccess['umrah_reports_stats_hotel_arrival_hotel_export'] && isset($SessionFilters) && $SessionFilters != '') { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/arrival_hotel" target="_blank">Export Records
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="ArrivalHotelReportForm" id="ArrivalHotelReportForm"
                      onsubmit="ArrivalHotelReportFormSubmit('ArrivalHotelReportForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey"
                           value="ArrivalHotelReportSessionFilters">
                    <input type="hidden" name="checkin_date_from" id="checkin_date_from"
                           value="<?=$CheckInDateFrom?>">
                    <input type="hidden" name="checkin_date_to" id="checkin_date_to"
                           value="<?=$CheckInDateTo?>">
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
                                            <label for="country">CheckIn Date</label>
                                            <input onchange="GetCheckInDate();" type="text"
                                                   class="form-control multidate"
                                                   name="checkin_date" id="checkin_date">
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Voucher Code</label>
                                                <input value="<?=$VoucherCode?>" type="text" class="form-control" name="voucher_code"
                                                       id="voucher_code">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">City</label>
                                                <input value="<?=$City?>" type="text" class="form-control" name="city"
                                                       id="city">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Hotel</label>
                                                <input value="<?=$Hotel?>" type="text" class="form-control" name="hotel"
                                                       id="hotel">
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="ArrivalHotelReportAjaxResult"></div>
                                        <div class="col-md-12" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="ArrivalHotelReportFormSubmit('ArrivalHotelReportForm');"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('ArrivalHotelReportSessionFilters');"
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
                        <table id="ArrivalHotelRecord" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>BRN</th>
                                <th>V. No</th>
                                <th>HTL Category</th>
                                <th>City</th>
                                <th>HTL Name</th>
                                <th>Room Type</th>
                                <th>PAX</th>
                                <th>Beds</th>
                                <th>Nights</th>
                                <th>Origin</th>
                                <th>CHK In Date & Time</th>
                                <th>PAX Mob. No</th>
                                <th>Category</th>
                                <th>Reference</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!--                            --><?php
                            //                            for ($i = 1; $i < 10; $i++) {
                            //                                echo '
                            //                                <tr>
                            //                                <td>' . $i . '</td>
                            //                                <td>Saudi Arabia</td>
                            //                                <td>Dummy IATA Name</td>
                            //                                <td>2983429487</td>
                            //                                <td>434</td>
                            //
                            //
                            //                                <td>5 Star</td>
                            //                                <td>Mecca</td>
                            //                                <td>Al Furas</td>
                            //                                <td>Sharing</td>
                            //                                 <td>15</td>
                            //                                 <td>5</td>
                            //                                 <td>5</td>
                            //                                  <td>Isb</td>
                            //                                   <td>13 Apr, 2021 12:00 am</td>
                            //                                <td>03365564654</td>
                            //                                <td>b2c</td>
                            //                                <td>Usman Khan</td>
                            //                                <td>Yes</td>
                            //
                            //
                            //                                </tr> ';
                            //                            }
                            //                            ?>
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
            var SessionCheckInDateFrom = "<?=$CheckInDateFrom?>";
            var SessionCheckInDateTo = "<?=$CheckInDateTo?>";
            $("#checkin_date_from").val(SessionCheckInDateFrom);
            $("#checkin_date_to").val(SessionCheckInDateTo);
            if (SessionCheckInDateFrom != '' && SessionCheckInDateTo != '') {
                $("#checkin_date").val(SessionCheckInDateFrom + " to " + SessionCheckInDateTo);
            }
        }, 1000);

        <?php
        if(isset($SessionFilters) && $SessionFilters != ''){?>
        ArrivalHotelRecord();
        <?php }?>

    });

    function ArrivalHotelRecord(){
        $('#ArrivalHotelRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Arrival Hotel Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Arrival Hotel Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_arrival_hotel_report",
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

    function GetCheckInDate() {

        const EntryDate = $("#checkin_date").val();
        const words = EntryDate.split(' to ');
        $("#checkin_date_from").val(words[0]);
        $("#checkin_date_to").val(words[1]);
    }

    function ArrivalHotelReportFormSubmit(parent) {

        //var dataTable = $('#ArrivalHotelRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'ArrivalHotelReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                location.reload();
                //dataTable.ajax.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        //var dataTable = $('#ArrivalHotelRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('ArrivalHotelReportForm', 'ArrivalHotelReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#ArrivalHotelReportForm input#checkin_date_from").val('');
                $("form#ArrivalHotelReportForm input#checkin_date_to").val('');
                $("form#ArrivalHotelReportForm")[0].reset();

                location.reload();
                //dataTable.ajax.reload();
            }, 500);
        }
    }
</script>
<script type="application/javascript">

    /* $('#ReportTable').DataTable({
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
    <?php if ($CheckAccess['umrah_reports_stats_hotel_arrival_hotel_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/arrival_hotel" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>
</script>
