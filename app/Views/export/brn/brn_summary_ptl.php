<?php

use App\Models\Crud;

$Crud = new Crud();
//$sectors = $Crud->LookupOptions('transport_sectors');
//$transporttypes = $Crud->LookupOptions('transport_types');

/** Session Filters Start */
$session = session();
$SessionFilters = $session->get('TransportBrnSummaryReportSessionFilters');
$TransportType = $TransportSector = '';

if (isset($SessionFilters['tpt_type']) && $SessionFilters['tpt_type'] != '') {
    $TransportType = $SessionFilters['tpt_type'];
}

if (isset($SessionFilters['tpt_sector']) && $SessionFilters['tpt_sector'] != '') {
    $TransportSector = $SessionFilters['tpt_sector'];
}
/** Session Filters Ends */

/** Transport Types Data For Report*/
$TransportTypeSql = ' SELECT main."LookupsOptions".*
                        FROM main."LookupsOptions" 
                        JOIN main."Lookups" ON ( main."Lookups"."UID" = main."LookupsOptions"."LookupID" )
                    WHERE main."Lookups"."Key" = \'transport_types\' AND main."LookupsOptions"."Archive" = 0 ';
if( $TransportType != '' ){
    $TransportTypeSql.=' AND main."LookupsOptions"."UID" = '.$TransportType.' ';
}
$transporttypes = $Crud->ExecuteSQL($TransportTypeSql);

/** Transport Sectors Data For Report*/
$TransportSectorSql = ' SELECT main."LookupsOptions".*
                        FROM main."LookupsOptions" 
                        JOIN main."Lookups" ON ( main."Lookups"."UID" = main."LookupsOptions"."LookupID" )
                    WHERE main."Lookups"."Key" = \'transport_sectors\' AND main."LookupsOptions"."Archive" = 0 ';
if( $TransportSector != '' ){
    $TransportSectorSql.=' AND main."LookupsOptions"."UID" = '.$TransportSector.' ';
}
$sectors = $Crud->ExecuteSQL($TransportSectorSql);

?>
<table id="ReportTable" class="table table-hover non-hover display nowrap cell-border"
       style="width:100%">
    <thead>
    <tr>
        <th rowspan="3">#</th>
        <th rowspan="3">Vehicle Type</th>
        <th rowspan="3">BRN</th>
        <th rowspan="2" colspan="4" style="text-align: center">Visa</th>
        <th colspan="<?= count($sectors) * 2 + 2; ?>" style="text-align: center">Actual</th>
    </tr>
    <tr>
        <th rowspan="2">Qty</th>
        <th rowspan="2">Seats</th>
        <?php

        foreach ($sectors as $sector) {
            echo '<th colspan="2" style="text-align: center">' . $sector['Name'] . '</th>';
        } ?>


    </tr>
    <tr>
        <th>QTY</th>
        <th>Seat</th>
        <th>Use</th>
        <th>Loss</th>

        <?php
        foreach ($sectors as $sector) {
            echo '<th>Use</th><th>Loss</th>';
        } ?>


    </tr>
    </thead>
    <tbody>
    <?php
    $cnt = 1;
    foreach ($transporttypes as $record) {
        $VTypeID = $record['UID'];
        ?>

        <tr>
            <td><?= $cnt; ?></td>
            <td><?= $record['Name']; ?></td>
            <td>N/A</td>
            <td style="border-top:none;"><?= (isset($records[$VTypeID]['visa']['qty']) ? $records[$VTypeID]['visa']['qty'] : '-') ?></td>
            <td style="border-top:none;"><?= (isset($records[$VTypeID]['visa']['seat']) ? $records[$VTypeID]['visa']['seat'] : '-') ?></td>
            <td style="border-top:none;"><?= (isset($records[$VTypeID]['visa']['use']) ? $records[$VTypeID]['visa']['use'] : '-') ?></td>
            <td style="border-top:none;"><?= (isset($records[$VTypeID]['visa']['loss']) ? $records[$VTypeID]['visa']['loss'] : '-') ?></td>
            <td style="border-top:none;"><?= (isset($records[$VTypeID]['actual']['actualqty']) ? $records[$VTypeID]['actual']['actualqty'] : '-') ?></td>
            <td style="border-top:none;"><?= (isset($records[$VTypeID]['actual']['actualseats']) ? $records[$VTypeID]['actual']['actualseats'] : '-') ?></td>
            <?php
            foreach ($sectors as $sector) {
                $SectorID = $sector['UID'];
                echo '<td class="b-none-align">' . (isset($records[$VTypeID][$SectorID]['use']) ? $records[$VTypeID][$SectorID]['use'] : '-') . '</td>
                                          <td class="b-none-align">' . (isset($records[$VTypeID][$SectorID]['use']) ? $records[$VTypeID]['actual']['actualseats'] - $records[$VTypeID][$SectorID]['use'] : '-') . '</td>';
            } ?>


        </tr>
        <?php $cnt++;
    }

    ?>
    <tr>

        <td>-</td>
        <td>N/A</td>
        <td>N/A</td>
        <td style="border-top:none;"><?= (isset($records[0]['visa']['qty']) ? $records[0]['visa']['qty'] : '-') ?></td>
        <td style="border-top:none;"><?= (isset($records[0]['visa']['seat']) ? $records[0]['visa']['seat'] : '-') ?></td>
        <td style="border-top:none;"><?= (isset($records[0]['visa']['use']) ? $records[0]['visa']['use'] : '-') ?></td>
        <td style="border-top:none;"><?= (isset($records[0]['visa']['loss']) ? $records[0]['visa']['loss'] : '-') ?></td>
        <td style="border-top:none;"><?= (isset($records[0]['actual']['actualqty']) ? $records[0]['actual']['actualqty'] : '-') ?></td>
        <td style="border-top:none;"><?= (isset($records[0]['actual']['actualseats']) ? $records[0]['actual']['actualseats'] : '-') ?></td>
        <?php
        foreach ($sectors as $sector) {
            $SectorID = $sector['UID'];
            echo '<td class="b-none-align">-</td>
                                          <td class="b-none-align">-</td>';
        } ?>


    </tr>
    </tbody>
</table>