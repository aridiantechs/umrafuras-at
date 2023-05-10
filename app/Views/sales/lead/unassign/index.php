<h4 class="page-head"></h4>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">All Un-Assign Leads
                </h4>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <button type="button" onclick="LoadModal('sales/lead/unassign/manual_lead_import', 0,'modal-lg')"
                            class="btn btn-lg btn-primary btn-success">Manual Lead Import
                    </button>
                    <button type="button" onclick="LoadModal('sales/lead/unassign/facebook_importer', 0,'modal-lg')"
                            class="btn btn-lg btn-success">FB Import
                    </button>
                    <button type="button" onclick="LoadModal('sales/lead/unassign/leads_tracking', 0,'modal-lg')"
                            class="btn btn-lg btn-danger">Track Leads
                    </button>
                    <button type="button" onclick="LoadModal('sales/lead/unassign/unassign_leads', 0,'modal-lg')"
                            class="btn btn-lg btn-primary btn-success">Assign "Un-Assign Leads"
                    </button>
                    <button type="button" onclick="LoadModal('sales/lead/unassign/add_lead', 0,'modal-lg')"
                            class="btn btn-lg btn-primary btn-success" style="float: right;">Add Lead
                    </button>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="UnAssignLeadTable" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Ref.ID</th>
                                <th>Submitted On</th>

                                <th>Product Name</th>
                                <th>Full Name</th>

                                <th>Lead Category</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            /* print_r($LeadData);exit;
                            foreach ($LeadData as $value){ };*/
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
        $('#UnAssignLeadTable').DataTable({
            "processing": true,
            "pageLength": 100,
            "searching": true,
            "serverSide": true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
            "ajax": {
                url: '<?=$path?>lead/fetch_all_unassign_lead',
                type: 'POST',
            }
        });
    });


    function DeleteLead(id) {

        return false;
        if (confirm('Are You Sure You Want To Delete This Record...')) {
            response = AjaxResponse("Lead/delete_lead_record", "UID=" + id);
            if (response.status == 'success') {
                location.reload();
            }
        }
    }

</script>


