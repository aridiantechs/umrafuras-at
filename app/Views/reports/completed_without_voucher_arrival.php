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
                <h4 class="page-head">Completed Without Voucher
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?= $path ?>exports/completed_without_voucher_arrival" target="_blank"> Export Record
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
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Country</label>
                                                        <select class="form-control validate[required]" id="Country"
                                                                name="Country">
                                                            <option value="">Please Select</option>
                                                            <?= Countries('html') ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Agent</label>
                                                        <input type="text" class="form-control" name="Agent"
                                                               value=""
                                                               placeholder="Agent">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Entry Port</label>
                                                        <input type="text" class="form-control" name="Entry"
                                                               value=""
                                                               placeholder="Entry Port">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">From</label>
                                                        <input type="date" class="form-control" name="From"
                                                               value=""
                                                               placeholder="From">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">To</label>
                                                        <input type="date" class="form-control" name="To"
                                                               value=""
                                                               placeholder="To">
                                                    </div>
                                                </div>

                                                <div class="col-md-12" id="FilterButtons">
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
                        <table id="ReportTable" class="table table-hover non-hover display nowrap "
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>EA Code</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>Group Code</th>
                                <th>Group Name</th>
                                <th>Pax</th>
                                <th>PPT No</th>
                                <th>DOB</th>
                                <th>MOFA Number</th>
                                <th>Visa No</th>
                                <th>Entry Date</th>
                                <th>Entry Time</th>
                                <th>Entry Port</th>
                                <th>Arrival Mode</th>
                                <th>Entry Carrier</th>
                                <th>Flight No</th>
                                <th>Category</th>
                                <th>Reference</th>
                                 </tr>
                            </thead>
                            <tbody>
                            <?php
                            $cnt = 0;

                            foreach ($Pilgrimslist as $Pilgrimlist) {
                                $cnt++;
                                echo
                                    '
                           <tr>
                           <td>' . $cnt . ' </td>
                           <td>N/A </td>
                           <td>' . $Pilgrimlist['Country'] . ' </td>
                           <td>' . $Pilgrimlist['AgentName'] . ' </td>
                           <td>' . $Pilgrimlist['GroupName'] . ' </td>
                           <td>' . Code('UF/G/', $Pilgrimlist['GroupUID']) . ' </td>
                           <td>' . $Pilgrimlist['FirstName'] . ' </td>
                           <td>' . $Pilgrimlist['PassportNumber'] . ' </td>
                           <td>' . DATEFORMAT($Pilgrimlist['DOB']) . ' </td>
                           <td>' . $Pilgrimlist['MOFAPilgrimID'] . ' </td>
                           <td>' . $Pilgrimlist['VisaNo'] . ' </td>
                           <td>' . DATEFORMAT($Pilgrimlist['EntryDate']) . ' </td>
                           <td>' . TIMEFORMAT($Pilgrimlist['EntryTime']) . ' </td>
                           <td>' . $Pilgrimlist['EntryPort'] . ' </td>
                           <td>' . $Pilgrimlist['TransportMode'] . ' </td>
                           <td>' . $Pilgrimlist['EntryCarrier'] . ' </td>
                           <td>' . $Pilgrimlist['FlightNo'] . ' </td>
                           <td>N/A </td>
                           <td>N/A </td>
                       
                           
                            </tr>   
                           
                           ';
                            }
                            ?>
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
        $('<a href="<?=$path?>exports/completed_without_voucher_arrival" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);

</script>
