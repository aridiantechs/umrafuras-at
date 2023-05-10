<?php

$session = session();
$SessionFilters = $session->get('HotelArrangementReportSessionFilters');
$Category = $City = $Hotel = '';

if (isset($SessionFilters['htl_category']) && $SessionFilters['htl_category'] != '') {
    $Category = $SessionFilters['htl_category'];
}

if (isset($SessionFilters['city']) && $SessionFilters['city'] != '') {
    $City = $SessionFilters['city'];
}

if (isset($SessionFilters['hotel']) && $SessionFilters['hotel'] != '') {
    $Hotel = $SessionFilters['hotel'];
}
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Hotel Arrangement Report
                    <?php if ($CheckAccess['umrah_reports_stats_hotel_hotel_arrangement_export'] && isset($SessionFilters) && $SessionFilters != '') { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/hotel_arrangement" target="_blank">Export Records
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="HotelArrangementReportForm" id="HotelArrangementReportForm"
                      onsubmit="HotelArrangementReportFormSubmit('HotelArrangementReportForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="HotelArrangementReportSessionFilters">
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
                                                <label for="country">HTL Category</label>
                                                <input value="<?= $Category ?>" type="text" class="form-control"
                                                       name="htl_category"
                                                       id="htl_category">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">City</label>
                                                <input value="<?= $City ?>" type="text" class="form-control" name="city"
                                                       id="city">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="country">Hotel</label>
                                                <input value="<?= $Hotel ?>" type="text" class="form-control"
                                                       name="hotel"
                                                       id="hotel">
                                            </div>
                                        </div>
                                        <div class="col-md-5" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="HotelArrangementReportFormSubmit('HotelArrangementReportForm');"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('HotelArrangementReportSessionFilters');"
                                                        id="btnreset" type="button" class="btn btn-danger">Clear
                                                    Filter
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="HotelArrangementReportAjaxResult"></div>
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
                        <table id="HotelArrangementRecord" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Hotel Category</th>
                                <th>City</th>
                                <th>Hotel Name</th>
                                <th>PAX</th><?php
                                foreach ($room_types as $room_type) {
                                    echo '<th>' . $room_type['Name'] . '</th>';
                                } ?>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            /*$cnt = 1;
                            foreach ($records as $record) {
                                $RoomsPilgrims = 0;
                                if (isset($record['RoomsPilgrims']))
                                    $RoomsPilgrims = $record['RoomsPilgrims'];

                                $SharingPilgrims = 0;
                                if (isset($record['SharingPilgrims']))
                                    $SharingPilgrims = $record['SharingPilgrims'];

                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                    <td>' . $record['CategoryName'] . '</td>      
                                    <td>' . $record['CityName'] . '</td>      
                                    <td>' . $record['HotelName'] . '</td>      
                                    <td>' . ($SharingPilgrims + $RoomsPilgrims) . '</td>';
                                $totalNights = 0;
                                $totalRooms = 0;
                                foreach ($room_types as $room_type) {
                                    $totalNights += (isset($record['RoomTypes'][$room_type['UID']]['TotalNights']) ? $record['RoomTypes'][$room_type['UID']]['TotalNights'] : 0);
                                    if ($record['RoomTypeName'] != 'Sharing')
                                        $totalRooms += (isset($record['RoomTypes'][$room_type['UID']]['TotalBeds']) ? $record['RoomTypes'][$room_type['UID']]['TotalBeds'] : 0);

                                    echo '<td>' . (isset($record['RoomTypes'][$room_type['UID']]['TotalBeds']) ? $record['RoomTypes'][$room_type['UID']]['TotalBeds'] : '-') . '</td>';
                                }
                                echo '                      
                                </tr> ';
                                $cnt++;
                            } */
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

    $(document).ready(function () {

        <?php
        if(isset($SessionFilters) && $SessionFilters != ''){?>
        HotelArrangementRecord();
        <?php }?>
    });

    function HotelArrangementRecord(){

        $('#HotelArrangementRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Hotel Arrangement Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Hotel Arrangement Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_all_hotel_arrangement_report",
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

    function HotelArrangementReportFormSubmit(parent) {

        //var dataTable = $('#HotelArrangementRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'HotelArrangementReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                location.reload();
                //dataTable.ajax.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        //var dataTable = $('#HotelArrangementRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('HotelArrangementReportForm', 'HotelArrangementReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#HotelArrangementReportForm")[0].reset();

                location.reload();
                //dataTable.ajax.reload();
            }, 500);
        }
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

    <?php if ($CheckAccess['umrah_reports_stats_hotel_hotel_arrangement_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/hotel_arrangement" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
