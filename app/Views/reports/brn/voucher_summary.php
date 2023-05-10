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
$SessionFilters = $session->get('VoucherSummarrySessionFilters');
$htl_category = '';


if (isset($SessionFilters['htl_category']) && $SessionFilters['htl_category'] != '') {
    $htl_category = $SessionFilters['htl_category'];
}


?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Voucher Summary
                    <?php if ($CheckAccess['umrah_reports_stats_voucher_voucher_summary_export']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/voucher_summary" target="_blank"> Export Record
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="VoucherSummarryForm" id="VoucherSummarryForm"
                      onsubmit="VoucherSummaryFormSubmit('VoucherSummarryForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey"
                           value="VoucherSummarrySessionFilters">
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
                                                        <label for="">HTL Category</label>
                                                        <input type="text" class="form-control" id="htl_category"
                                                               name="htl_category" placeholder="HTL Category"
                                                               value="<?= $htl_category ?>">
                                                    </div>
                                                </div>
                                                <!--<div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">From  To</label>
                                                        <input type="text" class="form-control multidate validate[required,future[now]]"
                                                               name="ArrivalReturn" id="ArrivalReturn" readonly
                                                               placeholder="ArrivalReturnDates" value=""
                                                               onchange="GetArrivalReturnDate();">

                                                    </div>
                                                </div>-->
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="VoucherSummaryFormSubmit('VoucherSummarryForm');"
                                                                id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('VoucherSummarrySessionFilters');"
                                                                id="btnreset" type="button" class="btn btn-danger">Clear
                                                            Filter
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="VoucherSummaryAjaxResult"></div>
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
                            <table id="VouchersSummaryRecord" class="table table-hover non-hover display nowrap "
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Hotel Category</th>
                                    <th>Total Voucher</th>
                                    <th>Total PAX</th>
                                    <th>Total Nights</th>
                                    <th>Total Room</th>
                                    <th>Sharing</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php /*                            $cnt = 0;
                                                        foreach ($records as $record) {
                                                            $cnt++;

                                                            echo '
                                                            <tr>
                                                            <td>' . $cnt . '</td>
                                                            <td>' . $record['Category'] . '</td>
                                                            <td>' . $record['Vouchers'] . '</td>
                                                            <td>' . $record['Pilgrims'] . '</td>
                                                            <td>' . $record['Nights'] . '</td>
                                                            <td>' . $record['Rooms'] . '</td>
                                                            <td>'.$record['Sharing'].'</td>
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

        <?php
        if(isset($SessionFilters) && $SessionFilters != ''){?>
        VouchersSummaryRecord();
        <?php }?>
    });
    function VouchersSummaryRecord() {
        var dataTable = $('#VouchersSummaryRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Vouchers Summary Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Vouchers Summary Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_voucher_summary_report",
                type: "POST",
                data: function (data) {
                    data.htl_category = $('#htl_category').val();
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
    $(document).ready(function () {
        $("#btnsearch").click(function () {
            VouchersSummaryRecord();
        });
        $('#btnreset').click(function () { //button reset event click
            $('#VouchersSummarySearchFilter')[0].reset();
            VouchersSummaryRecord(); //just reload table
        });
    });


    function VoucherSummaryFormSubmit(parent) {

        //var dataTable = $('#SeatLossRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'VoucherSummaryAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                //dataTable.ajax.reload();
                location.reload();
                // VouchersSummaryRecord();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        //var dataTable = $('#SeatLossRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('VoucherSummarryForm', 'VoucherSummaryAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                  $("form#VoucherSummarryForm")[0].reset();
                // VouchersSummaryRecord();
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

    <?php if ($CheckAccess['umrah_reports_stats_voucher_voucher_summary_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/stats_b2b" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
