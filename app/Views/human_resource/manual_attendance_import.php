<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Manual Attendance Importer</h5>
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
<form enctype="multipart/form-data" class="validate" method="post" action="#" id="ManualAttendanceImportForm"
      name="ManualAttendanceImportForm"
      onsubmit="ManualAttendanceImportFormSubmit('ManualAttendanceImportForm'); return false;">
    <div class="modal-body pt-0" id="">
        <div class="row layout-top-spacing">
            <div class="col-md-12">
                <label>Upload Attendance Report</label>
                <input type="file" accept=".xls" class="form-control validate[required] "
                       id="manual_attendance_uploaded_file"
                       name="manual_attendance_uploaded_file"
                       placeholder="" value="" required>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Discard</button>
        <button id="ImportAttendanceButton" type="button" class="btn btn-primary"
                onclick="ManualAttendanceImportFormSubmit('ManualAttendanceImportForm');">
            Save
        </button>
    </div>
</form>
<script>


    function ManualAttendanceImportFormSubmit(parent) {

        var validate = $("form#ManualAttendanceImportForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        if (confirm("Do You Want to Import Attendance File ?")) {

            $("form#ManualAttendanceImportForm button#ImportAttendanceButton").css('background', 'lightpink');
            $("form#ManualAttendanceImportForm button#ImportAttendanceButton").html('Plz Wait....');
            $("form#ManualAttendanceImportForm button#ImportAttendanceButton").attr("disabled", true);

            var phpdata = new window.FormData($("form#" + parent)[0]);
            var response = AjaxUploadResponse("hr/manual_attendance_import_form_submit", phpdata);
            if (response.status == 'success') {
                setTimeout(function () {
                    $("form#" + parent)[0].reset();
                    location.reload();
                }, 4500);

            }else{

                $("form#ManualAttendanceImportForm button#ImportAttendanceButton").css('background', '#c82333');
                $("form#ManualAttendanceImportForm button#ImportAttendanceButton").html('Save');
                $("form#ManualAttendanceImportForm button#ImportAttendanceButton").attr("disabled", false);
            }
        }
    }

</script>