<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Bed Loss
                    <?php if ($CheckAccess['umrah_reports_stats_hotel_bed_loss_export']) { ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?=$path?>exports/bed_loss" target="_blank">Export Records
                    </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing d-none">
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
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">City</label>
                                                <input type="text" class="form-control" name="City"
                                                       value=""
                                                       placeholder="City">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Hotel </label>
                                                <input type="text" class="form-control" name="Hotel Name"
                                                       value=""
                                                       placeholder="Hotel">
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

                                        <div class="col-md-4" id="FilterButtons">
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

                </form>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>BRN/Cash</th>
                                <th>City</th>
                                <th>Hotel</th>

                                <th>Date</th>
                                <th>Room No</th>
                                <th>Bed Loss</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
/*                            $cnt = 0;
                            foreach ($records as $record) {
                                $cnt++;

                                echo '
                                <tr>
                                <td>' . $cnt . '</td>
                                <td>'.( (isset($record['BRNCode'])) ? $record['BRNCode'] : 'Cash' ).'</td>
                                
                                <td>' . $record['City'] . ' </td>
                                <td>' . $record['Hotel'] . ' </td>
                                
                                <td>' . $record['CheckInDate'] . '</td>
                                <td>' . $record['RoomNumber'] . '</td>
                                <td>' . $record['BedLoss'] . ' </td>
                                
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
        var dataTable = $('#ReportTable').DataTable({
            "processing": true,
            "searching": false,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, 'All']],
            "pageLength": 100,
            "lengthChange": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ Bed Loss",
                "info": "Showing _START_ to _END_ of _TOTAL_ Bed Loss",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_all_bed_loss_report",
                type: "POST"
            },
            "columnDefs": [
                {
                    "defaultContent": "-",
                    "targets": "_all",
                    //"targets":[0, 3, 4],
                    "orderable": false,
                },
            ],
        });
    });

    function VoucherIssuedFiltersFormSubmit(parent) {

        var dataTable = $('#ReportTable').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {
            dataTable.ajax.reload();
        }
    }

    function ClearSession(SessionKey) {

        var dataTable = $('#ReportTable').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {
            $("form#VoucherIssuedSearchFilters")[0].reset();
            dataTable.ajax.reload();
        }
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

    <?php if ($CheckAccess['umrah_reports_stats_hotel_bed_loss_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/bed_loss" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
