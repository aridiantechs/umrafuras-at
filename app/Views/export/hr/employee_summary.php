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
<div class="table-responsive mb-4 mt-4" style="overflow: auto;">
    <h2> Employee Summary : <?php if ($From != '' && $To != '') { ?> <small>(<?= DATEFORMAT($From) ?> - <?= DATEFORMAT($To) ?>) </small>
        <?php } else { ?>  <small>(<?= DATEFORMAT($StartMonthDate) ?> - <?= DATEFORMAT($EndMonthDate) ?>
            ) </small> <?php } ?>
    </h2>
    <table id="MainRecords" class="table table-hover non-hover display nowrap"
           style="width:100%">
        <thead>
        <tr>
            <th>Sr.No</th>
            <th>Employee Name</th>
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
            ?>
            <tr <?= $Color ?>>
                <td><?= $cnt ?></td>
                <td><?= $record['emp_firstname'] . " " . $record['emp_lastname'] ?>
                </td>
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