<!--  BEGIN CONTENT AREA  -->
<?php

use App\Models\Crud;

$Crud = new Crud();

$session = session();
$SessionFilters = $session->get('PilgrimListSessionFilters');
$country = $agent = $passport_no = $reference = '';


if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $country = $SessionFilters['country'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $agent = $SessionFilters['agent'];
}

if (isset($SessionFilters['passport_no']) && $SessionFilters['passport_no'] != '') {
    $passport_no = $SessionFilters['passport_no'];
}

if (isset($SessionFilters['reference']) && $SessionFilters['reference'] != '') {
    $reference = $SessionFilters['reference'];
}


?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Pilgrim List
                    <?php if ($CheckAccess['umrah_reports_stats_pilgrim_management_manage_pilgrim_export']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/pilgrim_list_report" target="_blank">Export Records
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="PilgrimListForm" id="PilgrimListForm"
                      onsubmit="PilgrimListFormSubmit('PilgrimListForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey"
                           value="PilgrimListSessionFilters">
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
                                                        <label for="country">P/P #</label>
                                                        <input class="form-control" id="passport_no" name="passport_no"
                                                               placeholder="Passport Number"
                                                               type="text" value="<?= $passport_no ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Reference</label>
                                                        <input class="form-control" id="reference" name="reference"
                                                               placeholder="Reference"
                                                               type="text" value="<?= $reference ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="PilgrimListFormSubmit('PilgrimListForm');"
                                                                id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('PilgrimListSessionFilters');"
                                                                id="btnreset" type="button" class="btn btn-danger">Clear
                                                            Filter
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="PilgrimListAjaxResult"></div>
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
                            <table id="PilgrimListRecord" class="table table-hover non-hover display nowrap"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Country</th>
                                    <!--                                <th>Pialgrim ID</th>-->
                                    <th>Agent Name</th>
                                    <th>Htl Category</th>

                                    <!--<th>IATA Group Code</th>-->
                                    <th>Voucher No</th>
                                    <th>Group Name</th>
                                    <th>PAX Name</th>
                                    <th>Gender</th>
                                    <th>P/P No</th>
                                    <th>D.O.B</th>
                                    <!--                                <th>Package</th>-->
                                    <th>Nationality</th>
                                    <th>City</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <!--                                <th>Relation</th>-->
                                    <!--                                <th>Embassy</th>-->
                                    <th>Reference</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php /*                            $cnt=0;
                            foreach ($records as $record) {
                                $Category='B2C';
                                if($record['AgentUID']>0){
                                    $Category='B2B';
                                }
                                $cnt++;
                                echo '
                                <tr>
                                <td>' . $cnt . '</td>
                                <td>' . $record['CountryName'] . '</td>
                                <!-- <td>' . Code('UF/P/', $record['UID']) . '</td> -->
                                <td>' . $record['IATANAME'] . '</td>
                                <td>'.$record['HotelCategory'].'</td>
                                <!-- <td>' .Code('UF/G/', $record['GroupCode']) . '</td>-->
                                <td>' . $record['VoucherCode'] . '</td>
                                <td>' . $record['GroupName'] . '</td>
                                <td>' . $record['PilgrimFullName'] . '</td>
                                <td>' . $record['Gender'] . '</td>
                                <td>' . $record['PassportNumber'] . '</td>
                                <td>' . DATEFORMAT($record['DOB']) . '</td>
                               
                                <td>' . $record['Nationality'] . '</td>
                                <td>' . $record['CityName'] . '</td>
                                <td>' . ucfirst(str_replace("_"," ",$record['IATAType'])). '</td>
                                <td>'.ucwords(str_replace('-',' ',$record['CurrentStatus'])).'</td>
                               <!--  <td>' . $record['Relation'] . '</td>
                                <td>' . $record['Embassy'] . '</td> -->
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


        <?php
        if(isset($SessionFilters) && $SessionFilters != ''){?>
        PilgrimListRecord();
        <?php }?>
    });

    function PilgrimListRecord() {
        $('#PilgrimListRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Pilgrim List",
                "info": "Showing _START_ to _END_ of _TOTAL_ Pilgrim List",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_pilgrim_list",
                type: "POST",
                data: function (data) {
                    data.country = $('#country').val();
                    data.agent = $('#agent').val();
                    data.passport_no = $('#passport_no').val();
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

    $(document).ready(function () {

        $("#btnsearch").click(function () {
            location.reload();
        });
        $('#btnreset').click(function () { //button reset event click
            $('#PilgrimListForm')[0].reset();
            location.reload();
        });
    });

    function PilgrimListFormSubmit(parent) {

        //var dataTable = $('#SeatLossRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'PilgrimListAjaxResult', 'alert-success', rslt.msg, 250);
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

            GridMessages('PilgrimListForm', 'PilgrimListAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#PilgrimListForm input#booking_date_from").val('');
                $("form#PilgrimListForm input#booking_date_to").val('');
                $("form#PilgrimListForm")[0].reset();

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

    <?php if ($CheckAccess['umrah_reports_stats_pilgrim_management_manage_pilgrim_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/pilgrim_list_report" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
