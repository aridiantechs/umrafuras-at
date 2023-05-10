<!--  BEGIN CONTENT AREA  -->
<style>
    table.cell-border thead th, table.cell-border tbody td {
        border: 0.5px solid #DDA420;
        border-collapse: collapse;
    }
</style>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">TRP Package
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?= $path ?>exports/trp_package" target="_blank"> Export Record
                    </a>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" id="B2CReportSearchFilter">
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
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="country">Actual/Visa</label>
                                                        <input class="form-control" id="name" name="name"
                                                               placeholder="Actual/Visa" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="country">All</label>
                                                        <input class="form-control" id="name" name="name"
                                                               placeholder="All" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4" id="FilterButtons">
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
                        </div>

                    </div>
                </form>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <table id="ReportTable" class="table table-hover non-hover display nowrap cell-border"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Booking Date</th>
                                <th>BRN No</th>
                                <th>Booking ID</th>
                                <th>Vehicle Type</th>
                                <th>QTY</th>
                                <th>Seats</th>
                                <th>Arrival Date</th>
                                <th>Company Name</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>6/29/21</td>
                                <td>MQM00051139PLST:358651</td>
                                <td>LALA INTL</td>
                                <td>Bus</td>
                                <td>1</td>
                                <td>25</td>
                                <td>6/29/21</td>
                                <td>BASMA</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>6/29/21</td>
                                <td>MQM00051139PLST:358651</td>
                                <td>LALA INTL</td>
                                <td>Bus</td>
                                <td>1</td>
                                <td>25</td>
                                <td>6/29/21</td>
                                <td>BASMA</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>6/29/21</td>
                                <td>MQM00051139PLST:358651</td>
                                <td>LALA INTL</td>
                                <td>Bus</td>
                                <td>1</td>
                                <td>25</td>
                                <td>6/29/21</td>
                                <td>BASMA</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>6/29/21</td>
                                <td>MQM00051139PLST:358651</td>
                                <td>LALA INTL</td>
                                <td>Bus</td>
                                <td>1</td>
                                <td>25</td>
                                <td>6/29/21</td>
                                <td>BASMA</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>6/29/21</td>
                                <td>MQM00051139PLST:358651</td>
                                <td>LALA INTL</td>
                                <td>Bus</td>
                                <td>1</td>
                                <td>25</td>
                                <td>6/29/21</td>
                                <td>BASMA</td>
                            </tr>
                            </tbody>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><b>300</b></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">


    $('#ReportTable').DataTable({
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
    });


    setTimeout(function () {
        $('<a href="<?=$path?>exports/trp_package" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);

</script>
