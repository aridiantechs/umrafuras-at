<!--  BEGIN CONTENT AREA  -->
<!--<link rel="stylesheet" type="text/css" href="--><?//= $template ?><!--assets/css/datatables/jquery.dataTables.min.css">-->

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Testing Server Side</h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div id="AgentPilgrimAssignResponse"></div>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="PilgrimsRecord" class="display table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Password</th>
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
<script type="text/javascript" language="javascript">
    $(document).ready(function (){
        $('#PilgrimsRecord').DataTable({
            "searching": false,
            "processing": true,
            "pageLength": 10,
            "serverSide": true,
            "lengthMenu": [[5, 10, 50, 100, 250, -1], [5, 10, 50, 100, 250, 'All']],
            "ajax":{
                url: "<?= $path ?>testing/fetch_all_record",
                type: "POST"
            }
        });
    });
</script>