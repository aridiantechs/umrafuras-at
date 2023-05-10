<?php

$session = session();
$SessionFilters = $session->get('ApprovedVoucherSessionFilters');
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
                <h4 class="page-head">Approved Voucher
                    <?php if ($CheckAccess['umrah_reports_stats_voucher_approved_voucher_export']) { ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?=$path?>exports/approved_voucher_report" target="_blank">Export Records
                    </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="ApprovedVoucherFiltersFormSubmit( 'ApprovedVouchersSearchFilter' ); return false;" class="section contact" id="ApprovedVouchersSearchFilter">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="ApprovedVoucherSessionFilters">
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="country">Create Date</label>
                                                <input onchange="GetCreateDate();" type="text"
                                                       class="form-control multidate"
                                                       name="create_date" id="create_date">
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="ApprovedVouchersReportAjaxResult"></div>
                                        <div class="col-md-12" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="ApprovedVoucherFiltersFormSubmit( 'ApprovedVouchersSearchFilter' );" id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('ApprovedVoucherSessionFilters');" id="btnreset" type="button" class="btn btn-danger">Clear
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
                    <?php
                    if (isset($SessionFilters) && $SessionFilters != '') { ?>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="ApprovedVouchersRecord" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Create Date</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>Category</th>
                                <th>Sub Agent Name</th>
                                <th>Create By</th>

                                <th>Voucher Ref. ID</th>
                                <th>Voucher No</th>

                                <th>Adult</th>
                                <th>Child</th>
                                <th>Infant</th>
                                <th>Total PAX</th>
                                <th>Arrival</th>
                                <th>Departure</th>
                                <th>Total Nights</th>
                                <th>Arrival Mode</th>

                                <th>Status</th>
                                <th>Approved By</th>
                                <th>Approved Date</th>
                                <th>Reference</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
/*                            $cnt = 0;
                            foreach ($records as $record) {
                                $cnt++;

                                echo '
                                <tr>
                                <td>' . $cnt . '</td>
                                <td>'.DATEFORMAT($record['CreatedDate']).'</td>
                                <td>' . $record['CountryName'] . '</td>
                                <td>' . $record['AgentName'] . '</td>
                                <td>' . $record['SubAgentName'] . '</td>
                                <td>'.$record['UserCreatedBy'].'</td>
                                <td>'.Code('UF/V/', $record['UID']).'</td>
                                <td>'.$record['VoucherCode'].'</td>
                                <td>'.$record['Adults'].'</td>
                                <td>'.$record['Child'].'</td>
                                <td>'.$record['Infant'].'</td>
                                <td>'.$record['TotalPilgrim'].'</td>
                                <td>'.DATEFORMAT($record['ArrivalDate']).'</td>
                                <td>'.DATEFORMAT($record['DepartureDate']).'</td>
                                <td>'.$record['TotalNights'].'</td>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>'.$record['UserCreatedBy'].'</td> 
                                <td>'.DATEFORMAT($record['ModifiedDate']).'</td>                                                  
                                <td>' . ucfirst(str_replace("_"," ",$record['IATAType'])). '</td>
                                <td>' . $record['ReferenceName'] . '</td>                             
                                 </tr> ';
                            }
                            */?>
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
<script type="text/javascript">
    $(document).ready(function () {

        setTimeout(function () {
            $("#create_date_from").val('');
            $("#create_date_to").val('');
        }, 1000);

        <?php
        if(isset($SessionFilters) && $SessionFilters != ''){?>
        ApprovedVoucherRecord();
        <?php }?>


    });
    function ApprovedVoucherRecord(){
        var dataTable = $('#ApprovedVouchersRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Approved Vouchers Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Approved Vouchers Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_approved_vouchers_report",
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
    function ApprovedVoucherFiltersFormSubmit(parent) {

        var dataTable = $('#ApprovedVouchersRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'ApprovedVouchersReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
               location.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        var dataTable = $('#ApprovedVouchersRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('ApprovedVouchersSearchFilter', 'ApprovedVouchersReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#ApprovedVouchersSearchFilter input#create_date_from").val('');
                $("form#ApprovedVouchersSearchFilter input#create_date_to").val('');
                $("form#ApprovedVouchersSearchFilter")[0].reset();
                location.reload();
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

    <?php if ($CheckAccess['umrah_reports_stats_voucher_approved_voucher_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/approved_voucher_report" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
