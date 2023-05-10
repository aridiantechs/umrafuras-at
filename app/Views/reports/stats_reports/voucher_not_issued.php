<?php
$session = session();
$SessionFilters = $session->get('VoucherNotIssuedSessionFilters');
$Country = $Agent = $Group = $PPTNO = $Pilgrim = $MofaNo = $VisaNo = '';
if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $Country = $SessionFilters['country'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $Agent = $SessionFilters['agent'];
}

if( isset($SessionFilters['group']) && trim($SessionFilters['group']) != '' ){
    $Group = $SessionFilters['group'];
}

if( isset($SessionFilters['pp_no']) && trim($SessionFilters['pp_no']) != '' ){
    $PPTNO = $SessionFilters['pp_no'];
}

if( isset($SessionFilters['pilgrim']) && trim($SessionFilters['pilgrim']) != '' ){
    $Pilgrim = $SessionFilters['pilgrim'];
}

if( isset($SessionFilters['mofa_no']) && trim($SessionFilters['mofa_no']) != '' ){
    $MofaNo = $SessionFilters['mofa_no'];
}

if( isset($SessionFilters['visa_no']) && trim($SessionFilters['visa_no']) != '' ){
    $VisaNo = $SessionFilters['visa_no'];
}
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Voucher Not Issued
                    <?php if ($CheckAccess['umrah_reports_status_stats_export_voucher_not_issued']) { ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?=$path?>exports/voucher_not_issued" target="_blank"> Export Record
                    </a>
                    <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="return false;" class="section contact" id="VoucherNotIssuedStatsReportSearchFilter">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="VoucherNotIssuedSessionFilters">
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
                                                            <option <?=( ( $Country == '' )? 'selected' : '' )?> value="">Please Select</option>
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
                                                        <label for="country">Group</label>
                                                        <input value="<?=$Group?>" type="text" class="form-control" id="group"
                                                               name="group" placeholder="Group Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">P/P No</label>
                                                        <input value="<?=$PPTNO?>" type="text" class="form-control" id="pp_no"
                                                               name="pp_no" placeholder="P/P No">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Pilgrim</label>
                                                        <input value="<?=$Pilgrim?>" type="text" class="form-control" id="pilgrim"
                                                               name="pilgrim" placeholder="Pilgrim Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Mofa#</label>
                                                        <input value="<?=$MofaNo?>" type="text" class="form-control" id="mofa_no"
                                                               name="mofa_no" placeholder="Mofa No">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Visa#</label>
                                                        <input value="<?=$VisaNo?>" type="text" class="form-control" id="visa_no"
                                                               name="visa_no" placeholder="Visa No">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="VoucherNotIssuedIssuedFiltersFormSubmit( 'VoucherNotIssuedStatsReportSearchFilter' );" id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('VoucherNotIssuedSessionFilters');" id="btnreset" type="button" class="btn btn-danger">Clear
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
                        <table id="VoucherNotIssuedRecord" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>EA Code </th>
                                <th>Country</th>
                                <th>Pilgrim. ID </th>

                                <th>Agent Name </th>

                                <th>HTL Category</th>
                                <th>Group Name </th>
                                <th>Pilgrim Name </th>
                                <th>Gender </th>
                                <th>P/p No </th>
                                <th>D.O.B</th>
                                <th>Nationality</th>
                                <th>City</th>

                                <th>Mofa No </th>
<!--                                <th>Mofa Issue Date</th>-->
                                <th>Visa No </th>
<!--                                <th>Visa Issue Date</th>-->
                                <th>Category </th>
                                <th>Reference</th>


                            </tr>
                            </thead>
                            <tbody>
                            <?php /*                            $cnt=0;
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
                                <td>' . $record['HotelCategory'] .'</td> 
                                <td>' . $record['GroupName'] . '</td>   
                                <td>' . $record['PilgrimFullName'] .'</td>
                                <td>' . $record['Gender'] . '</td>
                                <td>' . $record['PassportNumber'] . '</td>
                                <td>' . DATEFORMAT($record['DOB']) . '</td>
                                <td>' . $record['Nationality'] . '</td>
                              
                                <td>' . $record['CityName'] . '</td> 
                               
                                <td>' . $record['MOFANumber'] . '</td>
                               <!-- <td>' . DATEFORMAT($record['IssueDateTime']) . '</td> -->
                               <td>' . $record['VisaNumber'] . '</td>
                                    <!--   <td>' . DATEFORMAT($record['IssueDate']) . '</td> -->
                                <td>'.$Category.'</td>
                                <td>' . $record['ReferenceName'] .'</td>
                                             
                                </tr> ';
                            }
                            */?>
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
        var dataTable = $('#VoucherNotIssuedRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Voucher Not Issued",
                "info": "Showing _START_ to _END_ of _TOTAL_ Voucher Not Issued",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_voucher_not_issued",
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

    function VoucherNotIssuedIssuedFiltersFormSubmit(parent){

        var dataTable = $('#VoucherNotIssuedRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if(rslt.status == 'success'){
            dataTable.ajax.reload();
        }
    }

    function ClearSession(SessionKey){

        var dataTable = $('#VoucherNotIssuedRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey );
        if(rslt.status == 'success'){
            $("form#VoucherNotIssuedStatsReportSearchFilter")[0].reset();
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
    <?php if ($CheckAccess['umrah_reports_status_stats_export_voucher_not_issued']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/voucher_not_issued" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>


</script>
