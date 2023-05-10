<?php
$session = session();
$SessionFilters = $session->get('VehicleArrangementSessionFilters');
$City = $TPTType = $TravelDateFrom = $TravelDateTo = '';

if (isset($SessionFilters['city']) && $SessionFilters['city'] != '') {
    $City = $SessionFilters['city'];
}

if (isset($SessionFilters['tpt_type']) && $SessionFilters['tpt_type'] != '') {
    $TPTType = $SessionFilters['tpt_type'];
}

if (isset($SessionFilters['travel_date_from']) && $SessionFilters['travel_date_from'] != '') {
    $TravelDateFrom = $SessionFilters['travel_date_from'];
}

if (isset($SessionFilters['travel_date_to']) && $SessionFilters['travel_date_to'] != '') {
    $TravelDateTo = $SessionFilters['travel_date_to'];
}
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Vehicle Arrangement Report
                    <?php if ($CheckAccess['umrah_reports_stats_transport_vehicle_arrangement_export']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/vehicle_arrangement" target="_blank">Export Records
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="VehicleArrangementFiltersFormSubmit( 'VehicleArrangementSearchFilters' ); return false;"
                      class="section contact" id="VehicleArrangementSearchFilters">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="VehicleArrangementSessionFilters">
                    <input type="hidden" name="travel_date_from" id="travel_date_from"
                           value="<?= $TravelDateFrom ?>">
                    <input type="hidden" name="travel_date_to" id="travel_date_to"
                           value="<?= $TravelDateTo ?>">
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
                                                        <label for="country">City</label>
                                                        <input type="text" class="form-control" id="city"
                                                               name="city"
                                                               value="<?= $City ?>" placeholder="Enter City">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Transport Type</label>
                                                        <input type="text" class="form-control" id="tpt_type"
                                                               name="tpt_type"
                                                               value="<?= $TPTType ?>"
                                                               placeholder="Enter Transport Type">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="country">Travel Date</label>
                                                    <input onchange="GetTravelDate();" type="text"
                                                           class="form-control multidate"
                                                           name="travel_date" id="travel_date">
                                                </div>
                                                <div class="col-md-6" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="VehicleArrangementFiltersFormSubmit( 'VehicleArrangementSearchFilters' );"
                                                                id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('VehicleArrangementSessionFilters');"
                                                                id="btnreset" type="button" class="btn btn-danger">Clear
                                                            Filter
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="VehicleArrangementReportAjaxResult"></div>
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
                            <table id="VehicleArrangementRecord" class="table table-hover non-hover display nowrap"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Travel Date</th>
                                    <th>City</th>
                                    <th>Pick up Location</th>
                                    <th>Pick up Time</th>
                                    <th>PAX</th>
                                    <th>Transport Type</th>
                                    <th>No Of Vehicles</th>
                                    <th>Drop off location</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php /*$cnt = 1;
                            foreach ($records as $record) {
                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                    <td>' . DATEFORMAT($record['TravelDate']) . '</td>
                                    <td>' . $record['CityName'] . '</td>
                                    <td>' . $record['PickupLocation'] . '</td>
                                    <td>' . $record['PickupTime'] . '</td>
                                    <td>' . $record['NoOfPax'] . '</td>
                                    <td>' . $record['TransportName'] . '</td>
                                    <td>' . $record['TotalVehicals'] . '</td>
                                    <td>' . $record['DropOffLocation'] . '</td>
                                </tr>';
                                $cnt++;
                            } */ ?>
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

    $(document).ready(function () {
        <?php
        if(isset($SessionFilters) && $SessionFilters != ''){?>
        VehicleArrangementRecord();
        <?php }?>

        setTimeout(function () {
            var SessionTravelDateFrom = "<?=$TravelDateFrom?>";
            var SessionTravelDateTo = "<?=$TravelDateTo?>";
            $("#travel_date_from").val(SessionTravelDateFrom);
            $("#travel_date_to").val(SessionTravelDateTo);
            if (SessionTravelDateFrom != '' && SessionTravelDateTo != '') {
                $("#travel_date").val(SessionTravelDateFrom + " to " + SessionTravelDateTo);
            }
        }, 1000);


    });

    function VehicleArrangementRecord(parent) {
        $('#VehicleArrangementRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Vehicle Arrangement Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Vehicle Arrangement Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_all_vehicle_arrangement_report",
                type: "POST"
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

    function VehicleArrangementFiltersFormSubmit(parent) {

        var dataTable = $('#VehicleArrangementRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'VehicleArrangementReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                dataTable.ajax.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        var dataTable = $('#VehicleArrangementRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('VehicleArrangementSearchFilters', 'VehicleArrangementReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#VehicleArrangementSearchFilters input#travel_date_from").val('');
                $("form#VehicleArrangementSearchFilters input#travel_date_to").val('');
                $("form#VehicleArrangementSearchFilters")[0].reset();
                dataTable.ajax.reload();
            }, 500);
        }
    }

    function GetTravelDate() {
        const Date = $("#travel_date").val();
        const words = Date.split(' to ');
        $("#travel_date_from").val(words[0]);
        $("#travel_date_to").val(words[1]);
    }

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


    <?php if ($CheckAccess['umrah_reports_stats_transport_vehicle_arrangement_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/vehicle_arrangement" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>