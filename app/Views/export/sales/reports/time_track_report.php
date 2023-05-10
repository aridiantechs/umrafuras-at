<?php


$Sess = session();
$TimeTrackFilter = array();
$TimeTrackFilter = $Sess->get('TimeTrackFilter');
$StartDate = $EndDate =  '';

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
