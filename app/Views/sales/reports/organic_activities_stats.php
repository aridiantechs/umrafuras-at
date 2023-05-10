<?php

$Sess = session();
$OrganicActivitiesStatFilter = array();
$OrganicActivitiesStatFilter = $Sess->get('OrganicActivitiesStatFilter');
$CheckInDateFrom = date("Y-m-1");
$CheckInDateTo = date("Y-m-d");

if (isset($OrganicActivitiesStatFilter['checkin_date_from']) && $OrganicActivitiesStatFilter['checkin_date_from'] != '') {
    $CheckInDateFrom = $OrganicActivitiesStatFilter['checkin_date_from'];
}
if (isset($OrganicActivitiesStatFilter['checkin_date_to']) && $OrganicActivitiesStatFilter['checkin_date_to'] != '') {
    $CheckInDateTo = $OrganicActivitiesStatFilter['checkin_date_to'];
}

$dateRange = dateRange(date("Y-m-d", strtotime($CheckInDateFrom)), date("Y-m-d", strtotime($CheckInDateTo)));


//echo $CheckInDateFrom;
//echo $CheckInDateTo;
//exit;


?>

<h4 class="page-head"></h4>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
<!--                <h4 class="page-head"> Organic Activities Stats-->
<!---->
<!--                </h4>-->

                <h4 class="page-head">Organic Activities Stats
                    <?php if ($CheckAccess['umrah_reports_sales_export']) { ?>
<!--                        <a type="button" class="btn btn_customized  btn-sm float-right"-->
<!--                           onclick="" href="--><?//= $path ?><!--exports/organic_activities_stats" target="_blank">Export Records-->
<!--                        </a>-->
                    <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="OrganicActivitiesStats" id="OrganicActivitiesStats"
                      onsubmit="OrganicActivitiesStatsFormSubmit('OrganicActivitiesStats'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey"
                           value="OrganicActivitiesStatFilter">
                    <input type="hidden" name="checkin_date_from" id="checkin_date_from"
                           value="<?= $CheckInDateFrom ?>">
                    <input type="hidden" name="checkin_date_to" id="checkin_date_to"
                           value="<?= $CheckInDateTo ?>">
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
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="country">Start Date From To</label>
                                                        <input onchange="GetCheckInDate();" type="text"
                                                               class="form-control multidate validate[required,future[now]]"
                                                               name="checkin_date" id="checkin_date" readonly
                                                               placeholder="" value="" >
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group" style="float:right">
                                                        <label for="country"><br><br><br></label>
                                                        <button onclick="OrganicActivitiesStatsFormSubmit('OrganicActivitiesStats');"
                                                                id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('OrganicActivitiesStatFilter');"
                                                                id="btnreset" type="button" class="btn btn-danger">Clear
                                                            Filter
                                                        </button>
                                                    </div>

                                                </div>
                                                <div class="col-md-12" id="OrganicActivitiesStatsAjax"></div>

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
                    <div class="table-responsive mb-4 mt-4" style="overflow: auto;">
                        <table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>Sr. No</th>
                                <th>Activity Name</th>
                                <?php $totalDays = 0;
                                foreach ($dateRange as $DR) {
                                    $totalDays++;
                                    echo '<th  style="text-align: center">' . date("d M, Y", strtotime($DR)) . '</th>';
                                }
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $cnt = 0;
                            $Heads = $OrganicActivitiesReportData['heads'];
                            $Activities = $OrganicActivitiesReportData['stats'];
                            $grandTotal = array();
                            foreach ($Heads as $Head) {
                                $cnt = 0;
                                echo '
                                    <tr>
                                        <td colspan="' . (2 + $totalDays) . '" align="center">' . ucwords($Head['Name']) . '</td>
                                    </tr> ';
                                foreach ($Head['options'] as $optionID => $optionName) {
                                    $cnt++;
                                    echo '
                                        <tr>
                                            <td>' . $cnt . '</td>
                                            <td>' . ucwords($optionName). '</td>
                                            ';
                                    foreach ($dateRange as $DR) {
                                        $RecordsCnt = (isset($Activities[$optionID][date("U", strtotime($DR))]) ? $Activities[$optionID][date("U", strtotime($DR))] : 0);
                                        $grandTotal[date("U", strtotime($DR))] += $RecordsCnt;
                                        echo ' <th  style="text-align: center">' . NUMBER($RecordsCnt) . ' </th>';
                                    }
                                    echo '</tr> 
                                        ';
                                }
                            } ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="2">Total</th><?php
                                foreach ($dateRange as $DR) {
                                    echo '<th  style="text-align: center">' . NUMBER($grandTotal[date("U", strtotime($DR))]) . '</th>';
                                } ?>
                            </tr>
                            </tfoot>
                            <!--                            --><?php
                            //                            $Crud = new Crud();
                            //
                            //
                            //                            echo '<thead>
                            //                                   <tr>
                            //                                    <th>Sr.No</th>
                            //                                    <th>Activities</th>';
                            //                            $totaldates = 10;
                            //
                            //                            for ($i = $totaldates; $i > 0; $i--) {
                            //                                echo "<th>" . date('d-M-Y', strtotime("-$i days")) . "</th>";
                            //                            }
                            //                            echo '</tr>
                            //                                </thead>';
                            //
                            //                            echo '<tbody>';
                            //                            $cnt = 0;
                            //                            $SumForColSpan = $totaldates + $RemainingTableHead = 2;
                            //                            foreach ($OrganicLookups as $allLookup) {
                            //                                $table = 'main."Lookups"';
                            //                                $where = array("Key" => $allLookup['Key']);
                            //                                $data['lookup'] = $Crud->SingleRecord($table, $where);
                            //                                $table = 'main."LookupsOptions"';
                            //                                $where = array("LookupID" => $data['lookup']['UID'], "Archive" => "0");
                            //                                $data['records'] = $Crud->ListRecords($table, $where, array("Name" => "ASC"));
                            //
                            //
                            //                                echo '<tr>
                            //                                        <td colspan="' . $SumForColSpan . '" style="text-align:center; background-color: beige;"><strong>' . ucwords(str_replace("-", " ", $allLookup['Name'])) . '</strong></td>
                            //                                      </tr>';
                            //                                $cnt++;
                            //
                            //                                foreach ($data['records'] as $value) {
                            //                                    echo '<tr>
                            //
                            //                                                   <td>' . $cnt . '</td>
                            //                                                   <td>'.ucwords($value['Name']).'--.'.$value['UID'].' </td>';
                            //
                            //
                            //                                    for ($j = 0; $j < $totaldates; $j++) {
                            //                                        echo '<td>' . $cnt . '' . $j . '0</td>';
                            //                                    }
                            //                                    echo '</tr>';
                            //
                            //                                }
                            //
                            //                            }
                            //                            echo '</tbody>';
                            //                            ?>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    //$('#ReportTable').DataTable({
    //    "scrollX": true,
    //    "oLanguage": {
    //        "oPaginate": {
    //            "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
    //            "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
    //        },
    //        "sInfo": "Showing page _PAGE_ of _PAGES_",
    //        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
    //        "sSearchPlaceholder": "Search...",
    //        "sLengthMenu": "Results :  _MENU_",
    //    },
    //    "stripeClasses": [],
    //    "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
    //    "pageLength": 100
    //});
    //

    //      ' . ucwords(str_replace("Organic Platform", "", $allLookup['Name'])) . '

    setTimeout(function () {
        $('<a href="<?=$path?>exports/organic_activities_stats" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);

    setTimeout(function () {
        //alert(<?//=$CheckInDateFrom?>//);
        //alert(<?//=$CheckInDateTo?>//);

        var SessionCheckInDateFrom = "<?=$CheckInDateFrom?>";
        var SessionCheckInDateTo = "<?=$CheckInDateTo?>";
        $("#checkin_date_from").val(SessionCheckInDateFrom);
        $("#checkin_date_to").val(SessionCheckInDateTo);
        if (SessionCheckInDateFrom != '' && SessionCheckInDateTo != '') {
            $("#checkin_date").val(SessionCheckInDateFrom + " to " + SessionCheckInDateTo);
        }
    }, 1000);

    function OrganicActivitiesStatsFormSubmit(parent) {

        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'OrganicActivitiesStatsAjax', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                location.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('OrganicActivitiesStats', 'OrganicActivitiesStatsAjax', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#OrganicActivitiesStats input#checkin_date_from").val('');
                $("form#OrganicActivitiesStats input#checkin_date_to").val('');
                $("form#OrganicActivitiesStats")[0].reset();
                location.reload();
            }, 500);
        }
    }

    function GetCheckInDate() {
        const EntryDate = $("#checkin_date").val();
        const words = EntryDate.split(' to ');
        $("#checkin_date_from").val(words[0]);
        $("#checkin_date_to").val(words[1]);
    }

</script>
