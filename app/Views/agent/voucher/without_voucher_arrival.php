<?php

$session = session();
$SessionFilters = $session->get('WithoutVouchersArrivalSessionFilters');
$Country = $Agent = $EntryStartDate = $EntryEndDate = '';
if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $Country = $SessionFilters['country'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $Agent = $SessionFilters['agent'];
}

if (isset($SessionFilters['entry_start_date']) && $SessionFilters['entry_start_date'] != '') {
    $EntryStartDate = $SessionFilters['entry_start_date'];
}

if (isset($SessionFilters['entry_end_date']) && $SessionFilters['entry_end_date'] != '') {
    $EntryEndDate = $SessionFilters['entry_end_date'];
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
                <h4 class="page-head">Without Voucher
                    <?php
                        if($CheckAccess['umrah_travel_check_wdout_voucher_arrival_export']){?>
                            <a type="button" class="btn btn_customized  btn-sm float-right"
                               onclick="" href="<?= $path ?>exports/without_voucher_arrival" target="_blank"> Export Record
                            </a>
                        <?php }?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="AllWithOutVoucherFiltersFormSubmit( 'AllWithOutVouchersSearchFiltersForm' ); return false;"
                      method="post" class="section contact" id="AllWithOutVouchersSearchFiltersForm">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="WithoutVouchersArrivalSessionFilters">
                    <input type="hidden" name="entry_start_date" id="entry_start_date" value="<?=$EntryStartDate?>">
                    <input type="hidden" name="entry_end_date" id="entry_end_date" value="<?=$EntryEndDate?>">
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
                                                            <?= Countries('html') ?>
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
                                                        <label for="">Entry Port</label>
                                                        <input type="text" class="form-control" id="entry_port"
                                                               name="entry_port"
                                                               placeholder="Entry Port">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Entry Date</label>
                                                        <input type="text" class="form-control multidate"
                                                               name="entry_date" id="entry_date"
                                                               placeholder="Entry Dates" value="" onchange="GetEntryDate();">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="AllWithOutVouchersReportAjaxResult"></div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="AllWithOutVoucherFiltersFormSubmit( 'AllWithOutVouchersSearchFiltersForm' );" id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('WithoutVouchersArrivalSessionFilters');" id="btnreset" type="button" class="btn btn-danger">Clear
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
                        <table id="AllWdOutVouchersRecord" class="table table-hover non-hover display nowrap "
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>EA Code</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>Group Code</th>
                                <th>Group Name</th>
                                <th>Pax</th>
                                <th>PPT No</th>
                                <th>DOB</th>
                                <th>MOFA Number</th>
                                <th>Visa No</th>
                                <th>Entry Date</th>
                                <th>Entry Time</th>
                                <th>Entry Port</th>
                                <th>Arrival Mode</th>
                                <th>Entry Carrier</th>
                                <th>Flight No</th>
                                <th>Category</th>
                                <th>Reference</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            /*                            $cnt = 0;

                                                        foreach ($Pilgrimslist as $Pilgrimlist) {
                                                            $actions = '
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                                                 <a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/voucher_remarks\', ' . $Pilgrimlist['PilgrimUID'] . ', \'modal-lg\')">Add Remarks</a>
                                                             </div>';
                                                            $cnt++;
                                                            echo
                                                                '
                                                       <tr>
                                                       <td>' . $cnt . ' </td>
                                                       <td>' . Code('UF/EA/', $Pilgrimlist['AgentUID']) . ' </td>
                                                       <td>' . $Pilgrimlist['CountryName'] . ' </td>
                                                       <td>' . $Pilgrimlist['AgentName'] . ' </td>
                                                       <td>' . $Pilgrimlist['GroupName'] . ' </td>
                                                       <td>' . Code('UF/G/', $Pilgrimlist['GroupUID']) . ' </td>
                                                       <td>' . $Pilgrimlist['FirstName'] . ' </td>
                                                       <td>' . $Pilgrimlist['PassportNumber'] . ' </td>
                                                       <td>' . DATEFORMAT($Pilgrimlist['DOB']) . ' </td>
                                                       <td>' . $Pilgrimlist['MOFAPilgrimID'] . ' </td>
                                                       <td>' . $Pilgrimlist['VisaNo'] . ' </td>
                                                       <td>' . DATEFORMAT($Pilgrimlist['EntryDate']) . ' </td>
                                                       <td>' . TIMEFORMAT($Pilgrimlist['EntryTime']) . ' </td>
                                                       <td>' . $Pilgrimlist['EntryPort'] . ' </td>
                                                       <td>' . $Pilgrimlist['TransportMode'] . ' </td>
                                                       <td>' . $Pilgrimlist['EntryCarrier'] . ' </td>
                                                       <td>' . $Pilgrimlist['FlightNo'] . ' </td>
                                                       <td>'.( (isset($Pilgrimlist['AgentType'])) ? ucfirst(str_replace("_"," ",$Pilgrimlist['AgentType'])) : '-' ).'</td>
                                                       <td>' . $Pilgrimlist['ReferenceName'] . ' </td>
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

                                                        </tr>

                                                       ';
                                                        }
                                                        */ ?>
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

        setTimeout(function (){
            $("#entry_start_date").val('');
            $("#entry_end_date").val('');
        }, 1000);

        var dataTable = $('#AllWdOutVouchersRecord').DataTable({
            "processing": true,
            "searching": false,
            "responsive": true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
            "pageLength": 100,
            "lengthChange": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ All WithOut Vouchers Arrival",
                "info": "Showing _START_ to _END_ of _TOTAL_ All WithOut Vouchers Arrival",
            },
            "ajax": {
                url: "<?= $path ?>agent/fetch_all_without_vouchers",
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

    function AllWithOutVoucherFiltersFormSubmit(parent) {

        var dataTable = $('#AllWdOutVouchersRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'AllWithOutVouchersReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                dataTable.ajax.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        var dataTable = $('#AllWdOutVouchersRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('AllWithOutVouchersSearchFiltersForm', 'AllWithOutVouchersReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#AllWithOutVouchersSearchFiltersForm input#entry_start_date").val('');
                $("form#AllWithOutVouchersSearchFiltersForm input#entry_end_date").val('');
                $("form#AllWithOutVouchersSearchFiltersForm")[0].reset();
                dataTable.ajax.reload();
            }, 500);
        }
    }

    function GetEntryDate() {

        const EntryDate = $("#entry_date").val();
        const words = EntryDate.split(' to ');
        $("#entry_start_date").val(words[0]);
        $("#entry_end_date").val(words[1]);
    }
</script>
<script type="application/javascript">


    /*  $('#ReportTable').DataTable({
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


    setTimeout(function () {
        $('<a href="<?=$path?>exports/without_voucher_arrival" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);

</script>
