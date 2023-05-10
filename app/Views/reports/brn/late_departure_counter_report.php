<!--  BEGIN CONTENT AREA  -->
<?php

$session = session();
$SessionFilters = $session->get('Over25DaysArrivalSessionFilters');
$Country = $Agent = $Group = $VoucherNo = $Pilgrim = $PassportNo =
$MofaNo = $EntryDateFrom = $EntryDateTo = $DepartureDateFrom = $DepartureDateTo = '';
if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $Country = $SessionFilters['country'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $Agent = $SessionFilters['agent'];
}

if (isset($SessionFilters['voucher_no']) && $SessionFilters['voucher_no'] != '') {
    $VoucherNo = $SessionFilters['voucher_no'];
}

if (isset($SessionFilters['group']) && $SessionFilters['group'] != '') {
    $Group = $SessionFilters['group'];
}

if (isset($SessionFilters['pilgrim']) && $SessionFilters['pilgrim'] != '') {
    $Pilgrim = $SessionFilters['pilgrim'];
}

if (isset($SessionFilters['ppt_no']) && $SessionFilters['ppt_no'] != '') {
    $PassportNo = $SessionFilters['ppt_no'];
}

if (isset($SessionFilters['mofa_no']) && $SessionFilters['mofa_no'] != '') {
    $MofaNo = $SessionFilters['mofa_no'];
}

if (isset($SessionFilters['visa_no']) && $SessionFilters['visa_no'] != '') {
    $VisaNo = $SessionFilters['visa_no'];
}

if (isset($SessionFilters['entry_date_from']) && $SessionFilters['entry_date_from'] != '') {
    $EntryDateFrom = $SessionFilters['entry_date_from'];
}

if (isset($SessionFilters['entry_date_to']) && $SessionFilters['entry_date_to'] != '') {
    $EntryDateTo = $SessionFilters['entry_date_to'];
}

if (isset($SessionFilters['departure_date_from']) && $SessionFilters['departure_date_from'] != '') {
    $DepartureDateFrom = $SessionFilters['departure_date_from'];
}

