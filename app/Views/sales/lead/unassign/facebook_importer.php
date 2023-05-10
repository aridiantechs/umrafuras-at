<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Facebook Leads Importer</h5>
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

<div class="modal-body pt-0" id="FacebookLeadsModal">
    <form class="validate" method="post" action="#" name="FacebookLeadsImportForm" id="FacebookLeadsImportForm"
          onsubmit="FacebookLeadsImportFormSubmit('FacebookLeadsImportForm'); return false;">
        <input type="hidden" name="UID" id="UID" value="#">
        <input type="hidden" name="DomainID" id="DomainID" value="#">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="products">Products</label>
                        <select class="form-control validate[required]" id="project_id"
                                name="project_id">
                            <option value="">Select Product</option>
                            <?php
                            foreach ($Products as $value) {
                                if ($value != 'home' && $value != 'sales' && $value != 'visitor')
                                    echo '<option value="' . $value . '">' . ucwords($value) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="products">Lead Category</label>
                        <select class="form-control validate[required]" id="lead_category"
                                name="lead_category">
                            <option value="">Select Category</option>
                            <option value="B2B">B2B</option>
                            <option value="B2C">B2C</option>

                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="File">File Format </label>
                        <select class="form-control validate[required]" id="file_format"
                                name="file_format">
                            <option value="">Select Format</option>
                            <option value="MM/DD/YYYY">MM/DD/YYYY</option>
                            <option value="DD/MM/YYYY">DD/MM/YYYY</option>

                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="products">File </label>
                        <input type="file" class="form-control" id="uploaded_file" name="uploaded_file"
                               placeholder="Choose File" value="">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="" id="LeadsImportAjaxResponse"></div>
            </div>
        </div>
    </form>
</div>
</div>
<div class="modal-footer">
    <button id="FacebookLeadImportButton" type="button" class="btn btn-success"
            onclick="FacebookLeadsImportFormSubmit('FacebookLeadsImportForm');">
        Import
    </button>
    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Discard</button>
</div>

<script>

    function FacebookLeadsImportFormSubmit(parent) {

        var Project = $("form#FacebookLeadsImportForm select#project_id").val();
        var LeadCategory = $("form#FacebookLeadsImportForm select#lead_category").val();
        var FileFormat = $("form#FacebookLeadsImportForm select#file_format").val();
        if (FileFormat != '' && Project != '' && LeadCategory != '') {

            $("#FacebookLeadImportButton").html("Plz Wait...");
            $("#FacebookLeadImportButton").removeClass("btn-success btn-sm");
            $("#FacebookLeadImportButton").addClass("btn-danger btn-sm");
            $("#FacebookLeadImportButton").attr("disabled", true);

            var data = new window.FormData($("form#" + parent)[0]);
            var rslt = AjaxUploadResponse('lead/facebook_leads_import_form_submit', data);
            if (rslt.status == 'success') {
                GridMessages('FacebookLeadsImportForm', 'LeadsImportAjaxResponse', 'alert alert-success', rslt.message, 3000);
                setTimeout(function () {
                    $("form#" + parent)[0].reset();
                    location.reload();
                }, 4500);

                $("#FacebookLeadImportButton").html("Import");
                $("#FacebookLeadImportButton").removeClass("btn-danger btn-sm");
                $("#FacebookLeadImportButton").addClass("btn-primary btn-sm");
                $("#FacebookLeadImportButton").attr("disabled", false);

            } else {

                GridMessages('FacebookLeadsImportForm', 'LeadsImportAjaxResponse', 'alert alert-warning', rslt.message, 3000);
                setTimeout(function () {
                    $("form#" + parent)[0].reset();
                }, 4500);

                $("#FacebookLeadImportButton").html("Import");
                $("#FacebookLeadImportButton").removeClass("btn-danger btn-sm");
                $("#FacebookLeadImportButton").addClass("btn-primary btn-sm");
                $("#FacebookLeadImportButton").attr("disabled", false);
            }

        } else {

            if(FileFormat == ''){
                GridMessages('FacebookLeadsImportForm', 'LeadsImportAjaxResponse', 'alert alert-warning', "Please Select File Format To Import Leads", 3000);
            }else if( Project == '' ){
                GridMessages('FacebookLeadsImportForm', 'LeadsImportAjaxResponse', 'alert alert-warning', "Please Select Project To Import Leads", 3000);
            }else{
                GridMessages('FacebookLeadsImportForm', 'LeadsImportAjaxResponse', 'alert alert-warning', "Please Select Lead Category To Import Leads", 3000);
            }

        }
    }
</script>