<!--  BEGIN CONTENT AREA  -->
<?php

use App\Models\Crud;

$Crud = new Crud();

$session = session();
$SessionFilters = $session->get('PilgrimCountSessionFilters');
$country = $agent = $group = $reference  = '';


if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $country = $SessionFilters['country'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $agent = $SessionFilters['agent'];
}

if (isset($SessionFilters['group']) && $SessionFilters['group'] != '') {
    $group = $SessionFilters['group'];
}

if (isset($SessionFilters['reference']) && $SessionFilters['reference'] != '') {
    $reference = $SessionFilters['reference'];
}

?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Pilgrim Count
                    <?php if ($CheckAccess['umrah_reports_stats_pilgrim_management_pilgrim_count_export']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/pilgrim_count_report" target="_blank">Export Records
                        </a>
                    <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="PilgrimCountReportForm" id="PilgrimCountReportForm"
                      onsubmit="PilgrimCountFormSubmit('PilgrimCountReportForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey"
                           value="PilgrimCountSessionFilters">
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
                                                            <?= Countries('html', $country) ?>
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
                                                        <input type="text" class="form-control" id="group" name="group"
                                                               placeholder="Group" value="<?= $group ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Reference</label>
                                                        <input type="text" class="form-control" id="reference"
                                                               name="reference" placeholder="Reference"
                                                               value="<?= $reference ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="PilgrimCountFormSubmit('PilgrimCountReportForm');"
                                                                id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('PilgrimCountSessionFilters');"
                                                                id="btnreset" type="button" class="btn btn-danger">Clear
                                                            Filter
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="PilgrimCountReportAjaxResult"></div>
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
                        <table id="PilgrimCountRecord" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>EA Code</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>HTL Category</th>
                                <th>Create Date</th>
                                <th>Group Code</th>
                                <th>Group Name</th>
                                <th>Adult</th>
                                <th>Child</th>
                                <th>Infant</th>
                                <th>Total</th>
                                <th>Category</th>
                                <th>Reference</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php /*                            $cnt=0;
                            $count=0;
                            $Adults=0;
                            $Child=0;
                            $Infant=0;
                            foreach ($records as $record) {
                                $cnt++;
                                $Category='B2C';
                                if($record['AgentUID']>0){
                                    $Category='B2B';
                                }
                                echo '
                                <tr>
                                <td>'.$cnt.'</td>
                                <td>' . Code('UF/A/', $record['AgentID']) . '</td>     
                                <td>' . $record['CountryName'] . '</td>
                                <td>' . $record['IATANAME'] . '</td>
                                <td>' . ((isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-') . '</td>
                                <td>' .DATEFORMAT($record['GroupCRDATE']). '</td>
                                <td>' .Code('UF/G/', $record['GroupCode']) . '</td>
                                <td>'.$record['GroupName'].'</td>
                                <td>'.$record['Adults'].'</td>
                                <td>'.$record['Child'].'</td>
                                <td>'.$record['Infant'].'</td>
                                <td>'.$record['TotalPilgrim'].'</td>
                                <td>' . ucfirst(str_replace("_"," ",$record['IATAType'])). '</td>
                                <td>'.$record['ReferenceName'].'</td>
                                </tr> ';
                                $Adults=$Adults+$record['Adults'];
                                $Child=$Child+$record['Child'];
                                $Infant=$Infant+$record['Infant'];
                            }
                            */ ?>
                            </tbody>
                            <!--<tr>
                                <td colspan="8">Total</td>
                                <td><?php /*echo $Adults; */ ?></td>
                                <td><?php /*echo $Child; */ ?></td>
                                <td><?php /*echo $Infant; */ ?></td>
                                <td><?php /*echo $Adults+$Child+$Infant; */ ?></td>
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
        PilgrimCountRecords();
        <?php }?>

    });

    function PilgrimCountRecords() {
        $('#PilgrimCountRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Pilgrim Count",
                "info": "Showing _START_ to _END_ of _TOTAL_ Pilgrim Count",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_pilgrim_count",
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
                    //"targets":[0, 3, 4],
                    "orderable": false,
                },
            ],
        });
    }


    function PilgrimCountFormSubmit(parent) {

        //var dataTable = $('#SeatLossRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'PilgrimCountReportAjaxResult', 'alert-success', rslt.msg, 250);
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

            GridMessages('PilgrimCountReportForm', 'PilgrimCountReportAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#PilgrimCountReportForm input#booking_date_from").val('');
                $("form#PilgrimCountReportForm input#booking_date_to").val('');
                $("form#PilgrimCountReportForm")[0].reset();

                location.reload();
                //dataTable.ajax.reload();
            }, 500);
        }
    }


    <?php if ($CheckAccess['umrah_reports_stats_pilgrim_management_pilgrim_count_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/pilgrim_count_report" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);
    <?php } ?>

    $(document).ready(function () {
        $("#btnsearch").click(function () {
            location.reload();
        });
        $('#btnreset').click(function () { //button reset event click
            $('#PilgrimCountReportForm')[0].reset();
            location.reload();
        });
    });
</script>
