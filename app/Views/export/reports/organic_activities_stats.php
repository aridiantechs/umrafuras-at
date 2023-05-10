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
                                            <td>' . ucwords($optionName) . '</td>
                                            ';
            foreach ($dateRange as $DR) {
                $RecordsCnt = (isset($Activities[$optionID][date("U", strtotime($DR))]) ? $Activities[$optionID][date("U", strtotime($DR))] : 0);
                $grandTotal[date("U", strtotime($DR))] += $RecordsCnt;
                echo ' <td  style="text-align: center">' . NUMBER($RecordsCnt) . ' </td>';
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
</table>