<!--  BEGIN CONTENT AREA  -->

<?php

use App\Models\Crud;

$Crud = new Crud();

$session = session();
$SessionFilters = $session->get('AgentWorkSessionFilters');
$start_date_from = $start_date_to = $end_date_from = $end_date_to = $country = $agent = $Company = '';


if (isset($SessionFilters['start_date_from']) && $SessionFilters['start_date_from'] != '') {
    $start_date_from = $SessionFilters['start_date_from'];
}

if (isset($SessionFilters['start_date_to']) && $SessionFilters['start_date_to'] != '') {
    $start_date_to = $SessionFilters['start_date_to'];
}

if (isset($SessionFilters['end_date_from']) && $SessionFilters['end_date_from'] != '') {
    $end_date_from = $SessionFilters['end_date_from'];
}

if (isset($SessionFilters['end_date_to']) && $SessionFilters['end_date_to'] != '') {
    $end_date_to = $SessionFilters['end_date_to'];
}

if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $country = $SessionFilters['country'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $agent = $SessionFilters['agent'];
}

if (isset($SessionFilters['company']) && $SessionFilters['company'] != '') {
    $Company = $SessionFilters['company'];
}

?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Agent Work Report
                    <?php if ($CheckAccess['umrah_reports_stats_statistics_agent_work_report_export']) { ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?= $path ?>exports/agent_work_report" target="_blank">Export Records
                    </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="AgentWorkReportForm" id="AgentWorkReportForm"
                      onsubmit="AgentWorkReportFormSubmit('AgentWorkReportForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey"
                           value="AgentWorkSessionFilters">
                    <input type="hidden" name="start_date_from" id="start_date_from" value="<?=$start_date_from?>">
                    <input type="hidden" name="start_date_to" id="start_date_to" value="<?=$start_date_to?>">
                    <input type="hidden" name="end_date_from" id="end_date_from" value="<?=$end_date_from?>">
                    <input type="hidden" name="end_date_to" id="end_date_to" value="<?=$end_date_to?>">
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
                                                        <label for="">Country</label>
                                                        <select class="form-control" id="country"
                                                                name="country">
                                                            <option value="">Please Select</option>
                                                            <?= Countries('html') ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Agent Name</label>
                                                        <select class="form-control" id="agent"
                                                                name="agent">
                                                            <?= $AgentsDropDown['html'] ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Start Date</label>
                                                        <input type="text" class="form-control multidate"
                                                               name="start_date" id="start_date"
                                                               placeholder="Dates" value=""
                                                               onchange="GetStartDate();">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">End Date</label>
                                                        <input type="text" class="form-control multidate"
                                                               name="end_date" id="end_date"
                                                               placeholder="Dates" value=""
                                                               onchange="GetEndDate();">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="AgentWorkReportFormSubmit('AgentWorkReportForm');"
                                                                id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('AgentWorkSessionFilters');"
                                                                id="btnreset" type="button" class="btn btn-danger">Clear
                                                            Filter
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="AgentWorkReportAjaxResult"></div>
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
                        <table id="AllAgentWorkReportRecord" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Package</th>
                                <th>Accommodation</th>
                                <th>Self Accommodation</th>
                                <th>Visa</th>
                                <th>Without Visa</th>
                                <th>Total PAX</th>
                                <th>Category</th>
                                <th>Reference</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- --><?php
                            /*                            $cnt=0;
                                                        $count=0;
                                                        $sumArray = array();;

                                                        foreach ($records as $record) {
                                                            $cnt++;
                                                            $Category='B2C';
                                                            if($record['AgentUID']>0){
                                                                $Category='B2B';
                                                            }
                                                            $sumArray['Accommodation']+=$record['Accommodation'];
                                                            $sumArray['SelfAccommodation']+=$record['SelfAccommodation'];
                                                            $sumArray['Visa']+=$record['Visa'];
                                                            $sumArray['NotVisa']+=$record['NotVisa'];
                                                            $sumArray['TotalPax']+=$record['TotalPax'];
                                                            echo '
                                                            <tr>
                                                            <td>'.$cnt.'</td>
                                                            <td>' . $record['CountryName'] . '</td>
                                                            <td>' . $record['AgentName'] . '</td>

                                                            <td>' .DATEFORMAT($record['StartDate']). '</td>
                                                            <td>' .DATEFORMAT($record['ExpireDate']). '</td>
                                                            <td>' . $record['PackageName'] . '</td>
                                                            <td>' . $record['Accommodation'] . '</td>
                                                            <td>' . $record['SelfAccommodation'] . '</td>
                                                            <td>' . $record['Visa'] . '</td>
                                                            <td>' . $record['NotVisa'] . '</td>
                                                            <td>' . $record['TotalPax'] . '</td>
                                                            <td>' . $Category . '</td>
                                                            <td>'.$record['ReferenceName'].'</td>

                                                            </tr> ';

                                                        }
                                                        */ ?>
                            </tbody>
                            <!--<tr>
                                <td  colspan="6" align="center"> Total : </td>

                                <td><?php /*echo $sumArray['Accommodation'];*/ ?></td>
                                <td><?php /*echo $sumArray['SelfAccommodation'];*/ ?> </td>
                                <td><?php /*echo $sumArray['Visa'];*/ ?> </td>
                                <td><?php /*echo $sumArray['NotVisa'];*/ ?> </td>
                                <td><?php /*echo $sumArray['TotalPax'];*/ ?> </td>


                                <td> - </td>
                                <td> - </td>
                            </tr>-->
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
            var start_date_from = "<?=$start_date_from?>";
            var start_date_to = "<?=$start_date_to?>";
            $("#start_date_from").val(start_date_from);
            $("#start_date_to").val(start_date_to);
            if (start_date_from != '' && start_date_to != '') {
                $("#start_date").val(start_date_from + " to " + start_date_to);
            }

            var end_date_from = "<?=$end_date_from?>";
            var end_date_to = "<?=$end_date_to?>";
            $("#start_date_from").val(end_date_from);
            $("#start_date_to").val(end_date_to);
            if (end_date_from != '' && end_date_to != '') {
                $("#end_date").val(end_date_from + " to " + end_date_to);
            }
        }, 1000);

        <?php
        if(isset($SessionFilters) && $SessionFilters != ''){?>
        AllAgentWorkReportRecord();
        <?php }?>
    });
    function AllAgentWorkReportRecord(){
       $('#AllAgentWorkReportRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ All Agent Work Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ All Agent Work Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_all_agent_work_report",
                type: "POST",
                data: function (data) {
                    data.country = $('#country').val();
                    data.agent = $('#agent').val();
                    data.reference = $('#reference').val();
                    data.start_date_from = $('#start_date_from').val();
                    data.start_date_to = $('#start_date_to').val();
                    data.end_date_from = $('#end_date_from').val();
                    data.end_date_to = $('#end_date_to').val();
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
            $('#AgentWorkReportSearchFilter')[0].reset();
            $("#start_date_from").val('');
            $("#start_date_to").val('');
            $("#end_date_from").val('');
            $("#end_date_to").val('');
            location.reload();
        });
    });

    function GetStartDate() {
        const Date = $("#start_date").val();
        const words = Date.split(' to ');
        $("#start_date_from").val(words[0]);
        $("#start_date_to").val(words[1]);
    }
    function GetEndDate() {
        const Date = $("#end_date").val();
        const words = Date.split(' to ');
        $("#end_date_from").val(words[0]);
        $("#end_date_to").val(words[1]);
    }


    function AgentWorkReportFormSubmit(parent) {

        //var dataTable = $('#SeatLossRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'AgentWorkReportAjaxResult', 'alert-success', rslt.msg, 250);
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

            GridMessages('AgentWorkReportForm', 'AgentWorkReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#AgentWorkReportForm input#end_date_from").val('');
                $("form#AgentWorkReportForm input#end_date_to").val('');
                $("form#AgentWorkReportForm input#start_date_from").val('');
                $("form#AgentWorkReportForm input#start_date_to").val('');
                $("form#AgentWorkReportForm")[0].reset();

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
    <?php if ($CheckAccess['umrah_reports_stats_statistics_agent_work_report_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/agent_work_report" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>
</script>
