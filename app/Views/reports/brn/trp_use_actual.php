<?php
use App\Models\Crud;

$Crud = new Crud();

$session = session();
$SessionFilters = $session->get('TransportBrnUseActualReportSessionFilters');
$BookingDateFrom = $BookingDateTo = $BookingID = $UseDateFrom = $UseDateTo = $Company = $SystemUsers = $TransportSector = '';

if (isset($SessionFilters['booking_date_from']) && $SessionFilters['booking_date_from'] != '') {
    $BookingDateFrom = $SessionFilters['booking_date_from'];
}

if (isset($SessionFilters['booking_date_to']) && $SessionFilters['booking_date_to'] != '') {
    $BookingDateTo = $SessionFilters['booking_date_to'];
}

if (isset($SessionFilters['booking_id']) && $SessionFilters['booking_id'] != '') {
    $BookingID = $SessionFilters['booking_id'];
}

if (isset($SessionFilters['use_date_from']) && $SessionFilters['use_date_from'] != '') {
    $UseDateFrom = $SessionFilters['use_date_from'];
}

if (isset($SessionFilters['use_date_to']) && $SessionFilters['use_date_to'] != '') {
    $UseDateTo = $SessionFilters['use_date_to'];
}

if (isset($SessionFilters['company']) && $SessionFilters['company'] != '') {
    $Company = $SessionFilters['company'];
}

if (isset($SessionFilters['system_users']) && $SessionFilters['system_users'] != '') {
    $SystemUsers = $SessionFilters['system_users'];
}

if (isset($SessionFilters['tpt_sector']) && $SessionFilters['tpt_sector'] != '') {
    $TransportSector = $SessionFilters['tpt_sector'];
}

/** Transport Sectors Data For Report*/
$TransportSectorSql = ' SELECT main."LookupsOptions".*
                        FROM main."LookupsOptions" 
                        JOIN main."Lookups" ON ( main."Lookups"."UID" = main."LookupsOptions"."LookupID" )
                    WHERE main."Lookups"."Key" = \'transport_sectors\' AND main."LookupsOptions"."Archive" = 0 ';
