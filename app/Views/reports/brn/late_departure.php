<style>
    table.cell-border thead th, table.cell-border tbody td {
        border: 0.5px solid #DDA420;
        border-collapse: collapse;
    }
</style>
<?php

use App\Models\Crud;

$Crud = new Crud();

$session = session();
$SessionFilters = $session->get('LateDepartureSessionFilters');
$EntryDateFrom = $EntryDateTo = $DepartureDateFrom = $DepartureDateTo  = $Country = $AgentName = '';

//print_r($SessionFilters);exit;

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

if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $Country = $SessionFilters['country'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $AgentName = $SessionFilters['agent'];
}


?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Late Departure
                    <?php if ($CheckAccess['umrah_reports_stats_arrival_departure_late_departure_export']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/late_departure" target="_blank"> Export Record
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="LateDepartureForm" id="LateDepartureForm"
                      onsubmit="LateDepartureFormSubmit('LateDepartureForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey"
                           value="LateDepartureSessionFilters">
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
                                                            <?= Countries('html',$Country) ?>
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
                                                        <label for="country">Entry Date</label>
                                                        <input onchange="GetEntryDate();" type="text"
                                                               class="form-control multidate"
                                                               name="entry_date" id="entry_date">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Departure Date</label>
                                                        <input onchange="GetDepartureDate();" type="text"
                                                               class="form-control multidate"
                                                               name="departure_date" id="departure_date">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="LateDepartureFormSubmit('LateDepartureForm');"
                                                                id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('LateDepartureSessionFilters');"
                                                                id="btnreset" type="button" class="btn btn-danger">Clear
                                                            Filter
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="LateDepartureAjaxResult"></div>
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
                        <table id="LateDepartureRecord" class="table table-hover non-hover display nowrap "
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>HTL Category</th>
                                <th>V. No</th>
                                <th>Group Code</th>
                                <th>Group Name</th>
                                <!--<th>City</th>
                                <th>Actual Hotel</th>
                                <th>Room No</th>-->
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
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            /*

                                                        $cnt=0;
                                                        foreach ($records as $record) {
                                                            $cnt++;


                                                            $Category = 'B2B';
                                                            if ($record['IATAType'] == 'external_agent') {
                                                                $Category = 'External Agent';
                                                            }
                                                            echo '
                                                            <tr>
                                                            <td>'.$cnt.'</td>
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
                                                            <td>' . ucfirst(str_replace("_"," ",$record['IATAType'])). '</td>
                                                            <td>' . $record['ReferenceName'] . '</td>

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
    $(document).ready(function () {
        setTimeout(function () {
            var EntryDateFrom = "<?=$EntryDateFrom?>";
            var EntryDateTo = "<?=$EntryDateTo?>";
            $("#entry_date_from").val(EntryDateFrom);
            $("#entry_date_to").val(EntryDateTo);
            if (EntryDateFrom != '' && EntryDateTo != '') {
                $("#entry_date").val(EntryDateFrom + " to " + EntryDateTo);
            }

            var DepartureDateFrom = "<?=$DepartureDateFrom?>";
            var DepartureDateTo = "<?=$DepartureDateTo?>";
            $("#departure_date_from").val(DepartureDateFrom);
            $("#departure_date_to").val(DepartureDateTo);
            if (DepartureDateFrom != '' && DepartureDateTo != '') {
                $("#departure_date").val(DepartureDateFrom + " to " + DepartureDateTo);
            }


            <?php
            if(isset($SessionFilters) && $SessionFilters != ''){?>
            LateDepartureRecord();
            <?php }?>

        }, 1000);
    });

    function LateDepartureRecord() {
        $('#LateDepartureRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Late Departure Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Late Departure Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_all_late_departure_report",
                type: "POST",
                data: function (data) {
                    data.country = $('#country').val();
                    data.agent = $('#agent').val();
                    data.entry_date_from = $('#entry_date_from').val();
                    data.entry_date_to = $('#entry_date_to').val();
                    data.departure_date_from = $('#departure_date_from').val();
                    data.departure_date_to = $('#departure_date_to').val();
                }
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

    $(document).ready(function () {

        $("#btnsearch").click(function () {
            location.reload();  //just reload table
        });
        $('#btnreset').click(function () { //button reset event click
            $('#LateDepartureSearchFilters')[0].reset();
            $("#entry_date_from").val('');
            $("#entry_date_to").val('');
            $("#departure_date_from").val('');
            $("#departure_date_to").val('');
            location.reload();  //just reload table
        });
    });

    function GetEntryDate() {
        const Date = $("#entry_date").val();
        const words = Date.split(' to ');
        $("#entry_date_from").val(words[0]);
        $("#entry_date_to").val(words[1]);
    }

    function GetDepartureDate() {
        const Date = $("#departure_date").val();
        const words = Date.split(' to ');
        $("#departure_date_from").val(words[0]);
        $("#departure_date_to").val(words[1]);
    }

    function LateDepartureFormSubmit(parent) {

        //var dataTable = $('#SeatLossRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'LateDepartureAjaxResult', 'alert-success', rslt.msg, 250);
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

            GridMessages('LateDepartureForm', 'LateDepartureAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#LateDepartureForm input#booking_date_from").val('');
                $("form#LateDepartureForm input#booking_date_to").val('');
                $("form#LateDepartureForm")[0].reset();

                location.reload();
                //dataTable.ajax.reload();
            }, 500);
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
    <?php if ($CheckAccess['umrah_reports_stats_arrival_departure_late_departure_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/late_departure" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
