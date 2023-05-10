<?php

$session = session();
$SessionFilters = $session->get('AllApprovedVoucherSessionFilters');
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
                <h4 class="page-head">Approved Vouchers
                    <?php
                        if($CheckAccess['umrah_travel_check_approved_voucher_add']){?>
                            <a type="button" class="btn btn_customized  btn-sm float-right"
                               href="<?= SeoUrl('agent/voucher') ?>">Add Voucher
                            </a>
                        <?php }?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="AllApprovedVoucherFiltersFormSubmit( 'AllApprovedVouchersSearchFiltersForm' ); return false;"
                      class="section contact" id="AllApprovedVouchersSearchFiltersForm">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="AllApprovedVoucherSessionFilters">
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
                            <div id="FilterDetails" class="collapse show " aria-labelledby=""
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
                                                <label for="country">Agent Name</label>
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
                                        <div class="col-md-12" id="AllApprovedVouchersReportAjaxResult"></div>
                                        <div class="col-md-12" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="AllApprovedVoucherFiltersFormSubmit( 'AllApprovedVouchersSearchFiltersForm' );" id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('AllApprovedVoucherSessionFilters');" id="btnreset" type="button" class="btn btn-danger">Clear
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
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                        <table id="AllApprovedVouchersRecord" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Country</th>
                                <th>Created Date</th>
                                <th>Voucher Reg. ID</th>
                                <th>Voucher Code</th>
                                <th>Agent Name</th>
                                <th>Arrival</th>
                                <th>Return</th>
                                <th>Total Nights</th>
                                <th>Total Pax</th>
                                <th>Arrival Mode</th>
                                <th>Agent Category</th>
                                <th>Approved By</th>
                                <th>Company</th>
                                <th>Reference</th>
                                <th>Operator</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
/*                            $cnt = 0;
                            foreach ($Vouchers as $voucher) {
                                $cnt++;
                                if ($voucher['AgentParentID'] > 0) {
                                    $Crud = new Crud();
                                    $table = 'main."Agents"';
                                    $where = array("UID" => $voucher['AgentUID']);
                                    $Name = $Crud->SingleRecord($table, $where);
                                    $SubAgentName = $Name['FullName'];

                                    $where = array("UID" => $voucher['AgentParentID']);
                                    $MainAgentName = $Crud->SingleRecord($table, $where);
                                    $AgentName = $MainAgentName['FullName'];

                                } else {
                                    $SubAgentName = '-';
                                    $AgentName = $voucher['AgentName'];
                                }
                                $days = '';
                                $days = date_diff(date_create($voucher['ArrivalDate']), date_create($voucher['ReturnDate']));
                                $days = $days->days;
                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                    <td>' . CountryName($voucher['AgentCountryID']) . '</td>
                                    <td>' . DATEFORMAT($voucher['CreatedDate']) . '</td>
                                    <td>' . Code('UF/V/', $voucher['UID']) . '</td>
                                    <td>' . $voucher['VoucherCode'] . '</td>
                                    <td>' . $AgentName . '</td>
                                    <td>' . $voucher['ArrivalDate'] . '</td>
                                    <td>' . $voucher['ReturnDate'] . '</td>
                                    <td>' . $days . ' Nights</td>
                                    <td>' . $voucher['ArrivalType'] . '</td>
                                    <td>' . ucwords(str_replace('_', ' ', $voucher['AgentCategory'])) . '</td>
                                    <td>' . ((isset($voucher['ApproveBy'])) ? $voucher['ApproveBy'] : '-') . '</td>
                                    <td>' . ((isset($voucher['CompanyName'])) ? $voucher['CompanyName'] : '-') . '</td>
                                    <td>' . ((isset($voucher['ReferenceName'])) ? $voucher['ReferenceName'] : '-') . '</td>
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
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                                <a class="dropdown-item" href="' . SeoUrl('agent/edit_voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '">Edit</a>
                                                <a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/change_voucher_status_modal\', ' . $voucher['UID'] . ', \'modal-xl\')" >Change Status</a>
                                                <a class="dropdown-item" href="' . SeoUrl('exports/voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '" target="_blank">Print</a>
                                                <a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/log_history_modal\', ' . $voucher['UID'] . ', \'modal-xl\')" >Update History</a>
                                               <!-- <a class="dropdown-item" href="' . SeoUrl('exports/voucher_invoice/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '" target="_blank">Inovice</a>  -->
                                            </div>
                                        </div>
                                    </td>
                                </tr>';
                            } */?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->
<script type="text/javascript" language="javascript">
    $(document).ready(function () {

        setTimeout(function () {
            $("#create_date_from").val('');
            $("#create_date_to").val('');
        }, 1000);

        var dataTable = $('#AllApprovedVouchersRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ All Approved Vouchers",
                "info": "Showing _START_ to _END_ of _TOTAL_ All Approved Vouchers",
            },
            "ajax": {
                url: "<?= $path ?>agent/fetch_all_approved_vouchers",
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

    function AllApprovedVoucherFiltersFormSubmit(parent) {

        var dataTable = $('#AllApprovedVouchersRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'AllApprovedVouchersReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                dataTable.ajax.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        var dataTable = $('#AllApprovedVouchersRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('AllApprovedVouchersSearchFiltersForm', 'AllApprovedVouchersReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#AllApprovedVouchersSearchFiltersForm input#create_date_from").val('');
                $("form#AllApprovedVouchersSearchFiltersForm input#create_date_to").val('');
                $("form#AllApprovedVouchersSearchFiltersForm")[0].reset();
                dataTable.ajax.reload();
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
    /*$('#MainRecords').DataTable({
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
        "lengthMenu": [15, 30, 50, 100],
        "pageLength": 15
    });*/

</script>