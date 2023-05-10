<?php

use App\Models\Crud;

$Crud = new Crud();
$session = session();
$SessionFilters = $session->get('WorkSheetSessionFilters');
$SubmittedBy = $WorkSheetStartDate = $WorkSheetEndDate = '';
$SaleOfficer = '';

if (isset($SessionFilters['submitted_by']) && $SessionFilters['submitted_by'] != '') {
    $SaleOfficerData = $Crud->SingleRecord('main."Users"', array('UID' => $SessionFilters['submitted_by']));
    $SaleOfficer = $SaleOfficerData['FullName'];
}

if (isset($SessionFilters['worksheet_start_date']) && $SessionFilters['worksheet_start_date'] != '') {
    $WorkSheetStartDate = $SessionFilters['worksheet_start_date'];
}

if (isset($SessionFilters['worksheet_end_date']) && $SessionFilters['worksheet_end_date'] != '') {
    $WorkSheetEndDate = $SessionFilters['worksheet_end_date'];
}

$ColSpan = (($SaleOfficer != '' && $WorkSheetStartDate != '' && $WorkSheetEndDate != '') ? 3 : (($SaleOfficer != '' && $WorkSheetStartDate == '' && $WorkSheetEndDate == '') ? 6 : (($SaleOfficer == '' && $WorkSheetStartDate != '' && $WorkSheetEndDate != '')) ? 6 : 2));
?>
<?php
if ($SaleOfficer != '' || $WorkSheetStartDate != '' || $WorkSheetEndDate != '') {
    ?>
    <table class="table table-striped table-bordered cell-border">
        <tr>
            <?php
            if ($SaleOfficer != '') {
                echo '<th>Sale Officer:</th>
                             <td width="30%"><b>' . $SaleOfficer . '</b></td>';
            }

            if ($WorkSheetStartDate != '' && $WorkSheetEndDate != '') {
                echo '<th>Create Date:</th>
                            <td width="30%"><b>' . date("d M, Y", strtotime($WorkSheetStartDate)) . ' To ' . date("d M, Y", strtotime($WorkSheetEndDate)) . '</b></td>';
            }
            ?>
        </tr>
    </table>
<?php } ?>
<table class="table table-striped table-hover  display nowrap cell-border GoldClass" cellspacing="0" cellpadding="0"
       width="100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Submitted By</th>
        <th>Submitted On</th>
        <th>Created On</th>
        <th>PlatForms</th>
        <th>Completed %</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (count($WorkSheetData) > 0) {
        $cnt = 1;
        foreach ($WorkSheetData as $WSD) {

            echo '<tr>
                            <td>' . $cnt . '</td>
                            <td>' . $WSD['UserName'] . '</td>
                            <td>' . DATEFORMAT($WSD['SystemDate']) . '</td>
                            <td>' . DATEFORMAT($WSD['CreatedAt']) . '</td>
                            <td>' . $WSD['PlatForms'] . '</td>
                            <td>' . $WSD['TotalPercent'] . '%</td>
                         </tr>';

            $cnt++;
        }
    }
    ?>
    </tbody>
</table>
