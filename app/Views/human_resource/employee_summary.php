<?php

use App\Models\HRModel;

$HRModel = new HRModel();
$AllMonths = array(
    01 => 'January',
    02 => 'Feburary',
    03 => 'March',
    04 => 'April',
    05 => 'May',
    06 => 'June',
    07 => 'July',
    8 => 'August',
    9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December');


$session = session();
$SessionFilters = $session->get('EmployeeSummarySessionFilter');

$From = $To = $StartMonthDate = $EndMonthDate = '';
//print_r($SessionFilters);
//exit;

if (isset($SessionFilters['from']) && $SessionFilters['from'] != '') {
    $From = $SessionFilters['from'];
}

if (isset($SessionFilters['to']) && $SessionFilters['to'] != '') {
    $To = $SessionFilters['to'];
}

if ($From != '' && $To != '') {
    $StartMonthDate = $From;
    $EndMonthDate = $To;
} else {
    $Month = date("m");
    $Year = date("Y");
    $EndMonthDate = $Year . "-" . $Month . "-21";
    $StartMonthDate = date("Y-m-d", strtotime("-1 Month", strtotime($EndMonthDate)));
    $EndMonthDate = date("Y-m-d", strtotime("-1 day", strtotime($EndMonthDate)));

}


//
//if (isset($SessionFilters['SelectedMonth']) && $SessionFilters['SelectedMonth'] != '') {
//    $Month = $SessionFilters['SelectedMonth'];
//} else {
//    $Month = date("m");
//}

//if (isset($SessionFilters['SelectedYear']) && $SessionFilters['SelectedYear'] != '') {
//    $Year = $SessionFilters['SelectedYear'];
//} else {
//    $Year = date("Y");
//}
if (isset($SessionFilters['Departments']) && $SessionFilters['Departments'] != '') {
    $ArrayKey = array();
    $DepartmentsVariable = $SessionFilters['Departments'];
    foreach ($DepartmentsVariable as $key => $value) {
        $ArrayKey[] = $key;
    }
    $Departments = implode(',', $ArrayKey);
} else {
    $Departments = '';
}

//$AttendanceDates = $session->set('AttendanceDates');


function displayDates($date1, $date2, $format = 'd M,Y')
{
    $dates = array();
    $current = strtotime($date1);
    $date2 = strtotime($date2);
    $stepVal = '+1 day';
    while ($current <= $date2) {
        $dates[date('Y-m-d', $current)] = date($format, $current);
        $current = strtotime($stepVal, $current);
    }
    return $dates;
}

$dateArray = displayDates($StartMonthDate, $EndMonthDate);

?>


<h4 class="page-head"></h4>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Employee Summary
                    <?php if ($From != '' && $To != '') { ?>
                        <small>(<?= DATEFORMAT($From) ?>
                            - <?= DATEFORMAT($To) ?>) </small>
                    <?php } else { ?>
                        <small>(<?= DATEFORMAT($StartMonthDate) ?> -
                            <?= DATEFORMAT($EndMonthDate) ?>) </small>
                    <?php } ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right ml-2"
                       onclick="" href="<?= $path ?>excel_export/employee_summary" target="_blank">Excel Export
                    </a>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?= $path ?>exports/employee_summary" target="_blank">PDF Export
                    </a>
                    <!--                    --><?php //echo $StartMonthDate . " => " . $EndMonthDate;echo " --- Month " . $Month ?>
                    <!--                  --><?php
                    //                                                            echo "<pre>";
                    //                                                            print_r($dateArray);
                    //                                                            exit;
                    //                                                         ?>

                </h4>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="EmployeeSummaryForm" id="EmployeeSummaryForm"
                      onsubmit="EmployeeSummaryFormSubmit('EmployeeSummaryForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey"
                           value="EmployeeSummarySessionFilter">
                    <input type="hidden" name="from" id="from"
                           value="<?= $From ?>">
                    <input type="hidden" name="to" id="to"
                           value="<?= $To ?>">
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
                                                <!--                                                <div class="col-md-2">-->
                                                <!--                                                    <div class="form-group mb-3">-->
                                                <!--                                                        <input type="hidden" name="SessionKey" id="SessionKey"-->
                                                <!--                                                               value="EmployeeSummarySessionFilter">-->
                                                <!--                                                        <label>Select Year</label>-->
                                                <!--                                                        <select class="form-control " id="SelectedYear"-->
                                                <!--                                                                name="SelectedYear">-->
                                                <!--                                                            <option value="" selected disabled>Please Select</option>-->
                                                <!--                                                            --><?php //?>
                                                <!--                                                            <option value="2022" -->
                                                <? //= ($Year == 2022) ? 'Selected' : '' ?><!-- >-->
                                                <!--                                                                2022-->
                                                <!--                                                            </option>-->
                                                <!--                                                            <option value="2023" -->
                                                <? //= ($Year == 2023) ? 'Selected' : '' ?><!-- >-->
                                                <!--                                                                2023-->
                                                <!--                                                            </option>-->
                                                <!--                                                            --><?php //?>
                                                <!---->
                                                <!--                                                        </select>-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <!---->
                                                <!--                                                <div class="col-md-2">-->
                                                <!--                                                    <div class="form-group mb-3">-->
                                                <!--                                                        <input type="hidden" name="SessionKey" id="SessionKey"-->
                                                <!--                                                               value="EmployeeSummarySessionFilter">-->
                                                <!--                                                        <label>Select Month</label>-->
                                                <!--                                                        <select class="form-control " id="SelectedMonth"-->
                                                <!--                                                                name="SelectedMonth">-->
                                                <!--                                                            <option value="" selected disabled>Please Select</option>-->
                                                <!--                                                            --><?php
                                                //                                                            foreach ($AllMonths as $key => $value) {
                                                //                                                                $selected = (($Month == $key) ? 'selected' : '');
                                                //                                                                echo ' <option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
                                                //                                                            }
                                                //                                                            ?>
                                                <!---->
                                                <!--                                                        </select>-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->

                                                <div class="col-md-2">
                                                    <label for="country">From To</label>
                                                    <input onchange="FromToDate();" type="text"
                                                           class="form-control multidate"
                                                           name="from_to" id="from_to">
                                                </div>

                                                <div class="col-md-12" id="">
                                                    <hr>
                                                    <h5> Departments </h5>
                                                    <?php

                                                    $DepSelected = array();
                                                    $DepSelected = explode(',', $Departments);

                                                    //                                                                                  echo "<pre>";
                                                    //                                                                                  print_r($DepSelected);

                                                    foreach ($DepartmentsData as $value) {
                                                        $checked = (in_array($value['id'], $DepSelected)) ? 'checked' : '';

                                                        echo '<label class="new-checkbox checkbox-primary"
                                                               style="margin-right: 10px;">
                                                                         <input id="' . $value['id'] . ' " type="checkbox" class="" value="1"  
                                                                            name="Departments[' . $value['id'] . ']" style="margin-right: 7px;" ' . $checked . '>
                                                                      <span></span><strong>' . $value['dept_name'] . '</strong>
                                                        </label>';
                                                    } ?>

                                                </div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="EmployeeSummaryFormSubmit('EmployeeSummaryForm');"
                                                                id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('EmployeeSummarySessionFilter');"
                                                                id="btnreset" type="button" class="btn btn-danger">Clear
                                                            Filter
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="EmployeeSummaryAjaxResult"></div>

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
                        <table id="MainRecords" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Employee Name</th>
                                <th>Working Day</th>
                                <th>Presents</th>
                                <th>OnTime</th>
                                <th>Over Time</th>
                                <th>Late</th>
                                <th>Short Leave</th>
                                <th>Half Day</th>
                                <th>Absents</th>
                                <th>Leaves</th>

                                <?php
                                foreach ($dateArray as $key => $value) {
                                    '<th>' . $value . '</th>';
                                }
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $Color = '';
                            $cnt = 0;
                            $OfficalHolidays = $HRModel->OfficalHolidays();
                            $EmployeeAttendance = $HRModel->EmployeesSummaryReport();
                            $EmployeeLeaveCategory = $HRModel->GetEmployeesLeavesCategoryDataByDate();
                            //                              echo "<pre>";
                            //                              print_r($EmployeeLeaveCategory);
                            //                              exit;
                            foreach ($EmployeesData as $record) {
                                $cnt++; ?>
                                <?php
                                $Check = '';
                                $TotalLate = 0;
                                $TotalPresents = 0;
                                $TotalAbsents = 0;
                                $ShortLeave = 0;
                                $HalfDay = 0;
                                $OnTime = 0;
                                $TotalLeaves = 0;
                                foreach ($dateArray as $key => $value) {
                                    if (date("l", strtotime($key)) == 'Sunday' || in_array(date("Y-m-d", strtotime($key)), $OfficalHolidays)) {
                                        $Check .= '<td class="text-center"><strong>-</strong></td>';
                                    } else {
                                        $leave = '';
                                        if (isset($EmployeeAttendance[$record['id']][date("Y-m-d", strtotime($key))]['TimeIN']) && $EmployeeAttendance[$record['id']][date("Y-m-d", strtotime($key))]['TimeIN'] != '') {
                                            $PunchTime = date("H:i:s", strtotime($EmployeeAttendance[$record['id']][date("Y-m-d", strtotime($key))]['TimeIN']));
//                                                    $RuleTime = date("H:i:s", strtotime('9:15:0'));
                                            if (isset($EmployeeAttendance[$record['id']][date("Y-m-d", strtotime($key))]['LateStart'])) {
                                                $RuleTime = date("H:i:s", strtotime($EmployeeAttendance[$record['id']][date("Y-m-d", strtotime($key))]['LateStart']));
                                                $LateTime = TimeDiff($PunchTime, $RuleTime);
                                            } else {
                                                $LateTime = 0;
                                            }
                                            $LeaveCheck = '';
                                            if (isset($EmployeeLeaveCategory[$record['id']][date("Y-m-d", strtotime($key))])) {
                                                $LeaveCheck = '<strong> - ' . ucwords(str_replace('_', ' ', $EmployeeLeaveCategory[$record['id']][date("Y-m-d", strtotime($key))])) . '</strong>';
                                                $TotalLeaves = $TotalLeaves + 1;
                                            }
                                            $Check .= '<td class="text-center" style="background: lightgreen"><strong> P ' . (($LateTime > 0) ? "- " . gmdate("H:i:s", $LateTime) : $LeaveCheck) . '</strong></td>';

                                            if ($LateTime > 0 && $LateTime < 2700) {
                                                $TotalLate = $TotalLate + 1;
                                            } elseif ($LateTime > 2701 && $LateTime < 9000) {
                                                $ShortLeave = $ShortLeave + 1;
                                            } else if ($LateTime > 9001) {
                                                $HalfDay = $HalfDay + 1;
                                            } else {
                                                $OnTime = $OnTime + 1;
                                            }
                                            $TotalPresents = $TotalPresents + 1;
                                        } else {
                                            if (isset($EmployeeLeaveCategory[$record['id']][date("Y-m-d", strtotime($key))])) {
                                                $Check .= '<td class="text-center" style="background: lightgrey"><strong>' . ucwords(str_replace('_', ' ', $EmployeeLeaveCategory[$record['id']][date("Y-m-d", strtotime($key))])) . '</strong></td>';
                                                $TotalLeaves = $TotalLeaves + 1;
                                            } else {
                                                $future = DateDiff(date("Y-m-d"), $key);
                                                if ($future > 0) {
                                                    $Check .= '<td class="text-center"><strong>-</strong></td>';
                                                } else {
                                                    $Check .= '<td class="text-center" style="background: lightpink"><strong>A</strong></td>';
                                                    $TotalAbsents = $TotalAbsents + 1;
                                                }
                                            }
                                        }
                                    }
                                }
                                if (($ShortLeave + $HalfDay) > $TotalLeaves) {
                                    $Color = 'class ="alert alert-danger"';
                                }
                                else
                                {
                                    $Color = '';
                                }
                                ?>
                                <tr <?= $Color ?>>
                                    <td><?= $cnt ?></td>
                                    <td><a href="<?=SeoUrl('hr/employee_attendance/' . $record['id'] . "-" . $record['emp_firstname'] . "-" . $record['emp_lastname'])?>" target="_blank"><?= $record['emp_firstname'] . " " . $record['emp_lastname'] ?></a>
                                        <br>
                                        <badge class="badge badge-success badge-mini mt-1 mr-1 ml-0"><?= ($record['dept_name'] != '') ? $record['dept_name'] : '-'; ?></badge>
                                        <badge class="badge badge-success badge-mini mt-1 mr-1 ml-0"><?= ($record['emp_hiredate'] != '') ? date('d M,Y', strtotime($record['emp_hiredate'])) : '-' ?></badge>
                                    </td>
                                    <td>-</td>
                                    <td><?= $TotalPresents ?></td>
                                    <td><?= $OnTime ?></td>
                                    <td>-</td>
                                    <td><?= $TotalLate ?></td>
                                    <td><?= $ShortLeave ?></td>
                                    <td><?= $HalfDay ?></td>
                                    <td><?= $TotalAbsents ?></td>
                                    <td> <?= $TotalLeaves ?></td>
                                    <?php $Check ?>
                                </tr>
                            <?php } ?>
                            </tbody>
                            <!--                            <tfoot>-->
                            <!--                            <tr>-->
                            <!--                                <td colspan="2">Total : </td>-->
                            <!--                                <td>-</td>-->
                            <!--                                <td>-</td>-->
                            <!--                                <td>-</td>-->
                            <!--                                <td>-</td>-->
                            <!--                                <td>-</td>-->
                            <!--                                <td>-</td>-->
                            <!--                                <td>-</td>-->
                            <!--                                <td>-</td>-->
                            <!--                            </tr>-->
                            <!---->
                            <!--                            </tfoot>-->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" language="javascript">

    // $(document).ready(function () {
    //     $('#leavesTable').DataTable();
    // });

    $(document).ready(function () {

        setTimeout(function () {
            var From = "<?=$From?>";
            var To = "<?=$To?>";
            $("#from").val(From);
            $("#to").val(To);
            if (From != '' && To != '') {
                $("#from_to").val(From + " to " + To);
            }
        }, 1000);

    });

    function FromToDate() {

        const EntryDate = $("#from_to").val();
        const words = EntryDate.split(' to ');
        $("#from").val(words[0]);
        $("#to").val(words[1]);
    }

    function EmployeeSummaryFormSubmit(parent) {

        //var dataTable = $('#SeatLossRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'EmployeeSummaryAjaxResult', 'alert-success', rslt.msg, 250);
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

            GridMessages('EmployeeSummaryForm', 'EmployeeSummaryAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#EmployeeSummaryForm input#from").val('');
                $("form#EmployeeSummaryForm input#to").val('');
                $("form#EmployeeSummaryForm")[0].reset();

                location.reload();
                //dataTable.ajax.reload();
            }, 500);
        }
    }

    // function SaveDateFilterForm(parent) {
    //
    //     PlzWait('show');
    //     var data = $("form#" + parent).serialize();
    //
    //     var responce = AjaxResponse('filters_session/create_filters_session', data);
    //     if (responce.status == 'success') {
    //         $('form#AttendanceReportForm button#applybtn').attr("disabled", false);
    //         location.reload();
    //     }
    //
    // }
    //
    // function ClearSession(SessionKey) {
    //     PlzWait('show');
    //     $('form#AttendanceReportForm button#btnreset').attr("disabled", true);
    //     var responce = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
    //     if (responce.status == 'success') {
    //         $('form#AttendanceReportForm button#btnreset').attr("disabled", false);
    //         location.reload();
    //     }
    // }
    $('#MainRecords').DataTable({
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
        "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, 'All']],
        "pageLength": 100
    });
</script>


