<?php

use App\Models\Crud;

$Crud = new Crud();

$session = session();
$SessionFilters = $session->get('B2CPilgrimsSessionFilters');
$Pilgrim = $PPTNo = $PilgrimStatus = '';

if (isset($SessionFilters['pilgrim']) && $SessionFilters['pilgrim'] != '') {
    $Pilgrim = $SessionFilters['pilgrim'];
}

if (isset($SessionFilters['ppt_no']) && $SessionFilters['ppt_no'] != '') {
    $PPTNo = $SessionFilters['ppt_no'];
}

if (isset($SessionFilters['pilgrim_status']) && $SessionFilters['pilgrim_status'] != '') {
    $PilgrimStatus = $SessionFilters['pilgrim_status'];
}

?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">B2C Pilgrims
                    <?php
                    if($CheckAccess['umrah_groups_pilgrim_b2c_add_new']){?>
                        <a type="button" class="btn btn_customized btn-sm float-right"
                           onclick="" href="<?= $path ?>pilgrim/new_b2c">Add New
                        </a>
                    <?php   } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing <?= (($AgentLogged) ? 'd-none' : '') ?>">
                <form method="post" name="B2CPilgrimsForm" id="B2CPilgrimsForm"
                      onsubmit="B2CPilgrimsFormSubmit('B2CPilgrimsForm'); return false;">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="B2CPilgrimsSessionFilters">
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
                                                <label for="country">Pax Name</label>
                                                <input class="form-control" id="pilgrim" name="pilgrim"
                                                       placeholder="Pilgrim Name"
                                                       value="<?= $Pilgrim ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">P/P No</label>
                                                <input class="form-control" id="ppt_no" name="ppt_no"
                                                       placeholder="P/P No"
                                                       value="<?= $PPTNo ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Current Status</label>
                                                <input type="text" class="form-control" name="pilgrim_status"
                                                       value="<?= $PilgrimStatus ?>"
                                                       placeholder="Pilgrim Status">
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="B2CPilgrimsAjaxResult"></div>
                                        <div class="col-md-12" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="B2CPilgrimsFormSubmit('B2CPilgrimsForm');"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('B2CPilgrimsSessionFilters');"
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
                    <div id="AgentPilgrimAssignResponse"></div>
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv ">
                        <table id="B2CPilgrimsRecord" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                 <th>Create Date</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>Voucher #</th>
                                <th>Group Name</th>
                                <th>Package(pdf)</th>
                                <th>Gender</th>
                                <th>PAX NAme</th>
                                <th>P/P No</th>
                                <th>D.O.B</th>
                                <th>Age</th>
                                <th>nationality</th>
                                <th>Relation</th>
                                <th>Contact #</th>
                                <th>Email</th>
                                <th>Front Pic</th>
                                <th>Back Pic</th>
                                <th>Booklet Pic</th>
                                <th>Pic</th>
                                <th>BPO ID</th>
                                <th>Web Reference</th>
                                <th>Approved By</th>
                                <th>Current Status</th>
                                <!--                                <th>Agent</th>-->


                                <!--                                <th>Website Name</th>-->
                                <!--                                <th>Group</th>-->
                                <!--                                <th>Full Name</th>-->
                                <!--                                <th>Passport Number</th>-->
                                <!--                                <th width="90">DOB</th>-->
                                <!--                                <th>DOB In Years</th>-->
                                <!--                                <th>Current Residence Country</th>-->
                                <!--                                <th>Email</th>-->
                                <!--                                <th>Current Status</th>-->
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
/*                            $cnt = 0;
                            foreach ($records as $record) {
                                $cnt++;
//
//                                if($record['PilgrimEmail'] && $record['PilgrimPassword'] != '' )
//                                {
                                $actions = '
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                    <a class="dropdown-item" href="' . $path . 'pilgrim/new/' . $record['UID'] . '">Update</a>
                                    <a class="dropdown-item" href="' . SeoUrl('exports/pilgrim/' . $record['UID'] . "-" . $record['FirstName']) . ' " target="_blank">Export Pilgrim Details</a>
                                    <a class="dropdown-item" href="#" onclick="LoadModal(\'pilgrim/update_visa\', ' . $record['UID'] . ')" >Update Visa Detail</a>
                                </div>';
                                echo '
                                <tr>
                                     <td>' . $cnt . '</td>  
                                      <td>N/A</td>
                                     <td>N/A</td>
                                     <td>N/A</td>
                                     <td>' . $record['GroupName'] . '</td>
                                     <td>N/A</td>
                                     <td>N/A</td>
                                     <td>N/A</td>                                 
                                     <td>' . $record['FirstName'] . '</td>
                                     <td>' . $record['PassportNumber'] . '</td>
                                     <td>' . DATEFORMAT($record['DOB']) . '</td>
                                     <td>' . $record['DOBInYears'] . '</td>
                                     <td>' . CountryName($record['Nationality']) . '</td>
                                     <td>N/A</td> 
                                     <td>N/A</td>                               
                                     <td>' . $record['PilgrimEmail'] . '</td>
                                     <td>N/A</td>
                                     <td>N/A</td>
                                     <td>N/A</td>
                                     <td>N/A</td>
                                     <td>N/A</td> 
                                     <td>N/A</td> 
                                     <td>N/A</td>                                        
                                     <td>' . $Statuses[$record['CurrentStatus']] . '</td>
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
                                </tr>';
//                                }

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
<script type="application/javascript">

    $(document).ready(function () {
        var dataTable = $('#B2CPilgrimsRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ B2C Pilgrims",
                "info": "Showing _START_ to _END_ of _TOTAL_ B2C Pilgrims",
            },
            "ajax": {
                url: "<?= $path ?>agent/fetch_b2c_pilgrims",
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

    function B2CPilgrimsFormSubmit(parent) {

        var dataTable = $('#B2CPilgrimsRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'B2CPilgrimsAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                dataTable.ajax.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        var dataTable = $('#B2CPilgrimsRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('B2CPilgrimsForm', 'B2CPilgrimsAjaxResult', 'alert-success', rslt.msg, 250);
            $("form#B2CPilgrimsForm")[0].reset();
            setTimeout(function () {
                dataTable.ajax.reload();
            }, 500);
        }
    }

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
        "lengthMenu": [100, 200, 300, 400],
        "pageLength": 100
    });*/

    setTimeout(function () {
        $('<a target="_blank" href="<?=$path?>exports/pilgrim_list" class="dt-filter-btn">Export</a>').appendTo(".dataTables_wrapper .dataTables_filter");
    }, 100);


    //function VOUPilgrimFileFormSubmitt(parent) {
    //
    //    var phpdata = new window.FormData($("form#" + parent)[0]);
    //    var response = AjaxUploadResponse('form_process/vou_pilgrim_file_form_submit', phpdata);
    //
    //    if (response.status == 'success') {
    //        $("#WOUPilgrimAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
    //        setTimeout(function () {
    //            location.href = "<?//=base_url('pilgrim/index')?>//";
    //        }, 2000)
    //    } else {
    //        $("#WOUPilgrimAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
    //    }
    //
    //}

    function AgentPilgrimAssign(agent_id, row_id) {
        if (agent_id > 0) {
            if (confirm("Are You Sure You Want To Assign Agent?")) {
                var response = AjaxResponse('form_process/agent_pilgrim_add_process', "agent_id=" + agent_id + "&pilgrimID=" + row_id);
                if (response.status == 'success') {
                    $("#AgentPilgrimAssignResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
                    setTimeout(function () {
                        location.reload();
                    }, 10)
                } else {
                    $("#AgentPilgrimAssignResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
                }
            }
        }
    }
</script>