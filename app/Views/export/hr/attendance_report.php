<?php

use App\Models\HRModel;

$HRModel = new HRModel();

$session = session();
$SessionFilters = $session->get('AttendenceReportSessionFilter');
//print_r($SessionFilters);
if (isset($SessionFilters['SelectedMonth']) && $SessionFilters['SelectedMonth'] != '') {
    $Month = $SessionFilters['SelectedMonth'];
} else {
    $Month = date("m");
}
if (isset($SessionFilters['SelectedYear']) && $SessionFilters['SelectedYear'] != '') {
    $Year = $SessionFilters['SelectedYear'];
} else {
    $Year = date("Y");
}

$EndMonthDate = $Year . "-" . $Month . "-21";
$StartMonthDate = date("Y-m-d", strtotime("-1 Month", strtotime($EndMonthDate)));
$EndMonthDate = date("Y-m-d", strtotime("-1 day", strtotime($EndMonthDate)));
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
    <table id="leavesTable" class="table table-hover non-hover display nowrap"
           style="width:100%">
        <thead>
        <tr>
            <th>Sr.No</th>
            <th>Employee Name</th>
            <th>Presents</th>
            <th>OnTime</th>
            <th>Over Time</th>
            <th>Late</th>
            <th>Leaves</th>
            <th>Short Leave</th>
            <th>Half Day</th>
            <th>Absents</th>

            <?php
            foreach ($dateArray as $key => $value) {
            if (date("l", strtotime($key)) != 'Sunday') {
                echo '<th>' . $value . '</th>';
            }
            }
            ?>
        </tr>
        </thead>
        <tbody>
        <?php
        $cnt = 0;
        $OfficalHolidays = $HRModel->OfficalHolidays();
        $EmployeeAttendance = $HRModel->EmployeesLastMonthAttendance();
        $EmployeeLeaveCategory = $HRModel->GetLeavesCategoryDataByDate();
        //                              echo "<pre>";
        //                              print_r($EmployeeLeaveCategory);
        //                              exit;
        foreach ($EmployeesData as $record) {
            $cnt++; ?>
            <tr>
                <td><?= $cnt ?></td>
                <td><?= $record['emp_firstname'] . " " . $record['emp_lastname'] ?>
                    <br>
                    <badge class="badge badge-success badge-mini mt-1 mr-1 ml-0"><?= ($record['dept_name'] != '') ? $record['dept_name'] : '-'; ?></badge>
                    <badge class="badge badge-success badge-mini mt-1 mr-1 ml-0"><?= ($record['emp_hiredate'] != '') ? date('d M,Y', strtotime($record['emp_hiredate'])) : '-' ?></badge>
                </td>

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
                    if (date("l", strtotime($key)) != 'Sunday') {
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
                                    $LateTime = 1;
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


                }
                ?>
                <td><?= $TotalPresents ?></td>
                <td><?= $OnTime ?></td>
                <td>-</td>
                <td><?= $TotalLate ?></td>
                <td><?= $TotalLeaves ?></td>
                <td><?= $ShortLeave ?></td>
                <td><?= $HalfDay ?></td>
                <td><?= $TotalAbsents ?></td>
                <?= $Check ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>