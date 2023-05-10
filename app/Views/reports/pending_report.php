<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Pending Voucher
                    <?php if ($CheckAccess['umrah_reports_stats_voucher_voucher_not_approved_export']) { ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?=$path?>exports/pending_voucher" target="_blank">Export Records
                    </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="return false;" class="section contact" id="PendingVouchersSearchFilter">
                    <input type="hidden" name="create_date_from" id="create_date_from" value="">
                    <input type="hidden" name="create_date_to" id="create_date_to" value="">
                    <input type="hidden" name="arrival_date_from" id="arrival_date_from" value="">
                    <input type="hidden" name="arrival_date_to" id="arrival_date_to" value="">
                    <input type="hidden" name="departure_date_from" id="departure_date_from" value="">
                    <input type="hidden" name="departure_date_to" id="departure_date_to" value="">
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
                                                        <select class="form-control" id="country"
                                                                name="country">
                                                            <option value="">Please Select</option>
                                                            <?= Countries('html') ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Sub Agent Name</label>
                                                        <select class="form-control" id="agent"
                                                                name="agent">
                                                            <?= $AgentsDropDown['html'] ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Voucher#</label>
                                                        <input type="text" class="form-control" id="voucher_code"
                                                               name="voucher_code">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Create Date</label>
                                                        <input onchange="GetCreateDate();" type="text"
                                                               class="form-control multidate"
                                                               name="create_date" id="create_date">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Arrival Date</label>
                                                        <input onchange="GetArrivalDate();" type="text"
                                                               class="form-control multidate"
                                                               name="arrival_date" id="arrival_date">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Departure Date</label>
                                                        <input onchange="GetDepartureDate();" type="text"
                                                               class="form-control multidate"
                                                               name="departure_date" id="departure_date">
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
                        <table id="PendingVouchersRecord" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Create Date</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>Sub Agent Name</th>
                                <th>Create By</th>

                                <th>Voucher Ref. ID</th>
                                <th>Voucher No</th>
                                <th>Adult</th>
                                <th>Child</th>
                                <th>Infant</th>
                                <th>Total PAX</th>
                                <th>Arrival</th>
                                <th>Departure</th>
                                <th>Total Nights</th>
                                <th>Arrival Mode</th>

                                <th>Status</th>
                                <th>Modified By</th>
                                <th>Modified Date</th>
                                <th>Category</th>
                                <th>Reference</th>
                            </tr>
                            </thead>
                            <tbody>
                           <!-- --><?php
/*                            $cnt = 0;
                            foreach ($records as $record) {
                                $cnt++;

                                echo '
                                <tr>
                                <td>' . $cnt . '</td>
                                <td>'.DATEFORMAT($record['CreatedDate']).'</td>
                                <td>' . $record['CountryName'] . '</td>
                                <td>' . $record['AgentName'] . '</td>
                                <td>' . $record['SubAgentName'] . '</td>
                                <td>'.$record['UserCreatedBy'].'</td>
                                <td>'.Code('UF/V/', $record['UID']).'</td>
                                <td>'.$record['VoucherCode'].'</td>
                                <td>'.$record['Adults'].'</td>
                                <td>'.$record['Child'].'</td>
                                <td>'.$record['Infant'].'</td>
                                <td>'.$record['TotalPilgrim'].'</td>
                                <td>'.DATEFORMAT($record['ArrivalDate']).'</td>
                                <td>'.DATEFORMAT($record['DepartureDate']).'</td>
                                <td>'.$record['TotalNights'].'</td>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>'.$record['UserCreatedBy'].'</td> 
                                <td>'.DATEFORMAT($record['ModifiedDate']).'</td>                                                  
                                <td>' . ucfirst(str_replace("_"," ",$record['IATAType'])). '</td>
                                <td>' . $record['ReferenceName'] . '</td>                             
                                 </tr> ';
                            }
                            */?>
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

        setTimeout(function (){
            $("#create_date_from").val('');
            $("#create_date_to").val('');
            $("#arrival_date_from").val('');
            $("#arrival_date_to").val('');
            $("#departure_date_from").val('');
            $("#departure_date_to").val('');
        }, 1000);

        var dataTable = $('#PendingVouchersRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Pending Vouchers Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Pending Vouchers Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_pending_voucher_report",
                type: "POST",
                data: function (data) {
                    data.country = $('#country').val();
                    data.agent = $('#agent').val();
                    data.voucher_code = $('#voucher_code').val();
                    data.create_date_from = $('#create_date_from').val();
                    data.create_date_to = $('#create_date_to').val();
                    data.arrival_date_from = $('#arrival_date_from').val();
                    data.arrival_date_to = $('#arrival_date_to').val();
                    data.departure_date_from = $('#departure_date_from').val();
                    data.departure_date_to = $('#departure_date_to').val();
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
            $('#PendingVouchersSearchFilter')[0].reset();
            $("#create_date_from").val('');
            $("#create_date_to").val('');
            $("#arrival_date_from").val('');
            $("#arrival_date_to").val('');
            $("#departure_date_from").val('');
            $("#departure_date_to").val('');
            dataTable.ajax.reload();  //just reload table
        });
    });

    function GetCreateDate() {
        const Date = $("#create_date").val();
        const words = Date.split(' to ');
        $("#create_date_from").val(words[0]);
        $("#create_date_to").val(words[1]);
    }

    function GetArrivalDate() {
        const Date = $("#arrival_date").val();
        const words = Date.split(' to ');
        $("#arrival_date_from").val(words[0]);
        $("#arrival_date_to").val(words[1]);
    }

    function GetDepartureDate() {
        const Date = $("#departure_date").val();
        const words = Date.split(' to ');
        $("#departure_date_from").val(words[0]);
        $("#departure_date_to").val(words[1]);
    }
</script>
<script type="application/javascript">


   /* $('#ReportTable').DataTable({
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

   <?php if ($CheckAccess['umrah_reports_stats_voucher_voucher_not_approved_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/hotel_summary_report" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
