<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="<?= $template ?>shield_logo_lala_services.png"/>

    <link rel="stylesheet" href="<?= $template ?>assets/css/leave_application_form.css">
    <script type="text/javascript" charset="utf-8">
        localStorage.setItem('path', '<?= $path ?>');
        localStorage.setItem('template', '<?= $template ?>');
    </script>
</head>
<body>
<div class="container-fluid" id="main_container_b2b">
    <!-- Header start -->
    <div class="row">
        <div class="col-md-12" id="main_header_logo">
            <img class="logo_header" src="<?= $template ?>assets/img/main-logo.png" alt="lala-international-logo">
        </div>
    </div>
    <!-- Header End -->
    <!-- B2B login Form Start -->
    <div class="row" id="signup_grid">
        <div class="col-md-8" id="signup_from_grid">
            <form id="LeaveApplicationForm" class="validate" method="post" action="#"  name="LeaveApplicationForm">
                <div class="col-md-12"><h3 class="form_main_heading">Leave Application Form</h3></div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="label_heading">Station</label>
                        <select class="form-control validate[required] drop_down_box" id="station"
                                name="station">
                            <option value="" selected disabled>Please Select</option>
                            <option value="HO/Islamabad">HO/Islamabad</option>
                            <option value="Layyah">Layyah</option>
                            <option value="Karachi">Karachi</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="label_heading">Name of Applicant</label>
                        <select class="form-control validate[required] drop_down_box" id="name_of_applicant" name="name_of_applicant" onchange="NameOfApplicantOnchange()">
                            <option value="" selected disabled>Please Select</option>
                            <?php
                            foreach ($employees as $value) {
                                if ($value['emp_firstname'] == 1) {
                                } else {
                                    echo ' <option value="' . $value['id'] . '">' . $value['emp_firstname'] . " " . $value['emp_lastname'] . '</option>';
                                }
                            }
                            ?>

                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="label_heading">Leave Category</label>
                        <select class="form-control validate[required] leave_category drop_down_box" id="leave_category" name="leave_category" onchange="LeaveCategoryOnChangefunction(this.value)">
                            <option value="" selected disabled>Please Select</option>
                            <?php
                            foreach ($LeaveCategory as $key => $value) {
                                $option = '<option value="' . $key . '">';
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
                        <label class="label_heading">Date From</label>
                        <input type="datetime-local" name="date_from" id="date_from" class="form-control validate[required] input_fields">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="label_heading">Date To</label>
                        <input type="datetime-local" name="date_to" id="date_to" class="form-control validate[required] input_fields">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="label_heading">Backup Person</label>
                        <select class="form-control validate[required] drop_down_box" id="backup_person" name="backup_person">
                            <option value="" selected disabled>Please Select</option>
                            <?php
                            foreach ($employees as $value) {
                                if ($value['emp_firstname'] == 1) {
                                } else {
                                    echo ' <option value="' . $value['id'] . '">' . $value['emp_firstname'] . " " . $value['emp_lastname'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="label_heading">HOD Approval</label>
                        <select class="form-control validate[required] drop_down_box" id="hod_approval" name="hod_approval">
                            <option value="" selected disabled>Please Select</option>
                            <?php
                            foreach ($employees as $value) {
                                if ($value['emp_firstname'] == 1) {
                                } else {
                                    echo ' <option value="' . $value['id'] . '">' . $value['emp_firstname'] . " " . $value['emp_lastname'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="label_heading">Reason</label>
                        <textarea class="form-control validate[required]" rows="4" name="reason"></textarea>
                    </div>
                </div>
<!--                <div class="col-md-4">-->
<!--                    <div class="form-group">-->
<!--                        <label class="label_heading">City</label>-->
<!--                        <input type="text" name="city" class="form-control input_fields">-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-4">-->
<!--                    <div class="form-group">-->
<!--                        <label class="label_heading">Country</label>-->
<!--                        <input type="text" name="country" class="form-control input_fields">-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-4">-->
<!--                    <div class="form-group">-->
<!--                        <label class="label_heading">Fax</label>-->
<!--                        <input type="text" name="fax" class="form-control input_fields">-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-11">-->
<!--                    <h4 class="attatcment_heading">Attachments</h4>-->
<!--                </div>-->
<!--                <div class="col-md-1">-->
<!--                    <button>+</button>-->
<!--                </div>-->
                <div class="col-md-12">
                    <hr style="margin-top: -6px !important;">
                </div>
                <div class="col-md-12" id="TotalLeaveData" style="margin-bottom: 10px;">

                </div>
                <div class="col-md-12" id="Status">
                </div>
                <div class="col-md-12" id="LeavesStatus">
                </div>
                <div class="row" style="margin-left: 0px;">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <button class="captcha_text form-control seperate_margin_top" type="button" id="ApplicationFormButton" onclick="SaveLeaveApplicationForm()">Save</button>
                        </div>
                    </div>
                </div>

<!--                <div class="col-md-12">-->
<!--                                        <p class="forget_password">Forget Password</p>-->
<!--                </div>-->

            </form>
        </div>

    </div>
    <!-- B2B login Form End -->

</div>

<script src="<?= $template ?>assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="<?= $template ?>bootstrap/js/popper.min.js"></script>
<script src="<?= $template ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?= $path ?>template/jquery_validator/jquery.validationEngine.js" type="text/javascript"
        charset="utf-8"></script>
<script src="<?= $path ?>template/jquery_validator/jquery.validationEngine-en.js" type="text/javascript"
        charset="utf-8"></script>
<script src="<?= $path ?>template/custom.js"></script>
<script type="application/javascript">
    function NameOfApplicantOnchange() {

        $("#TotalLeaveData").hide();
        $('#LeavesStatus').hide();
        $('.leave_category').val('');
    }
    function LeaveCategoryOnChangefunction(category) {

        var empid = $('#name_of_applicant').val();
        $("#TotalLeaveData").hide();
        $('#LeavesStatus').hide();
        var data = {
            LeaveCategory: category,
            EmployeeID: empid
        }
        AjaxRequest('leavemanagement/HTMLLeaveData', data, 'TotalLeaveData');
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
            response = AjaxResponse("leavemanagement/SaveLeave_ApplicationForm", data);
            if (response.status == 'success') {
                $("#Status").html('<div class="text-center alert alert-success mb-4" role="alert">  <strong>Success!</strong> ' + response.message + ' </div>')
                $('form#LeaveApplicationForm').trigger("reset");
                location.reload();
            }
        }


    }


</script>
</body>
</html>