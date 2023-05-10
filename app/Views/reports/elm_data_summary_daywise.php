<!--  BEGIN CONTENT AREA  -->
<?php

use App\Models\Crud;

$Crud = new Crud();

$session = session();
$SessionFilters = $session->get('ELMDataSummaryDayWiseSessionFilters');
$From = $To = $Company = '';

print_r($SessionFilters);

if (isset($SessionFilters['from']) && $SessionFilters['from'] != '') {
    $From = $SessionFilters['from'];
}

if (isset($SessionFilters['to']) && $SessionFilters['to'] != '') {
    $To = $SessionFilters['to'];
}

if (isset($SessionFilters['Country']) && $SessionFilters['Country'] != '') {
    $Country = $SessionFilters['Country'];
}

if (isset($SessionFilters['AgentName']) && $SessionFilters['AgentName'] != '') {
    $AgentName = $SessionFilters['AgentName'];
}
?>


<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">ELM Data Summary DayWise
                    <?php if ($CheckAccess['umrah_reports_stats_pilgrim_management_elm_data_summary_daywise_export']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/elm_summary_daywise" target="_blank">Export Records
                        </a>
                    <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="ELMDataSummaryDayWiseForm" id="ELMDataSummaryDayWiseForm"
                      onsubmit="ELMDataSummaryDayWiseFormSubmit('ELMDataSummaryDayWiseForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey"
                           value="ELMDataSummaryDayWiseSessionFilters">
                    <input type="hidden" name="from" id="from"
                           value="<?= $From ?>">
                    <input type="hidden" name="to" id="to"
                           value="<?= $To ?>">
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
                            <div id="FilterDetails" class="collapse show " aria-labelledby=""
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
                                                            <?= Countries('html', $Country) ?>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Agent Name</label>
                                                        <select class="form-control validate[required]" id="AgentName"
                                                                name="AgentName">
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            foreach ($AllAgents as $AllAgent) {
                                                                echo ' <option value="' . $AllAgent['UID'] . '" ' . (($AgentName == $AllAgent['UID']) ? 'selected' : '') . '>' . $AllAgent['FullName'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">From To</label>
                                                        <input type="text"
                                                               class="form-control multidate"
                                                               name="FromTo" id="FromTo" onchange="GetDatesData();"
                                                               placeholder="" value="">

                                                    </div>
                                                </div>


                                                <div class="col-md-4" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="ELMDataSummaryDayWiseFormSubmit('ELMDataSummaryDayWiseForm');"
                                                                id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('ELMDataSummaryDayWiseSessionFilters');"
                                                                id="btnreset" type="button" class="btn btn-danger">Clear
                                                            Filter
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="ELMDataSummaryDayWiseAjaxResult"></div>
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
                    <?php
                    if (isset($SessionFilters) && $SessionFilters != '') { ?>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>Date</th>
                                <th>Arrvl JED</th>
                                <th>Dep JED</th>
                                <th>Arrvl MED</th>
                                <th>Dep MED</th>
                                <th>Arrvl Yanbu</th>
                                <th>Dep Yanbu</th>
                                <th>CHK In MAK</th>
                                <th>CHK Out MAK</th>
                                <th>CHK in MED</th>
                                <th>CHK Out MED</th>
                                <th>CHK in JED</th>
                                <th>CHK Out JED</th>
                                <th>Pax In MAK</th>
                                <th>Pax In MED</th>
                                <th>Pax In JED</th>
                                <th>Category</th>
                                <th>Reference</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            if (count($records) > 0)
                                foreach ($records as $recordDate => $record) {
                                    //print_r($record);
                                    foreach ($record as $elmrslt) {
                                        $PaxInMak = CKHBlank($elmrslt['keys']['check-in-mecca-status'], 0);
                                        $PaxInMed = CKHBlank($elmrslt['keys']['check-in-medina-status'], 0);
                                        $PaxInJed = CKHBlank($elmrslt['keys']['check-in-jeddah-status'], 0);
                                        echo '
                                        <tr>
                                            <td>' . $i . '</td>
                                            <td>' . $elmrslt['CountryName'] . '</td>
                                            <td>' . $elmrslt['AgentName'] . '</td>
                                            <td>' . DATEFORMAT($recordDate) . '</td>                             
                                            <td>' . CKHBlank($elmrslt['keys']['jeddah-arrival-status'], '-') . '</td>                             
                                            <td>' . CKHBlank($elmrslt['keys']['departure-jeddah-status'], '-') . '</td>                             
                                            <td>' . CKHBlank($elmrslt['keys']['medina-arrival-status'], '-') . '</td>                             
                                            <td>' . CKHBlank($elmrslt['keys']['departure-medina-status'], '-') . '</td>                            
                                            <td>' . CKHBlank($elmrslt['keys']['yanbu-arrival-status'], '-') . '</td>                             
                                            <td>' . CKHBlank($elmrslt['keys']['departure-yanbu-status'], '-') . '</td>                               
                                            <td>' . CKHBlank($elmrslt['keys']['check-in-mecca-status'], '-') . '</td>                      
                                            <td>' . CKHBlank($elmrslt['keys']['check-out-mecca-status'], '-') . '</td>                         
                                            <td>' . CKHBlank($elmrslt['keys']['check-in-medina-status'], '-') . '</td>                      
                                            <td>' . CKHBlank($elmrslt['keys']['check-out-medina-status'], '-') . '</td>                             
                                            <td>' . CKHBlank($elmrslt['keys']['check-in-jeddah-status'], '-') . '</td>                      
                                            <td>' . CKHBlank($elmrslt['keys']['check-out-jeddah-status'], '-') . '</td>                              
                                            <td>' . $PaxInMak . '</td>                    
                                            <td>' . $PaxInMed . '</td>                    
                                            <td>' . $PaxInJed . '</td>                    
                                            <td>' . $elmrslt['AgentCategory'] . '</td>
                                            <td>' . $elmrslt['ReferenceName'] . '</td>
                                        </tr> ';
                                        $i++;
                                    }
                                    //break;
                                }
                            ?>
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

    function ELMDataSummaryDayWiseFormSubmit(parent) {

        //var dataTable = $('#SeatLossRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'ELMDataSummaryDayWiseAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                //dataTable.ajax.reload();
                location.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        //var dataTable = $('#SeatLossRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('ELMDataSummaryDayWiseForm', 'ELMDataSummaryDayWiseAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#ELMDataSummaryDayWiseForm input#booking_date_from").val('');
                $("form#ELMDataSummaryDayWiseForm input#booking_date_to").val('');
                $("form#ELMDataSummaryDayWiseForm")[0].reset();

                location.reload();
                //dataTable.ajax.reload();
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
    <?php if ($CheckAccess['umrah_reports_stats_pilgrim_management_elm_data_summary_daywise_export']) { ?>




    function GetDatesData() {

        const EntryDate = $("#FromTo").val();
        const words = EntryDate.split(' to ');
        $("#from").val(words[0]);
        $("#to").val(words[1]);
    }

    setTimeout(function () {
        var From = "<?=$From?>";
        var To = "<?=$To?>";
        $("#from").val(From);
        $("#to").val(To);
        if (From != '' && To != '') {
            $("#FromTo").val(From + " to " + To);
        }
        $('<a href="<?=$path?>exports/elm_summary_daywise" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 1000);
    <?php } ?>
</script>
