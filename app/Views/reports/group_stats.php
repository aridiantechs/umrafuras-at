<!--  BEGIN CONTENT AREA  -->

<?php

use App\Models\Crud;

$Crud = new Crud();

$session = session();
$SessionFilters = $session->get('GroupStatsSessionFilters');
$country = $agent = $group = '';


if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $country = $SessionFilters['country'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $agent = $SessionFilters['agent'];
}
if (isset($SessionFilters['group']) && $SessionFilters['group'] != '') {
    $group = $SessionFilters['group'];
}


?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Group Stats
                    <?php if ($CheckAccess['umrah_reports_stats_pilgrim_management_group_stats_export']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/group_stats_report" target="_blank">Export Records
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="GroupStatsReportForm" id="GroupStatsReportForm"
                      onsubmit="GroupStatsReportFormSubmit('GroupStatsReportForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="GroupStatsSessionFilters">
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
                                                    <?= Countries('html',$country) ?>
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
                                                <label for="country">Group Name</label>
                                                <input type="text" class="form-control" name="group" id="group"
                                                       placeholder="Group" value="<?=$group?>">
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="GroupStatsReportAjaxResult"></div>
                                        <div class="col-md-12" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="GroupStatsReportFormSubmit('GroupStatsReportForm'); return false;"
                                                        class="btn btn-success">Display Record
                                                </button>
                                                <button onclick="ClearSession('GroupStatsSessionFilters'); return false;"
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
                            <table id="GroupStatsRecord" class="table table-hover non-hover display nowrap"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Country</th>
                                    <th>Agent Name</th>
                                    <th>HTL Category</th>
                                    <th>Group Code</th>
                                    <th>Group Name</th>
                                    <th>Pax</th>
                                    <th>V. Not Issue</th>
                                    <th>V. Issue</th>
                                    <th>Arrived</th>
                                    <th>CHK In Mecca</th>
                                    <th>CHK In Medina</th>
                                    <th>CHK In Jeddah</th>
                                    <th>Exited</th>
                                    <th>Category</th>
                                    <th>Reference</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php /*                            $cnt=0;
                            $Pax=0;
                            $VoucherNotIssued=0;
                            $VoucherIssued=0;
                            $Arrived=0;
                            $CheckInMecca=0;
                            $CheckInMedina=0;
                            $CheckInJeddah=0;
                            $Exit=0;
                            foreach ($records as $record) {
                                $cnt++;
                                $Category='B2C';
                                if($record['AgentUID']>0){
                                    $Category='B2B';
                                }
                                echo '
                                <tr>
                                <td>'.$cnt.'</td>
                                <td>'.$record['CountryName'].'</td>
                                
                                <td>'.$record['IATANAME'].'</td>
                                <td>' . ((isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-') . '</td>
                                <td>' .Code('UF/G/', $record['GroupCode']) . '</td>
                                <td>'.$record['GroupName'].'</td>
                                <td>'.$record['TotalPAX'].'</td>
                                 <td>'.$record['VoucherNotIssued'].'</td>                             
                                <td>'.$record['VoucherIssued'].'</td>                             
                                <td>'.$record['Arrived'].'</td>   
                                <td>'.$record['CheckInMecca'].'</td>   
                                <td>'.$record['CheckInMedina'].'</td>
                                <td>'.$record['CheckInJeddah'].'</td>                             
                                <td>'.$record['Exit'].'</td>                             
                                <td>' . ucfirst(str_replace("_"," ",$record['IATAType'])). '</td>
                                <td>'.$record['ReferenceName'].'</td>                      
                               <!-- <td>'.$record['MofaIssued'].'</td>                             
                                <td>'.$record['MofaNotIssued'].'</td>                             
                                <td>'.$record['VisaNotIssued'].'</td>                             
                                <td>'.$record['VisaIssued'].'</td>    -->                       
                                </tr> ';
                                $Pax=$Pax+$record['TotalPAX'];
                                $VoucherNotIssued=$VoucherNotIssued+$record['VoucherNotIssued'];
                                $VoucherIssued=$VoucherIssued+$record['VoucherIssued'];
                                $Arrived=$Arrived+$record['Arrived'];
                                $CheckInMecca=$CheckInMecca+$record['CheckInMecca'];
                                $CheckInMedina=$CheckInMedina+$record['CheckInMedina'];
                                $CheckInJeddah=$CheckInJeddah+$record['CheckInJeddah'];
                                $Exit=$Exit+$record['Exit'];
                            }
                            */ ?>
                                </tbody>
                                <!--<tr>
                                <td colspan="6" align="center"> Total : </td>
                                <td> <?php /*echo $Pax; */ ?></td>
                                <td> <?php /*echo $VoucherNotIssued; */ ?></td>
                                <td> <?php /*echo $VoucherIssued; */ ?></td>
                                <td><?php /*echo $Arrived; */ ?></td>
                                <td><?php /*echo $CheckInMecca; */ ?></td>
                                <td><?php /*echo $CheckInMedina; */ ?></td>
                                <td><?php /*echo $CheckInJeddah; */ ?></td>
                                <td><?php /*echo $Exit; */ ?></td>
                                <td></td>
                                <td></td>

                             </tr>-->
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


        <?php
        if(isset($SessionFilters) && $SessionFilters != ''){?>
        GroupStatsRecord();
        <?php }?>

    });

    function GroupStatsRecord() {
        $('#GroupStatsRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Group Stats Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Group Stats Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_all_group_stats_report",
                type: "POST",
                data: function (data) {
                    data.country = $('#country').val();
                    data.agent = $('#agent').val();
                    data.group = $('#group').val();
                    data.reference = $('#reference').val();
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

    $("#btnsearch").click(function () {
        location.reload();
    });
    $('#btnreset').click(function () { //button reset event click
        $('#GroupStatsFilters')[0].reset();
        location.reload();
    });


    function GroupStatsReportFormSubmit(parent) {

        //var dataTable = $('#SeatLossRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'GroupStatsReportAjaxResult', 'alert-success', rslt.msg, 250);
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

            GridMessages('GroupStatsReportForm', 'GroupStatsReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#GroupStatsReportForm input#booking_date_from").val('');
                $("form#GroupStatsReportForm input#booking_date_to").val('');
                $("form#GroupStatsReportForm input#expiry_date_from").val('');
                $("form#GroupStatsReportForm input#expiry_date_to").val('');
                $("form#GroupStatsReportForm")[0].reset();


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

    <?php if ($CheckAccess['umrah_reports_stats_pilgrim_management_group_stats_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/group_stats_report" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
