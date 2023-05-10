<?php

use App\Models\Crud;

$Crud = new Crud();

$session = session();
$SessionFilters = $session->get('ExecutedVoucherSessionFilters');
$arrival_date_from = $arrival_date_to = $departure_date_from = $departure_date_to = $expiry_date_from = $Hotel = '';


if (isset($SessionFilters['arrival_date_from']) && $SessionFilters['arrival_date_from'] != '') {
    $arrival_date_from = $SessionFilters['arrival_date_from'];
}

if (isset($SessionFilters['arrival_date_to']) && $SessionFilters['arrival_date_to'] != '') {
    $arrival_date_to = $SessionFilters['arrival_date_to'];
}

if (isset($SessionFilters['departure_date_from']) && $SessionFilters['departure_date_from'] != '') {
    $departure_date_from = $SessionFilters['departure_date_from'];
}

if (isset($SessionFilters['departure_date_to']) && $SessionFilters['departure_date_to'] != '') {
    $departure_date_to = $SessionFilters['departure_date_to'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $Agent = $SessionFilters['agent'];
}

if (isset($SessionFilters['voucher_no']) && $SessionFilters['voucher_no'] != '') {
    $voucher_no = $SessionFilters['voucher_no'];
}


?>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Executed Voucher
                    <?php if ($CheckAccess['umrah_reports_stats_voucher_executed_voucher_export']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/executed_voucher" target="_blank">Export Records
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="ExecutedVoucherReportForm" id="ExecutedVoucherReportForm"
                      onsubmit="ExecutedVoucherReportFormSubmit('ExecutedVoucherReportForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="ExecutedVoucherSessionFilters">

                    <input type="hidden" name="arrival_date_from" id="arrival_date_from" value="<?=$arrival_date_from?>">
                    <input type="hidden" name="arrival_date_to" id="arrival_date_to" value="<?=$arrival_date_to?>">
                    <input type="hidden" name="departure_date_from" id="departure_date_from" value="<?=$departure_date_from?>">
                    <input type="hidden" name="departure_date_to" id="departure_date_to" value="<?=$departure_date_to?>">
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
                                                        <label for="country">V. No</label>
                                                        <input id="voucher_no" type="text" class="form-control"
                                                               name="voucher_no" placeholder="Voucher Number" value="<?=$voucher_no?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Arrival Date</label>
                                                        <input onchange="GetArrivalDate();" type="text"
                                                               class="form-control multidate"
                                                               name="arrival_date" id="arrival_date">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Departure Date</label>
                                                        <input onchange="GetDepartureDate();" type="text"
                                                               class="form-control multidate "
                                                               name="departure_date" id="departure_date">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="ExecutedVoucherReportAjaxResult"></div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="ExecutedVoucherReportFormSubmit('ExecutedVoucherReportForm'); return false;"
                                                                class="btn btn-success">Display Record
                                                        </button>
                                                        <button onclick="ClearSession('ExecutedVoucherSessionFilters'); return false;"
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
                    <div class="table-responsive mb-4 mt-4">
                        <table id="ExecutedVoucherRecord" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Create Date</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>Sub Agent Name</th>
                                <th>Create By</th>
                                <th>Voucher Ref. ID</th>
                                <th>Voucher No</th>
                                <th>Adult</th>
                                <th>Child</th>
                                <th>Infant</th>
                                <th>Total PAX</th>
                                <th>Arrival</th>
                                <th>Departure</th>
                                <th>Total Nights</th>
                                <th>Arrival Mode</th>
                                <th>Status</th>
                                <th>Category</th>
                                <th>Reference</th>
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
                                                            <td>'.DATEFORMAT($record['CreatedDate']).'</td>
                                                            <td>' . $record['CountryName'] . '</td>
                                                            <td>' . $record['AgentName'] . '</td>
                                                            <td>' . $record['SubAgentName'] . '</td>
                                                            <td>'.$record['UserCreatedBy'].'</td>
                                                            <td>'.Code('UF/V/', $record['UID']).'</td>
                                                            <td>'.$record['VoucherCode'].'</td>
                                                            <td>'.$record['Adults'].'</td>
                                                            <td>'.$record['Child'].'</td>
                                                            <td>'.$record['Infant'].'</td>
                                                            <td>'.$record['TotalPilgrim'].'</td>
                                                            <td>'.DATEFORMAT($record['ArrivalDate']).'</td>
                                                            <td>'.DATEFORMAT($record['DepartureDate']).'</td>
                                                            <td>'.$record['TotalNights'].'</td>
                                                            <td>N/A</td>
                                                            <td>N/A</td>

                                                            <td>' . ucfirst(str_replace("_"," ",$record['IATAType'])). '</td>
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

    // setTimeout(function (){
    //     $("#arrival_date_from").val('');
    //     $("#arrival_date_to").val('');
    //     $("#departure_date_from").val('');
    //     $("#departure_date_to").val('');
    // }, 1000);

    $(document).ready(function () {


        setTimeout(function () {
            var arrival_date_from = "<?=$arrival_date_from?>";
            var arrival_date_to = "<?=$arrival_date_to?>";
            $("#arrival_date_from").val(arrival_date_from);
            $("#arrival_date_to").val(arrival_date_to);
            if (arrival_date_from != '' && arrival_date_to != '') {
                $("#arrival_date").val(arrival_date_from + " to " + arrival_date_to);
            }


            var departure_date_from = "<?=$departure_date_from?>";
            var departure_date_to = "<?=$departure_date_to?>";
            $("#departure_date_from").val(departure_date_from);
            $("#departure_date_to").val(departure_date_to);
            if (departure_date_from != '' && departure_date_to != '') {
                $("#departure_date").val(departure_date_from + " to " + departure_date_to);
            }
        }, 1000);

        <?php
        if(isset($SessionFilters) && $SessionFilters != ''){?>
        ExecutedVoucherRecord();
        <?php }?>
    });

    function ExecutedVoucherRecord() {
        $('#ExecutedVoucherRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Executed Vouchers Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Executed Vouchers Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_all_executed_vouchers_report",
                type: "POST",
                data: function (data) {
                    data.agent = $('#agent').val();
                    data.voucher_no = $('#voucher_no').val();
                    data.arrival_date_from = $('#arrival_date_from').val();
                    data.arrival_date_to = $('#arrival_date_to').val();
                    data.departure_date_from = $('#departure_date_from').val();
                    data.departure_date_to = $('#departure_date_to').val();
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
        $('#ExecutedVouchersSearchFilters')[0].reset();
        $("#arrival_date_from").val('');
        $("#arrival_date_to").val('');
        $("#departure_date_from").val('');
        $("#departure_date_to").val('');
        location.reload();
    });

    function GetArrivalDate() {
        const Date = $("#arrival_date").val();
        const words = Date.split(' to ');
        $("#arrival_date_from").val(words[0]);
        $("#arrival_date_to").val(words[1]);
    }

    function GetDepartureDate() {
        const Date = $("#departure_date").val();
        const words = Date.split(' to ');
        $("#departure_date_from").val(words[0]);
        $("#departure_date_to").val(words[1]);
    }

    function ExecutedVoucherReportFormSubmit(parent) {

        //var dataTable = $('#SeatLossRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'ExecutedVoucherReportAjaxResult', 'alert-success', rslt.msg, 250);
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

            GridMessages('ExecutedVoucherReportForm', 'ExecutedVoucherReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#ExecutedVoucherReportForm input#arrival_date_from").val('');
                $("form#ExecutedVoucherReportForm input#arrival_date_to").val('');
                $("form#ExecutedVoucherReportForm input#departure_date_from").val('');
                $("form#ExecutedVoucherReportForm input#departure_date_to").val('');
                $("form#ExecutedVoucherReportForm")[0].reset();


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


    <?php if ($CheckAccess['umrah_reports_stats_voucher_executed_voucher_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/hotel_summary_report" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
