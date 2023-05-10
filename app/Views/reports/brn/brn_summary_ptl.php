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
$TransportTypeSql .=' ORDER BY main."LookupsOptions"."Name" ASC';
$transporttypes = $Crud->ExecuteSQL($TransportTypeSql);

/** Transport Sectors Data For Report*/
$TransportSectorSql = ' SELECT main."LookupsOptions".*
                        FROM main."LookupsOptions" 
                        JOIN main."Lookups" ON ( main."Lookups"."UID" = main."LookupsOptions"."LookupID" )
                    WHERE main."Lookups"."Key" = \'transport_sectors\' AND main."LookupsOptions"."Archive" = 0';
if( $TransportSector != '' ){
    $TransportSectorSql.=' AND main."LookupsOptions"."UID" = '.$TransportSector.' ';
}
$TransportSectorSql .=' ORDER BY main."LookupsOptions"."Name" ASC';
$sectors = $Crud->ExecuteSQL($TransportSectorSql);

?>
<style>
    table.cell-border thead th, table.cell-border tbody td {
        border: 0.5px solid #DDA420;
        border-collapse: collapse;
    }
</style>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Transport BRN Summary
                    <?php if ($CheckAccess['umrah_reports_stats_brn_transport_transport_brn_summary_export']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/brn_summary_ptl" target="_blank"> Export Record
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="TransportBrnSummaryReportForm" id="TransportBrnSummaryReportForm"
                      onsubmit="TransportBrnSummaryReportFormSubmit('TransportBrnSummaryReportForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey"
                           value="TransportBrnSummaryReportSessionFilters">

                    <div id="toggleAccordion">
                        <div class="card">
                            <div class="card-header">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class="" data-toggle="collapse"
                                         data-target="#FilterDetails" aria-expanded="true"
                                         aria-controls="FilterDetails">
                                        Filters
                                    </div>
                                </section>
                            </div>
                            <div id="FilterDetails" class="collapse show" aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="Operator">TPT Type</label>
                                            <select class="form-control validate[required]" id="tpt_type"
                                                    name="tpt_type">
                                                <option value="">Please Select</option>
                                                <?php
                                                $TransportTypes = $Crud->LookupOptions('transport_types');
                                                foreach ($TransportTypes as $options) {
                                                    echo '<option ' . ((isset($TransportType) && $TransportType == $options['UID']) ? 'selected' : '') . ' value="' . $options['UID'] . '">' . $options['Name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="Operator">TPT Sector</label>
                                            <select class="form-control validate[required]" id="tpt_sector"
                                                    name="tpt_sector">
                                                <option value="">Please Select</option>
                                                <?php
                                                $TransportSectors = $Crud->LookupOptions('transport_sectors');
                                                foreach ($TransportSectors as $options) {
                                                    echo '<option ' . ((isset($TransportSector) && $TransportSector == $options['UID']) ? 'selected' : '') . ' value="' . $options['UID'] . '">' . $options['Name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-8" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="TransportBrnSummaryReportFormSubmit('TransportBrnSummaryReportForm');"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('TransportBrnSummaryReportSessionFilters');"
                                                        id="btnreset" type="button" class="btn btn-danger">Clear
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="TransportBrnSummaryReportAjaxResult"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <?php
                    if (isset($SessionFilters) && $SessionFilters != '') { ?>
                    <div class="table-responsive mb-4 mt-4">
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
                                }

                                ?>


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
                    </div>
                    <?php } else { ?>
                    <div class="alert alert-warning text-center font-weight-bold">Filters! Plz Select Filters
                        To View Record...
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">

    function TransportBrnSummaryReportFormSubmit(parent) {

        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {
            GridMessages(parent, 'TransportBrnSummaryReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                location.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {
            GridMessages('TransportBrnSummaryReportForm', 'TransportBrnSummaryReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                location.reload();
            }, 500);
        }
    }

    $('#ReportTable').DataTable({
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
        "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
        "pageLength": 100
    });

    <?php if ($CheckAccess['umrah_reports_stats_brn_transport_transport_brn_summary_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/stats_b2b" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
