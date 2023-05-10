<?php

$session = session();
$SessionFilters = $session->get('LeaveApplicationSessionFilter');

if (isset($SessionFilters['applicant_name']) && $SessionFilters['applicant_name'] != '') {
    $ApplicantName = $SessionFilters['applicant_name'];
} else {
    $ApplicantName = '';
}
if (isset($SessionFilters['leave_category']) && $SessionFilters['leave_category'] != '') {
    $LeaveCategoryInSession = $SessionFilters['leave_category'];
} else {
    $LeaveCategoryInSession = '';
}
if (isset($SessionFilters['FromTo']) && $SessionFilters['FromTo'] != '') {
    $DateINBetween = $SessionFilters['FromTo'];
} else {
    $EndMonthDate = date('Y-m-21');
    $StartMonthDate = date("Y-m-d", strtotime("-1 Month", strtotime($EndMonthDate)));
    $EndMonthDate = date("Y-m-d", strtotime("-1 day", strtotime($EndMonthDate)));
    $DateINBetween = $StartMonthDate . ' to ' . $EndMonthDate;
}
if (isset($SessionFilters['Department_id']) && $SessionFilters['Department_id'] != '') {
    $Department_id = $SessionFilters['Department_id'];
} else {
    $Department_id = '';
}


?>


