<?php

$session = session();
$SessionFilters = $session->get('ActualUsedTransportReportSessionFilters');
$Agent = $CheckOutDateFrom = $CheckOutDateTo = $City = $VoucherCode = '';

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $Agent = $SessionFilters['agent'];
}

if (isset($SessionFilters['checkout_date_from']) && $SessionFilters['checkout_date_from'] != '') {
    $CheckOutDateFrom = $SessionFilters['checkout_date_from'];
}

if (isset($SessionFilters['checkout_date_to']) && $SessionFilters['checkout_date_to'] != '') {
    $CheckOutDateTo = $SessionFilters['checkout_date_to'];
}

if (isset($SessionFilters['voucher_code']) && $SessionFilters['voucher_code'] != '') {
    $VoucherCode = $SessionFilters['voucher_code'];
}

if (isset($SessionFilters['city']) && $SessionFilters['city'] != '') {
    $City = $SessionFilters['city'];
}
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Actual Used Transport
                    <?php if ($CheckAccess['umrah_reports_stats_transport_actual_used_export'] && isset($SessionFilters) && $SessionFilters != '') { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/transport_report" target="_blank">Export Records
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="ActualUsedTransportReportForm" id="ActualUsedTransportReportForm"
                      onsubmit="ActualUsedTransportReportFormSubmit('ActualUsedTransportReportForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey"
                           value="ActualUsedTransportReportSessionFilters">
                    <input type="hidden" name="checkout_date_from" id="checkout_date_from"
                           value="<?= $CheckOutDateFrom ?>">
                    <input type="hidden" name="checkout_date_to" id="checkout_date_to"
                           value="<?= $CheckOutDateTo ?>">
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
                            <div id="FilterDetails" class="collapse show " aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">
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
                                                    <label for="country">CheckOut Date</label>
                                                    <input onchange="GetCheckOutDate();" type="text"
                                                           class="form-control multidate"
                                                           name="checkout_date" id="checkout_date">
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Voucher Code</label>
                                                        <input value="<?= $VoucherCode ?>" type="text"
                                                               class="form-control" name="voucher_code"
                                                               id="voucher_code">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">City</label>
                                                        <input value="<?= $City ?>" type="text" class="form-control"
                                                               name="city"
                                                               id="city">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="ActualUsedTransportReportAjaxResult"></div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="ActualUsedTransportReportFormSubmit('ActualUsedTransportReportForm');"
                                                                id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('ActualUsedTransportReportSessionFilters');"
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
                    <?php
                    if (isset($SessionFilters) && $SessionFilters != '') { ?>
                        <div class="table-responsive mb-4 mt-4">
                            <table id="ActualUsedTransportRecord" class="table table-hover non-hover display nowrap"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Agent Name</th>
                                    <th>BRN</th>
                                    <th>V. No</th>
                                    <th>CHK Out Date</th>
                                    <th>CHK Out Time</th>
                                    <th>City</th>
                                    <th>Pick Up Point</th>
                                    <th>Actual Hotel</th>
                                    <th>Room No</th>
                                    <th>Pax</th>
                                    <th>Seats</th>
                                    <th>Actual Dep Time</th>
                                    <th>Sector</th>
                                    <th>Destination</th>
                                    <th>TPT Type</th>
                                    <th>Vehicle Number</th>
                                    <th>Driver Name</th>
                                    <th>Driver Mob. Number</th>
                                    <th>Pax Mob. No</th>
                                    <th>TPT Company</th>
                                    <th>Category</th>
                                    <th>Reference</th>

                                </tr>
                                </thead>
                                <tbody>
                                <!--                            --><?php
                                //                            for($i=1;$i<10;$i++)
                                //                            {
                                //                                echo '
                                //                                <tr>
                                //                                <td>'.$i.'</td>
                                //                                <td>Dummy IATA Name</td>
                                //                                <td>98</td>
                                //                               <td>10:00 am</td>
                                //                                <td>Mecca</td>
                                //                                <td>Hotel</td>
                                //                                <td>Al Furas</td>
                                //                                <td>54</td>
                                //                                <td>5</td>
                                //
                                //                                <td>7</td>
                                //                                <td>Business</td>
                                //                                <td>Jeddah</td>
                                //                                <td>JP-1845</td>
                                //                                <td>Usman</td>
                                //                                <td>03665465468</td>
                                //                                <td>0355464678</td>
                                //                                <td>Furas Company</td>
                                //                                <td>b2c</td>
                                //                                <td>Usman Khan</td>
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
            var SessionCheckOutDateFrom = "<?=$CheckOutDateFrom?>";
            var SessionCheckOutDateTo = "<?=$CheckOutDateTo?>";
            $("#checkout_date_from").val(SessionCheckOutDateFrom);
            $("#checkout_date_to").val(SessionCheckOutDateTo);
            if (SessionCheckOutDateFrom != '' && SessionCheckOutDateTo != '') {
                $("#checkout_date").val(SessionCheckOutDateFrom + " to " + SessionCheckOutDateTo);
            }
        }, 1000);

        <?php
        if(isset($SessionFilters) && $SessionFilters != ''){?>
        ActualUsedTransportRecord();
        <?php }?>

    });

    function ActualUsedTransportRecord(){

        $('#ActualUsedTransportRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Actual Used Transport",
                "info": "Showing _START_ to _END_ of _TOTAL_ Actual Used Transport",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_actual_used_transport_report",
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

    function GetCheckOutDate() {

        const EntryDate = $("#checkout_date").val();
        const words = EntryDate.split(' to ');
        $("#checkout_date_from").val(words[0]);
        $("#checkout_date_to").val(words[1]);
    }

    function ActualUsedTransportReportFormSubmit(parent) {

        //var dataTable = $('#ActualUsedTransportRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'ActualUsedTransportReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                location.reload();
               // dataTable.ajax.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        //var dataTable = $('#ActualUsedTransportRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('ActualUsedTransportReportForm', 'ActualUsedTransportReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#ActualUsedTransportReportForm input#checkout_date_from").val('');
                $("form#ActualUsedTransportReportForm input#checkout_date_to").val('');
                $("form#ActualUsedTransportReportForm")[0].reset();

                location.reload();
                // dataTable.ajax.reload();
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

    <?php if ($CheckAccess['umrah_reports_stats_transport_actual_used_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/transport_report" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>
</script>
