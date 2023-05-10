<!--  BEGIN CONTENT AREA  -->
<?php

use App\Models\Crud;

$Crud = new Crud();

$session = session();
$SessionFilters = $session->get('PassportCompleteSessionFilters');
//print_r($SessionFilters);
$DOBFrom = $DOBTo = $agent = $groups = $ppt_number = $full_name = '';


if (isset($SessionFilters['dob_from']) && $SessionFilters['dob_from'] != '') {
    $DOBFrom = $SessionFilters['dob_from'];
}

if (isset($SessionFilters['dob_to']) && $SessionFilters['dob_to'] != '') {
    $DOBTo = $SessionFilters['dob_to'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $agent = $SessionFilters['agent'];
}

if (isset($SessionFilters['group']) && $SessionFilters['group'] != '') {
    $groups = $SessionFilters['group'];
}

if (isset($SessionFilters['ppt_number']) && $SessionFilters['ppt_number'] != '') {
    $ppt_number = $SessionFilters['ppt_number'];
}


if (isset($SessionFilters['full_name']) && $SessionFilters['full_name'] != '') {
    $full_name = $SessionFilters['full_name'];
}

?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Passport Completed
                    <?php if ($CheckAccess['umrah_reports_stats_passport_management_passport_complete_export']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/passport_completed" target="_blank"> Export Record
                        </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post" name="PassportCompleteForm" id="PassportCompleteForm"
                      onsubmit="PassportCompleteFormSubmit('PassportCompleteForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey"
                           value="PassportCompleteSessionFilters">
                    <input type="hidden" name="dob_from" id="dob_from" value="<?= $DOBFrom ?>">
                    <input type="hidden" name="dob_to" id="dob_to" value="<?= $DOBTo ?>">
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
                                                <label for="country">Agent</label>
                                                <select class="form-control" id="agent"
                                                        name="agent">
                                                    <?= $AgentsDropDown['html'] ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Full Name</label>
                                                <input type="text" class="form-control"
                                                       name="full_name" id="full_name" value="<?= $full_name ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Group</label>
                                                <select class="form-control" id="group"
                                                        name="group">
                                                    <option value="">Please Select</option>
                                                    <?php
                                                    foreach ($Groups as $group) {
                                                        echo '<option value="' . $group['UID'] . '" ' . (($groups == $group['UID']) ? 'selected' : '') . '>' . $group['FullName'] . '</option>  ';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">PPT#</label>
                                                <input type="text" class="form-control"
                                                       name="ppt_number" id="ppt_number" value="<?= $ppt_number ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="country">DOB</label>
                                                <input onchange="GetDOB();" type="text" class="form-control multidate"
                                                       name="dob" id="dob">
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="PassportCompleteFormSubmit('PassportCompleteForm');"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('PassportCompleteSessionFilters');"
                                                        id="btnreset" type="button" class="btn btn-danger">Clear
                                                    Filter
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="PassportCompleteAjaxResult"></div>
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
                            <table id="PassportCompleteRecord" class="table table-hover non-hover display nowrap"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ref.ID</th>
                                    <th>Agent</th>
                                    <th>Group</th>
                                    <th>Full Name</th>
                                    <th>PPT Number</th>
                                    <th>DOB</th>
                                    <th>Nationality</th>
                                    <th>Front</th>
                                    <th>Back</th>
                                    <th>Booklet</th>
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
                                                                    <td>' . Code("UF/A/", $record['AgentUID']) . '</td>
                                                                    <td>' . $record['AgentName'] . '</td>
                                                                    <td>' . $record['GroupName'] . '</td>
                                                                    <td>' . $record['FullName'] . '</td>
                                                                    <td>' . $record['PPNO'] . '</td>
                                                                    <td>' . ((isset($record['DOB'])) ? DATEFORMAT($record['DOB']) : '-') . '</td>
                                                                    <td>' . $record['Nationality'] . '</td>
                                                                    <td>' . ((isset($record['PassportFrontPicFileID'])) ? '<a href="' . $path . 'home/load_file/' . $record['PassportFrontPicFileID'] . '" target="_blank">Download</a>' : '-') . '</td>
                                                                    <td>' . ((isset($record['PassportBackPicFileID'])) ? '<a href="' . $path . 'home/load_file/' . $record['PassportBackPicFileID'] . '" target="_blank">Download</a>' : '-') . '</td>
                                                                    <td>' . ((isset($record['PassportBookletPicFileID'])) ? '<a href="' . $path . 'home/load_file/' . $record['PassportBookletPicFileID'] . '" target="_blank">Download</a>' : '-') . '</td>
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
            var DOBFrom = "<?=$DOBFrom?>";
            var DOBTo = "<?=$DOBTo?>";
            $("#dob_from").val(DOBFrom);
            $("#dob_to").val(DOBTo);
            if (DOBFrom != '' && DOBTo != '') {
                $("#dob").val(DOBFrom + " to " + DOBTo);
            }
        }, 1000);


        <?php
        if(isset($SessionFilters) && $SessionFilters != ''){?>
        PassportCompleteRecord();
        <?php }?>
    });

    function PassportCompleteRecord() {
        $('#PassportCompleteRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Passport Complete Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Passport Complete Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_passport_complete_report",
                type: "POST",
                data: function (data) {
                    // data.dob_from = $('#dob_from').val();
                    // data.dob_to = $('#dob_to').val();
                    // data.agent = $('#agent').val();
                    // data.group = $('#group').val();
                    // data.ppt_number = $('#ppt_number').val();
                    // data.full_name = $('#full_name').val();
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
            location.reload();
        });
        $('#btnreset').click(function () { //button reset event click
            $('#PassportCompleteSessionFilters')[0].reset();
            $("#dob_from").val('');
            $("#dob_to").val('');
            location.reload();
        });
    });

    function GetDOB() {
        const Date = $("#dob").val();
        const words = Date.split(' to ');
        $("#dob_from").val(words[0]);
        $("#dob_to").val(words[1]);
    }

    function PassportCompleteFormSubmit(parent) {

        //var dataTable = $('#PassportCompleteRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'PassportCompleteAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                //dataTable.ajax.reload();
                location.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        //var dataTable = $('#PassportCompleteRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('PassportCompleteForm', 'PassportCompleteAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#PassportCompleteForm input#dob_from").val('');
                $("form#PassportCompleteForm input#dob_to").val('');
                $("form#PassportCompleteForm")[0].reset();

                location.reload();
                //dataTable.ajax.reload();
            }, 500);
        }
    }

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

    <?php if ($CheckAccess['umrah_reports_stats_passport_management_passport_complete_export']) { ?>

    setTimeout(function () {
        $('<a href="<?=$path?>exports/passport_completed" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>


</script>
