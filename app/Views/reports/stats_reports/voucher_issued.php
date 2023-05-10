<?php
$Country = $Agent = $VoucherNo = $HTlCategory = '';
$session = session();
$SessionFilters = $session->get('VoucherIssuedSessionFilters');
if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $Country = $SessionFilters['country'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $Agent = $SessionFilters['agent'];
}

if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
    $VoucherNo = $SessionFilters['voucher_code'];
}

if (isset($SessionFilters['htl_category']) && trim($SessionFilters['htl_category']) != '') {
    $HTlCategory = $SessionFilters['htl_category'];
}
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Voucher Issue Report
                    <?php if ($CheckAccess['umrah_reports_status_stats_export_voucher_issued']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/voucher_issued" target="_blank">Export Records
                        </a>
                    <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="return false;" method="post" class="section contact" id="VoucherIssuedSearchFilters">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="VoucherIssuedSessionFilters">
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
                                                    <option <?= (($Country == '') ? 'selected' : '') ?> value="">Please
                                                        Select
                                                    </option>
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
                                                <input value="<?= $VoucherNo ?>" type="text" class="form-control"
                                                       id="voucher_code"
                                                       name="voucher_code" placeholder="Voucher No">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">HTL Category</label>
                                                <input value="<?= $HTlCategory ?>" type="text" class="form-control"
                                                       id="htl_category"
                                                       name="htl_category" placeholder="HTL Category">
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="VoucherIssuedFiltersFormSubmit( 'VoucherIssuedSearchFilters' );"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('VoucherIssuedSessionFilters');"
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

                </form>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <table id="VoucherIssuedRecord" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>EA Code</th>
                                <th>Country</th>
                                <th>Pilgrim ID</th>

                                <th>Agent Name</th>
                                <th>HTL Category</th>
                                <th>Voucher No</th>
                                <th>Issue Date</th>
                                <th>Group Name</th>
                                <th>Pilgrim Name</th>
                                <th>Gender</th>
                                <th>P/P No</th>
                                <th>DOB</th>
                                <th>Nationality</th>

                                <th>City</th>

                                <th>MOFA No</th>
                                <th>VISA No</th>
                                <th>Category</th>
                                <th>Reference</th>


                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            /*                            $cnt = 0;
                                                        foreach ($records as $record) {
                                                            $cnt++;
                                                            $Category = 'B2B';
                                                            if ($record['IATAType'] == 'external_agent') {
                                                                $Category = 'External Agent';
                                                            }
                                                            echo '
                                                            <tr>
                                                            <td>' . $cnt . '</td>
                                                            <td>' . Code('UF/A/', $record['AgentID']) . '</td>
                                                            <td>' . $record['CountryName'] . '</td>
                                                            <td>' . Code('UF/P/', $record['UID']) . '</td>
                                                            <td>' . $record['AgentName'] . '</td>
                                                            <td>' . $record['HotelCategory'] . '</td>
                                                            <td>' . $record['VoucherCode'] . '</td>
                                                            <td>' . DATEFORMAT($record['IssueDate']) . '</td>
                                                            <td>' . $record['GroupName'] . '</td>
                                                            <td>' . $record['PilgrimFullName'] . '</td>
                                                            <td>' . $record['Gender'] . '</td>
                                                            <td>' . $record['PassportNumber'] . '</td>
                                                            <td>' . DATEFORMAT($record['DOB']) . '</td>
                                                            <td>' . $record['Nationality'] . '</td>
                                                            <td>' . $record['CityName'] . '</td>

                                                            <td>' . $record['MOFANumber'] . '</td>
                                                            <td>' . $record['VisaNumber'] . '</td>
                                                            <td>' . $Category . '</td>
                                                            <td>' . $record['ReferenceName'] . '</td>

                                                            </tr> ';
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
        var dataTable = $('#VoucherIssuedRecord').DataTable({
            "processing": true,
            "searching": false,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, 'All']],
            "pageLength": 100,
            "lengthChange": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ Voucher Issued",
                "info": "Showing _START_ to _END_ of _TOTAL_ Voucher Issued",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_voucher_issued",
                type: "POST"
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

    function VoucherIssuedFiltersFormSubmit(parent) {

        var dataTable = $('#VoucherIssuedRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {
            dataTable.ajax.reload();
        }
    }

    function ClearSession(SessionKey) {

        var dataTable = $('#VoucherIssuedRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {
            $("form#VoucherIssuedSearchFilters")[0].reset();
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
    <?php if ($CheckAccess['umrah_reports_status_stats_export_voucher_issued']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/voucher_issued" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);
    <?php } ?>

</script>
