<?php
$session = session();
$session = $session->get();
$head = 'Add New ';
$update_id = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
}


//print_r($finalMeta);

?>
<style>
    .table th, td {
        padding: .25rem !important;
        font-size: 12px !important;
    }
</style>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Manual Leads Importer</h5>
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
<form enctype="multipart/form-data" class="validate" method="post" action="#" id="ManualLeadsImportForm"
      name="ManualLeadsImportForm"
      onsubmit="ManualLeadsImportFormSubmit('ManualLeadsImportForm'); return false;">
    <div class="modal-body pt-0" id="ManualLeadsModal">
        <input type="hidden" name="UID" id="UID" value="0">
        <input type="hidden" name="DomainID" id="DomainID" value="">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <span  style="font-weight: bold; color: #dda420;">&raquo; Sample Columns for .csv file</span>
                    <div class="table-responsive mb-2 mt-2" style="overflow:auto;">
                        <table class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>Company/Agent</th>
                                <th>Contact Person</th>
                                <th>Mobile# 1</th>
                                <th>Mobile# 2</th>
                                <th>Phone# 1</th>
                                <th>Phone# 2</th>
                                <th>WhatsApp</th>
                                <th>Data Source</th>
                                <th>Country</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Al Ziafat Travel</td>
                                <td>Lala Ramzan</td>
                                <td>03458863524</td>
                                <td>03458863524</td>
                                <td>03458863524</td>
                                <td>03458863524</td>
                                <td>03458863524</td>
                                <td>Organic Data</td>
                                <td>Pakistan</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                        <label for="File">File </label>
                        <input type="file" class="form-control " id="uploaded_file" name="uploaded_file"
                               placeholder="Choose File"
                               value="">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="" id="ManualLeadsImportAjaxResponse"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Discard</button>
        <button type="button" class="btn btn-primary" onclick="ManualLeadsImportFormSubmit('ManualLeadsImportForm');">
            Save
        </button>
    </div>
</form>
<script>


    function ManualLeadsImportFormSubmit(parent) {

        var Project = $("form#ManualLeadsImportForm select#project_id").val();
        var LeadCategory = $("form#ManualLeadsImportForm select#lead_category").val();

        if (Project != '' && LeadCategory != '') {

            if (confirm("Do You Want to Import Leads File ?")) {
                var phpdata = new window.FormData($("form#" + parent)[0]);
                var response = AjaxUploadResponse("lead/manual_leads_import_form_submit", phpdata);
                if (response.status == 'success') {
                    GridMessages('ManualLeadsImportForm', 'ManualLeadsImportAjaxResponse', 'alert alert-success', response.message, 3000);
                    setTimeout(function () {
                        $("form#" + parent)[0].reset();
                        location.reload();
                    }, 4500);

                } else {

                    GridMessages('ManualLeadsImportForm', 'ManualLeadsImportAjaxResponse', 'alert alert-warning', response.message, 3000);
                    setTimeout(function () {
                        $("form#" + parent)[0].reset();
                    }, 4500);
                }
            }

        } else {
            if (Project == '') {
                GridMessages('ManualLeadsImportForm', 'ManualLeadsImportAjaxResponse', 'alert alert-warning', "Please Select Project To Import Leads", 3000);
            } else {
                GridMessages('ManualLeadsImportForm', 'ManualLeadsImportAjaxResponse', 'alert alert-warning', "Please Select Lead Category To Import Leads", 3000);
            }
        }
    }

</script>