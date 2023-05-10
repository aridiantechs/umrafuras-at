<?php

$session = session();
$SessionFilters = $session->get('UpdateVoucherSessionFilters');
$Country = $Agent = $VoucherNo = $CreateDateFrom = $CreateDateTo = '';
if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $Country = $SessionFilters['country'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $Agent = $SessionFilters['agent'];
}

if (isset($SessionFilters['voucher_no']) && $SessionFilters['voucher_no'] != '') {
    $VoucherNo = $SessionFilters['voucher_no'];
}

if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '') {
    $CreateDateFrom = $SessionFilters['create_date_from'];
}

if (isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
    $CreateDateTo = $SessionFilters['create_date_to'];
}
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Update Voucher List
                    <?php if ($CheckAccess['umrah_reports_stats_voucher_update_voucher_export'] && isset($SessionFilters) && $SessionFilters != '') { ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?= $path ?>exports/update_voucher_list" target="_blank"> Export Record
                    </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="UpdateVoucherFiltersFormSubmit( 'UpdatedVoucherSearchFilters' ); return false;" class="section contact" id="UpdatedVoucherSearchFilters">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="UpdateVoucherSessionFilters">
                    <input type="hidden" name="create_date_from" id="create_date_from" value="<?=$CreateDateFrom?>">
                    <input type="hidden" name="create_date_to" id="create_date_to" value="<?=$CreateDateTo?>">
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
                                                        <label for="country">Sub Agent Name</label>
                                                        <select class="form-control" id="agent"
                                                                name="agent">
                                                            <?= $AgentsDropDown['html'] ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Voucher#</label>
                                                        <input value="<?=$VoucherNo?>" type="text" class="form-control" id="voucher_code"
                                                               name="voucher_code">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Create Date</label>
                                                        <input onchange="GetCreateDate();" type="text"
                                                               class="form-control multidate"
                                                               name="create_date" id="create_date">
                                                    </div>
                                                </div>
                                                <div class="col-md-4" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="UpdateVoucherFiltersFormSubmit( 'UpdatedVoucherSearchFilters' );" id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('UpdateVoucherSessionFilters');" id="btnreset" type="button" class="btn btn-danger">Clear
                                                            Filter
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="UpdatedVouchersReportAjaxResult"></div>
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
                        <table id="UpdatedVouchersRecord" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>Sr. No</th>
                                <th>Create Date</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>Sub Agent Name</th>
                                <th>Voucher Ref. ID</th>
                                <th>Voucher No</th>
                                <th>Total PAX</th>
                                <th>Changing Reason</th>
                                <th>Changing Services</th>
                                <th>No of Changes</th>
                                <th>Warning</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Approved By</th>
                                <th>Change ID</th>
                                <th>Category</th>
                                <th>Reference</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php /*
                         $cnt = 0;
                            foreach ($records as $record) {
                                $cnt++;

                                echo '
                                <tr>
                                <td>' . $cnt . '</td>
                                <td>'.DATEFORMAT($record['CreatedDate']).'</td>
                                <td>' . $record['CountryName'] . '</td>
                                <td>' . $record['AgentName'] . '</td>
                                <td>' . $record['SubAgentName'] . '</td>
                                
                                <td>'.Code('UF/V/', $record['UID']).'</td>
                                <td>'.$record['VoucherCode'].'</td>
                                
                                <td>'.$record['TotalPilgrim'].'</td>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>'.$record['UserModifiedBy'].'</td> 
                                <td>N/A</td>
                                                                              
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
            $("#create_date_from").val('');
            $("#create_date_to").val('');
        }, 1000);

        <?php
        if(isset($SessionFilters) && $SessionFilters != ''){?>
        UpdatedVouchersRecord();
        <?php }?>
    });

    function UpdatedVouchersRecord(){
        $('#UpdatedVouchersRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Updated Vouchers Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Updated Vouchers Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_updated_vouchers_report",
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

    function UpdateVoucherFiltersFormSubmit(parent) {

        //var dataTable = $('#UpdatedVouchersRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'UpdatedVouchersReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                location.reload();
                //dataTable.ajax.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        //var dataTable = $('#UpdatedVouchersRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('UpdatedVoucherSearchFilters', 'UpdatedVouchersReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {

                $("form#UpdatedVoucherSearchFilters input#create_date_from").val('');
                $("form#UpdatedVoucherSearchFilters input#create_date_to").val('');
                $("form#UpdatedVoucherSearchFilters")[0].reset();

                location.reload();
                //dataTable.ajax.reload();
            }, 500);
        }
    }

    function GetCreateDate() {
        const Date = $("#create_date").val();
        const words = Date.split(' to ');
        $("#create_date_from").val(words[0]);
        $("#create_date_to").val(words[1]);
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

    <?php if ($CheckAccess['umrah_reports_stats_voucher_update_voucher_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/update_voucher_list" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