<h4 class="page-head"></h4>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">All Leaves Application
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" onsubmit="return false;" id="LeaveApplicationReportForm">
                    <div id="toggleAccordion">
                        <div class="card">
                            <div class="card-header">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class="" data-toggle="collapse"
                                         data-target="#FilterDetails" aria-expanded="false"
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
                                                <input type="hidden" name="SessionKey" id="SessionKey"
                                                       value="LeaveApplicationSessionFilter">

                                                <div class="col-md-2">
                                                    <div class="form-group mb-3">
                                                        <label>Select Department</label>
                                                        <select class="form-control " id="Department_id"
                                                                name="Department_id" onchange="GetEmployeesByDEP(this.value)">
                                                            <option value="" selected disabled>Please Select</option>
                                                            <?php
                                                            foreach ($DepartmentsData as $value) {
                                                                $Selected = '';
                                                                ($value['id'] == $Department_id ? $Selected = 'Selected' : $Selected = '');
                                                                echo '<option value="' . $value['id'] . '" ' . $Selected . ' >' . $value['dept_name'] . '</option>';

                                                            }
                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Applicant Name </label>
                                                        <select class="form-control validate[required]"
                                                                id="applicant_name"
                                                                name="applicant_name">
                                                            <option value="" selected disabled>Please Select Department
                                                            </option>
                                                            <?php
                                                            /*foreach ($employees as $value) {
                                                                if ($value['emp_firstname'] == 1) {
                                                                } else {
                                                                    $Selected = '';
                                                                    ($value['id'] == $ApplicantName ? $Selected = 'Selected' : $Selected = '');
                                                                    echo ' <option value="' . $value['id'] . '" ' . $Selected . '>' . $value['emp_firstname'] . " " . $value['emp_lastname'] . '</option>';
                                                                }
                                                            }*/
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-2">
                                                    <div class="form-group mb-3">
                                                        <label>Leave Category</label>
                                                        <select class="form-control validate[required]"
                                                                id="leave_category"
                                                                name="leave_category">
                                                            <option value="" selected disabled>Please Select</option>
                                                            <?php
                                                            foreach ($LeaveCategory as $key => $value) {
                                                                $Selected = '';
                                                                ($key == $LeaveCategoryInSession ? $Selected = 'Selected' : $Selected = '');
                                                                $option = '<option value="' . $key . '" ' . $Selected . '    >';
                                                                foreach ($value as $name) {
                                                                    $option .= ' ' . $name . '</option>';
                                                                }
                                                                echo $option;
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">From To</label>
                                                        <input type="text"
                                                               class="form-control multidate validate[required,future[now]]"
                                                               name="FromTo" id="FromTo" readonly
                                                               placeholder="" value="<?= $DateINBetween ?>"
                                                        >

                                                    </div>
                                                </div>


                                                <div class="col-md-12 mt-2">
                                                    <div class="form-group">
                                                        <button id="applybtn"
                                                                class="mr-2 btn btn-success float-right" type="button"
                                                                onclick="SaveLeaveApplicationFilterForm('LeaveApplicationReportForm')">
                                                            Apply
                                                        </button>
                                                        <button onclick="ClearSession('LeaveApplicationSessionFilter');"
                                                                id="btnreset" type="button" class="btn btn-danger"
                                                                style="float: right;margin-right: 7px;">Clear
                                                        </button>
                                                        <a href="#"
                                                           class="btn btn-lg btn-primary btn-success mr-2 d-none"
                                                           style="float: right;">Exports
                                                        </a>
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
                    <button type="button" onclick="LoadModal('human_resource/add_leave_model', 0,'modal-lg')"
                            class="btn btn-lg btn-primary btn-success mb-2" style="float: right;">Add Application
                    </button>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="leavesTable" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Name</th>
                                <th>Station</th>
                                <th>Leave Category</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Backup Person</th>
                                <th>Approved By</th>
                                <th>Submitted By</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $cnt = 0;
                            foreach ($AllLeaves as $value) {
                                $cnt++; ?>
                                <tr>
                                    <td><?= $cnt; ?></td>
                                    <td><?= $value['EmployeeName'] ?></td>
                                    <td><?= $value['Station'] ?></td>
                                    <td><?= ucwords(str_replace('_', ' ', $value['LeaveCategory'])) ?></td>
                                    <td><?= date('d M, Y h:i A', strtotime($value['From'])) ?></td>
                                    <td><?= date('d M, Y h:i A', strtotime($value['To'])) ?></td>
                                    <td><?= $value['BackupPersonName'] ?></td>
                                    <td><?= $value['ApprovalAuthorityName'] ?></td>
                                    <td><?= $value['SubmitBY'] ?></td>
                                    <td><?= str_replace('_', ' ', ucwords($value['Status'])) ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button"
                                                    class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split"
                                                    id="dropdownMenuReference1" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-chevron-down">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1"
                                                 style="will-change: transform;">
                                                <a class="dropdown-item" href="#"
                                                   onclick="LoadModal('human_resource/add_leave_model',<?= $value['UID'] ?>,'modal-lg')">Update</a>
                                                <a class="dropdown-item" href="#"
                                                   onclick="DeleteLeave(<?= $value['UID'] ?>)">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php }
                            ?>

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
        $('#leavesTable').DataTable({
            "processing": true,
            "searching": true,
            "responsive": true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, 'All']],
            "pageLength": 100,
            "lengthChange": true,
            "info": true,
            "autoWidth": true,
            "order": [],
        });
    });


    function DeleteLeave(id) {
        if (confirm('Are You Sure You Want To Delete This Record...')) {
            response = AjaxResponse("hr/delete_leave_application_record", "UID=" + id);
            if (response.status == 'success') {
                location.reload();
            }
        }
    }


    function SaveLeaveApplicationFilterForm(parent) {

        PlzWait('show');
        var data = $("form#" + parent).serialize();

        var responce = AjaxResponse('filters_session/create_filters_session', data);
        if (responce.status == 'success') {
            $('form#AttendanceReportForm button#applybtn').attr("disabled", false);
            location.reload();
        }

    }

    function ClearSession(SessionKey) {
        PlzWait('show');
        $('form#AttendanceReportForm button#btnreset').attr("disabled", true);
        var responce = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (responce.status == 'success') {
            $('form#AttendanceReportForm button#btnreset').attr("disabled", false);
            location.reload();
        }
    }

    // dependant dropdown employees

    function GetEmployeesByDEP(DepartmentId) {
        $("#applicant_name").html('');

        var data = {
            departmentID: DepartmentId,

        }
        response = AjaxResponse("hr/get_employees_departments", data);

        if (response != '' && response != null) {

            var html = '';
            html += '<option selected disabled>Please Select</option>';

            for (var i = 0; i < response.length; i++) {
                let Selected = ((response[i].id == '<?=$ApplicantName?>') ? 'selected' : '');

                // if(response[i].id == )
                html += '<option value="' + response[i].id + '"   ' + Selected + '  >' + response[i].EmployeeName + '</option>';

            }

        } else {
            html += '<option selected disabled>Please Select Department</option>';
        }
        $("#applicant_name").append(html);

    }


    setTimeout(function() {
        GetEmployeesByDEP(<?=$Department_id?>);
    }, 1000);

</script>


