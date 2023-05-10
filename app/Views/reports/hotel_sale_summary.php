<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Hotel Sale Summary
                    <?php if ($CheckAccess['umrah_reports_stats_sale_hotel_sale_summary_export']) { ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?=$path?>exports/hotel_sale_summary" target="_blank"> Export Record
                    </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" id="VoucherNotIssuedStatsReportSearchFilter">
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
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">HTL Category</label>
                                                <input type="text" class="form-control" name="HTL Category"
                                                       value=""
                                                       placeholder="HTL Category ">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">City</label>
                                                <input type="text" class="form-control" name="City"
                                                       value=""
                                                       placeholder="City ">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Hotel</label>
                                                <input type="text" class="form-control" name="Hotel"
                                                       value=""
                                                       placeholder="Hotel ">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="country"> From  To</label>
                                                <input type="text" class="form-control multidate validate[required,future[now]]"
                                                       name="FromTo" id="FromTo" readonly
                                                       placeholder="" value=""
                                                >

                                            </div>
                                        </div>

                                        <div class="col-md-2" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="UpdateFilters('B2CReportSearchFilter'); return false;"
                                                        class="btn btn-success">Display Record
                                                </button>
                                                <button onclick="ClearFilters('B2CReportSearchFilter'); return false;"
                                                        class="btn btn-danger">Clear Filter
                                                </button>
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
                    <div class="table-responsive mb-4 mt-4">
                        <table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Hotel Category</th>
                                <th>City</th>
                                <th>Actual Hotel Name</th>
                                <th>Total PAX</th>
                                <?php
                                foreach ($room_types as $room_type) {
                                    echo '<th>' . $room_type['Name'] . '</th>';
                                } ?>
                                <th>Sharing PAX</th>
                                <th>Total Rooms</th>
                                <th>Total Nights</th>

                                <th>Reference</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
//                            for($i=1;$i<10;$i++)
//                            {
//                                echo '
//                                <tr>
//                                <td>'.$i.'</td>
//                                <td>Movenpick </td>
//                                <td>Mecca</td>
//                                <td>13</td>
//                                <td>2</td>
//                                <td>2</td>
//                                <td>2</td>
//                                <td>22</td>
//                                <td>21</td>
//                                <td>212</td>
//                                <td>22</td>
//                                <td>232</td>
//                                <td>5 Star</td>
//                                <td>Usman Khan</td>
//
//                                </tr> ';
//                            }
                            ?>
                            </tbody>
<!--                            <tr>-->
<!--                                <td colspan="3" style="text-align: center"> Total : </td>-->
<!--                                <td> 50</td>-->
<!--                                <td> 50</td>-->
<!--                                <td> 50</td>-->
<!--                                <td> 50</td>-->
<!--                                <td> 50</td>-->
<!--                                <td> 50</td>-->
<!--                                <td> 50</td>-->
<!--                                <td> 50</td>-->
<!--                                <td> 500</td>-->
<!--                                <td> -</td>-->
<!--                                <td> -</td>-->
<!--                            </tr>-->
                        </table>
                    </div>
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
                "lengthMenu": "Show _MENU_ Hotel Sale Summary Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Hotel Sale Summary Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_hotel_sale_summary_report",
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


    <?php if ($CheckAccess['umrah_reports_stats_sale_hotel_sale_summary_export']) { ?>

    setTimeout(function () {
        $('<a href="<?=$path?>exports/hotel_sale_summary" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>


</script>
