<?php

use App\Models\HRModel;

$record = new HRModel();
//$employees = $record->AllEmployees();
$departments = $record->AllDepartments();

?>


<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add Roastes</h5>
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
<form class="validate" method="post" action="#" id="AddRoastersForm"
      name="AddRoastersForm"
      >
    <div class="modal-body" id="">
        <div class="row ">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="country">Date</label>
                    <input type="date" class="form-control validate[required]"
                           name="date" id="datepicker"
                           placeholder="" value="<?= date('Y-m-d') ?>">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label>Department</label>
                    <select class="form-control validate[required]" id="department"
                            name="department">
                        <option value="" selected disabled>Please Select</option>
                        <?php
                        foreach ($departments as $value) {
                            echo '<option value="' . $value['id'] . '">' . ucwords($value['dept_name']) . '</option>';
                        }
                        ?>

                    </select>
                </div>
            </div>

            <div class="col-md-12" id="EmployeeDepStatus">
                <hr>
                <h5> Employees </h5>
                <div id="Status">
                </div>

            </div>
            <div class="col-md-12" id="ResponseStatus">

            </div>


        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Discard</button>
        <button id="AddRoastersFormButton" type="button" class="btn btn-primary"
                onclick="AddRoastersFormSubmit();">
            Save
        </button>
    </div>
</form>

<script type="application/javascript">

    $('#EmployeeDepStatus').hide();
    $('#department').on('change', function () {

        var DepartmentId = $('#department').val();

        var data = {
            departmentID: DepartmentId,
        }
        response = AjaxResponse("hr/get_employees_departments", data);

        if (response != '' && response != null) {
            var html = '';
            for (var i = 0; i < response.length; i++) {

                html += ' \n' +
                    '                   \n' +
                    '                    \n' +
                    '                    <label class="new-checkbox checkbox-primary" style="margin-right: 10px;">\n' +
                    '                        <input id=" ' + response[i].id + '  " type="checkbox" class="" value="1"\n' +
                    '                               name="employees[' + response[i].id + ']" style="margin-right: 7px;">\n' +
                    '                        <span></span><strong>' + response[i].EmployeeName + '</strong>\n' +
                    '                    </label>';
            }


        } else {
            html += '<div class="alert alert-danger text-center font-weight-bold">No Record Found...!</div>';
        }
        $("#Status").html(html);
        $('#EmployeeDepStatus').show();
    });

    function AddRoastersFormSubmit() {

        var validate = $("form#AddRoastersForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        var data = $('form#AddRoastersForm').serialize();
        response = AjaxResponse("hr/save_add_roaster_form", data);
        if (response.status == 'success') {
            $('#EmployeeDepStatus').hide();
            $("#ResponseStatus").html('<div class="text-center alert alert-success mb-4" role="alert">  <strong>Success!</strong> ' + response.message + ' </div>')
            $('form#AddRoastersForm').trigger("reset");
            location.reload();
        }

    }






</script>