<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">WTU Pilgrim File Upload</h5>
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
<form enctype="multipart/form-data" method="post" action="#"
      id="WOUPilgrimIssuedFilesForm" name="WOUPilgrimIssuedFilesForm">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group pull-right">
                            <label for="Name">Upload File</label>
                            <input type="file" class="form-control" id="UploadFiles"
                                   name="UploadFiles"
                                   placeholder="Upload File">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="" id="WOUPilgrimAddResponse"></div>
                    </div>


                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn_customized"
                    onclick="VOUPilgrimFileFormSubmit('WOUPilgrimIssuedFilesForm');">
                Upload
            </button>
        </div>
</form>

<script>
    function VOUPilgrimFileFormSubmit(parent) {

        var phpdata = new window.FormData($("form#" + parent)[0]);
        var response = AjaxUploadResponse('form_process/vou_pilgrim_file_form_submit', phpdata);

        if (response.status == 'success') {
            $("#WOUPilgrimAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.href = "<?=base_url('pilgrim/index')?>";
            }, 2000)
        } else {
            $("#WOUPilgrimAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }

</script>