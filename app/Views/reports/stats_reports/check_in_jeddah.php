<!--  BEGIN CONTENT AREA  -->
<?php

$session = session();
$SessionFilters = $session->get('CheckInJeddahSessionFilters');
$Country = $Agent = $VoucherNo = $CheckInDateFrom = $CheckInDateTo = $City = '';
if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $Country = $SessionFilters['country'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $Agent = $SessionFilters['agent'];
}

if (isset($SessionFilters['voucher_no']) && $SessionFilters['voucher_no'] != '') {
    $VoucherNo = $SessionFilters['voucher_no'];
}

if (isset($SessionFilters['city']) && $SessionFilters['city'] != '') {
    $City = $SessionFilters['city'];
}

if (isset($SessionFilters['check_in_date_from']) && $SessionFilters['check_in_date_from'] != '') {
    $CheckInDateFrom = $SessionFilters['check_in_date_from'];
}

if (isset($SessionFilters['check_in_date_to']) && $SessionFilters['check_in_date_to'] != '') {
    $CheckInDateTo = $SessionFilters['check_in_date_to'];
}
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Check In Jeddah
                    <?php if ($CheckAccess['umrah_reports_status_stats_export_check_in_jeddah']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/check_in_jeddah" target="_blank">Export Records
                        </a>
                    <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="CheckInJeddahFiltersFormSubmit('CheckInJeddahSearchFiltersForm'); return false;"
                      class="section contact" id="CheckInJeddahSearchFiltersForm">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="CheckInJeddahSessionFilters">
                    <input type="hidden" name="check_in_date_from" id="check_in_date_from"
                           value="<?= $CheckInDateFrom ?>">
                    <input type="hidden" name="check_in_date_to" id="check_in_date_to" value="<?= $CheckInDateTo ?>">
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
                                                       value="<?= $VoucherNo ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">City</label>
                                                <input class="form-control" id="city" name="city"
                                                       placeholder="City"
                                                       value="<?= $City ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">CheckIn Date</label>
                                                <input type="text" class="form-control multidate "
                                                       name="check_in_date" id="check_in_date"
                                                       onchange="GetCheckInDate();">
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="CheckInJeddahAjaxResult"></div>
                                        <div class="col-md-12" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="CheckInJeddahFiltersFormSubmit('CheckInJeddahSearchFiltersForm');"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('CheckInJeddahSessionFilters');"
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

                </form>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>S.NO</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>BRN</th>
                                <th>V. No</th>
                                <th>HTL Category</th>

                                <th>City</th>
                                <th>Actl Hotel</th>
                                <th>Room Type</th>
                                <th>Room No</th>
                                <th>Pax</th>
                                <th>Actl Beds</th>
                                <th>CHK In Date</th>
                                <th>CHK In Time</th>
                                <th>CHK Out Date</th>
                                <th>Nights</th>
                                <th>Actl Arrival Time</th>

                                <th>Origin</th>
                                <th>PAX Mob. No</th>
                                <th>Category</th>
                                <th>Reference</th>
                                <th>System User</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $Pilgrims = new \App\Models\Pilgrims();
                            $cnt = 0;
                            foreach ($records as $record) {

                                $PilgrimMetaRecords = $Pilgrims->PilgrimMetaRecords($record['LeaderPilgrimUID']);
                                //echo '<pre>';print_r($PilgrimMetaRecords);
                                $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], 'check-in-jeddah-status');
                                //echo '<pre>';print_r($PilgrimLastActivity);
                                if ($PilgrimMetaRecords['check-in-jeddah-actual-Hotel'] > 0) {

                                    $ActualHotel = HotelName($PilgrimMetaRecords['check-in-jeddah-actual-Hotel'], 'Name', 1);
                                } else {
                                    $ActualHotel = HotelName($PilgrimMetaRecords['check-in-jeddah-package-Hotel'], 'Name', 0);
                                }
                                $Checkintime = '';
                                $Arrivalpos = strpos($PilgrimLastActivity['LastActivity'], "arrival");
                                if ($Arrivalpos > 0) {
                                    $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['LastActivityRecordTime'] . ' + 4 hours'));

                                    // $Checkintime + 4hours
                                } else {
                                    if ($PilgrimLastActivity['LastActivity'] == 'check-out-medina') {
                                        //$Checkintime = date('H:i:s',strtotime($PilgrimLastActivity['ActivityRecords']['check-out-medina-time']. ' + 6 hours'));
                                        // $Checkintime + 6hours
                                    }
                                }
                                $ActivityUserName = UserNameByID($PilgrimLastActivity['ActivityRecords'][$PilgrimLastActivity['LastActivity'] . '-user-id']);
                                $Category = 'B2B';
                                if ($record['IATAType'] == 'external_agent') {
                                    $Category = 'External Agent';
                                }

                                $cnt++;
                                echo '
                                <tr>
                                <td>' . $cnt . '</td>
                                <td>' . $record['CountryName'] . '</td>
                                <td>' . $record['IATANAME'] . '</td>
                                <td>' . ((isset($PilgrimMetaRecords['check-in-jeddah-brn-no'])) ? BRNCode($PilgrimMetaRecords['check-in-jeddah-brn-no']) : '-') . '</td>  
                                <td>' . $record['VoucherCode'] . '</td>                          
                                <td>' . $record['HotelCategory'] . '</td>
                               
                                <td>' . $record['HotelCityName'] . '</td>
                                <td>' . ((isset($ActualHotel)) ? $ActualHotel : '-') . '</td> 
                                <td>' . $record['RoomType'] . '</td>
                                 <td>' . ((isset($PilgrimMetaRecords['check-in-jeddah-room-no'])) ? $PilgrimMetaRecords['check-in-jeddah-room-no'] : '-') . '</td>                             

                                <td>' . $record['TotalPilgrim'] . '</td>   
                                     <td>' . ((isset($PilgrimMetaRecords['check-in-jeddah-no-of-bed'])) ? $PilgrimMetaRecords['check-in-jeddah-no-of-bed'] : '-') . '</td>                             

                                 <td>' . DATEFORMAT($record['CheckINDate']) . '</td>
                                <td>' . ((isset($Checkintime)) ? TIMEFORMAT($Checkintime) : '-') . '</td>
                                <td>' . ((isset($PilgrimMetaRecords['check-in-jeddah-out-date'])) ? DATEFORMAT($PilgrimMetaRecords['check-in-jeddah-out-date']) : '-') . '</td>                          
                                <td>' . $record['Nights'] . '</td>                          
                                <td>' . ((isset($PilgrimMetaRecords['check-in-jeddah-actual-arrival-time'])) ? TIMEFORMAT($PilgrimMetaRecords['check-in-jeddah-actual-arrival-time']) : '-') . '</td>                             
                                <td>' . ucwords(str_replace('-', ' ', $PilgrimLastActivity['LastActivity'])) . '</td>                             
                                <td>' . ((isset($PilgrimMetaRecords['check-in-jeddah-contact-number'])) ? $PilgrimMetaRecords['check-in-jeddah-contact-number'] : '-') . '</td>                           
                                <td>' . ucfirst(str_replace("_", " ", $record['IATAType'])) . '</td> 
                                <td>' . ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-') . '</td>    
                                <td>' . ((isset($ActivityUserName)) ? $ActivityUserName : '-') . '</td>
                                <td>Check In Jeddah</td>    
                                
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

    $(document).ready(function () {
        setTimeout(function () {
            var CheckInDateFrom = "<?=$CheckInDateFrom?>";
            var CheckInDateTo = "<?=$CheckInDateTo?>";
            $("#check_in_date_from").val(CheckInDateFrom);
            $("#check_in_date_to").val(CheckInDateTo);
        }, 500);
    });

    function CheckInJeddahFiltersFormSubmit(parent) {

        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'CheckInJeddahAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                location.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('CheckInJeddahSearchFiltersForm', 'CheckInJeddahAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                location.reload();
            }, 500);
        }
    }

    function GetCheckInDate() {
        const CheckInDate = $("#check_in_date").val();
        const words = CheckInDate.split(' to ');
        $("#check_in_date_from").val(words[0]);
        $("#check_in_date_to").val(words[1]);
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

    <?php if ($CheckAccess['umrah_reports_status_stats_export_check_in_jeddah']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/check_in_jeddah" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);
    <?php } ?>

</script>
