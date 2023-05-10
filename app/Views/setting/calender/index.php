<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Umrah Calenders
                    <?php if($CheckAccess['umrah_settings_umrah_calender_add']) { ?>
                    <button type="button" class="btn btn_customized btn-sm float-right"
                            onclick="LoadModal('setting/calender/add', 0, 'modal-lg')">Create New
                    </button>
                    <?php }
                    ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                        <table id="CalenderRecords" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Year</th>
                                <th>Title</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->
<script type="application/javascript">

    $(document).ready(function () {

        var dataTable = $('#CalenderRecords').DataTable({
            "processing": true,
            "searching": false,
            "responsive": true,
            "lengthMenu": [[100,500,1000,-1],[100,500,1000,'All']],
            "pageLength": 100,
            "lengthChange": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ Umrah Calenders Data",
                "info": "Showing _START_ to _END_ of _TOTAL_ Umrah Calenders Data",
            },
            "ajax": {
                url: "<?= $path ?>setting/fetch_calender_records",
                type: "POST"
            },
            "columnDefs": [
                {
                    "defaultContent": "-",
                    "targets": "_all",
                    "orderable": false,
                },
            ],
        });
    });

</script>