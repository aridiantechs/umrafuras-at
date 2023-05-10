<!--  BEGIN CONTENT AREA  -->
<?php

use App\Models\Crud;

$Crud = new Crud();
$Sess = session();
$Session = session();
$B2CStatsFilter = array();
$B2CStatsFilter = $Sess->get('B2BStatsFilter');
$From = $To = $Status = $Agent = $Keyword = '';

if (isset($B2CStatsFilter['Country']) && $B2CStatsFilter['Country'] != '') {
    $Country = $B2CStatsFilter['Country'];
}
if (isset($B2CStatsFilter['IATA']) && $B2CStatsFilter['IATA'] != '') {
    $IATA = $B2CStatsFilter['IATA'];
}
if (isset($B2CStatsFilter['Group']) && $B2CStatsFilter['Group'] != '') {
    $Group = $B2CStatsFilter['Group'];
}
if (isset($B2CStatsFilter['Package']) && $B2CStatsFilter['Package'] != '') {
    $Package = $B2CStatsFilter['Package'];
}

if (isset($B2CStatsFilter['Reference']) && $B2CStatsFilter['Reference'] != '') {
    $Reference = $B2CStatsFilter['Reference'];
}

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
                <h4 class="page-head">B2B Pilgrims
                    <?php if ($CheckAccess['umrah_reports_status_stats_export_b2b']) { ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?= $path ?>exports/stats_b2b" target="_blank"> Export Record
                    </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="B2BStatsForm" id="B2BStatsForm"
                      onsubmit="B2BFormSearchFiltersFormSubmit('B2BStatsForm');">
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
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Country</label>
                                                        <select class="form-control validate[required]" id="Country"
                                                                name="Country">
                                                            <option value="">Please Select</option>
                                                            <?= Countries('html') ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">IATA</label>
                                                        <input class="form-control" id="IATA" name="IATA"
                                                               placeholder="IATA" type="text"
                                                               value="<?=$IATA?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Group Name</label>
                                                        <input class="form-control" id="Group" name="Group"
                                                               placeholder="Group Name"
                                                               value="<?=$Group?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Package</label>
                                                        <input type="text" class="form-control" name="Package"
                                                               value="<?=$Package?>"
                                                               placeholder="Package">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Reference</label>
                                                        <input type="text" class="form-control" name="Reference"
                                                               value="<?=$Reference?>"
                                                               placeholder="Reference">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="B2BReportAjaxResult">

                                                </div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button type="button"
                                                                onclick="B2BFormSearchFiltersFormSubmit('B2BStatsForm');"
                                                                class="btn btn-success">Search
                                                        </button>
                                                        <button type="button"
                                                                onclick="ClearFilter('B2BStatsFilter');"
                                                                class="btn btn-danger">Clear Filter
                                                        </button>
                                                    </div>
                                                </div>


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
                    <div class="table-responsive mb-4 mt-4">
                        <table id="ReportTable" class="table table-hover non-hover display nowrap cell-border"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>EA Code</th>
                                <th>Country</th>
                                <th>Pilgrim ID</th>
                                <th>Agent Name</th>
                                <th>HTL Category</th>
                                <th>Group</th>
                                <th>Pilgrim Name</th>
                                <th>Gender</th>
                                <th>P/p No</th>
                                <th>DOB</th>
                                <th>Nationality</th>
                                <th>Relation</th>
                                <th>City</th>

                                <th>Embassy</th>
                                <th>Reference</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $cnt = 0;
                            foreach ($records as $record) {
                                $cnt++;
                                echo '
                                    <tr>
                                    <td>' . $cnt . '</td>
                                        <td width="28px">' . Code('UF/A/', $record['AgentID']) . '</td>
                                         <td>' . $record['CountryName'] . '</td>     
                                    <td width="28px">' . Code('UF/P/', $record['UID']) . '</td>
                                
                                    <td>' . $record['AgentName'] . '</td>
                                    <td>' . $record['PackageName'] . '</td>  
                                    <td>' . $record['GroupName'] . '</td>                               
                                    <td>' . $record['PilgrimFullName'] . '</td>
                                    <td>' . $record['Gender'] . '</td>
                                    <td>' . $record['PassportNumber'] . '</td>
                                    <td>' . DATEFORMAT($record['DOB']) . '</td>
                                    <td>' . $record['Nationality'] . '</td>
                                    <td>' . $record['Relation'] . '</td>                           
                                    <td>' . $record['CityName'] . '</td> 
                                   
                                    <td>' . $record['Embassy'] . '</td>     
                                    <td>' . $record['ReferenceName'] . '</td>                       
                                    </tr> ';
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">

    function B2BFormSearchFiltersFormSubmit(parent) {

        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters/b2b_report_search_filters_form_submit', data);
        if (rslt.status == 'success') {
            GridMessages(parent, 'B2BReportAjaxResult', 'alert-success', rslt.message, 150);
            location.reload();
        } else {
            GridMessages('B2BStatsForm', 'B2BReportAjaxResult', 'alert-danger', rslt.message, 150);
        }
    }

    function ClearFilter(Session) {
        var rslt = AjaxResponse('filters/clear_session', 'SessionName=' + Session);
        if (rslt.status == 'success') {
            GridMessages('B2BStatsForm', 'B2BReportAjaxResult', 'alert-success', rslt.message, 150);
            location.reload();
        } else {
            GridMessages('B2BStatsForm', 'B2BReportAjaxResult', 'alert-danger', rslt.message, 150);

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

    <?php if ($CheckAccess['umrah_reports_status_stats_export_b2b']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/stats_b2b" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
