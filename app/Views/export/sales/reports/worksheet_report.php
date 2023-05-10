<style>
    .worksheet tr.worksheet_row th, .worksheet tr.worksheet_row td{
        border: 1px solid black !important;
    }
    .worksheet_head tr.worksheet_head_row th{
        border: none !important;
    }
</style>
<table class="worksheet">
    <tr class="worksheet_row">
        <th>WorkSheet REF:</th>
        <td width="20%"><?= Code("UF/OWS/", $WorkSheetData['Sheet']['UID']) ?></td>
        <th>Submitted By:</th>
        <td width="20%"><?= $WorkSheetData['Sheet']['UserName'] ?></td>
        <th>Sheet Date:</th>
        <td width="20%"><?= date("d M, Y", strtotime($WorkSheetData['Sheet']['CreatedAt'])) ?></td>
    </tr>
</table>
<?php
foreach ($WorkSheetData['WorkSheetMeta'] as $Key => $Options) {
    echo '
    <h3 style="margin-bottom: 0px;">' . $Key . '</h3>
    <table class="worksheet">
        <thead>
        <tr class="worksheet_row">
            <th align="left" width="25%">Activity</th>
            <th align="left">Remarks</th>
        </tr>
        </thead>
        <tbody>';
    foreach ($Options as $Option) {
        echo '
                    <tr class="worksheet_row">
                        <td align="left" valign="top">' . $Option['title'] . '</td>
                        <td align="left" valign="top">' . trim(nl2br($Option['remarks'])) . '</td>
                    </tr>';
    }
    echo '
        </tbody>
    </table>';
} ?>