if( $TransportSector != '' ){
    $TransportSectorSql .=' AND main."LookupsOptions"."UID" = '.$TransportSector.' ';
}
$TransportSectorSql .=' ORDER BY main."LookupsOptions"."Name" ASC';
$sectors = $Crud->ExecuteSQL($TransportSectorSql);
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
                <h4 class="page-head">Transport BRN use Actual
                    <?php if ($CheckAccess['umrah_reports_stats_brn_transport_transport_brn_use_actual_export']  && isset($SessionFilters) && $SessionFilters != '') { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/trp_use_actual" target="_blank"> Export Record
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="TransportBrnUseActualReportForm" id="TransportBrnUseActualReportForm"
                      onsubmit="TransportBrnUseActualReportFormSubmit('TransportBrnUseActualReportForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey"
                           value="TransportBrnUseActualReportSessionFilters">

                    <input type="hidden" name="booking_date_from" id="booking_date_from"
                           value="<?= $BookingDateFrom ?>">
                    <input type="hidden" name="booking_date_to" id="booking_date_to"
                           value="<?= $BookingDateTo ?>">
                    <input type="hidden" name="use_date_from" id="use_date_from"
                           value="<?= $UseDateFrom ?>">
                    <input type="hidden" name="use_date_to" id="use_date_to"
                           value="<?= $UseDateTo ?>">
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
                                            <label for="country">Booking Date</label>
                                            <input onchange="GetBookingDate();" type="text"
                                                   class="form-control multidate"
                                                   name="booking_date" id="booking_date">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="country">Booking ID</label>
                                            <input value="<?= $BookingID ?>" type="text" class="form-control"
                                                   name="booking_id" id="booking_id">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="country">Use Date</label>
                                            <input onchange="GetUseDate();" type="text"
                                                   class="form-control multidate"
                                                   name="use_date" id="use_date">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="Operator">TPT Sector</label>
                                            <select class="form-control validate[required]" id="tpt_sector"
                                                    name="tpt_sector">
                                                <option value="">Please Select</option>
                                                <?php
                                                $TransportSectors = $Crud->LookupOptions('transport_sectors');
                                                foreach ($TransportSectors as $options) {
                                                    echo '<option ' . ((isset($TransportSector) && $TransportSector == $options['UID']) ? 'selected' : '') . ' value="' . $options['UID'] . '">' . $options['Name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="country">Company</label>
                                            <input value="<?= $Company ?>" type="text" class="form-control"
                                                   name="company" id="company">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="country">System Users</label>
                                            <input value="<?= $SystemUsers ?>" type="text" class="form-control"
                                                   name="system_users" id="system_users">
                                        </div>
                                        <div class="col-md-12 mt-3" id="TransportBrnUseActualReportAjaxResult"></div>
                                        <div class="col-md-12" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="TransportBrnUseActualReportFormSubmit('TransportBrnUseActualReportForm');"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('TransportBrnUseActualReportSessionFilters');"
                                                        id="btnreset" type="button" class="btn btn-danger">Clear
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
                        <table id="ReportTable" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Booking Date</th>
                                <th>BRN No</th>
                                <th>Vehicle Type</th>
                                <th>Booking ID</th>
                                <th>Use ID</th>
                                <th>Used Date</th>
                                <th>QTY</th>
                                <th>Seats</th>
                                <?php
                                foreach ($sectors as $sector) {
                                    echo '<th>' . $sector['Name'] . '</th><th>USE</th>';
                                } ?>
                                <th>Company Name</th>
                                <th>User</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $cnt = 1;
                            foreach ($records as $record){ ?>
                            <tr>
                                <td>1</td>
                                <td><?= $record['BookingDate'] ?></td>
                                <td><?= $record['BRNCode'] ?></td>
                                <td><?= $record['VehicleType'] ?></td>
                                <td><?= $record['BookingID'] ?></td>
                                <td>N/A</td>
                                <td><?= $record['Useddate'] ?></td>
                                <td><?= $record['NoOfVehicles']; ?></td>
                                <td><?= $record['Seats']; ?></td>
                                <?php
                                foreach ($sectors as $sector) {
                                    $NoOfSeats = (isset($record['sectors'][$sector['UID']]['NoOfSeats']) ? $record['sectors'][$sector['UID']]['NoOfSeats'] : '-');
                                    $BRNUsed = (isset($record['sectors'][$sector['UID']]['BRNUsed']) ? $record['sectors'][$sector['UID']]['BRNUsed'] : '-');
                                    echo '<td>' . $NoOfSeats . '</td><td>' . $BRNUsed . '</td>';
                                } ?>
                                <td><?= $record['PurchaseID'] ?></td>
                                <td><?= $record['UserName'] ?></td>
                            </tr>
                            </tbody><?php $cnt++;
                            } ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="7">Total</td>
                                <td>abc</td>
                                <td>Seats</td>
                                <?php
                                foreach ($sectors as $sector) {
                                    echo '<td>Total SUM: ' . $sector['UID'] . '</td><td>Used SUM: ' . $sector['UID'] . '</td>';
                                } ?>
                                <td>Company Name</td>
                                <td>User</td>
                            </tr>
                            </tfoot>
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

        setTimeout(function () {
            var SessionBookingDateFrom = "<?=$BookingDateFrom?>";
            var SessionBookingDateTo = "<?=$BookingDateTo?>";
            $("#booking_date_from").val(SessionBookingDateTo);
            $("#booking_date_to").val(SessionBookingDateTo);
            if (SessionBookingDateFrom != '' && SessionBookingDateTo != '') {
                $("#booking_date").val(SessionBookingDateFrom + " to " + SessionBookingDateTo);
            }
        }, 1000);

        setTimeout(function () {
            var SessionUseDateFrom = "<?=$UseDateFrom?>";
            var SessionUseDateTo = "<?=$UseDateTo?>";
            $("#use_date_from").val(SessionUseDateFrom);
            $("#use_date_to").val(SessionUseDateTo);
            if (SessionUseDateFrom != '' && SessionUseDateTo != '') {
                $("#use_date").val(SessionUseDateFrom + " to " + SessionUseDateTo);
            }
        }, 1000);
    });

    function GetBookingDate() {
        const Date = $("#booking_date").val();
        const words = Date.split(' to ');
        $("#booking_date_from").val(words[0]);
        $("#booking_date_to").val(words[1]);
    }

    function GetUseDate() {
        const Date = $("#use_date").val();
        const words = Date.split(' to ');
        $("#use_date_from").val(words[0]);
        $("#use_date_to").val(words[1]);
    }

    function TransportBrnUseActualReportFormSubmit(parent) {

        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {
            GridMessages(parent, 'TransportBrnUseActualReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                location.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('TransportBrnUseActualReportForm', 'TransportBrnUseActualReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#TransportBrnUseActualReportForm input#booking_date_from").val('');
                $("form#TransportBrnUseActualReportForm input#booking_date_to").val('');
                $("form#TransportBrnUseActualReportForm input#use_date_from").val('');
                $("form#TransportBrnUseActualReportForm input#use_date_to").val('');
                $("form#TransportBrnUseActualReportForm")[0].reset();
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

    <?php if ($CheckAccess['umrah_reports_stats_brn_transport_transport_brn_use_actual_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/trp_use_actual" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);
    <?php } ?>

</script>
