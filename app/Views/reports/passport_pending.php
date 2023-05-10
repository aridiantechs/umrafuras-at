<!--  BEGIN CONTENT AREA  -->
<?php

use App\Models\Crud;

$Crud = new Crud();

$session = session();
$SessionFilters = $session->get('PassportPendingSessionFilters');
//print_r($SessionFilters);exit;
$ArrivalDateFrom = $ArrivalDateTo = $BookingID = $VehicleType = $Company = '';

if (isset($SessionFilters['arrival_date_from']) && $SessionFilters['arrival_date_from'] != '') {
    $ArrivalDateFrom = $SessionFilters['arrival_date_from'];
}

if (isset($SessionFilters['arrival_date_to']) && $SessionFilters['arrival_date_to'] != '') {
    $ArrivalDateTo = $SessionFilters['arrival_date_to'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $agent = $SessionFilters['agent'];
}

if (isset($SessionFilters['group']) && $SessionFilters['group'] != '') {
    $group = $SessionFilters['group'];
}

if (isset($SessionFilters['ppt_number']) && $SessionFilters['ppt_number'] != '') {
    $ppt_number = $SessionFilters['ppt_number'];
}

if (isset($SessionFilters['full_name']) && $SessionFilters['full_name'] != '') {
    $full_name = $SessionFilters['full_name'];
}

if (isset($SessionFilters['company']) && $SessionFilters['company'] != '') {
    $Company = $SessionFilters['company'];
}

?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Passport Pending
                    <?php if ($CheckAccess['umrah_reports_stats_passport_management_passport_pending_export']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/passport_pending" target="_blank"> Export Record
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="PassportPendingReportForm" id="PassportPendingReportForm"
                      onsubmit="PassportPendingFormSubmit('PassportPendingReportForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey"
                           value="PassportPendingSessionFilters">
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
                                            <div class="form-group">
                                                <label for="country">Agent</label>
                                                <select class="form-control" id="agent"
                                                        name="agent">
                                                    <?= $AgentsDropDown['html'] ?>
                                                </select>
                                            </div>
                                        </div>
<!--                                        <div class="col-md-2">-->
<!--                                            <div class="form-group">-->
<!--                                                <label for="country">Group</label>-->
<!--                                                <input type="text" class="form-control"-->
<!--                                                       name="group" id="group" value="--><?//=$group?><!--">-->
<!--                                            </div>-->
<!--                                        </div>-->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">PPT#</label>
                                                <input type="text" class="form-control"
                                                       name="ppt_number" id="ppt_number" value="<?=$ppt_number?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Full Name</label>
                                                <input type="text" class="form-control"
                                                       name="full_name" id="full_name" value="<?=$full_name?>">
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
                                        <div class="col-md-12" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="PassportPendingFormSubmit('PassportPendingReportForm');"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('PassportPendingSessionFilters');"
                                                        id="btnreset" type="button" class="btn btn-danger">Clear
                                                    Filter
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="PassportPendingAjaxResult"></div>
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
                            <table id="PassportPendingRecord" class="table table-hover non-hover display nowrap"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ref.ID</th>
                                    <th>Agent</th>
                                    <th>Group</th>
                                    <th>Full Name</th>
                                    <th>PPT Number</th>
                                    <th>Actual Arrival Date</th>
                                    <th>Arrival Port</th>
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
                                                                <td>' . Code("UF/A/",$record['AgentUID']) . '</td>
                                                                <td>' . $record['AgentName'] . '</td>
                                                                <td>' . $record['GroupName'] . '</td>
                                                                <td>' . $record['FullName'] . '</td>
                                                                <td>' . $record['PPNO'] . '</td>
                                                                <td>' . ((isset($record['ActualArrivalDate'])) ? DATEFORMAT($record['ActualArrivalDate']) : '-') . '</td>
                                                                <td>' . ((isset($record['EntryPort'])) ? $record['EntryPort'] : '-') . '</td>


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

    setTimeout(function () {
        var ArrivalDateFrom = "<?=$ArrivalDateFrom?>";
        var ArrivalDateTo = "<?=$ArrivalDateTo?>";
        $("#arrival_date_from").val(ArrivalDateFrom);
        $("#arrival_date_to").val(ArrivalDateTo);
        if (ArrivalDateFrom != '' && ArrivalDateTo != '') {
            $("#arrival_date").val(ArrivalDateFrom + " to " + ArrivalDateTo);
        }
    }, 1000);

    setTimeout(function () {

        <?php
        if(isset($SessionFilters) && $SessionFilters != ''){?>
        PassportPendingRecord();
        <?php }?>

    }, 1000);


    function PassportPendingRecord() {

        $('#PassportPendingRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Passport Pending Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Passport Pending Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_passport_pending_report",
                type: "POST",
                data: function (data) {
                    data.arrival_date_from = $('#arrival_date_from').val();
                    data.arrival_date_to = $('#arrival_date_to').val();
                    data.agent = $('#agent').val();
                    data.group = $('#group').val();
                    data.ppt_number = $('#ppt_number').val();
                    data.full_name = $('#full_name').val();
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
            location.reload();
        });
        $('#btnreset').click(function () { //button reset event click
            $('#PassportPendingReportForm')[0].reset();
            location.reload();
        });
    });


    function GetArrivalDate() {

        const EntryDate = $("#arrival_date").val();
        const words = EntryDate.split(' to ');
        $("#arrival_date_from").val(words[0]);
        $("#arrival_date_to").val(words[1]);
    }

    function PassportPendingFormSubmit(parent) {

        //var dataTable = $('#SeatLossRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'PassportPendingAjaxResult', 'alert-success', rslt.msg, 250);
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

            GridMessages('PassportPendingReportForm', 'PassportPendingAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#PassportPendingReportForm input#arrival_date_from").val('');
                $("form#PassportPendingReportForm input#arrival_date_to").val('');
                $("form#PassportPendingReportForm")[0].reset();

                location.reload();
                //dataTable.ajax.reload();
            }, 500);
        }
    }

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


    <?php if ($CheckAccess['umrah_reports_stats_passport_management_passport_pending_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/passport_pending" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>


</script>
