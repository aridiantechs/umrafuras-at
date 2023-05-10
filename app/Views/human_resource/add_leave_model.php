<?php

use App\Models\HRModel;

$record = new HRModel();
$employees = $record->AllEmployeesRecords();

$session = session();
$session = $session->get();

$update_id = 0;
if ($record_id > 0) {
    $head = 'Update';
    $update_id = $record_id;
    $ApplicationData = $records['Application_record'];
//    echo "<pre>";
//    print_r($ApplicationData);
//    exit;
}

?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?> Leave Application Form </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="feather feather-x-circle">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
    </button>
</div>
<div>

</div>
<form class="validate" method="post" action="#" id="LeaveApplicationForm" name="LeaveApplicationForm">
    <div class="modal-body">

        <div class="row">
            <input type="hidden" name="UID" value="<?= $update_id ?>">
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label>Station</label>
                    <select class="form-control validate[required]" id="station"
                            name="station">
                        <option value="" selected disabled>Please Select</option>
                        <option value="HO/Islamabad" <?= ($ApplicationData['Station'] == 'HO/Islamabad') ? 'Selected' : '' ?> >
                            HO/Islamabad
                        </option>
                        <option value="Layyah" <?= ($ApplicationData['Station'] == 'Layyah') ? 'Selected' : '' ?> >
                            Layyah
                        </option>
                        <option value="Karachi" <?= ($ApplicationData['Station'] == 'Karachi') ? 'Selected' : '' ?> >
                            Karachi
                        </option>
                        <option value="Other" <?= ($ApplicationData['Station'] == 'Other') ? 'Selected' : '' ?> >Other
                        </option>

                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label>Name Of Applicant</label>
                    <select class="form-control validate[required]" id="name_of_applicant"
                            name="name_of_applicant" onchange="NameOfApplicantOnchange()">
                        <option value="" selected disabled>Please Select</option>
                        <?php
                        foreach ($employees as $value) {
                            if ($value['emp_firstname'] == 1) {
                            } else {
                                $Selected = '';
                                ($value['id'] == $ApplicationData['EmployeeID'] ? $Selected = 'Selected' : $Selected = '');
                                echo ' <option value="' . $value['id'] . '" ' . $Selected . '>' . $value['emp_firstname'] . " " . $value['emp_lastname'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!--            <div class="col-md-4">-->
            <!--                <div class="form-group mb-3">-->
            <!--                    <label>Department</label>-->
            <!--                    <select class="form-control validate[required]" id="department"-->
            <!--                            name="department">-->
            <!--                        <option value="" selected disabled>Please Select</option>-->
            <!--                        --><?php
            //                        foreach ($department as $value) {
            //                                echo ' <option value="' . $value['id'] . '">' . $value['dept_name'] .'</option>';
            //                        }
            //                        ?>
            <!---->
            <!--                    </select>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div class="col-md-4">-->
            <!--                <div class="form-group mb-3">-->
            <!--                    <label>Designation</label>-->
            <!--                    <input type="text" class="form-control  validate[required]" id="designation" name="designation"-->
            <!--                           placeholder="Designation" value="">-->
            <!--                </div>-->
            <!--            </div>-->
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label>Leave Category</label>
                    <select class="form-control validate[required] leave_category" id="leave_category"
                            name="leave_category" onchange="LeaveCategoryOnChangefunction(this.value)">
                        <option value="" selected disabled>Please Select</option>
                        <?php
                        foreach ($LeaveCategory as $key => $value) {
                            $Selected = '';
                            ($key == $ApplicationData['LeaveCategory'] ? $Selected = 'Selected' : $Selected = '');
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
            <div class="col-md-4">
                <div class="form-group">
                    <label for="country">Date From </label>
                    <input type="datetime-local" class="form-control validate[required]"
                           name="date_from" id="date_from"
                           placeholder="" value="<?= $ApplicationData['From'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="country">Date To</label>
                    <input type="datetime-local" class="form-control validate[required]"
                           name="date_to" id="date_to"
                           placeholder="" value="<?= $ApplicationData['To'] ?>">
                </div>
            </div>


            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label>Backup Person</label>
                    <select class="form-control validate[required]" id="backup_person"
                            name="backup_person">
                        <option value="" selected disabled>Please Select</option>
                        <?php
                        foreach ($employees as $value) {
                            if ($value['emp_firstname'] == 1) {
                            } else {
                                $Selected = '';
                                ($value['id'] == $ApplicationData['BackupPerson'] ? $Selected = 'Selected' : $Selected = '');
                                echo ' <option value="' . $value['id'] . '"  ' . $Selected . '   >' . $value['emp_firstname'] . " " . $value['emp_lastname'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!--            <div class="col-md-4">-->
            <!--                <div class="form-group mb-3">-->
            <!--                    <label>Backup Person Designation</label>-->
            <!--                    <input type="text" class="form-control validate[required] " id="backup_designation" name="backup_designation"-->
            <!--                           placeholder="Backup Person Designation" value="">-->
            <!--                </div>-->
            <!--            </div>-->
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label>HOD Approval</label>
                    <select class="form-control validate[required]" id="hod_approval"
                            name="hod_approval">
                        <option value="" selected disabled>Please Select</option>
                        <?php
                        foreach ($employees as $value) {
                            if ($value['emp_firstname'] == 1) {
                            } else {
                                $Selected = '';
                                ($value['id'] == $ApplicationData['ApprovalAuthority'] ? $Selected = 'Selected' : $Selected = '');
                                echo ' <option value="' . $value['id'] . '" ' . $Selected . '   >' . $value['emp_firstname'] . " " . $value['emp_lastname'] . '</option>';
                            }
                        }
                        ?>

                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label>Leave Status</label>
                    <select class="form-control validate[required]" id="leave_status"
                            name="leave_status">
                        <option value="" selected disabled>Please Select</option>
                        <option value="approved" <?= ($ApplicationData['Status'] == 'approved') ? 'Selected' : '' ?> >
                            Approved
                        </option>
                        <option value="not_Approved" <?= ($ApplicationData['Status'] == 'not_Approved') ? 'Selected' : '' ?> >
                            Not Approved
                        </option>

                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group mb-3">
                    <label>Reason</label>
                    <textarea class="form-control validate[required]" id=""
                              name="reason"><?= $ApplicationData['Reason'] ?></textarea>
                </div>
            </div>


            <!--            <div class="col-md-4  "> // d-none class use for remove create date because create date in system date -->
            <!--                <div class="form-group mb-4">-->
            <!--                    <label for="createDate">Create Date </label>-->
            <!--                    <input type="date" class="form-control  " id="createDate" name="createDate"-->
            <!--                           value="">-->
            <!--                </div>-->
            <!--            </div>-->

        </div>
        <div class="row" id="show">
            <div class="col-md-12" id="HTML">
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12" id="Status">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="LeavesStatus">
        </div>
    </div>


    </div>
    <div class="modal-footer">
        <span id="TotalLeaveData" style="float: left;width: 70%;text-align: left;">

        </span>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Discard</button>
        <button class="btn btn-success" id="ApplicationFormButton" type="button" onclick="SaveLeaveApplicationForm()"><i
                    class="flaticon-12"></i>Save
        </button>
    </div>
</form>

<script type="application/javascript">


    // $('#name_of_applicant').on('change', function () {
    //
    // });
    //
    function NameOfApplicantOnchange() {

        $("#TotalLeaveData").hide();
        $('#LeavesStatus').hide();
        $('.leave_category').val('');
    }


    // $('#leave_category').on('change', function () {
    //
    // });
    function LeaveCategoryOnChangefunction(category) {

        var empid = $('#name_of_applicant').val();
        $("#TotalLeaveData").hide();
        $('#LeavesStatus').hide();
        var data = {
            LeaveCategory: category,
            EmployeeID: empid
        }
        AjaxRequest('hr/HTMLLeaveData', data, 'TotalLeaveData');
        $("#TotalLeaveData").show();
    }


    function SaveLeaveApplicationForm() {


        if ($("#total_leave_category_balance").val() == 0) {
            $('#LeavesStatus').show();
            $("#LeavesStatus").html('<div class="text-center alert alert-danger mb-4" role="alert">  <strong>Alert!</strong> No Remaining Leaves Sorry </div>')

        } else {

            $('#LeavesStatus').hide();
            var validate = $("form#LeaveApplicationForm").validationEngine('validate');
            if (validate == false) {
                return false;
            }
            var data = $('form#LeaveApplicationForm').serialize();
            response = AjaxResponse("hr/SaveLeave_ApplicationForm", data);
            if (response.status == 'success') {
                $("#Status").html('<div class="text-center alert alert-success mb-4" role="alert">  <strong>Success!</strong> ' + response.message + ' </div>')
                $('form#LeaveApplicationForm').trigger("reset");
                location.reload();
            }
        }


    }


</script>