<!--  BEGIN CONTENT AREA  -->
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
                <h4 class="page-head">Actual Transport BRN Balance
                    <?php if ($CheckAccess['umrah_reports_stats_brn_transport_transport_brn_balance_actual_export']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/actual_trp_balance" target="_blank"> Export Record
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" id="B2CReportSearchFilter">
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
                                                <label for="">Booking ID</label>
                                                <input type="text" class="form-control" name="Booking"
                                                       value=""
                                                       placeholder="Booking ID">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Vehicle Type</label>
                                                <input type="text" class="form-control" name="VehicleType"
                                                       value=""
                                                       placeholder="Vehicle Type ">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Sector</label>
                                                <input type="text" class="form-control" name="Sector"
                                                       value=""
                                                       placeholder="Sector">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="country">Booking Date</label>
                                                <input type="text"
                                                       class="form-control multidate validate[required,future[now]]"
                                                       name="BookingDate" id="BookingDate" readonly
                                                       placeholder="" value=""
                                                >

                                            </div>
                                        </div>

                                        <div class="col-md-12" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="UpdateFilters('B2CReportSearchFilter'); return false;"
                                                        class="btn btn-success">Display Record
                                                </button>
                                                <button onclick="ClearFilters('B2CReportSearchFilter'); return false;"
                                                        class="btn btn-danger">Clear Filter
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
                    <?php
                    if (isset($SessionFilters) && $SessionFilters != '') { ?>
                        <div class="table-responsive mb-4 mt-4">
                            <table id="ReportTable" class="table table-hover non-hover display nowrap cell-border"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Booking Date</th>
                                    <th>BRN No</th>
                                    <th>Vehicle Type</th>
                                    <th>Booking ID</th>


                                    <th>QTY</th>
                                    <th>Seats</th>
                                    <?php
                                    foreach ($sectors as $sector) {
                                        echo '<th>' . $sector['Name'] . '</th><th>Remaining</th>';
                                    } ?>


                                    <th>Company Name</th>
                                    <th>System User</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $cnt = 1;
                                foreach ($records as $record) { ?>
                                    <tr>
                                        <td>1</td>
                                        <td><?= $record['BookingDate'] ?></td>
                                        <td><?= $record['BRNCode'] ?></td>
                                        <td><?= $record['VehicleType'] ?></td>
                                        <td><?= $record['BookingID'] ?></td>
                                        <td><?= $record['NoOfVehicles']; ?></td>
                                        <td><?= $record['Seats']; ?></td>

                                        <?php

                                        foreach ($sectors as $sector) {
                                            $NoOfSeats = (isset($record['sectors'][$sector['UID']]['NoOfSeats']) ? $record['sectors'][$sector['UID']]['NoOfSeats'] : '-');
                                            $BRNUsed = (isset($record['sectors'][$sector['UID']]['BRNUsed']) ? $record['sectors'][$sector['UID']]['BRNUsed'] : '-');
                                            $Seats = (isset($record['sectors'][$sector['UID']]['BRNUsed']) ? $record['Seats'] - $record['sectors'][$sector['UID']]['BRNUsed'] : '-');
                                            echo '<td>' . $BRNUsed . '</td><td>' . $Seats . '</td>';
                                        } ?>
                                        <td><?= $record['PurchaseID'] ?></td>
                                        <td><?= $record['UserName'] ?></td>


                                    </tr>
                                    <?php $cnt++;
                                } ?>

                                </tbody>
                            </table>
                        </div>
                    <?php } else {
                        ?>
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

    <?php if ($CheckAccess['umrah_reports_stats_brn_transport_transport_brn_balance_actual_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/actual_trp_balance" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php
    }
    ?>

</script>
