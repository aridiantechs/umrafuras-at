<!--  BEGIN CONTENT AREA  -->
<?php

use App\Models\Crud;

$Crud = new Crud();
$session = session();
$SessionFilters = $session->get('ExternalStatsReportSessionFilters');
$Country = $Agent = $Group = $Package = $Reference = '';
if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $Country = $SessionFilters['country'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $Agent = $SessionFilters['agent'];
}

if (isset($SessionFilters['group']) && $SessionFilters['group'] != '') {
    $Group = $SessionFilters['group'];
}

if (isset($SessionFilters['package']) && $SessionFilters['package'] != '') {
    $Package = $SessionFilters['package'];
}

if (isset($SessionFilters['reference']) && $SessionFilters['reference'] != '') {
    $Reference = $SessionFilters['reference'];
}
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">External Pilgrim
                    <?php if ($CheckAccess['umrah_reports_status_stats_export_external']) { ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?= $path ?>exports/external" target="_blank"> Export Record
                    </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="ExternalStatsReportForm" id="ExternalStatsReportForm"
                      onsubmit="return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="ExternalStatsReportSessionFilters">
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
                                                        <select class="form-control validate[required]" id="country"
                                                                name="country">
                                                            <option value="">Please Select</option>
                                                            <?= Countries('html', $Country) ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Agent Name</label>
                                                        <select class="form-control" id="agent"
                                                                name="agent">
                                                            <?= $AgentsDropDown['html'] ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Group Name</label>
                                                        <input class="form-control" id="group" name="group"
                                                               placeholder="Group Name"
                                                               value="<?= $Group ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Package</label>
                                                        <input type="text" class="form-control" id="package"
                                                               name="package"
                                                               value="<?= $Package ?>"
                                                               placeholder="Package">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Reference</label>
                                                        <input type="text" class="form-control" id="reference"
                                                               name="reference"
                                                               value="<?= $Reference ?>"
                                                               placeholder="Reference">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="ExternalReportAjaxResult"></div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="ExternalStatsReportFiltersFormSubmit('ExternalStatsReportForm');"
                                                                id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('ExternalStatsReportSessionFilters');"
                                                                id="btnreset" type="button" class="btn btn-danger">Clear
                                                            Filter
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
                                      <td>' . Code('UF/A/', $record['AgentID']) . '</td>
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

    function ExternalStatsReportFiltersFormSubmit(parent) {

        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'ExternalReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                location.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('ExternalStatsReportForm', 'ExternalReportAjaxResult', 'alert-success', rslt.msg, 250);
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

    <?php if ($CheckAccess['umrah_reports_status_stats_export_external']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/external" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);
    <?php } ?>

</script>
