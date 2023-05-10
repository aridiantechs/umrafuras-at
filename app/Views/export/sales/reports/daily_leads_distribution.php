<?php
$Heads = $DailyLeadsActivityReport['heads'];
$Status = $DailyLeadsActivityReport['status'];
$LeadsStats = $DailyLeadsActivityReport['stats'];

//$LeadsStatusDef = array();
$LeadStatusArray = [
    'new' => 'New',
    'rate_issue' => 'Rate Issue',
    'follow_ups' => 'Follow Ups',
    'call_back' => 'Call Back',
    'sale' => 'Sale', 'close' => 'Close'
];
foreach ($LeadStatusArray as $StatusKey => $StatusValue) {
    $LeadsStatusDef[$StatusKey] = $StatusValue;
}

$session = session();
$SessionFilters = $session->get('DailyLeadDistributionSessionFilters');

if (isset($SessionFilters['product']) && $SessionFilters['product'] != '') {
    $Product = $SessionFilters['product'];
}
$StartDate = ((isset($SessionFilters['start_date']) && $SessionFilters['start_date'] != '') ? $SessionFilters['start_date'] : date("Y-m-d"));
$EndDate = ((isset($SessionFilters['end_date']) && $SessionFilters['end_date'] != '') ? $SessionFilters['end_date'] : date("Y-m-d"));

$StartTime = ((isset($SessionFilters['start_time']) && $SessionFilters['start_time'] != '') ? $SessionFilters['start_time'] : '');
$EndTime = ((isset($SessionFilters['end_time']) && $SessionFilters['end_time'] != '') ? $SessionFilters['end_time'] : '');
?>
<table class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>Sr.No</th>
        <th>Agent Name</th>
        <?php
        foreach ($Status as $St) {
            echo '<th  style="text-align: center">' . (($St == 'sms') ? 'Details on SMS' : $LeadsStatusDef[$St]) . '</th>';
        } ?>
        <th>Total Leads</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (count($Heads) > 0) {
        $cnt = 0;
        $grandTotal = array();
        $GrandTotalAgents = array();
        foreach ($Heads as $Headid => $HeadName) {
            $cnt++; ?>
            <tr>
            <td><?= $cnt ?></td>
            <td><?= ucwords($HeadName) ?></td><?php
            foreach ($Status as $St) {
                $RecordsCnt = (isset($LeadsStats[$Headid][$St]) ? $LeadsStats[$Headid][$St] : 0);
                $grandTotal[$St] += $RecordsCnt;
                $GrandTotalAgents[$Headid] += $RecordsCnt;
                /*if ($St == 'new') {
                    echo '<th style="text-align: center"><a href="javascript:void(0);" onclick="DailyNewLeadsDisrtibution(\'' . $St . '\',\'' . $Headid . '\')">' . NUMBER($RecordsCnt) . '</a></th>';
                } else if ($St == 'sms') {
                    echo '<th style="text-align: center"><a href="javascript:void(0);" onclick="DailySMSLeadsDisrtibution(\'' . $St . '\',\'' . $Headid . '\')">' . NUMBER($RecordsCnt) . '</a></th>';
                } else {
                    echo '<th style="text-align: center"><a href="javascript:void(0);" onclick="DailyLeadsDisrtibution(\'' . $St . '\',\'' . $Headid . '\')"> ' . NUMBER($RecordsCnt) . ' </a></th>';
                }*/
                echo '<td style="text-align: center">' . NUMBER($RecordsCnt) . '</td>';
            } ?>
            <td style="text-align: center"><?= $GrandTotalAgents[$Headid] ?></td>
            </tr><?php
        }
    } else {
        $Colspan = count($Status) + 3;
        echo '<tr><td colspan="' . $Colspan . '"><div class="alert alert-danger text-center font-weight-bold">No Leads Distribution Record Found...!</div></td></tr>';
    }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="2"> Total</th><?php
        $Total = 0;
        foreach ($Status as $St) {
            $Total += $grandTotal[$St];
            echo '<th style="text-align: center">' . $grandTotal[$St] . '</th>';
        } ?>
        <th style="text-align: center"><?= $Total ?></th>
    </tr>
    </tfoot>
</table>































<!--<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>Sr.No</th>
        <th>Agent Name</th>
        <th>New</th>
        <th>Details on SMS</th>
        <th>Closed Clients</th>
        <th>Dealer</th>
        <th>Follow Up</th>
        <th>Interested</th>
        <th>No Answers/Callback</th>
        <th>Old CRM Record</th>
        <th>Sale/Maturity</th>
        <th>Total Leads</th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>-->




