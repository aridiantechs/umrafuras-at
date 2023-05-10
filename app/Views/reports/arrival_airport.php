<?php
$session = session();
$SessionFilters = $session->get('ArrivalAirportSessionFilters');
$Country = $Agent = $ArrivalDateFrom = $ArrivalDateTo = $DepartureDateFrom = $DepartureDateTo = $TPTType = $Reference = '';
if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $Country = $SessionFilters['country'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $Agent = $SessionFilters['agent'];
}

if (isset($SessionFilters['arrival_date_from']) && trim($SessionFilters['arrival_date_from']) != '') {
    $ArrivalDateFrom = $SessionFilters['arrival_date_from'];
}

if (isset($SessionFilters['arrival_date_to']) && trim($SessionFilters['arrival_date_to']) != '') {
    $ArrivalDateTo = $SessionFilters['arrival_date_to'];
}

if (isset($SessionFilters['departure_date_from']) && trim($SessionFilters['departure_date_from']) != '') {
    $DepartureDateFrom = $SessionFilters['departure_date_from'];
}

if (isset($SessionFilters['departure_date_to']) && trim($SessionFilters['departure_date_to']) != '') {
    $DepartureDateTo = $SessionFilters['departure_date_to'];
}

if (isset($SessionFilters['tpt_type']) && trim($SessionFilters['tpt_type']) != '') {
    $TPTType = $SessionFilters['tpt_type'];
}

if (isset($SessionFilters['reference']) && trim($SessionFilters['reference']) != '') {
    $Reference = $SessionFilters['reference'];
}


