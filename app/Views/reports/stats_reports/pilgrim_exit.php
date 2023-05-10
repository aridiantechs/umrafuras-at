<?php
$session = session();
$SessionFilters = $session->get('PilgrimsExitSessionFilters');
$Country = $Agent = $VoucherNo = $FlightDateFrom = $FlightDateTo = '';
if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $Country = $SessionFilters['country'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $Agent = $SessionFilters['agent'];
}

if (isset($SessionFilters['voucher_no']) && trim($SessionFilters['voucher_no']) != '') {
    $VoucherNo = $SessionFilters['voucher_no'];
}

if (isset($SessionFilters['flight_date_from']) && trim($SessionFilters['flight_date_from']) != '') {
    $FlightDateFrom = $SessionFilters['flight_date_from'];
}

if (isset($SessionFilters['flight_date_to']) && trim($SessionFilters['flight_date_to']) != '') {
    $FlightDateTo = $SessionFilters['flight_date_to'];
}
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Pilgrim Exit
                    <?php if ($CheckAccess['umrah_reports_status_stats_export_exit']) { ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?= $path ?>exports/pilgrim_exit" target="_blank"> Export Records
                    </a>
                    <?php  } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="return false;" class="section contact" id="PilgrimsExitSearchFilterForm">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="PilgrimsExitSessionFilters">
                    <input type="hidden" name="flight_date_from" id="flight_date_from" value="<?=$FlightDateFrom?>">
                    <input type="hidden" name="flight_date_to" id="flight_date_to" value="<?=$FlightDateTo?>">
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
                                                        <label for="">Country</label>
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
                                                        <label for="country">Voucher No</label>
                                                        <input type="text" class="form-control" id="voucher_no" name="voucher_no"
                                                               value="<?=$VoucherNo?>" placeholder="Voucher No">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Flight Date</label>
                                                        <input type="text" class="form-control multidate "
                                                               name="flight_date_from_to" id="flight_date_from_to" onchange="GetFlightDateFromTo();">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="PilgrimsExitFiltersFormSubmit( 'PilgrimsExitSearchFilterForm' );"
                                                                id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('PilgrimsExitSessionFilters');"
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
                        <table id="PilgrimsExitRecord" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>Voucher No</th>
                                <th>Actl Hotel</th>
                                <th>Room No</th>
                                <th>Dep Date</th>
                                <th>Dep Htl Time</th>
                                <th>Flight Date</th>
                                <th>Flight No</th>
                                <th>Flight Time</th>
                                <th>PAX</th>
                                <th>Seats</th>
                                <th>Airport</th>
                                <th>Dep City</th>
                                <th>TPT Type</th>
                                <th>Vehicle Number</th>
                                <th>Driver Name</th>
                                <th>Driver Mob.</th>
                                <th>TPT Company</th>
                                <th>PAX Mob. No</th>
                                <th>Category</th>
                                <th>Reference</th>
                                <th>System User</th>
                                <th>Status</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php /*                            $PilgrimModel = new \App\Models\Pilgrims();
                            $cnt = 0;
                            foreach ($records as $record) {
                                $PilgrimMetaRecords = $PilgrimModel->DeparturePilgrimLeaderMetaRecords($record['LeaderPilgrimUID']);
                                //echo '<pre>';print_r($PilgrimMetaRecords);
                                $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], $PilgrimMetaRecords['Status'].'-status');
                                //echo '<pre>';print_r($PilgrimLastActivity);
                                $PilgrimCurrentActivity = PilgrimCurrentActivity($record['LeaderPilgrimUID'],$PilgrimMetaRecords['Status']);
                                //echo '<pre>';print_r($PilgrimCurrentActivity);
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
                                <td>' . $record['VoucherCode'] . '</td>                           
                                <td>' . $PilgrimMetaRecords['ActualHotel'] . '</td>                             
                                <td>' . $PilgrimMetaRecords['RoomNo'] . '</td>                             
                                <td>' . DATEFORMAT($PilgrimMetaRecords['DepartureDate']) . '</td>                             
                                <td>' . TIMEFORMAT($PilgrimCurrentActivity['LastActivityRecordTime']) . '</td>                             
                                <td>' . DATEFORMAT($record['FlightDate']) . '</td>                             
                                <td>' . $record['FlightNo'] . '</td>                             
                                <td>' . TIMEFORMAT($record['FlightTime']) . '</td>                             
                                <td>' . $record['TotalPilgrim'] . '</td>                             
                                <td>' . $PilgrimMetaRecords['Seats'] . '</td>                         
                                <td>' . AirportName($record['SectorFrom']) . '</td>                             
                                <td>' . AirportCode($record['SectorFrom']) . '</td>                            
                                <td>' . $record['TransportType'] . '</td>                                  
                                <td>' . $PilgrimMetaRecords['VehicleNumber'] . '</td>                             
                                <td>' . $PilgrimMetaRecords['DriverName'] . '</td>                             
                                <td>' . $PilgrimMetaRecords['DriverMobileNumber'] . '</td>                          
                                <td>' . $PilgrimMetaRecords['TransportCompany'] . '</td>                              
                                <td>' . $PilgrimMetaRecords['PaxMobileNumber'] . '</td>                               
                                <td>' . ucfirst(str_replace("_"," ",$record['IATAType'])). '</td>                              
                                <td>' . $record['ReferenceName'] . '</td>                             
                                <td>' . ((isset($ActivityUserName)) ? $ActivityUserName : '-') . '</td>                             
                                <td>' . ucwords(str_replace('-', ' ', $PilgrimMetaRecords['Status'])) . '</td>                             
                                </tr> ';
                            }
                            */?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
    $(document).ready(function () {

        setTimeout(function () {
            $("#flight_date_from").val('');
            $("#flight_date_to").val('');
        }, 1000);

        var dataTable = $('#PilgrimsExitRecord').DataTable({
            "processing": true,
            "searching": false,
            "responsive":true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, 'All']],
            "pageLength": 100,
            "lengthChange": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ Pilgrim Exit",
                "info": "Showing _START_ to _END_ of _TOTAL_ Pilgrim Exit",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_pilgrims_exit",
                type: "POST",
            },
            "columnDefs": [
                {
                    "defaultContent": "-",
                    "targets": "_all",
                    //"targets":[0, 3, 4],
                    "orderable": false,
                },
            ],
        });
    });

    function GetFlightDateFromTo() {
        const FlightDateFromTo = $("#flight_date_from_to").val();
        const words = FlightDateFromTo.split(' to ');
        $("#flight_date_from").val(words[0]);
        $("#flight_date_to").val(words[1]);
    }

    function PilgrimsExitFiltersFormSubmit(parent) {

        var dataTable = $('#PilgrimsExitRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {
            dataTable.ajax.reload();
        }
    }

    function ClearSession(SessionKey) {

        var dataTable = $('#PilgrimsExitRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {
            $("form#PilgrimsExitSearchFilterForm input#flight_date_from").val('');
            $("form#PilgrimsExitSearchFilterForm input#flight_date_to").val('');
            $("form#PilgrimsExitSearchFilterForm")[0].reset();
            dataTable.ajax.reload();
        }
    }
</script>
<script type="application/javascript">
    /*$('#ReportTable').DataTable({
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

    <?php if ($CheckAccess['umrah_reports_status_stats_export_exit']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/pilgrim_exit" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);
    <?php } ?>

</script>