if (isset($SessionFilters['departure_date_to']) && $SessionFilters['departure_date_to'] != '') {
    $DepartureDateTo = $SessionFilters['departure_date_to'];
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
                <h4 class="page-head">Over 25 Days Arrival
                    <?php if ($CheckAccess['umrah_reports_status_stats_export_over_25_days_arrival']) { ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?= $path ?>exports/Over25DaysArrival" target="_blank"> Export Record
                    </a>
                    <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="Over25DaysArrivalFiltersFormSubmit('Over25DaysArrivalSearchFilterForm'); return false;"
                      class="section contact" name="Over25DaysArrivalSearchFilterForm"
                      id="Over25DaysArrivalSearchFilterForm">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="Over25DaysArrivalSessionFilters">
                    <input type="hidden" name="entry_date_from" id="entry_date_from" value="<?=$EntryDateFrom?>">
                    <input type="hidden" name="entry_date_to" id="entry_date_to" value="<?=$EntryDateTo?>">
                    <input type="hidden" name="departure_date_from" id="departure_date_from" value="<?=$DepartureDateFrom?>">
                    <input type="hidden" name="departure_date_to" id="departure_date_to" value="<?=$DepartureDateTo?>">
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
                                                        <select class="form-control" id="country"
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
                                                        <label for="country">Voucher#</label>
                                                        <input class="form-control" id="voucher_no" name="voucher_no"
                                                               placeholder="Voucher No"
                                                               value="<?=$VoucherNo?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Group Name</label>
                                                        <input class="form-control" id="group" name="group"
                                                               placeholder="Group Name"
                                                               value="<?=$Group?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Pilgrim Name</label>
                                                        <input class="form-control" id="pilgrim" name="pilgrim"
                                                               placeholder="Pilgrim Name"
                                                               value="<?=$Pilgrim?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">PPT#</label>
                                                        <input class="form-control" id="ppt_no" name="ppt_no"
                                                               placeholder="PPT No"
                                                               value="<?=$PassportNo?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Mofa#</label>
                                                        <input class="form-control" id="mofa_no" name="mofa_no"
                                                               placeholder="Mofa No"
                                                               value="<?=$MofaNo?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Visa#</label>
                                                        <input class="form-control" id="visa_no" name="visa_no"
                                                               placeholder="Visa No"
                                                               value="<?=$VisaNo?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Entry Date</label>
                                                        <input type="text" class="form-control multidate "
                                                               name="entry_date" id="entry_date"
                                                               onchange="GetEntryDate();">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Departure Date</label>
                                                        <input type="text" class="form-control multidate "
                                                               name="departure_date" id="departure_date"
                                                               onchange="GetDepartureDate();">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="Over25DaysArrivalAjaxResult"></div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="Over25DaysArrivalFiltersFormSubmit('Over25DaysArrivalSearchFilterForm');"
                                                                id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('Over25DaysArrivalSessionFilters');"
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
                        <table id="ReportTable" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>HTL Category</th>
                                <th>V.No</th>
                                <th>Group Code</th>
                                <th>Group Name</th>
                                <th>Pilgrim ID</th>
                                <th>Name</th>
                                <th>PPT No</th>
                                <th>Nationality</th>
                                <th>Mofa No</th>
                                <th>Visa No</th>
                                <th>MOI No</th>
                                <th>Entry Date</th>
                                <th>Entry Time</th>
                                <th>Dep Date</th>
                                <th>Days</th>
                                <th>Category</th>
                                <th>Reference</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php


                            $cnt = 0;
                            foreach ($records as $record) {
                                $actions = '
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                     <a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/voucher_remarks\', ' . $record['PilgrimID'] . ', \'modal-lg\')">Add Remarks</a>
                                 </div>';
                                $cnt++;


                                $Category = 'B2B';
                                if ($record['IATAType'] == 'external_agent') {
                                    $Category = 'External Agent';
                                }
                                echo '
                                <tr>
                                <td>' . $cnt . '</td>
                                <td>' . $record['CountryName'] . '</td>                              
                                                             
                                <td>' . $record['IATANAME'] . '</td>
                                <td>' . $record['HotelCategory'] . '</td>
                                
                                <td>' . $record['VoucherCode'] . '</td>
                                <td>' . Code('UF/G/', $record['GroupID']) . '</td> 
                                <td>' . $record['GroupName'] . '</td> 
                                <td>' . Code('UF/P/', $record['PilgrimID']) . '</td>
                                <td>' . $record['PilgrimFullName'] . '</td> 
                                <td>' . $record['PassportNumber'] . '</td>                            
                                <td>' . $record['Nationality'] . '</td>                                                          
                                <td>' . $record['MOFANumber'] . '</td>                                                         
                                <td>' . $record['VisaNo'] . '</td> 
                                <td>' . $record['MOINumber'] . '</td>                                                         
                                <td>' . DATEFORMAT($record['EntryDate']) . '</td>                                                         
                                <td>' . TIMEFORMAT($record['EntryTime']) . '</td>                                                         
                                <td>' . DATEFORMAT($record['DepartureDate']) . '</td>                                                         
                                <td>' . $record['Days'] . '</td>                                                         
                                       
                                <td>' . ucfirst(str_replace("_", " ", $record['IATAType'])) . '</td> 
                                                 
                                <td>' . $record['ReferenceName'] . '</td>
                                 <td>
                                        <div class="btn-group">
                                            <button type="button"
                                                    class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split"
                                                    id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" data-reference="parent">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                     stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-chevron-down">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg>
                                            </button>
                                            ' . $actions . '
                                        </div>
                             </td>                                                        
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

    $(document).ready(function (){
        setTimeout(function (){
            $("#entry_date_from").val('');
            $("#entry_date_to").val('');
            $("#departure_date_from").val('');
            $("#departure_date_to").val('');
        }, 500);
    });

    function Over25DaysArrivalFiltersFormSubmit(parent) {

        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'Over25DaysArrivalAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                location.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('Over25DaysArrivalSearchFilterForm', 'Over25DaysArrivalAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                location.reload();
            }, 500);
        }
    }

    function GetEntryDate() {
        const EntryDate = $("#entry_date").val();
        const words = EntryDate.split(' to ');
        $("#entry_date_from").val(words[0]);
        $("#entry_date_to").val(words[1]);
    }

    function GetDepartureDate() {
        const DepartureDate = $("#entry_date").val();
        const words = DepartureDate.split(' to ');
        $("#departure_date_from").val(words[0]);
        $("#departure_date_to").val(words[1]);
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
    setTimeout(function () {
        <?php if ($CheckAccess['umrah_reports_status_stats_export_over_25_days_arrival']) { ?>
        $('<a href="<?=$path?>exports/late_departure" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);
    <?php } ?>

</script>
