<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Agent Monitor Screen Report
                    <?php if ($CheckAccess['umrah_reports_stats_statistics_agent_monitor_screen_export']) { ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?= $path ?>exports/agent_monitor_screen" target="_blank">Export Records
                    </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" id="AgentSearchFilter">
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
                                                        <label for="country">Country</label>
                                                        <select class="form-control validate[required]" id="Country"
                                                                name="Country">
                                                            <option value="">Please Select</option>
                                                            <?= Countries('html') ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Agent Name</label>
                                                        <input type="text" class="form-control" name="AgentName"
                                                               value=""
                                                               placeholder="Agent Name">
                                                    </div>
                                                </div>


                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">From  To</label>
                                                        <input type="text" class="form-control multidate validate[required,future[now]]"
                                                               name="FromTo" id="FromTo" readonly
                                                               placeholder="" value=""
                                                        >

                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Reference</label>
                                                        <input type="text" class="form-control" name="Reference"
                                                               value=""
                                                               placeholder="Reference">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick=""
                                                                class="btn btn-success">Display Records
                                                        </button>
                                                        <button onclick=""
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
                    <?php
                    //if (isset($SessionFilters) && $SessionFilters != '') { ?>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>Total Pax</th>
                                <th>Entered</th>
                                <th>Exited</th>
                                <th>IN KSA</th>
                                <th>After 1 day (Tomorrow)</th>
                                <th>After 2 Days</th>
                                <th>After 3 Days</th>
                                <th>After 4 Days</th>
                                <th>After 5 Days</th>
                                <th>Not Entered Yet</th>
                                <th>Category</th>
                                <th>Reference</th>

                            </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>
                    <?php /*} else { */?><!--
                        <div class="alert alert-warning text-center font-weight-bold">Filters! Plz Select Filters
                            To View Record...
                        </div>
                    --><?php /*} */?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
    $(document).ready(function () {

        setTimeout(function (){
            $("#booking_date_from").val('');
            $("#booking_date_to").val('');
            $("#expiry_date_from").val('');
            $("#expiry_date_to").val('');
            $("#check_in_date_from").val('');
            $("#check_in_date_to").val('');
        }, 1000);

        var dataTable = $('#ReportTable').DataTable({
            "processing": true,
            "searching": false,
            "responsive": true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
            "pageLength": 100,
            "lengthChange": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ Agent Monitor Screen Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Agent Monitor Screen Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_agent_monitor_screen_report",
                type: "POST",
                data: function (data) {
                    data.booking_date_from = $('#booking_date_from').val();
                    data.booking_date_to = $('#booking_date_to').val();
                    data.expiry_date_from = $('#expiry_date_from').val();
                    data.expiry_date_to = $('#expiry_date_to').val();
                    data.check_in_date_from = $('#check_in_date_from').val();
                    data.check_in_date_to = $('#check_in_date_to').val();
                    data.booking_id = $('#booking_id').val();
                    data.hotel_name = $('#hotel_name').val();
                    data.city = $('#city').val();
                }
            },
            "columnDefs": [
                {
                    "defaultContent": "-",
                    "targets": "_all",
                    "orderable": false,
                },
            ],
        });
        $("#btnsearch").click(function () {
            dataTable.ajax.reload();
        });
        $('#btnreset').click(function () { //button reset event click
            $('#HotelUseVisaSearchFilters')[0].reset();
            $("#booking_date_from").val('');
            $("#booking_date_to").val('');
            $("#expiry_date_from").val('');
            $("#expiry_date_to").val('');
            $("#check_in_date_from").val('');
            $("#check_in_date_to").val('');
            dataTable.ajax.reload();  //just reload table
        });
    });

    function GetBookingDate() {
        const Date = $("#booking_date").val();
        const words = Date.split(' to ');
        $("#booking_date_from").val(words[0]);
        $("#booking_date_to").val(words[1]);
    }

    function GetExpiryDate() {
        const Date = $("#expiry_date").val();
        const words = Date.split(' to ');
        $("#expiry_date_from").val(words[0]);
        $("#expiry_date_to").val(words[1]);
    }

    function GetCheckInDate() {
        const Date = $("#check_in_date").val();
        const words = Date.split(' to ');
        $("#check_in_date_from").val(words[0]);
        $("#check_in_date_to").val(words[1]);
    }
</script>
<script type="application/javascript">


    /*$('#ReportTable').DataTable({
        "scrollX": true,
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
        "pageLength": 100
    });*/
    <?php if ($CheckAccess['umrah_reports_stats_statistics_agent_monitor_screen_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/agent_monitor_screen" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
