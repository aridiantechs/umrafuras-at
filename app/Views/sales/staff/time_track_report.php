<?php


$Sess = session();
$TimeTrackFilter = array();
$TimeTrackFilter = $Sess->get('TimeTrackFilter');
$StartDate = $EndDate = '';

if (isset($TimeTrackFilter['StartDate']) && $TimeTrackFilter['StartDate'] != '') {
    $StartDate = $TimeTrackFilter['StartDate'];
}
if (isset($TimeTrackFilter['EndDate']) && $TimeTrackFilter['EndDate'] != '') {
    $EndDate = $TimeTrackFilter['EndDate'];
}

$Heads = $TimeTrackReport['heads'];
$Status = $TimeTrackReport['status'];
$LeadsStats = $TimeTrackReport['stats'];
$LeadsDuration = $TimeTrackReport['duration'];

$StartDate = ((isset($Filters['StartDate']) && $Filters['StartDate'] != '') ? $Filters['StartDate'] : date("Y-m-d"));
$EndDate = ((isset($Filters['EndDate']) && $Filters['EndDate'] != '') ? $Filters['EndDate'] : date("Y-m-d"));

$StartTime = ((isset($Filters['StartTime']) && $Filters['StartTime'] != '') ? $Filters['StartTime'] : '');
$EndTime = ((isset($Filters['EndTime']) && $Filters['EndTime'] != '') ? $Filters['EndTime'] : 'date("Y-m-d")');


?>

<h4 class="page-head"></h4>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head"> Time Track Report (<?= $LeadsDuration ?>)

                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form name="TimeTrackFilterForm" id="TimeTrackFilterForm" class="section contact">
                    <input type="hidden" name="StartDate" id="StartDate" value="<?= $StartDate ?>">
                    <input type="hidden" name="EndDate" id="EndDate" value="<?= $EndDate ?>">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="TimeTrackFilter">

                    <div id="toggleAccordion">
                        <div class="card">
                            <div class="card-header">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class="" data-toggle="collapse"
                                         data-target="#FilterDetails" aria-expanded="false"
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
                                                        <label for="country">Start Date From To</label>
                                                        <input onchange="GetfromTo();" type="text"
                                                               class="form-control multidate"
                                                               name="FromTo" id="FromTo">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button id="multiple-messages"
                                                            class=" btn btn-danger float-right"
                                                            onclick="ClearSession('TimeTrackFilter');">Clear
                                                    </button>

                                                    <button id="multiple-messages"
                                                            class="mr-2 btn btn-success float-right"
                                                            onclick="TimeTrackFiltersFormSubmit('TimeTrackFilterForm');">
                                                        Apply
                                                    </button>
                                                </div>

                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group" id="AjaxResult">

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
                        <table id="TimeTrackReportTable" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Agents Name</th><?php
                                foreach ($Status as $St) {
                                    echo '<th  style="text-align: center">' . ucwords($St) . '</th>';
                                } ?>
                                <th>Total Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $cnt = 0;
                            $grandTotal = array();
                            $GrandTotalAgents = array();
                            foreach ($Heads as $Headid => $HeadName) {
                                $cnt++; ?>
                                <tr>
                                <td><?= $cnt ?></td>
                                <td><?= ucwords($HeadName) ?></td><?php
                                $duration = array();
                                foreach ($Status as $St) {
                                    $RecordsCnt = (isset($LeadsStats[$Headid][$St]) ? $LeadsStats[$Headid][$St] : '-');
                                    if ($RecordsCnt != '-') $grandTotal[$St][] = $RecordsCnt;
                                    echo '<td style="text-align: center">' . $RecordsCnt . '</td>';
                                    if ($RecordsCnt != '-') $duration[] = $RecordsCnt;
                                    // echo '<th style="text-align: center">' . NUMBER($RecordsCnt) . '</th>';
                                } ?>
                                <td style="text-align: center"><?= TotalDuration($duration) ?></td>
                                </tr><?php
                            } ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="2"> Total</th><?php
                                $GrandTotal = array();
                                foreach ($Status as $St) {
                                    $TDur = TotalDuration($grandTotal[$St]);
                                    $GrandTotal[] = $TDur;
                                    echo '<th style="text-align: center">' . $TDur . '</th>';
                                } ?>
                                <th style="text-align: center"><?= TotalDuration($GrandTotal) ?></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>



    </div>
</div>
</div>

<script type="application/javascript">
    function GetfromTo() {
        const Date = $("#FromTo").val();
        const words = Date.split(' to ');
        $("#StartDate").val(words[0]);
        $("#EndDate").val(words[1]);
    }


    $('#TimeTrackReportTable').DataTable({
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
    });

    setTimeout(function () {
        $('<a href="<?=$path?>exports/time_track_report" target="_blank" class="btn btn_customized  btn-sm float-right">Export Records</a>').appendTo(".table-responsive");
    }, 100);


    function TimeTrackFiltersFormSubmit(parent) {

        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {
            GridMessages(parent, 'AjaxResult', 'alert alert-success', rslt.msg, 250);
            setTimeout(function () {
                location.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {


        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('TimeTrackFilterForm', 'AjaxResult', 'alert alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#TimeTrackFilterForm input#StartDate").val('');
                $("form#TimeTrackFilterForm input#EndDate").val('');
                $("form#TimeTrackFilterForm")[0].reset();
                location.reload();
            }, 500);
        }
    }

    $(document).ready(function () {

        setTimeout(function () {
            var SessionStartDate = "<?=$StartDate?>";
            var SessionEndDate = "<?=$EndDate?>";
            $("#StartDate").val(SessionStartDate);
            $("#EndDate").val(SessionEndDate);
            if (SessionStartDate != '' && SessionEndDate != '') {
                $("#FromTo").val(SessionStartDate + " to " + SessionEndDate);
            }
        }, 1000);
    });
</script>

