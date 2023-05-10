<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Actual Hotel Report
                    <?php if ($CheckAccess['umrah_reports_stats_hotel_actual_hotel_export']) { ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?= $path ?>exports/actual_hotel_report" target="_blank">Export Records
                    </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="return false;" class="section contact" id="ActualHotelSearchFilter">
                    <input type="hidden" name="checkin_date_from" id="checkin_date_from" value="">
                    <input type="hidden" name="checkin_date_to" id="checkin_date_to" value="">
                    <input type="hidden" name="checkout_date_from" id="checkout_date_from" value="">
                    <input type="hidden" name="checkout_date_to" id="checkout_date_to" value="">
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
                            <div id="FilterDetails" class="collapse show " aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Country</label>
                                                        <select class="form-control" id="country"
                                                                name="country">
                                                            <option value="">Please Select</option>
                                                            <?= Countries('html') ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Agent Name</label>
                                                        <select class="form-control" id="agent"
                                                                name="agent">
                                                            <?= $AgentsDropDown['html'] ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Voucher#</label>
                                                        <input type="text" class="form-control" id="voucher_no"
                                                               name="voucher_no"
                                                               placeholder="Voucher NO">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">City</label>
                                                        <input type="text" class="form-control" id="city"
                                                               name="city"
                                                               placeholder="City">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">HTL Category</label>
                                                        <input type="text" class="form-control" id="htl_category"
                                                               name="htl_category"
                                                               placeholder="HTL Category">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">CheckIn Date</label>
                                                        <input type="text" class="form-control multidate"
                                                               name="checkin_date" id="checkin_date"
                                                               placeholder="CheckIn Dates" value=""
                                                               onchange="GetCheckInDate();">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">CheckOut Date</label>
                                                        <input type="text" class="form-control multidate"
                                                               name="checkout_date" id="checkout_date"
                                                               placeholder="CheckOut Dates" value=""
                                                               onchange="GetCheckOutDate();">
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button id="btnreset" type="button" class="btn btn-danger">Clear
                                                            Filter
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
                    <div class="table-responsive mb-4 mt-4">
                        <table id="ActualHotelRecord" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>BRN</th>
                                <th>V. No</th>
                                <th>City</th>
                                <th>HTL Category</th>
                                <th>Actual HTL Name</th>
                                <th>Room Type</th>
                                <th>Room No</th>
                                <th>PAX</th>
                                <th>Beds</th>
                                <th>Actual Beds</th>
                                <th>CHK In Date</th>
                                <th>CHK Out Date</th>
                                <th>Nights</th>
                                <th>Actual CHK In Time</th>
                                <th>Origin</th>
                                <th>PAX MOB. No</th>
                                <th>Category</th>
                                <th>Reference</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php

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

        setTimeout(function () {
            $("#checkin_date_from").val('');
            $("#checkin_date_to").val('');
            $("#checkout_date_from").val('');
            $("#checkout_date_to").val('');
        }, 1000);

        var dataTable = $('#ActualHotelRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Actual Hotel Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Actual Hotel Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_actual_hotel_report",
                type: "POST",
                data: function (data) {
                    data.country = $('#country').val();
                    data.agent = $('#agent').val();
                    data.voucher_no = $('#voucher_no').val();
                    data.city = $('#city').val();
                    data.htl_category = $('#htl_category').val();
                    data.checkin_date_from = $('#checkin_date_from').val();
                    data.checkin_date_to = $('#checkin_date_to').val();
                    data.checkout_date_from = $('#checkout_date_from').val();
                    data.checkout_date_to = $('#checkout_date_to').val();
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
            $('#ActualHotelSearchFilter')[0].reset();
            $("#checkin_date_from").val('');
            $("#checkin_date_to").val('');
            $("#checkout_date_from").val('');
            $("#checkout_date_to").val('');
            dataTable.ajax.reload();  //just reload table
        });
    });

    function GetCheckInDate() {

        const EntryDate = $("#checkin_date").val();
        const words = EntryDate.split(' to ');
        $("#checkin_date_from").val(words[0]);
        $("#checkin_date_to").val(words[1]);
    }

    function GetCheckOutDate() {

        const EntryDate = $("#checkout_date").val();
        const words = EntryDate.split(' to ');
        $("#checkout_date_from").val(words[0]);
        $("#checkout_date_to").val(words[1]);
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
    <?php if ($CheckAccess['umrah_reports_stats_hotel_actual_hotel_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/actual_hotel_report" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