?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Arrival Airport Report
                    <?php if ($CheckAccess['umrah_reports_stats_arrival_departure_arrival_airport_export']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/arrival_airports" target="_blank">Export Records
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="return false;" class="section contact" id="ArrivalAirportSearchFiltersForm">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="ArrivalAirportSessionFilters">
                    <input type="hidden" name="arrival_date_from" id="arrival_date_from"
                           value="<?= $ArrivalDateFrom ?>">
                    <input type="hidden" name="arrival_date_to" id="arrival_date_to" value="<?= $ArrivalDateTo ?>">
                    <input type="hidden" name="departure_date_from" id="departure_date_from"
                           value="<?= $DepartureDateFrom ?>">
                    <input type="hidden" name="departure_date_to" id="departure_date_to"
                           value="<?= $DepartureDateTo ?>">
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
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Arrival Date</label>
                                                        <input onchange="GetArrivalDate();" type="text"
                                                               class="form-control multidate"
                                                               name="arrival_date" id="arrival_date">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Departure Date</label>
                                                        <input onchange="GetDepartureDate();" type="text"
                                                               class="form-control multidate "
                                                               name="departure_date" id="departure_date">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">TPT Type</label>
                                                        <input value="<?= $TPTType ?>" type="text" class="form-control"
                                                               name="tpt_type"
                                                               id="tpt_type" placeholder="TPT Type">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Reference</label>
                                                        <input value="<?= $Reference ?>" id="reference" type="text"
                                                               class="form-control"
                                                               name="reference" placeholder="Reference">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="ArrivalAirportFiltersFormSubmit( 'ArrivalAirportSearchFiltersForm' );"
                                                                id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('ArrivalAirportSessionFilters');"
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
                    <?php
                    if (isset($SessionFilters) && $SessionFilters != '') { ?>

                        <div class="table-responsive mb-4 mt-4">
                            <table id="ArrivalAirPortRecord" class="table table-hover non-hover display nowrap"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>EA Code</th>
                                    <th>Country</th>

                                    <th>Agent Name</th>
                                    <!--                                <th>BRN</th>-->
                                    <th>V. No</th>
                                    <th>Pilgrim Name</th>
                                    <th>P/P No</th>
                                    <th>PAX</th>
                                    <th>Seats</th>
                                    <th>Dep Date</th>
                                    <th>Dep Time</th>
                                    <th>Arrvl Date</th>
                                    <th>Arrvl Time</th>

                                    <th>Flight No</th>
                                    <th>Sector</th>
                                    <th>Destination</th>
                                    <th>TPT Type</th>
                                    <th>Vehicle No</th>
                                    <th>Driver Name</th>
                                    <th>Driver No</th>

                                    <th>TPT Company</th>
                                    <th>Airport</th>
                                    <th>Pax Mob. No</th>

                                    <th>Category</th>
                                    <th>Reference</th>
                                    <th>System User</th>
                                    <th>Status</th>

                                </tr>
                                </thead>
                                <tbody>
                                <!-- --><?php /*                            $cnt=0;
                            $PilgrimModel=new \App\Models\Pilgrims();
                            foreach ($records as $record) {
                                $cnt++;

                                $PilgrimID=$record['LeaderPilgrimUID'];
                                $PilgrimMetaRecords = $PilgrimModel->ArrivalPilgrimLeaderMetaRecords($PilgrimID);
                                //echo '<pre>';print_r($PilgrimMetaRecords);
                                $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], $PilgrimMetaRecords['Status'].'-status');
                                //echo '<pre>';print_r($PilgrimLastActivity);
                                $ActivityUserName = UserNameByID($PilgrimLastActivity['ActivityRecords'][$PilgrimLastActivity['LastActivity'] . '-user-id']);
                                $Category = 'B2B';
                                if ($record['IATAType'] == 'external_agent') {
                                    $Category = 'External Agent';
                                }
                                echo '
                                <tr>
                                <td>'.$cnt.'</td>
                                <td>' . Code('UF/A/', $record['AgentID']) . '</td> 
                                <td>' . $record['CountryName'] . '</td>
                                
                                <td>' . $record['IATANAME'] . '</td>
                               <!--   <td>'.$PilgrimMetaRecords['BRN'].'</td>  -->
                                <td>' . $record['VoucherCode'] . '</td> 
                                
                                <td>' . $record['FullName'] . '</td>                             
                                <td>' . $record['PPNO'] . '</td>
                                <td>'. $record['TotalPilgrim'] .'</td> 
                                <td>' . ((isset($PilgrimMetaRecords['Seats'])) ? $PilgrimMetaRecords['Seats'] : '-') . '</td> 
                                <td>' . DATEFORMAT($record['DepartureDate']) . '</td>  
                                <td>' . $record['DepartureTime'] . '</td>  
                                <td>' . DATEFORMAT($record['ArrivalDate']) . '</td>
                                <td>' . $record['ArrivalTime'] . '</td>
                               
                                <td>' . $record['FlightNo'] . '</td>                             
                                <td>' . $record['SectorFrom'].' - '.$record['SectorTo'] . '</td>                             
                                <td>' . ((isset($record['Destination'])) ? $record['Destination'] : '-') . '</td>
                                <td>' . $record['TypeOFTransport'] . '</td>
                                <td>'.$PilgrimMetaRecords['VehicleNumber'].'</td> 
                                 <td>'.$PilgrimMetaRecords['DriverName'].'</td>                               
                                <td>'.$PilgrimMetaRecords['DriverNumber'].'</td> 
                                                        
                                                         
                                <td>'.$PilgrimMetaRecords['TransportCompany'].'</td> 
                                <td>'. $record['SectorTo'] .'</td>    
                                <td>'.((isset($PilgrimMetaRecords['PilgrimMobile']))?$PilgrimMetaRecords['PilgrimMobile']:'-').'</td>    
                                                               
                                <td>' . ucfirst(str_replace("_"," ",$record['IATAType'])). '</td>                             
                                <td>' . ((isset($record['ReferenceName'])) ? $record['ReferenceName'] :'-') . '</td>             
                               <td>'. $ActivityUserName .'</td>    
                                <td>'.((isset($PilgrimMetaRecords['CurrentStatus'])) ?$PilgrimMetaRecords['CurrentStatus'] :'-').'</td>                            
                                 
                                </tr> ';
                            }
                            */ ?>
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
<script type="text/javascript" language="javascript">

    setTimeout(function () {
        $("#arrival_date_from").val('');
        $("#arrival_date_to").val('');
        $("#departure_date_from").val('');
        $("#departure_date_to").val('');
    }, 1000);
     $(document).ready(function () {
        <?php
        if(isset($SessionFilters) && $SessionFilters != ''){?>
        ArrivalAirPortRecordData();
        <?php }?>
    });

    function ArrivalAirPortRecordData() {
        var dataTable = $('#ArrivalAirPortRecord').DataTable({
            "processing": true,
            "searching": false,
            "responsive": true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, 'All']],
            "pageLength": 100,
            "lengthChange": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ Arrival Airport Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Arrival Airport Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_all_arrival_airport_report",
                type: "POST",
            },
            "columnDefs": [
                {
                    "defaultContent": "-",
                    "targets": "_all",
                    "orderable": false,
                },
            ],
        });

    }

    function GetArrivalDate() {
        const Date = $("#arrival_date").val();
        const words = Date.split(' to ');
        $("#arrival_date_from").val(words[0]);
        $("#arrival_date_to").val(words[1]);
    }

    function GetDepartureDate() {
        const Date = $("#departure_date").val();
        const words = Date.split(' to ');
        $("#departure_date_from").val(words[0]);
        $("#departure_date_to").val(words[1]);
    }

    function ArrivalAirportFiltersFormSubmit(parent) {

        var dataTable = $('#ArrivalAirPortRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {
            location.reload();
        }
    }

    function ClearSession(SessionKey) {

        var dataTable = $('#ArrivalAirPortRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {
            $("form#ArrivalAirportSearchFiltersForm input#arrival_date_from").val('');
            $("form#ArrivalAirportSearchFiltersForm input#arrival_date_to").val('');
            $("form#ArrivalAirportSearchFiltersForm input#departure_date_from").val('');
            $("form#ArrivalAirportSearchFiltersForm input#departure_date_to").val('');
            $("form#ArrivalAirportSearchFiltersForm")[0].reset();
            location.reload();
        }
    }
</script>
<script type="application/javascript">

    /* $('#ReportTable').DataTable({
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
     });*/

    <?php if ($CheckAccess['umrah_reports_stats_arrival_departure_arrival_airport_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/arrival_airports" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
