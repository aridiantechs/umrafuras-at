<!--  BEGIN CONTENT AREA  -->
<link rel="stylesheet" type="text/css" href="<?= $template ?>assets/css/datatables/jquery.dataTables.min.css">

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">B2C
                    <a type="button" class="btn btn_customized btn-sm float-right"
                       onclick="" href="<?= $path ?>pilgrim/new">Add New
                    </a>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing <?=( ($AgentLogged) ? 'd-none' : '' )?>">
                <form class="section contact" id="PilgrimSearchFilter">
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
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Agent Name</label>
                                                        <select class="form-control" id="agent"
                                                                name="agent">
                                                            <option value="">Please Select</option><?php
                                                            foreach ($Agents as $Agent) {
                                                                echo '<option value="' . $Agent['UID'] . '">' . $Agent['FullName'] . '</option>';
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Full Name</label>
                                                        <input class="form-control" id="name" name="name" placeholder="Full Name"
                                                               value="<?=( (isset($session['PilgrimSearchFilter']['name'])) ? $session['PilgrimSearchFilter']['name'] : '' )?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">P/P Number</label>
                                                        <input class="form-control" id="PassportNumber" name="PassportNumber" placeholder="Passport Number "
                                                               value="<?=( (isset($session['PilgrimSearchFilter']['PassportNumber'])) ? $session['PilgrimSearchFilter']['PassportNumber'] : '' )?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Group Name</label>
                                                        <input class="form-control" id="GroupCode" name="GroupCode" placeholder="Group Code"
                                                               value="<?=( (isset($session['PilgrimSearchFilter']['GroupCode'])) ? $session['PilgrimSearchFilter']['GroupCode'] : '' )?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button type="button" id="btnsearch"
                                                                class="btn btn-success">Search
                                                        </button>
                                                        <button type="button" id="btnreset"
                                                                class="btn btn-danger">Clear Filter
                                                        </button>
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
                    <div id="AgentPilgrimAssignResponse"></div>
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                        <table id="MainRecords" class="display table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ref.ID</th>
                                <th>Agent Name</th>
                                <th>Group Name</th>
                                <th>Full Name</th>
                                <th>Passport Number</th>
                                <th width="90">DOB</th>
                                <th>DOB In Years</th>
                                <th>Country</th>
                                <th>Current Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->
<script src="<?= $template ?>assets/js/datatables/jquery.dataTables.min.js"></script>
<script src="<?= $template ?>assets/js/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" >
    $(document).ready(function(){
        var dataTable = $('#MainRecords').DataTable({
            "processing":true,
            "searching": false,
            "pageLength" : 100,
            "lengthChange": true,
            "info": true,
            "autoWidth": true,
            "serverSide":true,
            "order":[],
            "language": {
                "lengthMenu": "Show _MENU_ Pilgrims",
                "info": "Showing _START_ to _END_ of _TOTAL_ Pilgrims",
            },
            "ajax":{
                url:"<?= $path ?>pilgrim/fetch_b2c",
                type:"POST",
                data:function ( data ) {
                    data.PassportNumber = $('#PassportNumber').val();

                }
            },
            "columnDefs":[
                {
                    "defaultContent": "-",
                    "targets": "_all",
                    //"targets":[0, 3, 4],
                    "orderable":false,
                },
            ],
        });
        $("#btnsearch").click(function(){

            dataTable.ajax.reload();
        });
        $('#btnreset').click(function(){ //button reset event click
            $('#PilgrimSearchFilter')[0].reset();
            dataTable.ajax.reload();  //just reload table
        });

    });
</script>
<script type="application/javascript">


    setTimeout(function () {
        $('<a target="_blank" href="<?=$path?>exports/pilgrim_list" class="dt-filter-btn">Export</a>').appendTo(".dataTables_wrapper .dataTables_filter");
    }, 100);


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