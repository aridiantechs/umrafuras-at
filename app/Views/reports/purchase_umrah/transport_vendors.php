<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Transport Vendor
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?=$path?>" target="_blank">Export Records
                    </a>
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
                            <div id="FilterDetails" class="collapse show " aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
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
                                                        <label for="country">Hotel Category</label>
                                                        <input type="text" class="form-control" name="Hotel Category"
                                                               value=""
                                                               placeholder="Hotel Category">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Hotel Name</label>
                                                        <input type="text" class="form-control" name="Hotel Name"
                                                               value=""
                                                               placeholder="Hotel Name">
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
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">BRN</label>
                                                        <input type="text" class="form-control" name="BRN"
                                                               value=""
                                                               placeholder="BRN">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">From</label>
                                                        <input type="date" class="form-control" name="From"
                                                               value=""
                                                               placeholder="From">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">To</label>
                                                        <input type="date" class="form-control" name="To"
                                                               value=""
                                                               placeholder="To">
                                                    </div>
                                                </div>
                                                <div class="col-md-10" id="FilterButtons">
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
                    <div class="table-responsive mb-4 mt-4">
                        <table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>EA Code</th>

                                <th>#</th>
                                <th>Vendor name</th>
                                <th>Vendor country</th>
                                <th>Vendor city</th>

                                <th>BRN </th>
                                <th>V. No</th>
                                <th>CHK Out Date</th>
                                <th>CHK Out Time</th>
                                <th>City</th>
                                <th>Pick Up Point</th>
                                <th>Actual Hotel </th>
                                <th>Room No </th>
                                <th>Pax</th>
                                <th>Seats</th>
                                <th>Actual Dep Time</th>
                                <th>Sector</th>
                                <th>Destination</th>
                                <th>TPT Type</th>
                                <th>Vehicle Number</th>
                                <th>Driver Name</th>
                                <th>Driver Mob. Number</th>
                                <th>Pax Mob. No</th>
                                <th>TPT Company</th>
                                <th>Category</th>
                                <th>Reference</th>

                            </tr>
                            </thead>
                            <tbody>
                            <!--                            --><?php
                            //                            for($i=1;$i<10;$i++)
                            //                            {
                            //                                echo '
                            //                                <tr>
                            //                                <td>'.$i.'</td>
                            //                                <td>Pakistan</td>
                            //                                <td>Dummy IATA Name</td>
                            //                                <td>4234</td>
                            //                                <td>98</td>
                            //                                <td>23 Apr, 2021</td>
                            //                                <td>ISB</td>
                            //                                <td>5 Star</td>
                            //                                 <td>Al Furas</td>
                            //                                 <td>Sharing</td>
                            //                                <td>5</td>
                            //                                <td>17</td>
                            //                                <td>15</td>
                            //
                            //                                <td>5</td>
                            //                                <td>5</td>
                            //                                <td>10:00 am</td>
                            //                                <td>Dummy</td>
                            //                                <td>0336564646</td>
                            //                                <td>b2c</td>
                            //                                <td>Usman Khan</td>
                            //
                            //                                </tr> ';
                            //                            }
                            //                            ?>
                            </tbody>
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
        $('<a href="<?=$path?>" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);

</script>
