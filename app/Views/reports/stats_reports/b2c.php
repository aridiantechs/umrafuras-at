<!--  BEGIN CONTENT AREA  -->
<?php

use App\Models\Crud;

$Crud = new Crud();
$Sess = session();
$Session = session();
$B2CStatsFilter = array();
$B2CStatsFilter = $Sess->get('B2CStatsFilter');
$From = $To = $Status = $Agent = $Keyword = '';

if (isset($B2CStatsFilter['Country']) && $B2CStatsFilter['Country'] != '') {
    $Country = $B2CStatsFilter['Country'];
}
if (isset($B2CStatsFilter['WebReference']) && $B2CStatsFilter['WebReference'] != '') {
    $WebReference = $B2CStatsFilter['WebReference'];
}
if (isset($B2CStatsFilter['BPOID']) && $B2CStatsFilter['BPOID'] != '') {
    $BPOID = $B2CStatsFilter['BPOID'];
}

?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">B2C
                    <?php if ($CheckAccess['umrah_reports_status_stats_export_b2c']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/stats_b2c" target="_blank"> Export Record
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="AllB2CForm" id="AllB2CForm"
                      onsubmit="B2CFormSearchFiltersFormSubmit('AllB2CForm');">
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
                                                        <label for="country">BPO ID</label>
                                                        <input class="form-control" id="BPOID" name="BPOID"
                                                               placeholder="BPO ID" type="text"
                                                               value="<?= $BPOID ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Web Reference</label>
                                                        <input type="text" class="form-control" name="WebReference"
                                                               value="<?= $WebReference ?>"
                                                               placeholder="WebReference">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="AllB2CReport">

                                                </div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button type="button"
                                                                onclick="B2CFormSearchFiltersFormSubmit('AllB2CForm');"
                                                                class="btn btn-success">Search
                                                        </button>
                                                        <button type="button"
                                                                onclick="ClearFilter('B2CStatsFilter');"
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
                        <table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Create Date</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>Voucher #</th>
                                <th>Group Name</th>
                                <th>Package(pdf)</th>
                                <th>Gender</th>
                                <th>PAX NAme</th>
                                <th>P/P No</th>
                                <th>D.O.B</th>
                                <th>Age</th>
                                <th>nationality</th>
                                <th>Relation</th>
                                <th>Contact #</th>
                                <th>Email</th>

                                <th>BPO ID</th>
                                <th>Web Reference</th>
                                <th>Approved By</th>
                                <th>Current Status</th>

                            </tr>
                            </thead>
                            <tbody>
                            <!--                            --><?php
                            //                            $cnt = 0;
                            //                            foreach ($records as $record) {
                            //                                $cnt++;
                            //                                echo '
                            //                                    <tr>
                            //                                    <td>' . $cnt . '</td>
                            //                                    <td width="28px">' . DATEFORMAT($record['RegistrationDate']) . '</td>
                            //                                    <td>' . $record['CountryName'] . '</td>
                            //                                    <td>' . $record['CityName'] . '</td>
                            //                                    <td width="28px">' . $record['VoucherCode'] . '</td>
                            //                                    <td>' . $record['GroupName'] . '</td>
                            //                                    <td>N/A</td>
                            //                                    <td>' . $record['Gender'] . '</td>
                            //                                    <td>' . $record['PilgrimFullName'] . '</td>
                            //                                    <td>' . $record['PassportNumber'] . '</td>
                            //                                    <td>' . DATEFORMAT($record['DOB']) . '</td>
                            //                                    <td>' . $record['PilgrimAge'] . '</td>
                            //                                    <td>' . $record['Nationality'] . '</td>
                            //                                    <td>' . $record['Relation'] . '</td>
                            //                                    <td>' . $record['ContactNumber'] . '</td>
                            //                                    <td>' . $record['Email'] . '</td>
                            //                                    <td>N/A</td>
                            //                                    <td>N/A</td>
                            //                                    <td>N/A</td>
                            //                                    <td>N/A</td>
                            //
                            //                                    </tr> ';
                            //                            }
                            //                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">

    function B2CFormSearchFiltersFormSubmit(parent) {

        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters/b2c_report_search_filters_form_submit', data);
        if (rslt.status == 'success') {
            GridMessages(parent, 'AllB2CReport', 'alert-success', rslt.message, 150);
            location.reload();
        } else {
            GridMessages('AllB2CForm', 'AllB2CReport', 'alert-danger', rslt.message, 150);
        }
    }

    function ClearFilter(Session) {
        var rslt = AjaxResponse('filters/clear_session', 'SessionName=' + Session);
        if (rslt.status == 'success') {
            GridMessages('AllB2CForm', 'AllB2CReport', 'alert-success', rslt.message, 150);
            location.reload();
        } else {
            GridMessages('AllB2CForm', 'AllB2CReport', 'alert-danger', rslt.message, 150);

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
    <?php if ($CheckAccess['umrah_reports_status_stats_export_b2c']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/stats_b2c" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>
</script>
